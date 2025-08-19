<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

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
