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
                        <h3 class="text-themecolor m-b-0 m-t-0">Password Reset</h3>

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
                <form class="form-horizontal form-material" action="{{ url('/passwordReset') }}" method="post" enctype='multipart/form-data'>
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
                   
                        <div class="col">
                            <div class="card">
                                <div class="card-block">
                                    <p style="font-size:12px;">Password should be of min 6 and max 16 alphanumeric characters</p>
                                    <div class="row hide">
                                        <div class="col">
                                         
                                            <label class="col-md-12">ID </label>

                                            <div class="col-md-12 ">
                                                
                                               <input type="text" name="user_id"  value="{{$data['reset_id']->id}}" class="form-control form-control-line"  readonly>
                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">

                                            <label class="col-md-12">Name </label>

                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                                               <input type="text" name="name"  value="{{$data['reset_id']->name}}" class="form-control form-control-line"  readonly>
                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">User ID </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                             
                                               <input type="text" name="email"  value="{{$data['reset_id']->email}}" class="form-control form-control-line"  readonly >
                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Old Password <span class="red">*</span></label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                               <input type="password" id="password" pattern="[A-Za-z0-9]{6,16}" name="old_password"  class="form-control form-control-line" readonly  onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');this.blur();this.focus();  }"  required >


                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">New Password  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                               <input type="password" id="password" pattern="[A-Za-z0-9]{6,16}" name="new_password"  class="form-control form-control-line" readonly  onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');this.blur();this.focus();  }"  required >


                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Confirm Password  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                               <input type="password" id="password" pattern="[A-Za-z0-9]{6,16}" name="confirm_password"  class="form-control form-control-line" readonly  onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');this.blur();this.focus();  }"  required >


                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <input type="submit" value="save" class="btn btn-info">
                            <a href="/dashboard" class="btn btn-info">Cancel</a>

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
