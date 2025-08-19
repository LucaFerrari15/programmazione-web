<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
