<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Comment acheter un produit ?',
                'answer' => 'Ajoutez le produit à votre panier puis terminez la commande depuis la page checkout. Nous vous confirmons ensuite la commande par e-mail.',
                'category' => 'commande',
                'tags' => ['achat', 'panier', 'checkout'],
            ],
            [
                'question' => 'Quels sont les modes de paiement disponibles ?',
                'answer' => 'Vous pouvez payer en carte bancaire sécurisée ou régler en espèces à la livraison. Choisissez l’option qui vous convient au moment du checkout.',
                'category' => 'paiement',
                'tags' => ['paiement', 'livraison'],
            ],
            [
                'question' => 'Quels sont les délais de livraison ?',
                'answer' => 'Les commandes sont préparées sous 24h ouvrées puis livrées sous 2 à 5 jours selon l’adresse de livraison.',
                'category' => 'livraison',
                'tags' => ['livraison', 'delai'],
            ],
            [
                'question' => 'Comment suivre mes commandes ?',
                'answer' => 'Rendez-vous dans la rubrique Mes commandes après connexion. Chaque commande affiche son statut (pending, accepted ou rejected).',
                'category' => 'commande',
                'tags' => ['suivi', 'commande'],
            ],
            [
                'question' => 'Que contient mon panier ?',
                'answer' => 'Votre panier regroupe les produits ajoutés depuis les fiches produits avec les quantités et prix unitaires. Vous pouvez modifier ou supprimer chaque ligne avant le paiement.',
                'category' => 'panier',
                'tags' => ['panier', 'produit'],
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'category' => $faq['category'],
                    'tags' => $faq['tags'],
                    'is_active' => true,
                ]
            );
        }
    }
}
