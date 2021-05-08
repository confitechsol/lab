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
                        <h3 class="text-themecolor m-b-0 m-t-0">User Management Module</h3>

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
                <form class="form-horizontal form-material" action="{{ url('/adduser') }}" method="post" enctype='multipart/form-data'>
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
                                            <label class="col-md-12">Name <span class="red">*</span>  </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                               <input type="text" name="name"  class="form-control form-control-line"  required>
                                           </div>
                                        </div>
                                        <div class="col ">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">User ID <span class="red">*</span> </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                               <input type="text" name="email"  value="" class="form-control form-control-line"  required >
                                           </div>
                                        </div>
                                        <div class="col ">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Password  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                               <input type="password" id="password" pattern="[A-Za-z0-9]{6,16}" name="password" value="" class="form-control form-control-line" readonly  onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');this.blur();this.focus();  }"  required >


                                           </div>
                                        </div>
                                        <div class="col ">

                                        </div>
                                    </div>
                                    <br><br>
                                    <!-- <div class="row">
                                    	<br>
                                    			<label class="col-md-12">Select Roles</label>
                                                @foreach ($data['services'] as $key=> $services)
                                                <div class="col-md-4 top5px">
                                                  <input class="service_array"
                                                    value="{{$services['id']}}"

                                                    name="checkbox[]"
                                                    type="checkbox">{{$services['name']}}
                                                </div>
                                                @endforeach
                                     </div> -->
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">User Permissions  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <select name="checkbox[]" class="form-control form-control-line" size="10" multiple required >

                                                         @foreach ($data['services'] as $key=> $services)
                                                                <option value="{{$services['id']}}" >{{$services['name']}}</option>

                                                        @endforeach
                                                </select>
                                           </div>
                                        </div>
                                       <div class="col">

                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <input type="submit" value="save" class="btn btn-info">
                            <a href="{{ url('/adduser') }}" class="btn btn-info">Cancel</a>

                        </div>

                    </div>
                    </div>

                </form>


            </div>

            <footer class="footer">  </footer>

        </div>


<script>
$(function(){

});

</script>
@endsection
