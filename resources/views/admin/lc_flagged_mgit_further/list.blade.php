@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LC Reporting</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lcflagfurther/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/lc_flagged_mgit/cipopup')
                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                          <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                              <div class="scroll-table " >
                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>Sample ID</th>
                                          <th>Enroll ID</th>
                                          <th class="noExport">Field NAAT Result</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td><a class='detail_modal bmwoff' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick="showNaatResult()">View Naat Result</a></td>
                                          <td>

                                            @if($samples->status == 0 || $samples->status == 2)
                                            Done
                                            @elseif($samples->status == 1)
                                            <a href="{{ url('/further_lc_flagged_mgit/'.$samples->log_id.'/edit') }}" class="btn btn-info btn-sm">Add Result</a>
                                            @elseif($samples->status == 4)
                                            Sent to decontamination
                                            @endif
                                          </td>
                                        </tr>
                                        @endforeach

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

        <div class="modal fade" id="myModal_naat" role="dialog" >
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Field NAAT Result</h4>
              </div>
        
               <form class="form-horizontal form-material" action="" method="post" enctype='multipart/form-data' id="naat_result">
                        @if(count($errors))
                          @foreach ($errors->all() as $error)
                             <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                         @endforeach
                       @endif
                  <div class="modal-body">
        
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      
                      <label class="col-md-12"><h5>Enrollment Id:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="enrollid" class="form-control form-control-line sampleId"  id="enroll-id">
                         </div>
                         <label class="col-md-12"><h5>Field Sample Id:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="sampleid" class="form-control form-control-line sampleId"  id="sample-id">
                         </div>
                         <label class="col-md-12"><h5>Patient Name:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="patientname" class="form-control form-control-line sampleId"  id="patientname">
                         </div>
                         <label class="col-md-12"><h5>Name of PHI where<br> testing was done:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="phitest" class="form-control form-control-line sampleId"  id="phitest">
                         </div>
                         <label class="col-md-12"><h5>Type of Result <br>(CBNAAT/TrueNAT):</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="resultcbnnat" class="form-control form-control-line sampleId"  id="resultcbnnat">
                         </div>
        
                         <label class="col-md-12"><h5>Vaid/Invalid:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="valid" class="form-control form-control-line sampleId"  id="valid">
                         </div>
        
                         <label class="col-md-12"><h5>If Not valid <br>(Invalid/NA/ No result/Error- specifiy):</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="invalid" class="form-control form-control-line sampleId"  id="invalid">
                         </div>
        
                         <label class="col-md-12"><h5>MTB Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="mtb_result" class="form-control form-control-line sampleId"  id="mtb_result">
                         </div>
                         <label class="col-md-12"><h5>RIF Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="rif_result" class="form-control form-control-line sampleId"  id="rif_result">
                         </div>
                         <label class="col-md-12"><h5>Date of Result:</h5></label>
                          <div class="col-md-12">
                            <input type="text" name="dor_result" class="form-control form-control-line sampleId"  id="dor_result">
                         </div>
                     
                      <br>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                    <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok2" >Ok</button>
                  </div>
        
            </form>
            </div>
          </div>
        </div>

<script>

  function showNaatResult()
  {
      $('#myModal_naat').modal('toggle');
  }

function openForm(sample_label, log_id, lpa_type){
  $('#sample_id').val(sample_label);
  $('#log_id').val(log_id);
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}
function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}
</script>

<script>

$(document).ready(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd = '0'+dd
  }

  if(mm<10) {
      mm = '0'+mm
  }

  today = dd + '-' + mm + '-' + yyyy;
    $('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_lc_reporting_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
} );
</script>
@endsection
