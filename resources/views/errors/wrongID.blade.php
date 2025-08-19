@extends('layouts.master')

@section('title', 'Error | JerseyShop')

@section('contenuto_principale')
    <div class="row">
        <div class="col mb-4">
            <div class="row">
                <div class="col text-center">
                    <img src="{{ url('/') }}/img/error.png" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row">
                <div class="col text-center mb-4">
                    <h1>{{$message}}</h1>
                    <a href="{{ route('home') }}" class="btn btn-red mt-3">
                        <i class="bi bi-house"></i> Torna alla Home
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection