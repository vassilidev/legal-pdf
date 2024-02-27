@extends('layouts.backoffice')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" id="progressBar" role="progressbar"></div>
                </div>
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
        Formio.createForm(document.getElementById('form'), @js($contract->form->form_schema))
            .then(function (form) {
                var navigation = document.querySelector('.formio-wizard-navigation');
                if (navigation) {
                    navigation.style.display = 'none';
                }

                let totalPages = form.pages.length;

                updateProgressBar(0, totalPages);

                form.on('nextPage', (page) => updateProgressBar(page.page))
                form.on('prevPage', (page) => updateProgressBar(page.page))

                function updateProgressBar(currentPage) {
                    let percentage = Math.floor((currentPage + 1) / totalPages * 100);

                    document.getElementById('progressBar').style.width = percentage + '%';
                    document.getElementById('progressBar').innerText = percentage + '%';
                }
            })
    </script>
@endpush

@push('css')
    <style>
        .formio-form ul.pagination {
            display: none;
        }

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
