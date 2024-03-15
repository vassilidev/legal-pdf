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
            @if($contract->direction == 'rtl')

            content_style: "body { font-family: Changa; }",

            @endif
            selector: '#contractBuilder',
            toolbar_sticky: true,
            directionality: @js($contract->direction),
            visualblocks_default_state: true,
            font_family_formats: 'RTL=Changa; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
            plugins: 'anchor autoresize autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'helpers lineheight | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align | numlist bullist indent outdent | emoticons charmap | removeformat',
            line_height_formats: '0.6 0.7 0.8 0.9 1.0 1.1 1.2 1.3 1.4 1.5 1.6 1.7 1.8 1.9 2.0',
            font_size_formats: '1pt 2pt 3pt 4pt 5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt 37pt 38pt 39pt 40pt 41pt 42pt 43pt 44pt 45pt 46pt 47pt 48pt 49pt 50pt',
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