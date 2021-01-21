@extends('admin.layout.app')
@section('content')

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
                        <h3 class="text-themecolor m-b-0 m-t-0">CBNAAT</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <p  class="pull-right ">Enrolment ID : {{ str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT) }}</p>
                   </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <form class="form-horizontal form-material" action="{{ url('/cbnaat') }}" method="post" enctype='multipart/form-data'>
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif


                    <div class="row sampleForm" id="sampleForm">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                    <h4>Sample </h4>

                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">Sample ID</label>
                                            <div class="col-md-12">
                                               <input type="text" name="sample_id" value="{{ old('sample_id', $data['sample_id']) }}" class="form-control form-control-line sampleId" disabled>
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Date of Receipt</label>
                                            <div class="col-md-12">
                                               <input type="date" name="receive_date" value="{{ old('receive_date', $data['cbnaat']->receive) }}"  min="<?php echo date("Y-m-d");?>" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">Visual Appearance</label>
                                            <div class="col-md-12">
                                               <input type="text" name="visual" class="form-control form-control-line sampleId" value="{{ $data['cbnaat']->visual }}" disabled>
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Number of Samples</label>
                                            <div class="col-md-12">
                                               <input type="number" name="no" value="{{$data['number']}}" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Sample Type</label>
                                            <div class="col-md-12">
                                               <input type="text" name="sample_type" value="{{ old('sample_type', $data['cbnaat']->sample_type) }}" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Result of MTB</label>
                                            <div class="col-md-12">
                                              <select id="mtb" name="mtb" class="form-control form-control-line" required>
                                                <option>--Select--</option>
                                                <option value="MTB Detected">MTB Detected</option>
												<!--<option value="MTB Detected">M.tb detected</option>-->
												<option value="MTB Not Detected">MTB Not Detected</option>
												<!--<option value="MTB Not Detected">M.tb not detected</option>-->
                                                <option value="Invalid">Invalid</option>
                                                <option value="Error">Error</option>
                                              </select>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="col">
                                            <label class="col-md-12">Result of RIF</label>
                                            <div class="col-md-12">
                                              <select id="rif" name="rif" class="form-control form-control-line" required>
                                                <option>--Select--</option>
												<option value="0">RIF Detected</option>
												<!--<option value="0">Rif resistance detected</option-->
                                                <option value="1">RIF Not Detected</option>
												<!--<option value="1">Rif resistance not detected</option>-->
                                                <option value="0">RIF Indeterminate</option>
												<!--<option value="0">Rif indeterminate</option>-->
												<option value="1">NA</option>
												<!--<option value="1">No result</option>-->
                                              </select>
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Date Tested</label>
                                            <div class="col-md-12">
                                               <input type="text" name="test_date" value="{{ old('test_date', $data['today']) }}"  min="<?php echo date("Y-m-d");?>" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                    </div>
                    

                                    <div class="row">
                                         <div class="col">
                                            <label class="col-md-12">Next Step</label>
                                            <div class="col-md-12">
                                              <select name="next_step" class="form-control form-control-line" required>
                                                <option value="">--Select--</option>
                                                <option value="0">Interim Report Submit another sample</option>
                                                <option value="1">Repeat Test with same sample</option>
                                                <option value="2">Repeat test with another sample</option>
                                                <option value="3">Submit result for finalization</option>
                                              </select>
                                           </div>
                                        </div>
                                        <div class="col ">

                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="moreSample"></div>


                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info" id="submit">Save</button>

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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>


<script>
    $(function(){


        $("#noOfSample").change(function(){
            $("#moreSample").html('');
            var _noOfSample = $(this).val();
            var alpha = ["A","B","C","D","E"];
            for(var i = 1; i < _noOfSample; i++) {
                $( "#sampleForm" ).clone().appendTo( "#moreSample" );

            }
            var enroll_id = $("#enrollId").val();
            $(".sampleForm").each(function(i){
              $(this).find(".sampleId").val(enroll_id+alpha[i]);
            })
        })
    });
</script>
@endsection
