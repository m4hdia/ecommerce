<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create categories first
        $categories = [
            ['name' => 'Electronics', 'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800'],
            ['name' => 'Apparel', 'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800'],
            ['name' => 'Home & Living', 'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800'],
            ['name' => 'Footwear', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800'],
            ['name' => 'Worklife', 'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800'],
            ['name' => 'Lifestyle', 'image' => 'https://images.unsplash.com/photo-1493666438817-866a91353ca9?w=800'],
            ['name' => 'Beauty', 'image' => 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?w=800'],
        ];

        $categoryMap = [];
        foreach ($categories as $category) {
            $record = Category::firstOrCreate(
                ['name' => $category['name']],
                ['image' => $category['image']]
            );
            $categoryMap[$category['name']] = $record->id;
        }

        // Sample products with real images from Unsplash API
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with adaptive noise cancellation and 32-hour battery.',
                'price' => 199.99,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=900',
                'featured' => true,
                'category' => 'Electronics',
                'stock' => 50
            ],
            [
                'name' => 'Smart Watch S9',
                'description' => 'Midnight aluminum case with health monitoring, GPS and fall detection.',
                'price' => 329.00,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=900',
                'featured' => true,
                'category' => 'Electronics',
                'stock' => 35
            ],
            [
                'name' => 'Everyday City Backpack',
                'description' => 'Weatherproof laptop backpack with modular interior and USB passthrough.',
                'price' => 129.99,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=900',
                'featured' => true,
                'category' => 'Apparel',
                'stock' => 120
            ],
            [
                'name' => 'Velocity Runner',
                'description' => 'Responsive foam midsole and recycled knit upper for all-surface comfort.',
                'price' => 149.99,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=900',
                'featured' => true,
                'category' => 'Footwear',
                'stock' => 80
            ],
            [
                'name' => 'Aurora Floor Lamp',
                'description' => 'Minimal floor lamp with warm dimming and touch controls for living spaces.',
                'price' => 189.00,
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=900',
                'featured' => false,
                'category' => 'Home & Living',
                'stock' => 45
            ],
            [
                'name' => 'Brew Pro Coffee Maker',
                'description' => 'Programmable pour-over system with reusable stainless filter.',
                'price' => 169.99,
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900',
                'featured' => false,
                'category' => 'Home & Living',
                'stock' => 55
            ],
            [
                'name' => 'Luna Scent Diffuser',
                'description' => 'Ultrasonic diffuser with three handcrafted fragrance oils.',
                'price' => 89.00,
                'image' => 'https://images.unsplash.com/photo-1503602642458-232111445657?w=900',
                'featured' => false,
                'category' => 'Lifestyle',
                'stock' => 70
            ],
            [
                'name' => 'Desk Organizer Kit',
                'description' => 'Magnetic wood tray set with wireless charger and pen rest.',
                'price' => 119.00,
                'image' => 'https://images.unsplash.com/photo-1487017159836-4e23ece2e4cf?w=900',
                'featured' => false,
                'category' => 'Worklife',
                'stock' => 65
            ],
            [
                'name' => 'Serum Glow Set',
                'description' => 'Vitamin C brightening serum paired with hyaluronic moisture lock.',
                'price' => 98.00,
                'image' => 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?w=900',
                'featured' => false,
                'category' => 'Beauty',
                'stock' => 90
            ],
            [
                'name' => 'Bluetooth Studio Speaker',
                'description' => 'Portable speaker with 360° audio, 24-hour playback and USB-C fast charge.',
                'price' => 149.99,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=900',
                'featured' => false,
                'category' => 'Electronics',
                'stock' => 60
            ],
            [
                'name' => 'Smart Home Projector',
                'description' => '4K short-throw projector with auto-focus, HDR support and Wi-Fi streaming.',
                'price' => 899.00,
                'image' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=900',
                'featured' => true,
                'category' => 'Electronics',
                'stock' => 25
            ],
            [
                'name' => 'Nordic Knit Hoodie',
                'description' => 'Premium cotton hoodie with minimalist silhouette and brushed interior.',
                'price' => 89.90,
                'image' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=900',
                'featured' => false,
                'category' => 'Apparel',
                'stock' => 110
            ],
            [
                'name' => 'Eco Suede Chelsea Boots',
                'description' => 'Lightweight Chelsea boots made from recycled suede with anti-slip sole.',
                'price' => 159.50,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=900',
                'featured' => true,
                'category' => 'Footwear',
                'stock' => 75
            ],
            [
                'name' => 'Modern Ceramic Dinner Set',
                'description' => '12-piece porcelain dinner set with matte glaze for contemporary tables.',
                'price' => 139.00,
                'image' => 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?w=900',
                'featured' => false,
                'category' => 'Home & Living',
                'stock' => 90
            ],
            [
                'name' => 'Focus Standing Desk',
                'description' => 'Motorized height-adjustable desk with memory presets and cable tray.',
                'price' => 649.00,
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=900',
                'featured' => true,
                'category' => 'Worklife',
                'stock' => 40
            ],
            [
                'name' => 'Botanical Skincare Ritual',
                'description' => 'Three-step botanical kit: cleanser, toner and overnight repair mask.',
                'price' => 119.00,
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=900',
                'featured' => false,
                'category' => 'Beauty',
                'stock' => 85
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categoryMap[$product['category']] ?? collect($categoryMap)->first();

            Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'featured' => $product['featured'],
                    'category_id' => $categoryId,
                    'stock' => $product['stock'],
                ]
            );
        }
    }
}