<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dl = new DataLayer();
        $productsList = $dl->listProducts();
        $teamList = $dl->listTeams();
        $brandList = $dl->listBrands();
        return view('product.products')->with('products_list', $productsList)->with('team_list', $teamList)->with('brand_list', $brandList);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dl = new DataLayer();
        $brandList = $dl->listBrands();
        $sizeList = $dl->listSizes();
        $teamList = $dl->listTeams();

        return view('product.editJersey')->with('list_brands', $brandList)->with('list_sizes', $sizeList)->with('list_teams', $teamList);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {     
        $product = Product::create(
            ['nome' => $request->input('nome_maglia'),
            'descrizione' => $request->input('descrizione'),
            'prezzo' => $request->input('prezzo'),
            'brand_id' => $request->input('floatingSelectMarca'),
            'team_id' => $request->input('floatingSelectTeam'),]
        );

        if ($request->hasFile('image_path')) {
            // Elimina la vecchia immagine se esiste
            if ($product->image_path && File::exists(public_path($product->image_path))) {
                File::delete(public_path($product->image_path));
            }
            
            // Crea la cartella se non esiste
            $imgPath = public_path('img/products');
            if (!File::exists($imgPath)) {
                File::makeDirectory($imgPath, 0755, true);
            }
            
            // Genera nome file unico
            $fileName = time() . '_' . Str::random(10) . '.' . $request->file('image_path')->getClientOriginalExtension();
            
            // Sposta il file nella cartella public/img/products
            $request->file('image_path')->move($imgPath, $fileName);
            
            // Salva il percorso relativo nel database (senza public/)
            $product->image_path = 'img/products/' . $fileName;
            $product->save();
        }

        // Aggiorna taglie
        $sizes = collect($request->all())
        ->filter(fn($value, $key) => str_starts_with($key, 'size-') && $value !== null && $value !== '')
        ->mapWithKeys(fn($value, $key) => [str_replace('size-', '', $key) => ['quantita' => (int)$value]])
        ->toArray();

        $product->sizes()->sync($sizes);

        $product->save();
        $product->refresh();

        return view('product.jersey')->with('product', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dl = new DataLayer();
        $product = $dl->findProductById($id);

        if ($product != null) {
            return view('product.jersey')->with('product', $product);
        } else {
            return view('errors.wrongID')->with('message', "Oooops, something went wrong!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dl = new DataLayer();
        $product = $dl->findProductById($id);
        $brandList = $dl->listBrands();
        $sizeList = $dl->listSizes();
        $teamList = $dl->listTeams();
        $quantities = $product->sizes->pluck('pivot.quantita', 'id')->toArray();

        if ($product != null) {
            return view('product.editJersey')->with('product', $product)->with('list_brands', $brandList)->with('list_sizes', $sizeList)->with('list_teams', $teamList)->with('quantities', $quantities);
        } else {
            return view('errors.wrongID')->with('message', "Oooops, something went wrong!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dl = new DataLayer();
        $product = $dl->findProductById($id);

        // Aggiorna campi prodotto
        $product->nome = $request->input('nome_maglia');
        $product->descrizione = $request->input('descrizione');
        $product->prezzo = $request->input('prezzo');
        $product->brand_id = $request->input('floatingSelectMarca');
        $product->team_id = $request->input('floatingSelectTeam');

        if ($request->hasFile('image_path')) {
            // Elimina la vecchia immagine se esiste
            if ($product->image_path && File::exists(public_path($product->image_path))) {
                File::delete(public_path($product->image_path));
            }
            
            // Crea la cartella se non esiste
            $imgPath = public_path('img/products');
            if (!File::exists($imgPath)) {
                File::makeDirectory($imgPath, 0755, true);
            }
            
            // Genera nome file unico
            $fileName = time() . '_' . Str::random(10) . '.' . $request->file('image_path')->getClientOriginalExtension();
            
            // Sposta il file nella cartella public/img/products
            $request->file('image_path')->move($imgPath, $fileName);
            
            // Salva il percorso relativo nel database (senza public/)
            $product->image_path = 'img/products/' . $fileName;
        }

        // Aggiorna taglie
        $sizes = collect($request->all())
        ->filter(fn($value, $key) => str_starts_with($key, 'size-') && $value !== null && $value !== '')
        ->mapWithKeys(fn($value, $key) => [str_replace('size-', '', $key) => ['quantita' => (int)$value]])
        ->toArray();

        $product->sizes()->sync($sizes);

        $product->save();
        $product->refresh();

        return view('product.jersey')->with('product', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dl = new DataLayer();
        $product = $dl->findProductById($id);
        
        if ($product) {
            // Elimina l'immagine se esiste
            if ($product->image_path && File::exists(public_path($product->image_path))) {
                File::delete(public_path($product->image_path));
            }
            
            $product->delete();
        }
    }

    public function ajaxCheckForProducts(Request $request)
    {
        $dl = new DataLayer();

        if ($dl->findProductByName($request->input('nome'))) {
            $response = array('found' => true);
        } else {
            $response = array('found' => false);
        }
        return response()->json($response);
    }
}