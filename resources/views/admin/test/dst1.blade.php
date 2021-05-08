
@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Dst 1st Line</h3>

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
                                              <th>Date of Inoculation </th>
                                              <th>Primary Culture Positive Date</th>
                                              <th>List of Drugs For DST Requested</th>
                                              <th>Reading time  </th>
                                              <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>

                                              <td>17-98765</td>
                                              <td>17-98765A</td>
                                              <td>21-10-2017</td>
                                              <td>22-10-2017</td>
                                              <td></td>
                                              <td>4th</td>
                                              <td><button type="button" onclick="openCbnaatForm()"   class="btn btn-info btn-sm resultbtn" >Submit</button></td>



                                          </tr>




                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
        </div>
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">1st Line</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/pcr') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <label class="col-md-12"><h5>Reading Week:</h5></label>
                  <select class="form-control form-control-line sampleId" name="sampleid" value="17-98765A" id="sampleid" />
                  <option>1st week </option>
                  <option>2nd week </option>
                  <option>3rd week </option>
                  <option>4th week </option>
                  <option>5th week </option>
                  <option>6th week </option>
                  </select>
                </div>

              </div>
              <div class="row">
                <div class="col-md-12">
                  <label class="col-md-12"><h5>Control drug free media 10-2 Dilution Neat :</h5></label>
                  <select class="form-control form-control-line sampleId" name="sampleid" value="17-98765A" id="sampleid" />
                  <option>1st week </option>
                  <option>2nd week </option>
                  <option>3rd week </option>
                  <option>4th week </option>
                  <option>5th week </option>
                  <option>6th week </option>
                  </select>
                </div>

              </div>



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
