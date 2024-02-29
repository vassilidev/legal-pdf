<div>
    <div>
        @if(optional($contract->form->form_schema)['display'] === 'wizard')
            <div class="progress">
                <div class="progress-bar progress-bar-striped" id="progressBar" role="progressbar"></div>
            </div>
        @endif

        <div class="card mx-5">
            <div class="card-body bg-light">
                <div id="form" wire:ignore></div>
            </div>
        </div>
    </div>

    @if($data)
        <hr>

        <div class="border p-5" id="render">
            {!! $contract->render($data) !!}
        </div>
    @endif
</div>

@script
    <script>
        Formio.createForm(document.getElementById('form'), @js($contract->form->form_schema), {
            buttonSettings: {
                showCancel: false,
            },
        }).then(function (form) {
            @this.set('data', form.data);

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
                @this.set('data', form.data)
            });
        })
    </script>
@endscript

@push('css')
    <style>
        .formio-form ul.pagination {
            display: none;
        }

        #render {
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently supported by Chrome and Opera */
            background: url(https://i.ibb.co/09Jvc9s/Mask-group.png);
            background-repeat: round;
        }
    </style>
@endpush