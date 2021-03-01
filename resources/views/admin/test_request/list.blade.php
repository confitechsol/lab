@extends('admin.layout.app')
@section('content')


<style>
  .bg-selected {
    background: #ffbdbd !important;
  }
 .hide_column {
    display : none;
}
</style>

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Test Request</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/test_request/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="table-scroll">
                                    
									<!-- Custom Filter Start-->
								   <table>
									 <tr>
									   <td>
									     <meta name="csrf-token" content="{{ csrf_token() }}">
										 <input type="text" name="enrollment_no" id="enrollment_no" placeholder="Search enrol. no from db" class="form-control" />
									   </td>									  
									 </tr>
								   </table>
								   <!-- Custom Filter End -->
								   
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Created By</th>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Receive Date</th>
                                              <th>Reason for Test</th>
                                              <th>Follow up month</th>
                                              <th>Field NAAT Result</th>
                                              <th>Action</th>
                                            </tr>
                                        </thead>
                                
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>





<!-- Modal -->

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

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Barcodes</h4>
      </div>
      <div class="modal-body" id="printCode">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$(function(){

});

function showNaatResult()
{
    $('#myModal_naat').modal('toggle');
}

function openPrintModal(obj){
  //console.log(obj.attr('data-sample'));
  var samples = obj.attr('data-sample');
  $.ajax({
    method: "GET",
    url: "{{url('sample/print/')}}"+'/'+samples,
    data: { samples: samples }
  }).done(function( msg ) {
    $("#printCode").html(msg)
    $('#myModal').modal('toggle');
  });

}
</script>

<script>

$(document).ready(function() {
  var labname="<?php echo $data['labname']; ?>";
  var labcity="<?php echo $data['labcity']; ?>";
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
    var dataTable =$('#exampl').DataTable( {
        dom: 'Bfrtip',
		pageLength:5,
		processing: true,
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
		ajax: {
			   url: "{{url('search_test_request')}}",
			   data: function(data){
				     // Read values
                    var enrollment_no = $('#enrollment_no').val();          

					  // Append to data
					  data.searchByEnrollmentNo = enrollment_no;
         
				},
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
		 columns: [
		   { data: 'enroll_id',className: "hide_column" },
		   { data: 'name' },
		   { data: 'label' },
		   { data: 'samples' },
		   { data: 'receive_date' },
		   { data: 'reason' },
		   { data: 'fu_month' },
       { data: 'naatresult' },
		   { data: 'action' },
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_TestRequest_'+today+'',
                    exportOptions: {
                    columns: [  1, 2, 3,4,5,6 ]
                }
            }
        ],
        "order": [[ 2, "desc" ]]
    });
	$('#enrollment_no').keyup(function () { //alert();
        dataTable.draw();
    });
} );
</script>
@endsection
