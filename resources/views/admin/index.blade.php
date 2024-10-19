@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Panel - Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Products</th>
                <th>Total</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name }} ({{ $item->quantity }} x ${{ $item->price }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>${{ $order->total }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
