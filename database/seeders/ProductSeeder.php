<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(30)->create()->each(function ($product) {
            
            $sizes = Size::all();
            
            foreach ($sizes as $size) {
                
                $quantity = fake()->numberBetween(0, 25);
                $product->sizes()->attach($size->id, ['quantita' => $quantity]);
            }
        });
    }
}
