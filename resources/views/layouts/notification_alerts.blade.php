<script>
    $(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if(Session::has('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ Session::get('success') }}",
            // background: '#dff0d8',
            color: '#3c763d',
        })
        @php
            Session::forget('success');
        @endphp
        @endif


        @if(Session::has('error'))

        Toast.fire({
            icon: 'error',
            title: "{{ Session::get('error') }}",
            // background: '#f2dede',
            color: '#a94442',
        })
        @php
            Session::forget('error');
        @endphp

        @endif

        @if($errors->any())

        @foreach ($errors->all() as $error)
        Toast.fire({
            icon: 'error',
            title: "{{ $error }}",
            //background: '#f2dede',
            color: '#a94442',
        })
        @endforeach

        @php
            Session::forget('error');
        @endphp

        @endif
    });
</script>
