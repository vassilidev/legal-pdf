<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div wire:ignore>
        <textarea id="contractBuilder">{{ $contract->content }}</textarea>
    </div>

    <button onclick="saveContent()" class="btn btn-success">Save Contract</button>
</div>

@push('js')
    <script src="https://cdn.tiny.cloud/1/d6sx4i8m09pytugxbyqxsawkvj4od5wd1tpn0k1cdkne2jdv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        let contractEditor = tinymce.init({
            selector: '#contractBuilder',
            toolbar_sticky: true,
            visualblocks_default_state: true,
            plugins: 'directionality anchor autoresize autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'helpers ltr rtl lineheight | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align | numlist bullist indent outdent | emoticons charmap | removeformat',
            line_height_formats: '0.6 0.7 0.8 0.9 1.0 1.1 1.2 1.3 1.4 1.5 1.6 1.7 1.8 1.9 2.0',
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