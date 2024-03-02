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

        function addKeyToLabel(component) {
            if (component.label && component.key) {
                component.label += ' <small class="text-secondary fw-bold">(' + component.key + ')</small>';
            }
            if (component.components) {
                component.components.forEach(childComponent => {
                    addKeyToLabel(childComponent); // Recursively handle nested components
                });
            }
        }

        function renderForm(schema) {
            Formio.createForm(document.getElementById('render'), schema);

            addKeyToLabel(schema)
        }

        renderForm(schema);

        Formio.builder(document.getElementById('builder'), schema, {
            noDefaultSubmitButton: true,
        }).then(function (form) {
            formBuilder = form;
            form.on('change', function () {
                @this.set('formSchema', form.schema);

                renderForm(form.schema);
            });
        });
    </script>
@endpush