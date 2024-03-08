@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ formatCurrency($product->unit_price, $order->currency) }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ formatCurrency($product->getTotalPrice(), $order->currency) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="table-secondary">
                                    <td colspan="2"></td>
                                    <td class="fw-bold">Total</td>
                                    <td>{{ formatCurrency($order->getTotalDue(), $order->currency) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Add more information about the product here -->
                        <div class="mt-3 small">
                            <p><strong>Order UUID:</strong> {{ $order->id }}</p>
                            <p><strong>Email</strong> {{ $order->email }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Order Link:</strong> <a
                                        href="{{ route('order.payment-view', $order) }}">{{ route('order.payment-view', $order) }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">Payment and Invoice Details</h5>
                    </div>
                    <div class="card-body">
                        <form id="payment-form" action="{{ route('order.process-payment', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_intent_client_secret"
                                   value="{{ $paymentIntent->client_secret }}">
                            <input type="hidden" name="payment_intent_id" value="{{ $paymentIntent->id }}">


                            <div class="mb-3">
                                <label for="card-holder-name" class="form-label">Card Holder Name</label>
                                <input type="text"
                                       name="cardHolder"
                                       class="form-control"
                                       id="card-holder-name"
                                       placeholder="John Doe">
                            </div>
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Card Details</label>
                                <div id="card-element" class="form-control"></div>
                            </div>
                            <hr>
                            <h5>Invoicing</h5>
                            <div class="mb-3">
                                <label for="invoice-name" class="form-label">Name</label>
                                <input type="text"
                                       class="form-control"
                                       id="invoice-name"
                                       name="invoicing_name"
                                       placeholder="John Doe"
                                       required>
                                @error('invoicing_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="invoice-address" class="form-label">Address</label>
                                <input type="text"
                                       class="form-control"
                                       id="invoice-address"
                                       name="invoicing_address"
                                       placeholder="123 Main St, City, Country"
                                       required>
                                @error('invoicing_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button id="payment-button" class="btn btn-primary">
                                <span id="payment-btn-text">Pay Now</span>
                                <span id="payment-btn-loader" class="spinner-border spinner-border-sm d-none"
                                      role="status"
                                      aria-hidden="true"></span>
                            </button>
                            <div id="payment-error-message" class="alert alert-danger mt-3 d-none" role="alert"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('{{ config('cashier.key') }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                hidePostalCode: true,
            });

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const paymentButton = document.getElementById('payment-button');
            const form = document.getElementById('payment-form');
            const clientSecret = document.querySelector('input[name=payment_intent_client_secret]').value;
            const paymentBtnText = document.getElementById('payment-btn-text');
            const paymentBtnLoader = document.getElementById('payment-btn-loader');
            const paymentErrorMessage = document.getElementById('payment-error-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                paymentButton.disabled = true;
                paymentBtnText.textContent = 'Processing...';
                paymentBtnLoader.classList.remove('d-none');

                const {paymentIntent, error} = await stripe.confirmCardPayment(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );

                if (error) {
                    paymentErrorMessage.textContent = error.message;
                    paymentErrorMessage.classList.remove('d-none');

                    paymentButton.disabled = false;
                    paymentBtnText.textContent = 'Pay Now';
                    paymentBtnLoader.classList.add('d-none');
                } else {
                    form.submit();
                }
            });
        });

    </script>
@endpush
