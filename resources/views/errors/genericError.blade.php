@extends('layouts.master')

@section('title', $error_name . ' | JerseyShop')

@section('contenuto_principale')

    <div class="row">
        <div class="error-img container-fluid d-flex align-items-center justify-content-center text-center">
            <div class="row">
                <div class="col-10 offset-1 col-lg-12 offset-lg-0">
                    <h1 class="fw-bold">{{ $error_name }}</h1>
                    <p class="lead">
                        {{ $spiegazione }}
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-red text-white btn-lg">
                        <i class="bi bi-house"></i> Torna
                        alla
                        Home
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection