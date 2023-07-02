<div>
    @if(session()->has('status'))
    <script>
      document.addEventListener("DOMContentLoaded", function (e) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: '{{ session()->get('icon') }}',
            title: '{{ session()->get('title') }}'
        })
      })
      </script>
    @endif
</div>
