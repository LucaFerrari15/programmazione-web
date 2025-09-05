<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
            'nome_spedizione' => $this->faker->firstName(),
            'cognome_spedizione' => $this->faker->lastName(),
            'via' => $this->faker->streetName(),
            'civico' => $this->faker->buildingNumber(),
            'cap' => $this->faker->numerify('#####'),
            'comune' => $this->faker->city(),
            'provincia' => $this->faker->stateAbbr(),
            'paese' => 'IT',
            'total' => 0, 
        ];
    }

    /**
     * Configure the factory to create orders with random timestamps
     */
    public function configure()
    {
        return $this->afterMaking(function (Order $order) {
            // Imposta una data casuale negli ultimi 6 mesi
            $randomDate = $this->faker->dateTimeBetween('-6 months', 'now');
            $order->created_at = $randomDate;
            $order->updated_at = $this->faker->dateTimeBetween($randomDate, 'now');
        });
    }

    // /**
    //  * Factory state for completed orders
    //  */
    // public function completed()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'status' => 'completed',
    //         ];
    //     });
    // }

    // /**
    //  * Factory state for pending orders
    //  */
    // public function pending()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'status' => 'pending',
    //         ];
    //     });
    // }
}