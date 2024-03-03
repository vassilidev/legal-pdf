@extends('layouts.backoffice')

@section('content')
    <div class="container m-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Payment Details</h5>
            </div>
            <div class="card-body">
                <form id="payment-form" action="{{ route('order.process-payment', $order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_intent_client_secret"
                           value="{{ $paymentIntent->client_secret }}">
                    <input type="hidden" name="payment_intent_id" value="{{ $paymentIntent->id }}">

                    <div class="mb-3">
                        <label for="card-holder-name" class="form-label">Card holder</label>
                        <input id="card-holder-name" type="text" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="card-element" class="form-label">Card Details</label>
                        <div id="card-element" class="form-control"></div>
                    </div>

                    <button id="card-button" class="btn btn-primary">
                        <span id="payment-btn-text">Process Payment for {{ $order->price / 100 . $order->currency->getSymbol()}}</span>
                        <span id="payment-btn-loader" class="spinner-border spinner-border-sm d-none" role="status"
                              aria-hidden="true"></span>
                    </button>

                    <div id="payment-error-message" class="alert alert-danger mt-3 d-none" role="alert"></div>
                </form>
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
            const cardButton = document.getElementById('card-button');
            const form = document.getElementById('payment-form');
            const clientSecret = document.querySelector('input[name=payment_intent_client_secret]').value;
            const paymentBtnText = document.getElementById('payment-btn-text');
            const paymentBtnLoader = document.getElementById('payment-btn-loader');
            const paymentErrorMessage = document.getElementById('payment-error-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                cardButton.disabled = true;
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

                    cardButton.disabled = false;
                    paymentBtnText.textContent = 'Process Payment';
                    paymentBtnLoader.classList.add('d-none');
                } else {
                    form.submit();
                }
            });
        });

    </script>
@endpush
