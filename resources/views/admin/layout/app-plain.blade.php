<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicon.png')}}">
    <title>LIMS</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

   <!--  <link href="{{url('/assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{url('/assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{url('/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{url('/assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet"> -->
    <link href="{{url('css/style.css') }}" rel="stylesheet">
    <link href="{{url('css/side-menu.css') }}" rel="stylesheet">
    <link href="{{url('css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!-- <link id="bsdp-css" href="{{url('bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet"> -->
   <!--  <link href="{{ url('https://fonts.googleapis.com/css?family=Roboto:400,500') }}" rel="stylesheet"> -->



    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>

    <link href="{{ url('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/HoldOn.min.css') }}" rel="stylesheet">
    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('js/buttons.flash.min.js') }}"></script>
    <script src="{{ url('js/jszip.min.js') }}"></script>
    <script src="{{ url('js/pdfmake.min.js') }}"></script>
    <script src="{{ url('js/vfs_fonts.js') }}"></script>
    <script src="{{ url('js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('js/buttons.print.min.js') }}"></script>
        <script src="{{ url('js/HoldOn.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


</head>


<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        
        <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <!-- <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Patient</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Add Patient</li>
                        </ol>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <!-- script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script -->

   	<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <script src="{{ url('js/jquery-ui.js') }}"></script>
   	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <link rel="stylesheet" href="{{ url('css/jquery-ui.css') }}"/>



       <script type="text/javascript">
    </script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ url('/assets/plugins/bootstrap/js/tether.min.js') }}"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ url('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ url('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ url('js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ url('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ url('js/custom.js') }}">
    </script>
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- chartist chart
    <script src="{{ url('../assets/plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ url('../assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 JavaScript
    <script src="{{ url('../assets/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ url('../assets/plugins/c3-master/c3.min.js') }}"></script>
    <!-- Chart JS -->
  <!--   <script src="{{ url('js/dashboard1.js') }}"></script> -->
    <script src="{{ url('js/common.js') }}"></script>
    <script>
      //sidemenuitemintoview();
      function sidemenuitemintoview() {
        var a, b, i = 0;
        a = document.getElementById("menu");
        if (!a || !a.getElementsByClassName) {return false;}
        b = a.getElementsByClassName("active");
        if (b.length < 1) {return false;}
        while (!isIntoView(a, b[0])) {
          i++
          if (i > 1000) {break;}
          a.scrollTop += 10;
        }
      }
      function isIntoView(x, y) {
        var a = x.scrollTop;
        var b = a + window.innerHeight;
        var ytop = y.offsetTop;
        var ybottom = ytop + 140;
        return ((ybottom <= b) && (ytop >= a));
      }
      $(document).on("click", "#sidemenu" , function() {
          $(".left-sidebar").toggleClass("hide");
          $(".page-wrapper").toggleClass("menu_hiding");
      });
    </script>


</body>

</html>
