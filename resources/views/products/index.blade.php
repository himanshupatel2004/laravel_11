@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3">
            <div class="card mb-4">
                <img src="{{ asset('products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style=" height:200px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">${{ $product->price }}</p>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
