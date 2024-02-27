<div>
    <div>
        <label for="type">Form type</label>
        <select wire:model.live="formType" id="type" class="form-control">
            <option value="form">Form</option>
            <option value="wizard">Wizard</option>
        </select>
    </div>
    <hr>
    <div wire:ignore>
        <div id="builder"></div>
    </div>
</div>

@push('js')
    <script>
        var formBuilder;

        Formio.builder(document.getElementById('builder'), @js($form->form_schema), {
            language: "fr",
        }).then(function (form) {
            formBuilder = form;
            form.on('change', function () {
                @this.
                set('formSchema', form.schema)
            });
        });
    </script>
@endpush