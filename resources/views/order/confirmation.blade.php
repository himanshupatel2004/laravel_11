@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Confirmation</h1>
    <p>Thank you for your purchase! Your order has been successfully placed.</p>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total: ${{ $order->total }}</p>
    <p>Payment Method: {{ $order->payment_method }}</p>
</div>
@endsection
