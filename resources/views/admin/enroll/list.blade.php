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
	  @include('admin/resultpopup/reason_for_rejection_modal')
      <div class="row page-titles">
          <div class="col-md-5 col-8 align-self-center">
              <h3 class="text-themecolor m-b-0 m-t-0">Enrolment</h3>
			   <ul class="color-code">
				<li><strong>Color Code</strong></li>
				<li><span class="white-color" font-size="20"><i class="mdi mdi-checkbox-blank" aria-hidden="true"></i></span>Action to be taken</li>
				<li><span class="yellow-color"><i class="mdi mdi-checkbox-blank" aria-hidden="true"></i></span>Patient details entered without Nikshay ID</li>
				<li><span class="pink-color"><i class="mdi mdi-checkbox-blank" aria-hidden="true"></i></span>Nikshay server failed to generate Nikshay ID</li>
				<li><span class="brown-color"><i class="mdi mdi-checkbox-blank" aria-hidden="true"></i></span>Nikshay server successfully accepted Patient details</li>
				<li><span class="green-color"><i class="mdi mdi-checkbox-blank" aria-hidden="true"></i></span>Patient details successfully completed</li>
			   </ul>			  
          </div>
          <div class="col-md-7 col-4 align-self-center">
            <form action="{{ url('/enroll/print') }}" method="post" target="_blank">
            <!--   <input type ="hidden" name="enroll" value = "1"> -->
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
            </form>
         </div>

      </div>
      <?php //dd($data); ?>

        <div class="row">

            <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                <div class="card" style="border: none;">
                    <div class="card-block">
                        <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12 col-sm-12" width="100%">
							   <!---Custom Filter Start--->
							   <table>
								 <tr>
								   <td>
									 <meta name="csrf-token" content="{{ csrf_token() }}">
									 <input type="text" name="enrollment_no" id="enrollment_no"  placeholder="Search enrol. no from db" class="form-control" />
								   </td>									  
								 </tr>
							   </table>
							   <!---Custom Filter End--->
							   
                            <table id="exampl" class=" export table table-striped table-bordered responsive col-lg-12" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th class="hide">ID</th>
                                      <th>Created By</th>
                                      <th>Enrolment ID</th>
                                      <th>Sample ID</th>
                                      <th>Receive Date</th>
                                      <th>Reason for Test</th>
                                      <th>Follow up month</th>
                                      <th>Action</th>
									  <th>Reason for rejection</th>
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
function getReasonforRejection(sample_label){
$("#det_modal > tbody").empty();
var label=sample_label;
// alert(label);

    $.ajax({
      url:"{{ url('/enroll/get_reason_for_rejection') }}",
      method:"POST",
      data:{"label":label,"_token":"{{ csrf_token() }}"},
      dataType:"JSON",
      success:function(response){
        console.log(response);
        $.each(response, function (key, val) {
				var enrollment_no=val.enrollment_no;	
				var patient_name=val.patient_name;				
				var job_method=val.job_method;
				var reason_for_failure=val.reason_for_failure;

				

				//$("#sample_name").text(val.sample_label);

				$("#det_modal > tbody").append("<tr><td>"+enrollment_no+"</td><td>"+patient_name+"</td><td>"+reason_for_failure+"</td></tr>");

       });

        $("#progressdetailpopup").modal('toggle');

     }

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
		language: {
            loadingRecords: '&nbsp;',
            //processing: 'Loading...'
            processing: '<div class="spinner"></div>'
        } , 
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
		ajax: {
			   url: "{{url('ajax_enroll_list')}}",
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
		   { data: 'reg_by' },
		   { data: 'label' },
		   { data: 'samples' },
		   { data: 'receive_date' },
		   { data: 'reason' },
		   { data: 'fu_month' },
		   { data: 'action' },
		   { data: 'reason_for_rejection' },
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_Enrollment_'+today+'',
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
