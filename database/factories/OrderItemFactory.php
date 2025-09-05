<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        
        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'size_id' => Size::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 3),
            'price' => $product->prezzo, // Usa il prezzo del prodotto
        ];
    }

    /**
     * Set the order for this item
     */
    public function forOrder(Order $order)
    {
        return $this->state(function (array $attributes) use ($order) {
            return [
                'order_id' => $order->id,
            ];
        });
    }
}