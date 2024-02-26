@extends('layouts.backoffice')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="form"></div>
            </div>
            <div class="col-md-6">
                <div class="iframe-container">
                    <iframe id="live-iframe" src="{{ route('pdf.contract', $contract) }}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        Formio.createForm(document.getElementById('form'), @js($contract->form->form_schema));
    </script>
@endpush

@push('css')
    <style>
        .iframe-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* Adjust this value according to your iframe's aspect ratio */
        }
        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            pointer-events: none;
            height: 100%;
            border: none; /* Removes the border around the iframe */
        }
    </style>
@endpush
