<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ChatbotQuery;
use App\Models\Faq;
use App\Models\Order;
use App\Models\Product;
use App\Models\UnknownQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = trim($data['message']);
        $user = $request->user();

        $response = $this->buildResponse($message, $user);

        ChatbotQuery::create([
            'user_id' => optional($user)->id,
            'question' => $message,
            'response' => $response['answer'] ?? null,
            'matched_type' => $response['matched_type'] ?? null,
            'matched_id' => $response['matched_id'] ?? null,
            'is_unanswered' => ($response['matched_type'] ?? null) === null,
            'metadata' => [
                'links' => $response['links'] ?? [],
                'context' => $response['context'] ?? [],
            ],
        ]);

        if (($response['matched_type'] ?? null) === null) {
            UnknownQuestion::create([
                'user_id' => optional($user)->id,
                'question' => $message,
                'context' => [
                    'links' => $response['links'] ?? [],
                    'context' => $response['context'] ?? [],
                ],
            ]);
        }

        return response()->json([
            'answer' => $response['answer'],
            'links' => $response['links'],
            'context' => $response['context'],
        ]);
    }

    protected function buildResponse(string $message, $user): array
    {
        $normalized = Str::lower($message);
        $links = [];
        $context = [];
        $matchedType = null;
        $matchedId = null;
        $answer = null;

        if ($user && $this->mentionsOrders($normalized)) {
            $orders = $this->latestOrdersFor($user);
            if ($orders->isNotEmpty()) {
                $matchedType = 'orders';
                $context['orders'] = $orders->toArray();
                $answer = sprintf(
                    'Voici vos %d dernières commandes : %s. Consultez la page Mes commandes pour tous les détails.',
                    $orders->count(),
                    $orders->map(fn ($order) => sprintf('#%d (%s - %.2f€)', $order['id'], $order['status'], $order['total']))->implode(', ')
                );
                $links[] = route('orders.index');
            } else {
                $matchedType = 'orders';
                $answer = 'Vous n’avez pas encore de commande. Ajoutez des produits au panier puis validez pour en créer une.';
                $links[] = route('products.index');
            }
        } elseif (! $user && $this->mentionsOrders($normalized)) {
            $matchedType = 'orders';
            $answer = 'Connectez-vous pour consulter vos commandes et leur statut (pending, accepted, rejected).';
            $links[] = route('login');
        }

        if (! $answer && $user && $this->mentionsCart($normalized)) {
            $cartItems = $this->cartSummaryFor($user);
            if ($cartItems->isNotEmpty()) {
                $matchedType = 'cart';
                $context['cart'] = $cartItems->toArray();
                $answer = 'Votre panier contient : ' . $cartItems->map(fn ($item) => sprintf('%s x%d (%.2f€)', $item['name'], $item['quantity'], $item['price']))->implode(', ') . '. Vous pouvez ajuster les quantités avant le paiement.';
                $links[] = route('cart.index');
            } else {
                $matchedType = 'cart';
                $answer = 'Votre panier est vide. Rendez-vous sur la boutique pour commencer vos achats.';
                $links[] = route('products.index');
            }
        } elseif (! $answer && ! $user && $this->mentionsCart($normalized)) {
            $matchedType = 'cart';
            $answer = 'Connectez-vous pour retrouver votre panier sauvegardé et finaliser vos achats.';
            $links[] = route('login');
        }

        if (! $answer) {
            $faq = $this->findFaq($message);
            if ($faq) {
                $matchedType = 'faq';
                $matchedId = $faq->id;
                $answer = $faq->answer;
                $context['faq'] = [
                    'question' => $faq->question,
                    'category' => $faq->category,
                ];
            }
        }

        if (! $answer) {
            $products = $this->findProducts($message);
            if ($products->isNotEmpty()) {
                $matchedType = 'products';
                $context['products'] = $products->toArray();
                $answer = 'Voici ce que j’ai trouvé : ' . $products->map(function ($product) {
                    $availability = $product['stock'] > 0 ? 'Disponible' : 'Rupture de stock';
                    return sprintf(
                        '%s — %s | %.2f€ | %s',
                        $product['name'],
                        Str::limit($product['description'] ?? 'Pas de description', 80),
                        $product['price'],
                        $availability
                    );
                })->implode('; ') . '.';
                $links = array_merge($links, array_column($products->toArray(), 'url'));
            }
        }

        if (! $answer) {
            $navigation = $this->navigationSuggestion($normalized);
            if ($navigation) {
                $matchedType = 'navigation';
                $answer = $navigation['message'];
                $links[] = $navigation['url'];
            }
        }

        if (! $answer) {
            $answer = 'Désolé, je ne peux répondre qu’aux questions concernant ce site.';
            $context['status'] = 'unknown';
        }

        return [
            'answer' => $answer,
            'links' => array_values(array_unique(array_filter($links))),
            'context' => $context,
            'matched_type' => $matchedType,
            'matched_id' => $matchedId,
        ];
    }

    protected function findFaq(string $message): ?Faq
    {
        $faq = Faq::active()->search($message)->take(1)->first();

        if (! $faq) {
            $faq = Faq::active()
                ->where(function ($query) use ($message) {
                    $query->where('question', 'like', '%' . $message . '%')
                        ->orWhere('answer', 'like', '%' . $message . '%');
                })
                ->first();
        }

        return $faq;
    }

    protected function findProducts(string $message): Collection
    {
        $results = Product::search($message)->take(3)->get();

        if ($results->isEmpty()) {
            $results = Product::where('name', 'like', '%' . $message . '%')
                ->orWhere('description', 'like', '%' . $message . '%')
                ->limit(3)
                ->get();
        }

        return $results->map(function (Product $product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'category' => optional($product->category)->name,
                'stock' => $product->stock,
                'description' => $product->description,
                'url' => route('products.show', $product),
            ];
        });
    }

    protected function latestOrdersFor($user): Collection
    {
        return Order::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (Order $order) => [
                'id' => $order->id,
                'status' => $order->status,
                'total' => (float) ($order->total_price ?? $order->total_amount ?? 0),
                'created_at' => optional($order->created_at)->toDateTimeString(),
            ]);
    }

    protected function cartSummaryFor($user): Collection
    {
        return Cart::with('product')
            ->where('user_id', $user->id)
            ->get()
            ->map(function (Cart $item) {
                $price = $item->price ?? optional($item->product)->price ?? 0;
                return [
                    'product_id' => $item->product_id,
                    'name' => optional($item->product)->name,
                    'quantity' => $item->quantity,
                    'price' => (float) $price,
                ];
            })
            ->filter(fn ($item) => ! empty($item['name']));
    }

    protected function mentionsOrders(string $message): bool
    {
        return Str::contains($message, ['commande', 'orders', 'order', 'achat']);
    }

    protected function mentionsCart(string $message): bool
    {
        return Str::contains($message, ['panier', 'cart', 'basket']);
    }

    protected function navigationSuggestion(string $message): ?array
    {
        $routes = [
            'home' => [
                'keywords' => ['home', 'accueil', 'start'],
                'url' => route('home'),
                'label' => 'page d’accueil',
            ],
            'products' => [
                'keywords' => ['product', 'catalog', 'shop', 'store'],
                'url' => route('products.index'),
                'label' => 'page produits',
            ],
            'cart' => [
                'keywords' => ['cart', 'panier', 'basket'],
                'url' => route('cart.index'),
                'label' => 'page panier',
            ],
            'login' => [
                'keywords' => ['login', 'sign in', 'connexion'],
                'url' => route('login'),
                'label' => 'page de connexion',
            ],
            'register' => [
                'keywords' => ['register', 'sign up', 'inscription'],
                'url' => route('register'),
                'label' => 'page d’inscription',
            ],
        ];

        foreach ($routes as $config) {
            if (Str::contains($message, $config['keywords'])) {
                return [
                    'message' => 'Vous trouverez ces informations sur la ' . $config['label'] . '. Voici le lien direct.',
                    'url' => $config['url'],
                ];
            }
        }

        return null;
    }
}
