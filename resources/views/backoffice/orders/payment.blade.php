{!! Blade::render(setting('orders.payment'), [
    'order' => $order,
    'paymentIntent' => $paymentIntent
]) !!}
