<!DOCTYPE html>
<html lang="en">

<head>
    <!-- --------------------------------------------------- -->
    <!-- Title -->
    <!-- --------------------------------------------------- -->
    <title>Lead CRM | {{ Str::of($title)->title() }}</title>

    <!-- --------------------------------------------------- -->
    <!-- Required Meta Tag -->
    <!-- --------------------------------------------------- -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- --------------------------------------------------- -->
    <!-- Favicon -->
    <!-- --------------------------------------------------- -->
    <link rel="shortcut icon" type="image/png" href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />

    @if ($title == 'dashboard')
       <!-- Owl Carousel  -->
      <link rel="stylesheet" href="{{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    @endif

    @if ($title == 'fresh recent leads' || $title == 'all leads')
    <!-- datatable  Js -->
    <link rel="stylesheet" href="{{ asset('dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    @endif

    <!-- --------------------------------------------------- -->
    <!-- Core Css -->
    <!-- --------------------------------------------------- -->

    <link  id="themeColors"  rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}" />
    <link  id="themeColors"  rel="stylesheet" href="{{ asset('dist/css/custom.css') }}" />
    @livewireStyles
  </head>

  <body>
    <!-- Preloader -->
    <div class="preloader">
      <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <livewire:components.alart-box/>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

      <livewire:components.sidebar/>

      <div class="body-wrapper">

        <livewire:components.header/>

          {{ $slot }}

      </div>
    </div>


    <!--  Mobilenavbar -->
    <livewire:components.mobile-navbar/>

    <!--  Search Bar -->
    <livewire:components.search-bar/>

    <!-- ---------------------------------------------- -->
    <!-- Import Js Files -->
    <!-- ---------------------------------------------- -->
    <script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/plugins/sweet-alert.min.js') }}"></script>

    <!-- ---------------------------------------------- -->
    <!-- core files -->
    <!-- ---------------------------------------------- -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>

    <script src="{{ asset('dist/js/custom.js') }}"></script>
    <script src="{{ asset('dist/libs/prismjs/prism.js') }}"></script>

    <!--  current page js files -->
    @if ($title == 'dashboard')
    <script src="{{ asset('dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    @endif

    @if ($title == 'fresh recent leads')
    <script src="{{ asset('dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
    <script src="{{ asset('cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') }}"></script>
    <script src="{{ asset('cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.5.1/js/fixedColumns.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/leads-page.js') }}"></script>
    @endif

    @if ($title == 'all leads' || 'old data leads')
    <script src="{{ asset('dist/js/pages/all-leads.js') }}"></script>
    @endif

    @if ($title == "lead comments & activities")
    <script src="{{ asset('dist/js/pages/lead-comments.js') }}"></script>
    <script type="text/javascript">
      window.onscroll = function (ev) {
          if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 15) {
              window.livewire.emit('load-more');
          }
      };
  </script>
    @endif

    <script>
      window.addEventListener('pushToast', event => {
          const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              //background: 'green',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
          })

          Toast.fire({
              icon: event.detail.icon,
              title: event.detail.title
          })
      })
    </script>
    @livewireScripts
  </body>

</html>
