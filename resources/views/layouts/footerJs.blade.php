<script src="{{ url('public/assets/js/vendors.bundle.js') }}"></script>
<script src="{{ url('public/assets/js/app.bundle.js') }}"></script>
<script src="{{ url('public/assets/js/sidebarActive.js') }}"></script>
<script src="{{ url('public/assets/js/parsley.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Sweet Alert---}}
<script src="{{ url('public/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ url('public/assets/js/datagrid/datatables/datatables.bundle.js') }}"></script>

<!-- page select 2 js below -->
<script src="{{ url('public/assets/js/formplugins/select2/select2.bundle.js') }}"></script>

<!-- page ssummer note js below -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>

<!-- common scripts -->
<script src="{{ url('public/assets/js/common.js') }}"></script>


<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize', 'height', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['custom', []] // Add the custom button to the toolbar
            ],
        });


    });
</script>

