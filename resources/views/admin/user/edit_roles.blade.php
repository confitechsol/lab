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
                <!-- <form class="form-horizontal form-material" action="{{ url('/adduser') }}" method="post" enctype='multipart/form-data'> -->
                <form id="createForm" action="{{ url('/adduser/'.$data['user']->id.'/updateform') }}" method="post">
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
                                            <label class="col-md-12">Name </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
               
                                               <input type="text" name="name"  value="{{$data['user']->name}}" class="form-control form-control-line"  disabled>
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
                                             
                                               <input type="text" name="email"  value="{{$data['user']->email}}" class="form-control form-control-line"  >
                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Password </label>
                                            <div class="col-md-12">
                                              
                                               <input type="password" id="password" pattern="[A-Za-z0-9]{6,16}" name="password" value="" class="form-control form-control-line" readonly  onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly');this.blur();this.focus();  }"   >


                                           </div>
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>

                                    
                                    <br><br>
                                   
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">User Permissions  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <select name="checkbox[]" class="form-control form-control-line" size="10" multiple required >
                                                        
                                                         @foreach ($data['services'] as $key=> $services)
                                                                <option value="{{$services['id']}}" 
                                                                @if(in_array($services['id'], $data['roles']))
                                                                    selected="selected"
                                                                @endif
                                                                >{{$services['name']}}</option>

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
           
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
         
        </div>


<script>
$(function(){
        
});

</script>
@endsection
