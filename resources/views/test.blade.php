@extends('layouts.backoffice')

@section('content')
    <div class="container m-4">
        <form action="">
            <div class="mb-4">
                <label for="card-holder-name">Card holder</label>
                <input id="card-holder-name" type="text" class="form-control">
            </div>

            <div class="mb-4">
                <div id="card-element" class="form-control"></div>
            </div>

            <button id="card-button" class="btn btn-success">
                Process Payment
            </button>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe(@js(config('cashier.key')));

        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            hidePostalCode: true,
        });

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user...
            } else {
                // The card has been verified successfully...
            }
        });
    </script>
@endpush