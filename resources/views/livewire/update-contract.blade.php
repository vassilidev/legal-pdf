<div>
    <div wire:ignore>
        <textarea id="contractBuilder">{{ $contract->content }}</textarea>
    </div>
</div>

@push('js')
    <script src="https://cdn.tiny.cloud/1/d6sx4i8m09pytugxbyqxsawkvj4od5wd1tpn0k1cdkne2jdv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        tinymce.PluginManager.add('customButtons', function (editor) {
            editor.ui.registry.addButton('answers', {
                text: 'Answers',
                onAction: function () {
                    editor.insertContent('\{\{ $answers[\'\'] \}\}');
                }
            });

            editor.ui.registry.addButton('nextArticleNumber', {
                text: 'Next Article Number',
                onAction: function () {
                    editor.insertContent('#nextArticleNumber#');
                }
            });

            editor.ui.registry.addButton('articleNumber', {
                text: 'Current Article Number',
                onAction: function () {
                    editor.insertContent('#articleNumber#');
                }
            });

            editor.ui.registry.addButton('loop', {
                text: 'Loop',
                onAction: function () {
                    editor.insertContent(@js($this->loop));
                }
            });
        });

        let contractEditor = tinymce.init({
            selector: '#contractBuilder',
            forced_root_block: false,
            plugins: 'customButtons anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tableofcontents footnotes autocorrect typography inlinecss',
            toolbar: 'answers nextArticleNumber articleNumber loop | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: (editor) => {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on("change", (e) => {
                    @this.
                    set('content', editor.getContent())
                });
            }
        });
    </script>
@endpush