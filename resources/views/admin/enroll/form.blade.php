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
                        <h3 class="text-themecolor m-b-0 m-t-0">Test Enrolment</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <p  class="pull-right ">Enrolment ID : 1000</p>
                   </div>
                </div>

               <!--  <form action="{{ url('/enroll') }}" class="form-horizontal form-material" method="post" enctype='multipart/form-data'>
 -->
                @if($data['enroll']->id>0)
                   <form id="createForm" action="{{ url('/enroll/'.$data['enroll']->id) }}" method="post">
                     <input name="_method" type="hidden" value="patch">
                   @else
                   <form id="createForm" action="{{ url('/enroll') }}" method="post" role="alert">
                 @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                    <h4>Patient Information</h4>


                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State</label>
                                                <div class="col-sm-12">
                                                    <select name="state" class="form-control form-control-line" value="{{ old('state', $data['enroll']->state) }}">

                                                        @foreach ($data['state'] as $key=> $state)

                                                                <option value="{{$state['state']}}" >{{$state['state']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">District</label>
                                                <div class="col-sm-12">
                                                    <select name="district" class="form-control form-control-line"  value="{{ old('district', $data['enroll']->district) }}">

                                                        @foreach ($data['district'] as $key=> $district)

                                                                <option value="{{$district['district']}}" >{{$district['district']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">TB Unit</label>
                                                <div class="col-sm-12">
                                                    <select name="tb" class="form-control form-control-line"  value="{{ old('tb', $data['enroll']->tb) }}">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">PHI</label>
                                                <div class="col-sm-12">
                                                    <select name="phi" class="form-control form-control-line"  value="{{ old('phi', $data['enroll']->phi) }}">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Patient's Name</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="name" value="{{ old('name', $data['enroll']->name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Age (in years)</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="age"  value="{{ old('age', $data['enroll']->age) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">Gender</label>
                                                <div class="col-sm-12">
                                                    <select name="gender" class="form-control form-control-line"  value="{{ old('gender', $data['enroll']->gender) }}">
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Transgender</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Mobile Number/Other Number</label>
                                                <div class="col-md-12">
                                               <input type="number" name="mobile_number"  value="{{ old('mobile_number', $data['enroll']->mobile_number) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Adhar Number</label>
                                            <div class="col-md-12">
                                               <input type="number" id="adhar_no" maxlength="12"  minlength="12" name="adhar_no" value="{{ old('adhar_no', $data['enroll']->adhar_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Bank Name</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="bank_name" value="{{ old('bank_name', $data['enroll']->bank_name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Account Number</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="account_no" value="{{ old('account_no', $data['enroll']->account_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">IFSC Code</label>
                                            <div class="col-md-12">
                                               <input type="number" name="ifsc_code" value="{{ old('ifsc_code', $data['enroll']->ifsc_code) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h6>Patient Address with Landmark:</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">House Number</label>
                                            <div class="col-md-12">
                                               <input type="text" name="house_no" value="{{ old('house_no', $data['enroll']->house_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Street</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="street" value="{{ old('street', $data['enroll']->street) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">Ward Number</label>
                                            <div class="col-md-12">
                                               <input type="number" name="ward" value="{{ old('ward', $data['enroll']->ward) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Town/City/Village</label>
                                                <div class="col-md-12">
                                               <input type="text"  name="town/city/village" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Taluk/Mandal</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="taluka" value="{{ old('taluka', $data['enroll']->taluka) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Landmark</label>
                                            <div class="col-md-12">
                                               <input type="text" name="landmark"  value="{{ old('landmark', $data['enroll']->landmark) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State</label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_state" class="form-control form-control-line" value="{{ old('landmark_state', $data['enroll']->landmark_state) }}">
                                                         @foreach ($data['state'] as $key=> $state)

                                                                <option value="{{$state['state']}}" >{{$state['state']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">District</label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_district" class="form-control form-control-line" value="{{ old('landmark_district', $data['enroll']->landmark_district) }}">
                                                       @foreach ($data['district'] as $key=> $district)

                                                                <option value="{{$district['district']}}" >{{$district['district']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Pincode</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="pincode" value="{{ old('pincode', $data['enroll']->pincode) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Area</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="area" value="{{ old('area', $data['enroll']->area) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Registered Date</label>
                                            <div class="col-md-12">
                                               <input type="date"  class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Maritial Status</label>
                                                <div class="col-sm-12">
                                                    <select name="marital_state" value="{{ old('marital_state', $data['enroll']->marital_state) }}" class="form-control form-control-line">
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
                                            <label class="col-sm-12">Occupation</label>
                                                <div class="col-sm-12">
                                                    <select name="occupation" value="{{ old('occupation', $data['enroll']->occupation) }}" class="form-control form-control-line">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Socioeconomic Status</label>
                                                <div class="col-sm-12">
                                                    <select name="socioeconomy_status" value="{{ old('socioeconomy_status', $data['enroll']->socioeconomy_status) }}" class="form-control form-control-line">
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Contact Person Name</label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_name" value="{{ old('cp_name', $data['enroll']->cp_name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">CP Mobile Number</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="cp_phn_no" value="{{ old('cp_phn_no', $data['enroll']->cp_phn_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Address</label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_address" value="{{ old('cp_address', $data['enroll']->cp_address) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Key Population</label>
                                                <div class="col-sm-12">
                                                    <select name="key_population" value="{{ old('key_population', $data['enroll']->key_population) }}" class="form-control form-control-line">
                                                        <option>Urban Slum</option>
                                                        <option>Health Care Worker</option>
                                                        <option>Other</option>
                                                        <option>Not Applicable</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col ">
                                            <label class="col-sm-12">HIV Test</label>
                                                <div class="col-sm-12">
                                                    <select name="hiv_test" value="{{ old('hiv_test', $data['enroll']->hiv_test) }}" class="form-control form-control-line">
                                                        <option>Unknown</option>
                                                        <option>Negative</option>
                                                        <option>Positive</option>

                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col hide">
                                            <label class="col-sm-12">enroll_type</label>
                                                <div class="col-md-12">
                                               <input type="number"  name="enroll" value="2" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="col-12">

                            <button id="save-btn" class="btn btn-info">Save</button>
                            <button class="btn btn-success">Preview</button>
                             <button class="btn ">Print</button>

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
        $(document).ready(function(){

        $("#adhar_no").on("keyup",function(){
        console.log(isNaN(this.value))
          if(isNaN(this.value)){
            var confirm=alert("Not a valid Number");
          $("#save-btn").css("display","none");

          }else{

          $("#save-btn").css("display","inline-block");
          $("#save-btn").css("margin-left", "1%");
          }

        });
        });
        </script>
@endsection
