<!doctype html>
<html lang="pt-br">
@include('layouts._includes.admin.head')
<body id='verticalLight' class="vertical light ">


        @if (!isset($login))
            @include('layouts._includes.admin.menu')
            <main role="main" class="main-content">
                @yield('conteudo')
            </main>
        @else
            @yield('conteudo')
        @endif




    </div> <!-- .wrapper -->


    <script src="{{ asset('painel/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{asset('painel/js/popper.min.js')}}"></script>
    <script src="{{asset('painel/js/moment.min.js')}}"></script>
    <script src="{{asset('painel/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('painel/js/simplebar.min.js')}}"></script>
    <script src="{{asset('painel/js/daterangepicker.js')}}"></script>
    <script src="{{asset('painel/js/jquery.stickOnScroll.js')}}"></script>
    <script src="{{asset('painel/js/tinycolor-min.js')}}"></script>
    <script src="{{asset('painel/js/config.js')}}"></script>
    <script src="{{asset('painel/js/d3.min.js')}}"></script>
    <script src="{{asset('painel/js/topojson.min.js')}}"></script>
    <script src="{{asset('painel/js/datamaps.all.min.js')}}"></script>
    <script src="{{asset('painel/js/datamaps-zoomto.js')}}"></script>
    <script src="{{asset('painel/js/datamaps.custom.js')}}"></script>
    <script src="{{asset('painel/js/Chart.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    /* defind global options */
    <script>
        Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
        Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="{{asset('painel/js/gauge.min.js')}}"></script>
    <script src="{{asset('painel/js/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('painel/js/apexcharts.min.js')}}"></script>
    <script src="{{asset('painel/js/apexcharts.custom.js')}}"></script>
    <script src="{{asset('painel/js/apps.js')}}"></script>
    <!--Select2-->
    <script src="{{asset('painel/js/select2.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (session('feedback'))
    {{-- @dump(session('feedback')); --}}

    @if (isset(session('feedback')['type']))
        <script>
            Swal.fire(
                '{{ session('feedback')['sms'] }}',
                '',
                '{{ session('feedback')['type'] }}'
            )
        </script>
    @endif
@endif
<script src="{{ asset('painel/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('painel/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            lengthMenu: [
                [10, 16, 32, 64, -1],
                [10, 16, 32, 64, "All"]
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            },
            ordering: false // Definindo a primeira coluna (0) como a coluna de ordenação inicial em ordem ascendente ('asc')
        });

    </script>
    <style>
        /* style a mexer */
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px;
            user-select: none;
            -webkit-user-select: none;
        }
    </style>
    <script>
        $('.select2').select2({
            theme:"bootstrap4",
        });
    </script>


  </body>
