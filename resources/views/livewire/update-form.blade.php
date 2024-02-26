<div>
    <div id="builder" wire:ignore></div>
</div>

@push('js')
    <script>
        let formBuilder = Formio.builder(document.getElementById('builder'), @js($form->form_schema), {
            language: "fr",
        }).then(function (form) {
            form.on('change', function () {
                @this.set('formSchema', form.schema)
            });
        });
    </script>
@endpush