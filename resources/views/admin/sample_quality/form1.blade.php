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
                        <h3 class="text-themecolor m-b-0 m-t-0">Test History</h3>

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


                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#home" role="tab" aria-expanded="false">Diagnosis TB</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-expanded="true">Follow Up (smear)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">DSTB</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#drtb" role="tab">DRTB</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div class="tab-pane" id="home" role="tabpanel" aria-expanded="false">
                                    <div class="card-block">

                                        <form action="{{ url('/req_test') }}" method="post" class="form-horizontal form-material">
                                            <h6>Name and type of referring facility</h6>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Facility Type</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_type" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">State</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="state" id="state3" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['state'] as $key=> $state)
                                                                      <option value="{{$state['STOCode']}}">{{$state['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                              <div class="col ">
                                                  <label class="col-sm-12">District</label>
                                                      <div class="col-sm-12">
                                                          <select class="form-control form-control-line" name="district" id="district3" required>
                                                            <option value="">Select</option>
                                                            @foreach ($data['district'] as $key=> $district)
                                                                     <option value="{{$district['id']}}">{{$district['name']}}</option>

                                                            @endforeach
                                                          </select>
                                                      </div>
                                              </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">TBU</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="tbu" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Name of Facility</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_id" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['facility'] as $key=> $facility)
                                                                       <option value="{{$facility['id']}}">{{$facility['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">H/O anti TB Rx for > 1 month</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="ho_anti_tb" required>
                                                                <option>yes</option>
                                                                <option>no</option>

                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Diagnosis of TB</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">Predominant Symptom</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="predmnnt_symptoms" required>
                                                                <option>yes</option>
                                                                <option>no</option>

                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-md-6">Duration in days</label>
                                                    <div class="col-md-6">
                                                       <input type="number"  class="form-control form-control-line" name="duration" required>
                                                   </div>
                                                </div>
                                                <div class="col hide">
                                                    <label class="col-md-6">type</label>
                                                    <div class="col-md-6">
                                                       <input type="text"  class="form-control form-control-line" name="req_test_type" value="1" required>
                                                   </div>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-info">Save</button>
                                                    <button class="btn btn-success">Preview</button>
                                                    <button class="btn ">Print</button>
                                                </div>

                                            </div>
                                        </form>


                                    </div>
                                </div>
                                <!--second tab-->
                                <div class="tab-pane active" id="profile" role="tabpanel" aria-expanded="true">
                                    <div class="card-block">
                                        <form action="{{ url('/req_test') }}" method="post" class="form-horizontal form-material">
                                            <h6>Name and type of referring facility</h6>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Facility Type</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_type" required>
                                                                <option value="1">1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">State</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="state" id="state" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['state'] as $key=> $state)
                                                                      <option value="{{$state['STOCode']}}">{{$state['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                              <div class="col ">
                                                  <label class="col-sm-12">District</label>
                                                      <div class="col-sm-12">
                                                          <select class="form-control form-control-line" name="district" id="district" required>
                                                            <option value="">Select</option>
                                                            @foreach ($data['district'] as $key=> $district)
                                                                     <option value="{{$district['id']}}">{{$district['name']}}</option>

                                                            @endforeach
                                                          </select>
                                                      </div>
                                              </div>

                                                <div class="col ">
                                                    <label class="col-sm-12">TBU</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="tbu" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Name of Facility</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_id" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['facility'] as $key=> $facility)
                                                                       <option value="{{$facility['id']}}">{{$facility['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <div class="col ">
                                                        <label class="col-md-12">RNTCP TB Reg No x</label>
                                                        <div class="col-md-12">
                                                           <input type="number"  class="form-control form-control-line" name="rntcp_reg_no" required>
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <br>
                                            <h6>Follow Up (Smear and Culture) :</h6>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Regimen</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="regimen" required>
                                                                <option>New</option>
                                                                <option>Previously Treated</option>

                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">Reason</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="reason" required>
                                                                <option>End IP</option>
                                                                <option>End CP</option>
                                                                <option>6 M</option>
                                                                <option>12 M</option>
                                                                <option>18 M</option>
                                                                <option>24 M</option>

                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row hide">
                                                <div class="col ">
                                                    <label class="col-md-6">type</label>
                                                    <div class="col-md-6">
                                                       <input type="text"  class="form-control form-control-line" name="req_test_type" value="2" required>
                                                   </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-info">Save</button>
                                                    <button class="btn btn-success">Preview</button>
                                                    <button class="btn ">Print</button>
                                                </div>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <div class="tab-pane" id="settings" role="tabpanel">
                                    <div class="card-block">
                                        <form action="{{ url('/req_test') }}" method="post" class="form-horizontal form-material">
                                            <h6>Name and type of referring facility</h6>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Facility Type</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_type" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">State</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="state" id="state1" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['state'] as $key=> $state)
                                                                      <option value="{{$state['STOCode']}}">{{$state['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                              <div class="col ">
                                                  <label class="col-sm-12">District</label>
                                                      <div class="col-sm-12">
                                                          <select class="form-control form-control-line" name="district" id="district1" required>
                                                            <option value="">Select</option>
                                                            @foreach ($data['district'] as $key=> $district)
                                                                     <option value="{{$district['id']}}">{{$district['name']}}</option>

                                                            @endforeach
                                                          </select>
                                                      </div>
                                              </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">TBU</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="tbu" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-6">Name of Facility</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control form-control-line" name="facility_id" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['facility'] as $key=> $facility)
                                                                       <option value="{{$facility['id']}}">{{$facility['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>

                                            </div>
                                            <br>
                                            <h6>Drug Susceptibility Testing DST :</h6>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Regimen</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="regimen" required>
                                                                <option>New</option>
                                                                <option>Previously Treated</option>

                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">Type of Presumptive DRTB</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="type_of_prsmptv_drtb" required>
                                                                <option>At diagnosis</option>
                                                                <option>Contact of MDR/RR TB</option>
                                                                <option>Follow up SM+VE at  END IP</option>
                                                                <option>Private referall</option>
                                                                <option>Presumptive H mono/poly</option>
                                                                <option>MDR/RR TB at Diagnosis</option>
                                                                <option>>= 4 months culture positive</option>
                                                                <option>3 monthly for persistent culture positives</option>
                                                                <option>Culture reversion</option>
                                                                <option>Failure of MDR/RR-TB regimen</option>
                                                                <option>Recurrant case of Second Line Treatment</option>


                                                            </select>
                                                        </div>
                                                </div>

                                            </div>
                                            <div class="row hide">
                                                <div class="col ">
                                                    <label class="col-md-6">type</label>
                                                    <div class="col-md-6">
                                                       <input type="text"  class="form-control form-control-line" name="req_test_type" value="3" required>
                                                   </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-info">Save</button>
                                                    <button class="btn btn-success">Preview</button>
                                                    <button class="btn ">Print</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="tab-pane" id="drtb" role="tabpanel" aria-expanded="false">
                                    <div class="card-block">

                                        <form action="{{ url('/req_test') }}" method="post" class="form-horizontal form-material">
                                            <h6>Name and type of referring facility</h6>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">Facility Type</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="facility_type" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">State</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="state" id="state2" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['state'] as $key=> $state)
                                                                      <option value="{{$state['STOCode']}}">{{$state['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                              <div class="col ">
                                                  <label class="col-sm-12">District</label>
                                                      <div class="col-sm-12">
                                                          <select class="form-control form-control-line" name="district" id="district2" required>
                                                            <option value="">Select</option>
                                                            @foreach ($data['district'] as $key=> $district)
                                                                     <option value="{{$district['id']}}">{{$district['name']}}</option>

                                                            @endforeach
                                                          </select>
                                                      </div>
                                              </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">TBU</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="tbu" required>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-6">Name of Facility</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control form-control-line" name="facility_id" required>
                                                              <option value="">Select</option>
                                                              @foreach ($data['facility'] as $key=> $facility)
                                                                       <option value="{{$facility['id']}}">{{$facility['name']}}</option>

                                                              @endforeach
                                                            </select>
                                                        </div>
                                                </div>

                                            </div>
                                            <br>
                                            <h6>Follow Up (Culture) :</h6>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-12">PMDT TB No.</label>
                                                        <div class="col-md-12">
                                               <input type="number" class="form-control form-control-line" name="pmdt_tb_no" required>
                                           </div>
                                                </div>
                                                <div class="col ">
                                                    <label class="col-sm-12">Presumptive XDR TB</label>
                                                        <div class="col-sm-12">
                                                            <select class="form-control form-control-line" name="prsmptv_xdr_tb" required>
                                                                <option>At diagnosis</option>
                                                                <option>Contact of MDR/RR TB</option>
                                                                <option>Follow up SM+VE at  END IP</option>
                                                                <option>Private referall</option>
                                                                <option>Presumptive H mono/poly</option>
                                                                <option>MDR/RR TB at Diagnosis</option>
                                                                <option>>= 4 months culture positive</option>
                                                                <option>3 monthly for persistent culture positives</option>
                                                                <option>Culture reversion</option>
                                                                <option>Failure of MDR/RR-TB regimen</option>
                                                                <option>Recurrant case of Second Line Treatment</option>


                                                            </select>
                                                        </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col ">
                                                    <label class="col-sm-6">Treatment (Month/Week)</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control form-control-line" name="treatment" required>
                                                                <option>1</option>
                                                                <option>2</option>

                                                            </select>
                                                        </div>
                                                </div>

                                                <div class="col hide">
                                                    <label class="col-md-6">type</label>
                                                    <div class="col-md-6">
                                                       <input type="text"  class="form-control form-control-line" name="req_test_type" value="4" required>
                                                   </div>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-info">Save</button>
                                                    <button class="btn btn-success">Preview</button>
                                                    <button class="btn ">Print</button>
                                                </div>

                                            </div>

                                        </form>


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
        </div>
        <script>
            $(document).ready(function() {
                $("#state").change( function() {
                    var state = $(this).val();

                    $.ajax({
                        url: "{{url('district')}}"+'/'+state,
                        type:"GET",
                        processData: false,
                        contentType: false,
                        dataType : "json",
                        success: function(items) {

                            //$('#district').html();
                            $("#district option").remove();
                            $('#district').append($('<option>', {
                                value: '',
                                text : 'Select'
                            }))
                            $.each(items.district, function (i, item) {
                                $('#district').append($('<option>', {
                                    value: item.id,
                                    text : item.name
                                }));
                            });
                        },
                        error: function() {
                          console.log("err")
                      }
                    });
                });
                $("#state1").change( function() {
                    var state = $(this).val();

                    $.ajax({
                        url: "{{url('district')}}"+'/'+state,
                        type:"GET",
                        processData: false,
                        contentType: false,
                        dataType : "json",
                        success: function(items) {

                            //$('#district').html();
                            $("#district1 option").remove();
                            $('#district1').append($('<option>', {
                                value: '',
                                text : 'Select'
                            }))
                            $.each(items.district, function (i, item) {
                                $('#district1').append($('<option>', {
                                    value: item.id,
                                    text : item.name
                                }));
                            });
                        },
                        error: function() {
                          console.log("err")
                      }
                    });
                });
                $("#state2").change( function() {
                    var state = $(this).val();

                    $.ajax({
                        url: "{{url('district')}}"+'/'+state,
                        type:"GET",
                        processData: false,
                        contentType: false,
                        dataType : "json",
                        success: function(items) {

                            //$('#district').html();
                            $("#district2 option").remove();
                            $('#district2').append($('<option>', {
                                value: '',
                                text : 'Select'
                            }))
                            $.each(items.district, function (i, item) {
                                $('#district2').append($('<option>', {
                                    value: item.id,
                                    text : item.name
                                }));
                            });
                        },
                        error: function() {
                          console.log("err")
                      }
                    });
                });
                $("#state3").change( function() {
                    var state = $(this).val();

                    $.ajax({
                        url: "{{url('district')}}"+'/'+state,
                        type:"GET",
                        processData: false,
                        contentType: false,
                        dataType : "json",
                        success: function(items) {

                            //$('#district').html();
                            $("#district3 option").remove();
                            $('#district3').append($('<option>', {
                                value: '',
                                text : 'Select'
                            }))
                            $.each(items.district, function (i, item) {
                                $('#district3').append($('<option>', {
                                    value: item.id,
                                    text : item.name
                                }));
                            });
                        },
                        error: function() {
                          console.log("err")
                      }
                    });
                });

            });
        </script>
@endsection
