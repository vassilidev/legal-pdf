<div>
    <div wire:ignore>
        <textarea id="contractBuilder">{{ $contract->content }}</textarea>
    </div>

    <button onclick="saveContent()" class="btn btn-success">Update Contract</button>
</div>

@push('js')
    <script src="https://cdn.tiny.cloud/1/d6sx4i8m09pytugxbyqxsawkvj4od5wd1tpn0k1cdkne2jdv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        let contractEditor = tinymce.init({
            selector: '#contractBuilder',
            toolbar_sticky: true,
            visualblocks_default_state: true,
            plugins: 'anchor autoresize autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tableofcontents footnotes autocorrect typography inlinecss',
            toolbar: 'helpers | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: function (editor) {
                var items = [];

                @foreach($this->editorUis ?? [] as $template)

                items.push({
                    type: 'menuitem',
                    text: @js($template->name),
                    onAction: function () {
                        editor.insertContent(@js($template->content));
                    }
                });

                @endforeach

                editor.ui.registry.addMenuButton('helpers', {
                    text: 'Helpers',
                    fetch: function (callback) {
                        callback(items);
                    }
                });
            }
        });

        function saveContent() {
            let content = tinymce.activeEditor.getContent();

            @this.
            set('content', content)
        }
    </script>
@endpush