<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Size;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->count(50)->create()->each(function ($order) {
            $numberOfItems = fake()->numberBetween(1, 5);
            $total = 0;

            for ($i = 0; $i < $numberOfItems; $i++) {
                $product = Product::inRandomOrder()->first();
                $size = Size::inRandomOrder()->first();
                $quantity = fake()->numberBetween(1, 3);
                $price = $product->prezzo;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price * $quantity;
            }

            // Aggiorna il totale dell'ordine
            $order->update(['total' => $total]);
        });
    }
}
