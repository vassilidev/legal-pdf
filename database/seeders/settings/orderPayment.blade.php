@extends('layouts.backoffice')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">@lang('order.product_details')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('order.product_name')</th>
                                    <th>@lang('order.price')</th>
                                    <th>@lang('order.quantity')</th>
                                    <th>@lang('order.total')</th>
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
                                    <td class="fw-bold">@lang('order.total')</td>
                                    <td>{{ formatCurrency($order->getTotalDue(), $order->currency) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Add more information about the product here -->
                        <div class="mt-3 small">
                            <p><strong>@lang('order.order_uuid'):</strong> {{ $order->id }}</p>
                            <p><strong>@lang('order.email'):</strong> {{ $order->email }}</p>
                            <p><strong>@lang('order.order_date')
                                    :</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>@lang('order.order_link'):</strong> <a
                                    href="{{ route('order.payment-view', $order) }}">{{ route('order.payment-view', $order) }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title">@lang('order.payment_details')</h5>
                    </div>
                    <div class="card-body">
                        <form id="payment-form" action="{{ route('order.process-payment', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_intent_client_secret"
                                   value="{{ $paymentIntent->client_secret }}">
                            <input type="hidden" name="payment_intent_id" value="{{ $paymentIntent->id }}">


                            <div class="mb-3">
                                <label for="card-holder-name" class="form-label">@lang('order.card_holder')</label>
                                <input type="text"
                                       name="cardHolder"
                                       class="form-control"
                                       id="card-holder-name"
                                       placeholder="@lang('order.card_holder_placeholder')">
                            </div>
                            <div class="mb-3">
                                <label for="card-element" class="form-label">@lang('order.card_details')</label>
                                <div id="card-element" class="form-control"></div>
                            </div>
                            <hr>
                            <h5>@lang('order.invoicing')</h5>
                            <div class="mb-3">
                                <label for="invoice-name" class="form-label">@lang('order.invoicing_name')</label>
                                <input type="text"
                                       class="form-control"
                                       id="invoice-name"
                                       name="invoicing_name"
                                       placeholder="@lang('order.invoicing_name_placeholder')"
                                       required>
                                @error('invoicing_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="invoice-address" class="form-label">@lang('order.invoicing_address')</label>
                                <input type="text"
                                       class="form-control"
                                       id="invoice-address"
                                       name="invoicing_address"
                                       placeholder="@lang('order.invoicing_address_placeholder')"
                                       required>
                                @error('invoicing_address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button id="payment-button" class="btn btn-primary">
                                <span id="payment-btn-text">@lang('order.pay_now')</span>
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
                    paymentBtnText.textContent = '@lang('order.pay_now')';
                    paymentBtnLoader.classList.add('d-none');
                } else {
                    form.submit();
                }
            });
        });

    </script>
@endpush
