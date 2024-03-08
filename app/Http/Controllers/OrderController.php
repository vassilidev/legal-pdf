<?php

namespace App\Http\Controllers;

use App\Enums\Stripe\PaymentIntentStatus;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pdf;
use Stripe\Exception\ApiErrorException;

class OrderController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function paymentView(Order $order)
    {
        $paymentIntent = $order->stripePaymentIntent;

        if ($paymentIntent->status === PaymentIntentStatus::SUCCEEDED->value) {
            return to_route('order.succeeded', $order);
        }

        return view('backoffice.orders.payment', compact('order', 'paymentIntent'));
    }

    public function processPayment(PaymentRequest $request, Order $order): mixed
    {
        if ($order->stripePaymentIntent->status === PaymentIntentStatus::SUCCEEDED->value) {
            if ($order->payment_status !== PaymentIntentStatus::SUCCEEDED) {
                $order->update(['payment_status' => PaymentIntentStatus::SUCCEEDED]);
            }

            $order->update([
                'invoicing_address' => $request->get('invoicing_address'),
                'invoicing_name'    => $request->get('invoicing_name'),
            ]);

            return to_route('order.succeeded', $order);
        }

        return back();
    }

    public function succeeded(Order $order)
    {
        return view('backoffice.orders.succeeded', compact('order'));
    }

    public function pdf(Order $order)
    {
        if (Auth::user()->isNot($order->user)) {
            return back();
        }

        $contract = $order->contract;
        $answers = $order->answers;

        return Pdf::loadView('contracts.pdf', compact('contract', 'order', 'answers'))
            ->stream($contract->name . '.pdf');
    }

    public function invoice(Order $order)
    {
        return Pdf::loadView('pdf.invoice', compact('order'))->stream();
    }
}
