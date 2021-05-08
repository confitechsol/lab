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
                        <h3 class="text-themecolor m-b-0 m-t-0">Sample Reception Preview</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                      
                   </div>
                </div>
               
                <form class="form-horizontal form-material" action="{{ url('/sample') }}" method="post" enctype='multipart/form-data'>
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
                                      <label class="col-md-12">No. of samples submitted : </label>
                                      <div class="col-md-12">
                                         
                                      </div>
                                    </div>
                                    <div class="col">
                                      <label class="col-md-12">Enrollment Number : </label>
                                      <div class="col-md-12">
                                         
                                      </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Name : </label>
                                           
                                        </div>
                                        <div class="col ">
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row sampleForm" id="sampleForm">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                    <h4>Sample </h4>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">Sample ID : </label>
                                            <div class="col-md-12">
                                               
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Date of Receipt : </label>
                                            <div class="col-md-12">
                                              
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Sample type : </label>
                                            <div class="col-md-12">
                                             
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Sample Accepted/Rejected : </label>
                                            <div class="col-md-12">
                                             
                                           </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                      <div class="col hide reject" id="rejectA">
                                            <label class="col-md-12">Reason of Rejection : </label>
                                            <div class="col-md-12">

                                             
                                           </div>
                                        </div>
                                        <div class="col" >
                                        <div class="col hide other" id="otherA">
                                            <label class="col-md-12">Reason of Rejection : </label>
                                            <div class="col-md-12">
                                                 
                                           </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">

                                            <label class="col-md-12">Sample Quality : </label>
                                            <div class="col-md-12">
                                              
                                           </div>


                                        </div>
                                        <div class="col hide other_sample_type" id="other_sample_typeA">
                                            <label class="col-md-12">Other sample type : </label>
                                            <div class="col-md-12">
                                             
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Reason for Test : </label>
                                            <div class="col-md-12">
                                              
                                           </div>
                                        </div>
                                        <div class="col hide fu_month" id="fu_monthA">
                                            <label class="col-md-12">Follow up month : </label>
                                            <div class="col-md-12">
                                              
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Sample Sent for : </label>
                                            
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="moreSample"></div>


                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info">Back</button>
                           
                        </div>

                    </div>
                </form>

               
            </div>
        
            <footer class="footer">  </footer>
         
        </div>



@endsection
