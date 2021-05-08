@extends('admin.layout.app')
@section('content')

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" />

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

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">LJ individual Sample</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                   </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                  <form class="form-horizontal form-material" action="{{ url('/lj/'.$data['sample']->log_id) }}" method="post" enctype='multipart/form-data' novalidate>
                    <input name="_method" type="hidden" value="patch">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-block">
                                  <div class="row">
                                    <div class="col">
                                      <label class="col-md-12">Lab Enrolment  ID</label>
                                      <div class="col-md-12">
                                          <input type="text" name="enroll_label" class="form-control form-control-line" value="{{$data['sample']->enroll_label}}" id="enroll_label" disabled>
                                      </div>
                                    </div>
                                    <div class="col">
                                      <label class="col-md-12">Sample ID</label>
                                      <div class="col-md-12">
                                          <input type="text" name="sample_label" class="form-control form-control-line" value="{{$data['sample']->samples}}" id="sample_label" disabled>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Date of Inoculation</label>
                                          <div class="col-md-12">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                             <input type="text" name="inoculation_date" class="form-control form-control-line" value="{{$data['sample']->inoculation_date}}" disabled>
                                         </div>
                                      </div>
                                      <div class="col ">
                                          <label class="col-md-12">DX/FU</label>
                                          <div class="col-md-12"><input type="text" name="reason" class="form-control form-control-line" value="{{$data['sample']->reason}}" disabled>
                                         </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Initial Smear result</label>
                                          <div class="col-md-12">
                                             <input type="text" name="result" class="form-control form-control-line" value="{{$data['sample']->result}}" disabled>
                                         </div>
                                      </div>
                                      <div class="col ">
                                          <label class="col-md-12">Week reading</label>
                                          <div class="col-md-12">
                                             <input type="number" name="status" class="form-control form-control-line" value="{{$data['sample']->status}}" disabled>
                                         </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Result</label>
                                          <div class="col-md-12">
                                            <input type="hidden" name="week" value="{{$data['sample']->status}}">
                                            <select name="result" class="form-control form-control-line test_reason" id="lj_result" required>
                                              <option value="">--Select--</option>
                                              @foreach ($data["dp"] as $key => $dp)
                                               <option value="{{$dp}}">{{$dp}}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hide" id="detail_div">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">ID  test</label>
                                            <div class="col-md-12">
                                               <input type="hidden" name="is_pos" value="0" id="is_pos" required>
                                               <select name="test_id" class="form-control form-control-line test_reason" id="test_id" required>
                                                 <option value="">--Select--</option>
                                                 <option value="Positive">Positive</option>
                                                 <option value="Negative">Negative</option>
                                                 <option value="Invalid">Invalid</option>
                                                 <option value="Not required">Not required</option>
                                               </select>
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Smear from culture </label>
                                            <div class="col-md-12">
                                               <select name="culture_smear" class="form-control form-control-line test_reason" id="culture_smear" required>
                                                 <option value="">--Select--</option>
                                                 <option value="Positive">Positive</option>
                                                 <option value="Cord factor Positive">Cord factor Positive</option>
                                                 <option value="No cord factor Negative">No cord factor Negative</option>
                                                 <option value="Not required">Not required</option>
                                               </select>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">Final result</label>
                                            <div class="col-md-12">
                                               <select name="final_result" class="form-control form-control-line test_reason" id="final_result" required>
                                                 <option value="">--Select--</option>
                                                 <option value="Positive">Positive</option>
                                                 <option value="Negative">Negative</option>
                                                 <option value="Contamination">Contamination</option>
                                                 <option value="NTM">NTM</option>
                                               </select>
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Date of LJ result </label>
                                            <div class="col-md-12">
                                               <input name="lj_result_date" class="form-control form-control-line datep" id="lj_result_date" required>
                                           </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="moreSample"></div>


                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info">Submit</button>
                        </div>

                    </div>
                </form>

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
        </div>


<script>
$(function(){
  $("#lj_result").change(function(){
    if($(this).val()=="POS"){
      $("#detail_div").show();
      $("#is_pos").val(1);
    }else{
      $("#detail_div").hide();
      $("#is_pos").val(0);
    }
  });
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
});
</script>
@endsection
