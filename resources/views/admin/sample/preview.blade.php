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


<style>
.card-block {

    -webkit-box-flex: 1;
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0.25rem;

}

.page-titles {

    padding-bottom: 20px;

}


.page-titles {

    background: #F2F2F2;
    margin: 15px 0px 20px 0px;
    padding: 10px;
    padding-bottom: 10px;
    padding-bottom: 10px;
    padding-bottom: 10px;
    -webkit-box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
    box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #BFDFFF;
    font-family: Times New Roman;
    font-size: 19px;
    font-weight: bold;

}

.page-titles-1 {

    background: #E5F2FF;
    margin: 15px 0px 20px 0px;
    padding: 10px;
    padding-bottom: 10px;
    padding-bottom: 10px;
    padding-bottom: 10px;
    -webkit-box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
    box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #BFDFFF;
    font-family: Times New Roman;
    font-size: 19px;
    font-weight: bold;

}









.footer {

    bottom: 0;
    color: #67757c;
    left: 0px;
    padding: 17px 15px;
    position: absolute;
    right: 0;
    border-top: 1px solid rgba(120, 130, 140, 0.13);
    background: #ffffff;
    text-align: center;

}
</style>

</head>


<body class="card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->

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







              <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Sample Opening Preview</h3>

                    </div>

                   </div>

                   <div class="row page-titles-1">

                       <div class="col-md-7 col-4 align-self-center">
                         <div style="padding-left:30px;">
                           <p>No. of samples created : {{$data['sample_detail']->no_of_samples}}</p>
                           <p>Enrolment Number : {{$data['enroll']->enroll}}</p>
                           <p>Name : {{$data['sample_detail']->name}}</p>
                        </div>

                      </div>
                   </div>


                   <div class="row">

                       <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                           <div class="card" style="border: none;">
                               <div class="card-block">
                                   <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                       <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                           <thead>
                                               <tr>
                                                 <th class="hide">ID</th>
                                                 <th>Sample ID</th>
                                                 <th>Date of Receipt</th>
                                                 <th>Sample type</th>
                                                 <th>Other Sample type</th>
                                                 <th>Sample Accepted/Rejected</th>
                                                 <th>Rejection reason</th>

                                                 <th>Sample Quality</th>
                                                 <th>Reason for Test</th>

                                                 <th>Follow up month</th>
                                                 <th>Sample sent to</th>

                                               </tr>
                                           </thead>
                                           <tbody>

                                             @foreach ($data['sample'] as $key=> $samples)
                                             <tr>
                                               <td class="hide">{{$samples->enroll_id}}</td>
                                               <td>{{$samples->sample_label}}</td>
                                               <td><?php echo date('d-m-Y h:i:s', strtotime($samples->receive_date)); ?></td>
                                               <td>{{$samples->sample_type}}</td>
                                               <td>
                                                 @if($samples->sample_type=="Other" || $samples->sample_type=="Others")
                                                 {{$samples->others_type}}
                                                 @endif
                                               </td>
                                               <td>{{$samples->is_accepted}}</td>
                                               <td>{{$samples->rejection}}</td>

                                               <td>{{$samples->sample_quality}}</td>
                                               <td>{{$samples->test_reason}}</td>

                                               <td>{{$samples->fu_month}}</td>
                                               <td>
                                               	@if($samples->service_id==1)
                                               	ZN Microscopy
                                               	@elseif($samples->service_id==2)
                                               	FM Microscopy
                                               	@elseif($samples->service_id==3)
                                               	Decontamination
                                               	@elseif($samples->service_id==4)
                                               	CBNAAT MTB/RIF
                                               	@elseif($samples->service_id==5)
                                               	AFB Culture
                                               	@elseif($samples->service_id==6)
                                               	LPA 1st line
                                               	@elseif($samples->service_id==7)
                                               	LPA 2nd line
                                                 @elseif($samples->service_id==8)
                                               	DNA Extraction
                                                 @elseif($samples->service_id==12)
                                               	PCR
                                                 @elseif($samples->service_id==13)
                                               	LPA Both Line
                                                 @elseif($samples->service_id==14)
                                               	Hybridization
                                                 @elseif($samples->service_id==15)
                                               	LPA interpretation
                                                 @elseif($samples->service_id==16)
                                               	Culture inoculation
                                                 @elseif($samples->service_id==17)
                                               	LC inoculation
                                                 @elseif($samples->service_id==18)
                                               	LC culture reporting
                                                 @elseif($samples->service_id==20)
                                               	LJ culture reporting
                                               	@elseif($samples->service_id==11)
                                               	Storage
                                               	@elseif($samples->service_id==26)
                                               	Rejected
                                               	@endif

                                               </td>


                                             </tr>
                                             @endforeach

                                         </tbody>
                                           </table>

                                   </div>
                               </div>
                           </div>
                       </div>

                   </div>

                </div>























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
          <footer class="footer">  </footer>
          <!-- ============================================================== -->
          <!-- End footer -->
          <!-- ============================================================== -->

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



</body>

</html>
