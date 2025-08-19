<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Team;
use App\Models\Product;
use App\Models\Size;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ottieni i brand e i team esistenti
        $nike = Brand::where('nome', 'Nike')->firstOrFail();
        $mitchellNess = Brand::where('nome', 'Mitchell and Ness')->firstOrFail();
        $lakers = Team::where('nome', 'Los Angeles Lakers')->firstOrFail();
        $warriors = Team::where('nome', 'Golden State Warriors')->firstOrFail();

        // Crea il prodotto LeBron James Jersey
        $lebronProduct = Product::create([
            'nome' => 'LeBron James Home Jersey',
            'prezzo' => 109.90,
            'team_id' => $lakers->id,
            'brand_id' => $nike->id,
            'descrizione' => 'La maglia ufficiale da gara indossata da LeBron James durante le partite casalinghe. Realizzata in tessuto traspirante e leggero, combina comfort e performance. Il design pulito presenta i colori della squadra, il numero 23 e il nome "James" sulla schiena, per un look autentico da vero tifoso. Ideale sia per il gioco che per il tifo.',
            'image_path' => 'immagini_prodotti/lbj_home.png',
        ]);

        // Array delle taglie e quantità per LeBron
        $lebronSizes = [
            'XS' => 5,
            'S' => 12,
            'M' => 15,
            'L' => 18,
            'XL' => 0,
            'XXL' => 7,
        ];

        // Collega taglie a LeBron Product
        foreach ($lebronSizes as $sizeName => $quantity) {
            $size = Size::where('nome', $sizeName)->firstOrFail();
            $lebronProduct->sizes()->attach($size->id, ['quantita' => $quantity]);
        }

        // Crea il prodotto Stephen Curry Away Jersey
        $curryProduct = Product::create([
            'nome' => 'Stephen Curry Away Jersey',
            'prezzo' => 119.90,
            'team_id' => $warriors->id,
            'brand_id' => $mitchellNess->id,
            'descrizione' => 'La maglia ufficiale away di Stephen Curry dei Golden State Warriors. Versione Mitchell & Ness con tessuto premium e dettagli autentici. Il design presenta i colori away della squadra con il numero 30 e il nome "Curry" ricamati con precisione. Perfetta combinazione di stile vintage e performance moderna per i fan dei Warriors.',
            'image_path' => 'immagini_prodotti/curry_away_mn.png',
        ]);

        // Array delle taglie e quantità per Curry
        $currySizes = [
            'XS' => 3,
            'S' => 0,
            'M' => 14,
            'L' => 16,
            'XL' => 12,
            'XXL' => 6,
        ];

        // Collega taglie a Curry Product
        foreach ($currySizes as $sizeName => $quantity) {
            $size = Size::where('nome', $sizeName)->firstOrFail();
            $curryProduct->sizes()->attach($size->id, ['quantita' => $quantity]);
        }



        // Ottieni il team e brand per Jimmy Butler
        $heat = Team::where('nome', 'Miami Heat')->firstOrFail();
        $nike = Brand::where('nome', 'Nike')->firstOrFail(); // riutilizzabile se già sopra

        // Crea il prodotto Jimmy Butler Icon Jersey (tutto esaurito)
        $butlerProduct = Product::create([
            'nome' => 'Jimmy Butler Icon Jersey',
            'prezzo' => 99.90,
            'team_id' => $heat->id,
            'brand_id' => $nike->id,
            'descrizione' => 'Maglia ufficiale da gara indossata da Jimmy Butler, versione Icon dei Miami Heat. Design aggressivo con dettagli neri e rossi, perfetta per i veri tifosi della squadra della Florida. Realizzata in tessuto traspirante Nike Dri-FIT, garantisce il massimo comfort durante ogni sfida.',
        ]);

        // Tutte le taglie esaurite
        $butlerSizes = [
            'XS' => 0,
            'S' => 0,
            'M' => 0,
            'L' => 0,
            'XL' => 0,
            'XXL' => 0,
        ];

        // Collega taglie a Butler Product con quantità zero
        foreach ($butlerSizes as $sizeName => $quantity) {
            $size = Size::where('nome', $sizeName)->firstOrFail();
            $butlerProduct->sizes()->attach($size->id, ['quantita' => $quantity]);
        }

    }
}
