
@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Culture Inoculation</h3>

                  </div>

              </div>
                              <div class="row">



                </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>MGIT  sequence ID (LC)</th>
                                              <th>Date of Inoculation </th>
                                              <th>Microscopy result</th>
                                              <th>DX/FU</th>
                                              <th>Culture method (LJ,LC,both) </th>
                                              <th>TUBE sequence ID (LJ)</th>
                                              <th>TUBE sequence ID (LJ)</th>
                                              <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>

                                              <td>17-98765</td>
                                              <td>17-98765A</td>
                                               <td></td>
                                              <td></td>
                                               <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>

                                                  <td>
                                                  <button type="button" onclick="openCbnaatForm()"   class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                </td>


                                          </tr>




                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Culture Inoculation</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/pcr') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollId" value="">

                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <input type="text" class="form-control form-control-line sampleId" name="sampleid" value="17-98765A" id="sampleid">

                       </input>
                   </div>
                <br>

                <label class="col-md-12"><h5>MGIT  sequence ID (LC):</h5></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line sampleId" name="mgit" value="" id="mgit">

                       </input>
                   </div>
                <br>
                <label class="col-md-12"><h5>TUBE sequence ID (LJ):</h5></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line sampleId" name="mgit" value="" id="mgit">

                       </input>
                   </div>
                <br>
                <label class="col-md-12"><h5>TUBE sequence ID (LJ):</h5></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line sampleId" name="mgit" value="" id="mgit">

                       </input>
                   </div>
                <br>
                <label class="col-md-12"><h5>Date of Inoculation:</h5></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line sampleId" name="mgit" value="" id="mgit">

                       </input>
                   </div>
                <br>



            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirm" data-dismiss="modal">Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<script>
$(function(){

});


 function openCbnaatForm(){
  //console.log("sample_ids", sample_ids.split(','));


  $('#myModal').modal('toggle');
 }
</script>

@endsection
