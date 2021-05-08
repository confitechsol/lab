@extends('admin.layout.app')
@section('content')

<style>
  .bg-selected {
    background: #ffbdbd !important;
  }
  
  #pageloader
{
  background: rgba( 255, 255, 255, 0.8 );
  display: none;
  height: 100%;
  position: fixed;
  width: 100%;
  z-index: 9999;
}

#pageloader .loader
{
  left: 50%;
  margin-left: -32px;
  margin-top: -32px;
  position: absolute;
  top: 50%;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  /*z-index: 9999;*/
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
.blue-color{
	color:#CCCCFF;
}
.pink-color{
	color:#FEC0C7;
}
</style>

 <div class="page-wrapper">
    <div class="container-fluid">
	  @include('admin/resultpopup/reason_for_rejection_modal')
      <div class="row page-titles">
          <div class="col-md-5 col-8 align-self-center">
              <h3 class="text-themecolor m-b-0 m-t-0">Change Nikshay ID of Enrolment</h3>			 
			 
			 
          </div>
          <!---<div class="col-md-7 col-4 align-self-center">
            <form action="{{ url('/enrollwithnikshay/print') }}" method="post" target="_blank">            
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
            </form>
         </div>------>

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
                                   if($samples->status_id==2){
									  $bgcolor="#CCCCFF !important";
								  }else if($samples->status_id==4){
									  $bgcolor="#FEC0C7 !important";
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
                                    <td>
									<button type="button" onclick="openNikshayIdEntryForm({{$samples->enroll_id}},'{{$samples->samples}}','{{$samples->label}}','{{$samples->nikshay_id}}');$('#exampl tr.bg-selected').removeClass('bg-selected');
                                                $(this).parents('tr').addClass('bg-selected')" class="btn btn-info btn-sm resultbtn" >Submit</button>
                                    
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
    <footer class="footer">  </footer>
</div>





<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Nikshay ID</h4>
        </div>
         <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
         <form class="form-horizontal form-material" action="{{ url('/updatewithnikshayid') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollid" id="enrollid" value="">
				
				<label class="col-md-12"><h5>Enrolment ID:</h5></label>
                    <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="enrolllabelid" id="enrolllabelid" readonly>
                   </div>
                <br>
				
                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
          <input type="text" class="form-control form-control-line sampleId" name="sampleid" id="sampleid" readonly>
                   </div>
                <br>

                <label class="col-md-12"><h5>Nikshay ID:<span class="red">*</span></h5></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="nikshayid" id="nikshayid" onkeypress="return isNumberKey(event)"  onchange="try{setCustomValidity('')}catch(e){}" required="required" >
                   </div>
				    <p  style="color:red;" id="errorNikshayid"></p>
                <br>


            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
 
<script>
$(document).ready(function(){
  $("#cbnaat_result").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
$(function(){
	$("#nikshayid").on("keyup paste",function(){ //alert();
		  if(isNaN(this.value) == true) {
			document.getElementById('errorNikshayid').innerHTML="Please enter numeric value";
			//document.getElementById("confirm").disabled=true;
		  }else{
			document.getElementById('errorNikshayid').innerHTML="";
			//document.getElementById("confirm").disabled=false;
		  }
    });

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {
       // Pass form reference to modal for submission on yes/ok
       var form = $(e.relatedTarget).closest('form');
       $(this).find('.modal-footer #confirm').data('form', form);
  });

});

 function openNikshayIdEntryForm(enroll_id, sample_id, enroll_label,nikshay_id){
  //console.log("sample_ids", sample_ids.split(','));
  $("#enrollid").val(enroll_id);
  $("#enrolllabelid").val(enroll_label);
  $("#sampleid").val(sample_id);
  $("#nikshayid").val(nikshay_id);
  
  $('#myModal').modal('toggle');
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
});
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
	}else{	
	       
	       if(document.getElementById("nikshayid").value.charAt(0)=="0")
           {
                //alert("it should start with 9 ");
                return false
           }else{
              return true;
		   }
		   
	}
}
</script>
@endsection
