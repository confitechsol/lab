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
                        <h3 class="text-themecolor m-b-0 m-t-0"> Enrolment</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <p  class="pull-right ">Enrolment ID : {{str_pad($data['patient']->id, 10, "0", STR_PAD_LEFT)}}</p>
                   </div>
                </div>

               <!--  <form action="{{ url('/enroll') }}" class="form-horizontal form-material" method="post" enctype='multipart/form-data'>
 -->
                @if($data['patient']->id>0)
                   <form id="createForm" action="{{ url('/patient/'.$data['patient']->id) }}" method="post">
                     <input name="_method" type="hidden" value="patch">
                   @else
                   <form id="createForm" action="{{ url('/patient') }}" method="post" role="alert">
                 @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">



                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State</label>
                                                <div class="col-sm-12">
                                                    <select name="state" class="form-control form-control-line" id="state" >
                                                        <option value="">Select</option>
                                                        @foreach ($data['state'] as $key=> $state)
                                                                <option value="{{$state['STOCode']}}"
                                                                @if($data['patient']->state==$state['STOCode'])
                                                                    selected="selected"
                                                                @endif
                                                                >{{$state['name']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>

                                        <div class="col ">
                                            <label class="col-sm-12">District</label>
                                                <div class="col-sm-12">
                                                    <select name="district" class="form-control form-control-line"  id="district">
                                                        <option value="">Select</option>
                                                        @foreach ($data['district'] as $key=> $district)
                                                                @if($data['patient']->district==$district->id)
                                                                 <option value="{{$district['id']}}"  selected="selected">{{$district['name']}}</option>>
                                                                @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">TB Unit</label>
                                                <div class="col-sm-12">
                                                    <select name="tb" class="form-control form-control-line" >
                                                         <option>Select</option>
                                                        <option value="1"
                                                         @if($data['patient']->tb=="1")
                                                            selected="selected"
                                                             @endif
                                                        >1</option>
                                                        <option value="2"
                                                        @if($data['patient']->tb=="2")
                                                            selected="selected"
                                                             @endif
                                                        >2</option>

                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">PHI</label>
                                                <div class="col-sm-12">
                                                    <select name="phi" class="form-control form-control-line" >

                                                         <option>Select</option>
                                                         <option value="1"
                                                         @if($data['patient']->phi=="1")
                                                            selected="selected"
                                                             @endif
                                                          >1</option>
                                                        <option value="2"
                                                        @if($data['patient']->phi=="2")
                                                            selected="selected"
                                                             @endif
                                                        >2</option>

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Patient's Name</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="name" value="{{ old('name', $data['patient']->name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Age (in years)</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="age"  value="{{ old('age', $data['patient']->age) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">Gender</label>
                                                <div class="col-sm-12">
                                                    <select name="gender" class="form-control form-control-line"  value="{{ old('gender', $data['patient']->gender) }}">
                                                         <option >Select</option>
                                                        <option value="male"
                                                         @if($data['patient']->gender=="male")
                                                            selected="selected"
                                                             @endif
                                                        >Male</option>
                                                        <option value="female"
                                                         @if($data['patient']->gender=="female")
                                                            selected="selected"
                                                             @endif
                                                        >Female</option>
                                                        <option value="transgender">Transgender</option>

                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Mobile Number/Other Number</label>
                                                <div class="col-md-12">
                                               <input type="number" name="mobile_number"  value="{{ old('mobile_number', $data['patient']->mobile_number) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Adhar Number</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="adhar_no" value="{{ old('adhar_no', $data['patient']->adhar_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Bank Name</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="bank_name" value="{{ old('bank_name', $data['patient']->bank_name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Account Number</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="account_no" value="{{ old('account_no', $data['patient']->account_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">IFSC Code</label>
                                            <div class="col-md-12">
                                               <input type="number" name="ifsc_code" value="{{ old('ifsc_code', $data['patient']->ifsc_code) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <h4>Patient Address with Landmark:</h4>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">House Number</label>
                                            <div class="col-md-12">
                                               <input type="text" name="house_no" value="{{ old('house_no', $data['patient']->house_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Street</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="street" value="{{ old('street', $data['patient']->street) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">Ward Number</label>
                                            <div class="col-md-12">
                                               <input type="number" name="ward" value="{{ old('ward', $data['patient']->ward) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Town/City/Village</label>
                                                <div class="col-md-12">
                                               <input type="text"  name="city" value="{{ old('city', $data['patient']->city) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Taluk/Mandal</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="taluka" value="{{ old('taluka', $data['patient']->taluka) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Landmark</label>
                                            <div class="col-md-12">
                                               <input type="text" name="landmark"  value="{{ old('landmark', $data['patient']->landmark) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State</label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_state" id="landmark_state" class="form-control form-control-line" value="{{ old('landmark_state', $data['patient']->landmark_state) }}">
                                                         <option value="">Select</option>

                                                        @foreach ($data['state'] as $key=> $state)
                                                                <option value="{{$state['STOCode']}}"
                                                                @if($data['patient']->landmark_state==$state['STOCode'])
                                                                    selected="selected"
                                                                @endif
                                                                >{{$state['name']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">District</label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_district" class="form-control form-control-line" id="landmark_district" value="{{ old('landmark_district', $data['patient']->landmark_district) }}">
                                                         <option value="">Select</option>


                                                        @foreach ($data['district'] as $key=> $district)
                                                                @if($data['patient']->landmark_district==$district->id)
                                                                 <option value="{{$district['id']}}"  selected="selected">{{$district['name']}}</option>>
                                                                @endif

                                                        @endforeach


                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Pincode</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="pincode" value="{{ old('pincode', $data['patient']->pincode) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Area</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="area" value="{{ old('area', $data['patient']->area) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                         <div class="col ">
                                            <label class="col-sm-12">HIV Test</label>
                                                <div class="col-sm-12">
                                                    <select name="hiv_test" value="{{ old('hiv_test', $data['patient']->hiv_test) }}" class="form-control form-control-line">
                                                         <option value="">Select</option>
                                                        <option value="Unknown"
                                                         @if($data['patient']->hiv_test=="Unknown")
                                                            selected="selected"
                                                             @endif
                                                        >Unknown</option>
                                                        <option value="Negative"
                                                        @if($data['patient']->hiv_test=="Negative")
                                                            selected="selected"
                                                             @endif
                                                        >Negative</option>
                                                        <option value="Positive"
                                                        @if($data['patient']->hiv_test=="Positive")
                                                            selected="selected"
                                                             @endif
                                                        >Positive</option>

                                                    </select>
                                                </div>
                                        </div>




                                        <div class="col ">
                                            <label class="col-sm-12">Maritial Status</label>
                                                <div class="col-sm-12">
                                                    <select name="marital_state" value="{{ old('marital_state', $data['patient']->marital_state) }}" class="form-control form-control-line">
                                                         <option value="">Select</option>
                                                        <option value="1"
                                                         @if($data['patient']->marital_state=="1")
                                                            selected="selected"
                                                             @endif
                                                        >Married</option>
                                                        <option value="0"
                                                        @if($data['patient']->marital_state=="0")
                                                            selected="selected"
                                                             @endif
                                                        >Not married</option>

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">Occupation</label>
                                                <div class="col-sm-12">
                                                    <select name="occupation" value="{{ old('occupation', $data['patient']->occupation) }}" class="form-control form-control-line">
                                                         <option value="">Select</option>
                                                        @foreach ($data['occupation'] as $key=> $occupation)

                                                                <option value="{{$occupation['name']}}"
                                                                @if($data['patient']->occupation==$occupation['name'])
                                                                    selected="selected"
                                                                @endif
                                                                >{{$occupation['name']}}</option>

                                                        @endforeach


                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Socioeconomic Status</label>
                                                <div class="col-sm-12">
                                                    <select name="socioeconomy_status" value="{{ old('socioeconomy_status', $data['patient']->socioeconomy_status) }}" class="form-control form-control-line">
                                                         <option value="">Select</option>
                                                        <option value="NA"
                                                        @if($data['patient']->socioeconomy_status=="NA")
                                                            selected="selected"
                                                             @endif
                                                        >NA</option>
                                                        <option value="APL"
                                                         @if($data['patient']->socioeconomy_status=="APL")
                                                            selected="selected"
                                                             @endif
                                                        >APL</option>
                                                        <option value="BPL"
                                                         @if($data['patient']->socioeconomy_status=="BPL")
                                                            selected="selected"
                                                             @endif
                                                        >BPL</option>

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Contact Person Name</label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_name" value="{{ old('cp_name', $data['patient']->cp_name) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">CP Mobile Number</label>
                                            <div class="col-md-12">
                                               <input type="number"  name="cp_phn_no" value="{{ old('cp_phn_no', $data['patient']->cp_phn_no) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Address</label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_address" value="{{ old('cp_address', $data['patient']->cp_address) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Key Population</label>
                                                <div class="col-sm-12">
                                                    <select name="key_population" value="{{ old('key_population', $data['patient']->key_population) }}" class="form-control form-control-line">
                                                         <option value="">Select</option>
                                                        <option value="Urban Slum"
                                                        @if($data['patient']->key_population=="Urban Slum")
                                                            selected="selected"
                                                             @endif
                                                        >Urban Slum</option>
                                                        <option value="Health Care Worker"
                                                        @if($data['patient']->key_population=="Health Care Worker")
                                                            selected="selected"
                                                             @endif
                                                        >Health Care Worker</option>
                                                        <option value="Other"
                                                        @if($data['patient']->key_population=="Other")
                                                            selected="selected"
                                                             @endif
                                                        >Other</option>
                                                        <option value="Not Applicable"
                                                        @if($data['patient']->key_population=="Not Applicable")
                                                            selected="selected"
                                                             @endif
                                                        >Not Applicable</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row hide">


                                        <div class="col">
                                            <label class="col-md-12">Registered Date</label>
                                            <div class="col-md-12">
                                               <input type="date" name="regr_date" class="form-control form-control-line">
                                           </div>
                                        </div>

                                        <div class="col">
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

                            <button class="btn btn-info">Save</button>
                            <a class="btn btn-warning" href="{{url('/enroll')}}">Cancel</a>
                            <!-- <button class="btn btn-success">Preview</button>
                             <button class="btn ">Print</button> -->

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

        $("#landmark_state").change( function() {
            var state = $(this).val();

            $.ajax({
                url: "{{url('district')}}"+'/'+state,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {
                    console.log(items);
                    //$('#district').html();
                    $("#landmark_district option").remove();
                    $('#landmark_district').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.district, function (i, item) {
                        $('#landmark_district').append($('<option>', {
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
