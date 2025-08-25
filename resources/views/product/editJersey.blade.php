@extends('layouts.master')

@section('title', 'Edit | JerseyShop')

@section('active_prodotti', 'active')

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.products') }}">Prodotti</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('product.show', $product->id) }}">{{$product->brand->nome}} -
                                {{$product->nome}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('contenuto_principale')





    <div class=" row mt-4">
        <div class="col offset-1">
            <a class="btn btn-red" href="{{ route('product.show', $product->id) }}"><i class="bi bi-arrow-left"></i> Torna
                Indietro</a>
        </div>
    </div>
    <div class="row">
        <div class="col-10 col-lg-5 offset-1 my-4"></div>
    </div>


@endsection