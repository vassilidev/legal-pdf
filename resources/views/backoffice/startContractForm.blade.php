@extends('layouts.backoffice')

@section('content')
    <div class="container">
        <div class="progress">
            <div class="progress-bar progress-bar-striped" id="progressBar" role="progressbar"></div>
        </div>
        <div id="form"></div>
    </div>

    <div class="border">
        {!! $contract->render() !!}
    </div>
@endsection

@push('js')
    <script>
        Formio.createForm(document.getElementById('form'), @js($contract->form->form_schema))
            .then(function (form) {
                let navigation = document.querySelector('.formio-wizard-navigation');

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
    </style>
@endpush
