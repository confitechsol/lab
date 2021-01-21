<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <script src="{{ url('/assets/plugins/bootstrap/js/tether.min.js') }}"></script>
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
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar printSection">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header" style="background-color:#e4edf6; width: 21.9%;">
                    <a class="navbar-brand" style="width:90%;float:left;" href="{{ url('/dashboard') }}">
                        <!-- Logo icon -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->

                            <!-- Light Logo icon -->
                            <!-- <img src="{{ url('assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" /></b> -->
                            <img style="height:70px; width:70px;" src="{{ url('/')}}/assets/images/rntcp-logomod.png" />


                        <!--End Logo icon -->
                        <!-- Logo text --></a>
                         <i class="mdi mdi-menu menu-hide" style="width:10%;float:right;" id="sidemenu"></i>

                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-0 mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                       <!--  <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class=" mdi mdi-account-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search Name, Barcode"> <a class="srh-btn"><i class="mdi mdi-close"></i></a> </form>
                        </li> -->
                    </ul>

                    <ul class="navbar-nav ml-sm-4 mr-auto nav-logistics">
                        @yield('primary-nav')
                    </ul>

                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark"
                               data-toggle="dropdown" href="#">
                                <span class="d-flex align-items-center">
                                    <img src="{{url('assets/images/users/1.jpg')}}" class="profile-pic m-r-10" alt="user"/>
                                    <span class="d-inline-block" style="line-height: 1; font-size: 12px;">
                                        {{Auth::user()->name}}
                                        <hr class="my-1 bg-light">
                                        {{ this_lab() ? this_lab()->name : 'CENTRAL' }}
                                    </span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="font-size: 14px;">
                                <a class="dropdown-item"
                                   style="text-align: left"
                                   href="{{ url('/passwordReset') }}">
                                    <i class="mdi mdi-security mdi-dark mr-1"></i> Reset Password
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                <a class="dropdown-item"
                                   style="text-align: left"
                                   href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-power mdi-dark mr-1"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" style="background-color: #f9f9f9;">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <div class="content">


            <nav>
                <div id="menu" class="menu printSection">
                    <!-- @role('equipment')
                        @if(Session::has('due_dates'))
                        @if(Session::get('due_dates'))
                        <div class="alert alert-danger">Equipments:
                          @foreach(Session::get('due_dates') as $due_date)
                          {{$due_date->name}},
                          @endforeach
                        </div>
                        @endif
                        @endif
                    @endrole -->

                    <ul>
                        <li  ><a href="{{ url('/dashboard') }}"><i class="mdi mdi-monitor"></i>Dashboard</a></li>
                        @role('sample_receptionist')
                        <li class="#">
                          <a href="{{ url('/sample') }}"><i class="mdi mdi-test-tube"></i>Sample Opening</a>
                        </li>
                        @endrole
						
						 @role('enrol_nikshay_id')
                        <li class="#">
                          <a href="{{ url('/enrollwithnikshay') }}"><i class="mdi mdi-account-edit"></i>Enrolment with Nikshay ID</a>
                        </li>
                        @endrole

                        @role('enroller')
                        <li class="#">
                          <a href="{{ url('/enroll') }}"><i class="mdi mdi-account-edit"></i>Enrolment</a>
                        </li>
                        @endrole
						
                       
						
                        @role('test_requester')
                        <li class="#">
                          <a href="{{ url('/test_request') }}"><i class="mdi mdi-redo-variant"></i>Test Request</a>
                        </li>
                        @endrole
                        <!-- <li class="#"><a href="{{ url('/patient') }}"><i class="mdi mdi-account-plus"></i>
                        Test Enrolment</a></li> -->




                        <!-- <li><a onclick="$('#subDiagnosis').toggle();" href="#"><i class="mdi mdi-medical-bag"></i>Services</a>
                            <ul id="subDiagnosis" class="submenu"> -->
                                @role('cbnaat')
                                <li><a href="{{ url('/cbnaat') }}"><i class="mdi mdi-tumblr-reblog"></i>CBNAAT</a></li>
                                @endrole

                                @role('microscopy')
                                <li><a href="{{ url('/microscopy/') }}"><i class="mdi mdi-microscope"></i>Microscopy</a></li>
                                @endrole

                                @role('microscopy_review')
                                <li><a href="{{ url('/review_microscopy') }}"><i class="mdi mdi-microscope"></i>Microscopy Next Step</a></li>
                                @endrole

                                @role('decontamination')
                                <li><a href="{{ url('/dash_decontamination') }}"><i class="mdi mdi-rhombus"></i>Decontamination</a></li>
                                @endrole

                                @role('decontamination_review')
                                <li><a href="{{ url('/decontamination') }}"><i class="mdi mdi-rhombus"></i>Decontamination Next Step</a></li>
                                @endrole

                                @role('dna_extraction')
                                <li><a href="{{ url('/DNAextraction') }}"><i class="mdi mdi-snowflake"></i>DNA extraction</a></li>
                                @endrole

                                @role('pcr')
                                <li><a href="{{ url('/PCR') }}"><i class="mdi mdi-snowman"></i>PCR</a></li>
                                @endrole

                                @role('hybridization')
                                <li><a href="{{ url('/hybridization') }}"><i class="mdi mdi-signal-hspa-plus"></i>Hybridization</a></li>
                                @endrole


                                @role('lpa_interpretation')
                                <li><a href="{{ url('/lpa_interpretation') }}"><i class="mdi mdi-stop"></i>LPA Interpretation</a></li>
                                @endrole

                                @role('culture_inoculation')
                                <li><a href="{{ url('/culture_inoculation') }}"><i class="mdi mdi-sigma-lower"></i>AFB Culture inoculation</a></li>
                                @endrole

                                @role('lc_flagged_mgit')
                                <li><a href="{{ url('/lc_flagged_mgit') }}"><i class="mdi mdi-sign-caution"></i>LC Flagged MGIT Tube</a></li>
                                @endrole

                                @role('lc_flagged_mgit_further')
                                <li><a href="{{ url('/further_lc_flagged_mgit') }}"><i class="mdi mdi-sign-caution"></i>LC Reporting</a></li>
                                @endrole

                                @role('lc_result_review')
                                <li><a href="{{ url('/lc_result_review') }}"><i class="mdi mdi-sign-caution"></i>Liquid Culture Result Review</a></li>
                                @endrole
								
								@role('lc_dst_inoculation')
                                <li><a href="{{ url('/lc_dst_inoculation') }}"><i class="mdi mdi-source-commit-end"></i>LC - DST- Inoculation</a></li>
                                @endrole

                                @role('lj')
                                <li><a href="{{ url('/dashboardlj') }}"><i class="mdi mdi-shuffle-disabled"></i>LJ Reporting</a></li>
                                @endrole

                                @role('lj_review')
                                <li><a href="{{ url('/reviewlj') }}"><i class="mdi mdi-shuffle-disabled"></i>LJ Review</a></li>
                                @endrole

                               

                                @role('lj_dst_1st_line')
                                <li><a href="{{ url('/lj_dst_ln1') }}"><i class="mdi mdi-source-commit-end"></i>LJ - DST - Inoculation</a></li>
                                @endrole

                                <!--@role('lj_dst_2st_line')
                                <li><a href="{{ url('/lj_dst_ln2') }}"><i class="mdi mdi-source-commit-end"></i>LJ - DST - 2nd Line</a></li>
                                @endrole -->

                                @role('microbiologist')
                                <li><a href="{{ url('/microbiologist') }}"><i class="mdi mdi-select-inverse"></i>Microbiologist</a></li>
                                @endrole
								
								@role('form15a')
									<li><a onclick="$('#subForm15A').toggle();" href="#"><i class="mdi mdi-information"></i>Annexure 15A</a>
									  <ul id="subForm15A" class="submenu">
										<li><a href="{{ url('/annexure15a') }}">CURRENT</a></li>
										<li><a href="{{ url('/history') }}">HISTORY</a></li>
									  </ul>
									</li>
                                @endrole
								
                                @role('Current_Status')
                                <li><a href="{{ url('/searchform') }}"><i class="mdi mdi-select"></i>Current Status</a></li>
                                @endrole
								
								@role('sample_storage')
                                <li><a href="{{ route('sample-storage.index') }}"><i class="mdi mdi-store"></i>Storage</a></li>
                                @endrole

                                @role('biowaste')
                                <li><a href="{{ url('/bioWaste') }}"><i class="mdi mdi-delete"></i>Biomedical Waste Management System</a></li>
                                @endrole
								
								@role('barcodes')
                                <li><a href="{{ url('/barcodes') }}"><i class="mdi mdi-star"></i>Barcode Print</a></li>
                                @endrole
                                <!--<li><a href="{{ url('/form') }}"><i class="mdi mdi-clipboard-arrow-down"></i>LPA Conta Event Report</a></li>-->
                                @role('report')
                                <li><a onclick="$('#subDiagnosis').toggle();" href="#"><i class="mdi mdi-medical-bag"></i>Report</a>
                                  <ul id="subDiagnosis" class="submenu">
									<li><a href="{{ url('/report/performance_indicator') }}">Performance indictors</a></li>
									<li><a href="{{ url('/report/cbnaat_monthly_report') }}">CBNAAT Monthly Reports</a></li>
									<!--<li><a href="{{ url('/annexurel') }}" target="_blank">Annexure 15L</a></li>--->
									<li><a href="{{ url('/report/annexurel') }}">Annexure 15L</a></li>
									<li><a href="{{ url('/report/referral_indicator') }}">Referral indicators</a></li>
                                    <li><a href="{{ url('/report/workload') }}">Sample workload</a></li>
                                    <li><a href="{{ url('/report/lqc_indicator') }}">LAB QC indicator</a></li>
                                    <li><a href="{{ url('/report/lqcIndicator_tat') }}">LAB QC indictor TAT </a></li>
                                    <li><a href="{{ url('/report/quality_indicator') }}">Quality indicator test wise </a></li>
                                    
                                    
                                   
                                    <!-- <li><a href="{{ url('/annexurek') }}" target="_blank">Annexure 15K</a></li> -->
                                    
                                   
                                    <li><a href="{{ url('/report/result_edit') }}">Test Result Edit Report</a></li>
									<li><a href="{{ url('/report/lpa_conta_event') }}">LPA Contra Event Report</a></li>
									<li><a href="{{ url('/report/test_result_status_nikshay') }}">Test Result Status (Nikshay)</a></li>
                                  </ul>
                                </li>
                                @endrole

                                 @role('hr')
                                <li><a href="{{ url('/hr') }}"><i class="mdi mdi-plus-box"></i>HR</a></li>
                                @endrole

                                @role('equipment')
                                <li><a href="{{ url('/equipment') }}"><i class="mdi mdi-select"></i>Equipment</a></li>
                                @endrole


                                @role('user_management')
                                <li><a href="{{ url('/adduser') }}"><i class="mdi mdi-plus"></i>User Management Module</a></li>
                                @endrole



                                @role('config_management')
                                <li><a href="{{ url('/laboratory') }}"><i class="mdi mdi-tumblr-reblog"></i>Configuration Management Module</a></li>
                                @endrole


                               
                                


                                <!--
                               @role('vendor_shipment')
                                <li><a href="{{ route('sample-storage.index') }}"><i class="mdi mdi-store"></i>Vendor Shipment</a></li>
                                @endrole
                            -->
                            
                                <!--li>
                                    <a href="{{ route('logistics.dashboard') }}">
                                    <i class="mdi mdi-select"></i> Logistics
                                    </a>
                                </li-->

                                <!-- @role('change_role')
                                <li><a href="{{ url('/user_role') }}"><i class="mdi mdi-plus"></i>Role Management Module</a></li>
                                @endrole -->






                </div>
            </nav>
        </div>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->

    <!-- Bottom points-->

    <!-- End Bottom points-->
  </aside>
  @yield('content')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
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
        <!-- End Page wrapper  -->
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
    <script src="{{ url('js/custom.js') }}"></script>
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- chartist chart
    <script src="{{ url('../assets/plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ url('../assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 JavaScript
    <script src="{{ url('../assets/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ url('../assets/plugins/c3-master/c3.min.js') }}"></script>
    <!-- Chart JS -->
    <!-- <script src="{{ url('js/dashboard1.js') }}"></script> -->
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



    @yield('footer')

</body>

</html>
