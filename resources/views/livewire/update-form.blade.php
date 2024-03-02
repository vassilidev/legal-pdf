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

        let schema = @js($contract->form_schema);

        function renderForm(schema) {
            Formio.createForm(document.getElementById('render'), schema).then(function (form) {
                form.components.forEach(component => {
                    let el = component.element.querySelector('label');

                    if (el) {
                        el.innerHTML = el.innerHTML + ' (<small>' + component.key + '</small>)';
                    }
                });
            });
        }

        renderForm(schema);

        Formio.builder(document.getElementById('builder'), schema, {
            noDefaultSubmitButton: true,
        }).then(function (form) {
            formBuilder = form;
            form.on('change', function () {
                @this.
                set('formSchema', form.schema);

                renderForm(form.schema);
            });
        });
    </script>
@endpush
