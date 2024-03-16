<div>
    <div>
        <div class="card mx-5" wire:ignore>
            @if(optional($contract->form_schema)['display'] === 'wizard')
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" id="progressBar" role="progressbar"></div>
                </div>
            @endif
            <div class="card-body p-4 shadow bg-light">
                <h2>{{ $contract->name }}</h2>
                <div id="form"></div>
            </div>
        </div>
    </div>

    @if($data)
        <div class="border border-top-0 border-4 shadow p-5" dir="{{ $contract->direction }}" id="render">
            {!! $contract->render($data) !!}
        </div>
    @endif

    <form action="{{ route('survey.process', $contract) }}" method="POST" id="process">
        @csrf
        <input type="hidden" name="submission" id="submission">
    </form>
</div>

@script
<script>
    Formio.createForm(document.getElementById('form'), @js($contract->final_schema), {
        buttonSettings: {
            showCancel: false,
            showPrevious: false,
        },
    }).then(function (form) {
        @this.set('data', form.data);

        let navigation = document.querySelector('.formio-wizard-navigation');

        if (navigation) {
            navigation.style.display = 'none';
        }

        let totalPages = form?.pages?.length ?? 0;

        if (totalPages) {
            updateProgressBar(form.page);
        }

        form.on('nextPage', (page) => updateProgressBar(page.page))
        form.on('prevPage', (page) => updateProgressBar(page.page))

        function updateProgressBar(currentPage) {
            let percentage = Math.floor((currentPage + 1) / totalPages * 100);

            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressBar').innerText = percentage + '%';
        }

        form.on('submit', function (form) {
            document.getElementById('submission').value = JSON.stringify(form);
            document.getElementById('process').submit();
        });

        form.on('change', function (form) {
            @this.
            set('data', form.data);
        });
    })
</script>
@endscript

@push('css')
    <style>
        /* Ensure buttons are displayed inline */
        .list-inline {
            margin-top: 10px;
            display: flex;
            justify-content: end;
        }

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

        .blur {
            color: transparent;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
@endpush