<div>
    <div wire:ignore>
        <textarea id="contractBuilder">{{ $contract->content }}</textarea>
    </div>
</div>

@push('js')
    <script src="https://cdn.tiny.cloud/1/d6sx4i8m09pytugxbyqxsawkvj4od5wd1tpn0k1cdkne2jdv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        let contractEditor = tinymce.init({
            selector: '#contractBuilder',
            forced_root_block: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tableofcontents footnotes mergetags autocorrect typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: (editor) => {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on("change", (e) => {
                    @this.set('content', editor.getContent())
                });
            }
        });
    </script>
@endpush