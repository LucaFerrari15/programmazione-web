<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Luca Ferrari',
            'email' => 'ferrariluca2002@gmail.com',
            'password' => 'user',
            'role' => 'registered_user'
        ]);

        User::factory()->count(10)->create();

        $this->call([
            BrandsTableSeeder::class,
            TeamsTableSeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

    }
}
