<div>
    <div>
        @if(optional($contract->form->form_schema)['display'] === 'wizard')
            <div class="progress">
                <div class="progress-bar progress-bar-striped" id="progressBar" role="progressbar"></div>
            </div>
        @endif

        <div id="form" wire:ignore></div>
    </div>

    @if($data)
        <div class="border p-5">
            {!! $contract->render($data) !!}
        </div>
    @endif
</div>

@push('js')
    <script>
        Formio.createForm(document.getElementById('form'), @js($contract->form->form_schema), {
            buttonSettings: {
                showCancel: false,
            },
        }).then(function (form) {
            @this.
            set('data', form.data)

            let navigation = document.querySelector('.formio-wizard-navigation');

            if (navigation) {
                navigation.style.display = 'none';
            }

            let totalPages = form?.pages?.length ?? 0;

            if (totalPages) {
                updateProgressBar(0, totalPages);
            }

            form.on('nextPage', (page) => updateProgressBar(page.page))
            form.on('prevPage', (page) => updateProgressBar(page.page))

            function updateProgressBar(currentPage) {
                let percentage = Math.floor((currentPage + 1) / totalPages * 100);

                document.getElementById('progressBar').style.width = percentage + '%';
                document.getElementById('progressBar').innerText = percentage + '%';
            }

            form.on('change', function (form) {
                @this.
                set('data', form.data)
            });
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