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
                        <h3 class="text-themecolor m-b-0 m-t-0">Configuration and Laboratory Details</h3>
                        <a class="pull-right btn-go go-button add-button" href="{{ url('/laboratory/create') }}">Add New/Edit</a>
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


               <form class="form-horizontal form-material" action="{{ url('/laboratory') }}" method="post" enctype='multipart/form-data'>

                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif

                        <div class="col">
                            <div class="card">
                                <div class="card-block">

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12"> Lab Name </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                               <input type="text" name="lab_name" value="{{$data['config']->lab_name}}" class="form-control form-control-line"  disabled>
                                           </div>
                                        </div>
                                        <div class="col ">
                                           <label class="col-md-12">Lab Code </label>
                                            <div class="col-md-12">

                                               <input type="text" name="lab_code" value="{{$data['config']->lab_code}}" class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">City </label>
                                            <div class="col-md-12">

                                               <input type="text"  name="city"  value="{{$data['config']->city}}" style="text-transform:capitalize;" class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                        <div class="col ">
                                          <label class="col-md-12">Lab Address</label>
                                            <div class="col-md-12">

                                               <input type="text"  name="address"  value="{{$data['config']->address}}" style="text-transform:capitalize;" class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col hide">
                                            <label class="col-md-12">Lab Details </label>
                                            <div class="col-md-12">

                                               <input type="text"  name="details"  value="{{$data['config']->details}}" style="text-transform:capitalize;" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Lab Logo </label>
                                            <div class="col-md-12">
                                               <img style="border-radius:15px;" src="{{url('uploads/lab_logo/'.$data['config']->logo)}}" height="100px" width="100px"/>
                                               <!--<input type="text"  name="img"  value="{{url('uploads/lab_logo/'.$data['config']->logo)}}"  class="form-control form-control-line" disabled>---->
                                           </div>
                                        </div>
										
										 <div class="col">
                                            <label class="col-md-12">NABL Logo </label>
                                            <div class="col-md-12">
                                               <img style="border-radius:15px;" src="{{url('uploads/nabl_logo/'.$data['config']->nabl_logo)}}" height="100px" width="100px"/>
                                               <!--<input type="text"  name="nabl_logo"  value="{{url('uploads/nabl_logo/'.$data['config']->nabl_logo)}}"  class="form-control form-control-line" disabled>---->
                                           </div>
                                        </div>
                                    </div>
									
									<div class="row">
                                        <div class="col">
                                            <label class="col-md-12">&nbsp;&nbsp; </label>
                                            <div class="col-md-12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>
										 <div class="col">
                                            <label class="col-md-12">NABL Certificate No.</label>
                                            <div class="col-md-12">
                                               <input type="text"  name="nabl_no"  value="{{$data['config']->nabl_no}}" style="text-transform:capitalize;" class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                        
                                    </div>
									
									
									
									

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Microbiologist : Name  </label>
                                            <div class="col-md-12">

                                               <input type="text" name="micro_name"   value="{{$data['config']->micro_name}}" style="text-transform:capitalize;" class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                        <div class="col ">
                                          <label class="col-md-12">Microbiologist : Email  </label>
                                            <div class="col-md-12">

                                               <input type="email" name="micro_email"   value="{{$data['config']->micro_email}}" class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                    </div>



                                     <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Microbiologist : Number  </label>
                                            <div class="col-md-12">

                                               <input type="text"  name="micro_number" value="{{$data['config']->micro_number}}"  class="form-control form-control-line"  disabled >
                                           </div>
                                        </div>
                                        <div class="col ">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Barcode Offset </label>
                                            <div class="col-md-12">

                                               <input type="text"  name="barcode_offset"  value="{{$data['config']->barcode_offset}}"  class="form-control form-control-line" disabled>
                                           </div>
                                        </div>
                                         <div class="col">
                                            <!-- <label class="col-md-12">Sync Schedule  </label>
                                            <div class="col-md-12">

                                               <input type="text"  name="sink_schedule" value="{{$data['config']->sink_schedule}}"  class="form-control form-control-line"  disabled >
                                           </div> -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <!-- <label class="col-md-12">Sync User Name  </label>
                                            <div class="col-md-12">


                                               <select name="sink_user" class="form-control form-control-line" disabled >
                                                        <option>--Select--</option>
                                                         @foreach ($data['user'] as $key=> $user)

                                                                @if($data['config']->sink_user==$user->name)
                                                                 <option value="{{$user->name}}"  selected="selected">{{$user->name}}</option>

                                                                @endif
                                                                <option value="{{$user->name}}" >{{$user->name}}</option>

                                                        @endforeach
                                                </select>
                                           </div> -->
                                        </div>
                                        <div class="col ">
                                          <!-- <label class="col-md-12">Sync Password  </label>
                                            <div class="col-md-12">

                                               <input type="password" name="sink_password"  value="{{$data['config']->sink_password}}" class="form-control form-control-line"  disabled >
                                           </div> -->
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <!-- <div class="col-12">
                            <button class="btn btn-info">Back</button>

                        </div> -->

                    </div>
                    </div>

                </form>


            </div>

            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>

        </div>



@endsection
