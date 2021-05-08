@extends('admin.layout.app')
@section('content')

<style>
  .bg-selected {
    background: #ffbdbd !important;
  }
  .color-code{
	font-size:15px;
	list-style:none;
	margin:5px 0px;
	padding:0px;
	
}
.color-code span{
	font-size:15px;
	margin-right:5px;
	border:1px solid #ddd;
	
	
}
.white-color{
	color:#fff;
}
.yellow-color{
	color:#FFFF99 !important;
}
.pink-color{
	color:#FEC0C7 !important;
}
.brown-color{
	color:#D0E4CB !important;
}
.green-color{
	color:#CCFFCC !important;
}
.purple-color{
	color:#CCCCFF !important;
}
.background-yellow-color{
	background:#FFFF99 !important;
}
.background-pink-color{
	background:#FEC0C7 !important;
}
.background-brown-color{
	background:#D0E4CB !important;
}
.background-green-color{
	background:#CCFFCC !important;
}
.background-purple-color{
	background:#CCCCFF !important;
}
.background-white-color{
	background:#FFFFFF !important;
}
 .hide_column {
    display : none;
}
@keyframes spinner {
  to {transform: rotate(360deg);}
}
 
.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 2px solid #ccc;
  border-top-color: #333;
  animation: spinner .6s linear infinite;
}

</style>

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Sample Opening</h3>

                  </div>
             <!---<div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/enroll') }}" method="post">
                      <input type ="hidden" name="enroll" value = "1">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Add New
                      </a>
                    </form>
                  </div>--->
				  <div class="col-md-7 col-4 align-self-center">
					  <a class="btn pull-right btn-sm btn-info" href="{{url('sample/create')}}">Add New </a>                  
                  </div>
              </div>
                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">
                                  <table>
                                    <tr>
                                      <td>
                                      <meta name="csrf-token" content="{{ csrf_token() }}">
                                      <input type="text" name="enrollment_no" id="enrollment_no"  placeholder="Search enrol. no from db" class="form-control" />
                                      </td>									  
                                    </tr>
                                    </table>
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Created By</th>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Date of Receipt</th>
                                              <th>Sample type</th>
                                              <th>Other Sample type</th>
                                              <th>Sample quality</th>
                                              <th>Sample Acceptance</th>
                                              <th>Reason for Test</th>
                                              <th>Follow Up Month</th>
                                              <th>samples submitted</th>
                                              <th>Sample sent to</th>
                                              <th>View</th>
                                              <!-- <th>Print</th> -->
                                              <!--<th>Result</th> -->
                                            </tr>
                                        </thead>                                        
                                      </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
        </div>





<!-- Modal -->
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
  // alert(labcity);
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
  var dataTable = $('#exampl').DataTable( {
        dom: 'Bfrtip',
		pageLength:25,
    stateSave: true,
    processing: true,
		language: {
            loadingRecords: '&nbsp;',
            //processing: 'Loading...'
            processing: '<div class="spinner"></div>'
        } , 
        serverSide: true,
        serverMethod: 'post',
        ajax: {
			   url: "{{url('ajax_sample_list')}}",
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
		   { data: 'ID',className: "hide_column" },
		   { data: 'created_by' },
		   { data: 'enroll_id' },
		   { data: 'sample_id' },
		   { data: 'date_of_receipt' },
		   { data: 'sample_type' },
		   { data: 'other_sample_type' },
		   { data: 'sample_quality' },
		   { data: 'sample_accept' },
       { data: 'reason_for_test' },
		   { data: 'fum' },
		   { data: 'sample_submitted' },
		   { data: 'sample_sent_to' },
		   { data: 'view' },
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_SampleOpening_'+today+'',
                 exportOptions: {
                    columns: [  1, 2, 3,4,5,6,7,8,9,10,11,12 ]
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
