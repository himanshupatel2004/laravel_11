<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\PaymentStrategy;
use App\Services\Payment\StripePayment;
use App\Services\Payment\PaypalPayment;
use App\Models\Order;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = $request->input('amount');
        $paymentMethod = $request->input('payment_method');

        $paymentStrategy = $this->getPaymentStrategy($paymentMethod);
        $paymentStrategy->pay($amount);

        // Store transaction details and create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $amount,
            'payment_method' => $paymentMethod,
            'status' => 'completed',
        ]);

        return redirect()->route('order.confirmation', $order->id);
    }

    private function getPaymentStrategy($paymentMethod): PaymentStrategy
    {
        return match ($paymentMethod) {
            'stripe' => new StripePayment(),
            'paypal' => new PaypalPayment(),
            default => throw new \Exception('Payment method not supported'),
        };
    }
}
