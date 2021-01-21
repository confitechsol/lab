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
	color:#FFFF99;
}
.pink-color{
	color:#FEC0C7;
}
.brown-color{
	color:#D0E4CB;
}
.green-color{
	color:#CCFFCC;
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
                        <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

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
                                <tbody>
                                  @foreach ($data['sample'] as $key=> $samples)
                                  <?php $dt= explode("," , $samples->receive);
                                  $counter= count($dt);
                                  if($samples->status_id==1){
									  $bgcolor="#CCFFCC !important";
								  }else if($samples->status_id==2){
									  $bgcolor="#CCCCFF !important";
								  }else if($samples->status_id==3){
									  $bgcolor="#FFFF99 !important";
								  }else if($samples->status_id==4){
									  $bgcolor="#FEC0C7 !important";
								  }else if($samples->status_id==5){
									  $bgcolor="#D0E4CB !important";
								  }else{
									  $bgcolor="";
								  }
                                  ?>
                                  <tr style="background: {{$bgcolor }}">
                                   <td class="hide">{{$samples->enroll_id}}</td>
                                    <td>{{ $samples->reg_by }}</td>
                                    <td>{{$samples->label}}</td>
									<td>{{$samples->samples}}</td>
                                    <!--<td><?php
									
                                    if (strpos($samples->samples, 'R') !== false) {
                                     $string = substr($samples->samples, 0, strpos($samples->samples, 'R'));
                                    echo $string;}else{ echo $samples->samples;} ?></td>-->
                                    <td> @foreach( $dt as $recvdates) <?php echo $custdt= date('d-m-Y h:i:s', strtotime($recvdates));   ?>  @endforeach</td>
                                    <td>{!! str_replace(',','<br/>', $samples->reason) !!}</td>
                                    <td>{!! str_replace(',','<br/>', $samples->fu_month) !!}</td>
                                    <!-- <td><a class="btn btn-default btn-sm"  target="_blank" href="{{ url('/enroll/patient/'.$samples->patient_id.'/edit') }}">Enroll </a></td> -->
                                    <td>
                                      <button class="btn btn-default btn-sm"
                                              onclick="
                                                window.open('{{ url('/enroll/patient/'.$samples->patient_id.'/edit') }}');
                                                $('#exampl tr.bg-selected').removeClass('bg-selected');
                                                $(this).parents('tr').addClass('bg-selected')
                                              ">{{ $samples->reg_by ? 'Enrolled' : 'Enroll' }}
                                            </button>
                                    </td>
                                    <td>
									  <?php if($samples->status_id==4){ ?>
									    <a class="detail_modal" style="color:#ff0000 !important; cursor:pointer; font-size:12px;" onclick="getReasonforRejection('<?php echo $samples->label; ?>')"><b>View</b></a>
									  <?php } ?>
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
    $('#exampl').DataTable( {
        dom: 'Bfrtip',
		pageLength:25,
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
} );
</script>
@endsection
