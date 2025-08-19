<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;  // o App\Models\Marca se usi italiano

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'Nike',
            'Mitchell and Ness',
            'Adidas',
        ];

        foreach ($brands as $brand) {
            Brand::create(['nome' => $brand]);
        }
    }
}
