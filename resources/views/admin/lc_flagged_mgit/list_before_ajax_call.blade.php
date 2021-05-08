@extends('admin.layout.app')
@section('content')
<style>
#pageloader
{
	top: 0;
    bottom: 0;
    left: 0;
    right: 0;
	position: fixed;
    height:100%;
	width:100%;
	background:rgba(0, 0, 0, 0.2);
	opacity:.7;
	z-index:9999;
	display:none;
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
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LC Flagged MGIT Tube</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lcflag/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/lc_flagged_mgit/cipopup')
                <div class="row">
                <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
				    <!---<div class="alert alert-danger hide"><h4></h4></div>----->
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="hide">ID</th>
                                          <th>Sample ID</th>
                                          <th>MGIT Tube sequence ID</th>
                                          <th>Date of Inoculation</th>
                                          <th>Initial Smear  result</th>
										  <th>Test Requested</th>
                                          <th>Reason for test (DX/FU)</th>
                                          <th>Follow up month</th>
                                          <th>GU</th>
                                          <th>Date of flagging  by MGIT</th>
										 
                                          <th>Results</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td class="hide">{{$samples->ID}}</td>
                                          <td>{{$samples->samples}}</td>
                                          <!-- <td>
                                            @if($samples->tube_id_lj)
                                            {{$samples->tube_id_lj}}
                                            @else
                                            {{$samples->tube_id_lc}}
                                            @endif
                                          </td> -->

                                          <td>{{$samples->mgit}}</td>

                                          <td><?php echo date('d-m-Y',strtotime($samples->inoculation_date)); ?></td>
                                          <td>{{$samples->result}}</td>
										  <td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                          <td>{{$samples->reason}}</td>
                                          <td>{{$samples->fu_month}}</td>
                                          <td>{{$samples->gu}}</td>
                                          <td>{{$samples->flagging_date}}</td>
                                          <td>
                                            @if($samples->status==1)
                                            <button onclick="openForm('{{$samples->samples}}', {{$samples->log_id}}, '{{$samples->lpa_type}}','{{$samples->gu}}','{{$samples->flagging_date}}','{{$samples->tag}}',{{$samples->enrollID}},{{$samples->sampleID}},{{$samples->service_id}},{{$samples->rec_flag}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Submit</button>
                                            @else
                                            Done
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
            <footer class="footer">  </footer>
        </div>

<script>
$(document).ready(function(){
  $("#extractionpopupDiv").on("submit", function(){
    $("#pageloader").fadeIn();
	var zIndex = 9999;

    if ($('body').hasClass('modal-open')) {
        zIndex = parseInt($('div.modal').css('z-index')) + 1;
    }

    $("#pageloader").css({
        'display': 'block',
        'z-index': zIndex
    });

    setTimeout(function(){$("#pageloader").css("display", "none");}, 5000);
  });//submit
});//document ready

function openForm(sample_label, log_id, lpa_type, gu, flagging_date, tag,enroll_id,sample_id,service_id,rec_flag){
  $('#sample_id').val(sample_label);
  $('#log_id').val(log_id);
  $('#gu').val(gu);
  $('#flagging_date').val(flagging_date);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  
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
                title: 'LIMS_lc_flagged_mgit_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.resultbtn, #submit').click( function(e) {
		//alert("here");
		var enroll_id=$("#enrollId").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		var tag=$("#tagId").val();
		var rec_flag=$("#recFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  //console.log(response);
					  
                        if(response==1){
							$('.alert-danger').removeClass('hide');
							$('.alert-danger').show();
							$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                            $('#submit').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#submit').prop("type", "submit");
							//$("#submit").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
} );
</script>
@endsection
