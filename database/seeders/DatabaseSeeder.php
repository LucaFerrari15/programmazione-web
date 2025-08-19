<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Luca Ferrari',
            'email' => 'luca@admin.com',
            'password' => 'admin',
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Marco Ferrari',
            'email' => 'marco@user.com',
            'password' => 'user',
            'role' => 'registered_user'
        ]);

        $this->call([
            BrandsTableSeeder::class,
            TeamsTableSeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
        ]);

    }
}
