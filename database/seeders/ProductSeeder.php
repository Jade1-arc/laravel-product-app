<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'price' => 999.99,
                'description' => 'Latest iPhone with advanced features and powerful performance.',
                'category_id' => 1 // Electronics
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'price' => 899.99,
                'description' => 'Premium Android smartphone with cutting-edge technology.',
                'category_id' => 1 // Electronics
            ],
            [
                'name' => 'Nike Air Max 270',
                'price' => 150.00,
                'description' => 'Comfortable running shoes with excellent cushioning.',
                'category_id' => 2 // Clothing
            ],
            [
                'name' => 'Adidas T-Shirt',
                'price' => 29.99,
                'description' => 'Comfortable and stylish t-shirt for everyday wear.',
                'category_id' => 2 // Clothing
            ],
            [
                'name' => 'The Great Gatsby',
                'price' => 12.99,
                'description' => 'Classic American novel by F. Scott Fitzgerald.',
                'category_id' => 3 // Books
            ],
            [
                'name' => 'Harry Potter Complete Set',
                'price' => 89.99,
                'description' => 'Complete collection of the Harry Potter series.',
                'category_id' => 3 // Books
            ],
            [
                'name' => 'Coffee Maker',
                'price' => 79.99,
                'description' => 'Automatic coffee maker for perfect brew every time.',
                'category_id' => 4 // Home & Garden
            ],
            [
                'name' => 'Yoga Mat',
                'price' => 25.00,
                'description' => 'Non-slip yoga mat for comfortable workouts.',
                'category_id' => 5 // Sports & Outdoors
            ],
            [
                'name' => 'Face Cream',
                'price' => 34.99,
                'description' => 'Moisturizing face cream for all skin types.',
                'category_id' => 6 // Beauty & Health
            ],
            [
                'name' => 'Chess Set',
                'price' => 45.00,
                'description' => 'Classic wooden chess set for strategic gameplay.',
                'category_id' => 7 // Toys & Games
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
