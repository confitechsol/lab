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
                      <h3 class="text-themecolor m-b-0 m-t-0">AFB Culture inoculation</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/cultureInno/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
                    </form>

                    <form action="{{ url('/cultureInno/printBarcode') }}" method="post" id="formprint">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>

                 </div>
              </div>

              @include('admin/culture_inoculation/cipopup')
                <div class="row">
                <div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
				    <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th class="hide">ID</th>
                                          <th>Lab Enrolment ID</th>
                                          <th>Sample ID</th>
                                          <th>Action</th>
                                          <th>Microscopy result</th>
                                          <th>Tag</th>
                                          <th>MGIT  sequence ID (LC)</th>
                                          <th>Date of Inoculation</th>
										  <th>Test Requested</th>
                                          <th>DX/FU</th>
                                          <th>Follow up month</th>
                                          <th>Culture method (LJ,LC,both)</th>
                                          <th>TUBE 1 sequence ID (LJ)</th>
                                          <th>TUBE 2 sequence ID (LJ)</th>
                                          <th>
                                              <button id="barcodeprn" type="submit" class="pull-right btn-sm btn-info" form="formprint" >Barcode Print</button>
                                          </th>
                                          <th>Copies</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      {{--{{ dd( $data['sample'] ) }}--}}

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td class="hide">{{$samples->ID}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>{{$samples->samples}}</td>
                                          <td>
                                            @if($samples->status==1)
                                            <button onclick="openForm('{{$samples->samples}}', {{$samples->log_id}}, '{{$samples->lpa_type}}','{{$samples->tag}}',{{$samples->enrollID}},{{$samples->sampleID}},{{$samples->service_id}},{{$samples->rec_flag}})",  value="" type="button" class = "btn btn-info btn-sm resultbtn">Submit</button>
                                            @else
                                            Done
                                            @endif
                                          </td>
                                          <td>{{$samples->result}}</td>
                                          <td>
                                            @if ($samples->tag != 'NONE')
                                                {{$samples->tag}}
                                              @endif
                                          </td>
                                          @if(empty($samples->mgit))
                                          <td>pending</td>
                                          @else
                                          <td>{{$samples->mgit}}</td>
                                          @endif
                                          <td>
                                            @if($samples->inoculation_date)
                                            {{$samples->inoculation_date}}
                                            @else
                                            pending
                                            @endif
                                          </td>
										  <td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                          <td>{{$samples->reason}}</td>
                                          <td>{{$samples->fu_month}}</td>
                                          <td>{{$samples->lpa_type}}</td>
                                          @if(empty($samples->tube_id_lj))
                                          <td></td>
                                          @else
                                          <td>{{$samples->tube_id_lj}}</td>
                                          @endif
                                          @if(empty($samples->tube_id_lc))
                                          <td></td>
                                          @else
                                          <td>{{$samples->tube_id_lc}}</td>
                                          @endif
                                          <td>

                                            <label class="hide"><span id="caterralert" style="color:red;"></span></label>
                                            <input type="checkbox" value="{{$samples->samples}}" class="single-checkbox" name="print[]" form="formprint" data-id="copy-<?php echo $key; ?>" id="check-<?php echo $key; ?>" class="btn btn btn-sm">
                                          </td>
                                          <td>

                                            <input type="text" class="single-input" name="no_of_copy[]" form="formprint" id="copy-<?php echo $key; ?>" class="btn btn btn-sm">
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
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->



          </div>
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

$(document).ready(function(){
  var limit = 4;
  var another_limit=1
 $("#barcodeprn").hide();
  $('input.single-checkbox').on('change', function(evt) {
     if($('[name="print[]"]:checked').length < another_limit) {
         // this.checked = false;
         $("#barcodeprn").hide();
     }else{
        $("#barcodeprn").show();
     }
  });




  $('input.single-checkbox').on('change', function(evt) {
     if($('[name="print[]"]:checked').length > limit) {
         this.checked = false;
         $("#caterralert").text("You can select only 4 samples!");
     }else{
        $("#caterralert").text("");
     }
  });
});
function openForm(sample_label, log_id, lpa_type, tag,enroll_id,sample_id,service_id,rec_flag){
  $('#sample_id').val(sample_label);
  $("#sample_id").attr("disabled",true);
  $('#log_id').val(log_id);
  $('#ssentfor').text(tag);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  $("#heading").text(tag);
  
  
  var service_html = '<option value="">--Select--</option>';
  if(tag =='LC'){
    service_html +='<option value="1">LC</option><option value="2" disabled>LJ</option><option value="3" disabled>LC & LJ Both</option><option value="Send to BWM">Send to BWM</option>';

  }else if(tag =='LJ'){

    service_html +='<option value="1" disabled>LC</option><option value="2" >LJ</option><option value="3" disabled>LC & LJ Both</option><option value="Send to BWM">Send to BWM</option>';

  }
  else if(tag =='LC and LJ Both'){
    service_html +='<option value="1" disabled>LC</option><option value="2" disabled>LJ</option><option value="3" >LC & LJ Both</option><option value="Send to BWM">Send to BWM</option>';

  }else{
    service_html +='<option value="1">LC</option><option value="2">LJ</option><option value="3">LC & LJ Both</option><option value="Send to BWM">Send to BWM</option>';
  }
  $("#service_id").html(service_html);
  $.ajax({
				  url: "{{url('get_mgit_id')}}"+'/'+enroll_id+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					//console.log(response);
                     var len = 0;
					if(response['json_data_item'] != null){
						len = response['json_data_item'].length;
					}
					//alert(len);					
					if(len > 0){
						for(var i=0; i<len; i++){					
					         $('#mgit_id').val(response['json_data_item'][i].mgit_id); 
						}
                    }						
						
				  },
				failure: function(response){
					console.log("err")
				}
		});
  
  
  
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  //alert(lpa_type);

  if(tag == 'NONE')
  {
    $('#p_heading').hide();
    $('#mgit_id_span').hide();
    $('#mgit_id').removeAttr('required');
    $('#tube_id_lj_span').hide();
    $('#tube_id_lj').removeAttr('required');
  }


  if(lpa_type == 'LJ'){
    //$("#mgit_id").attr("disabled", "disabled");
	$("#mgit_id").attr("readonly", "readonly");
    $("#tube_id_lj").attr("disabled",false);
    $("#tube_id_lc").removeAttr("disabled","disabled" );
	$('#tube_id_lj').val(sample_label);
  }
  
  if(lpa_type == 'LC'){
	$('#tube_id_lj').val("");  
    $("#tube_id_lj").attr("disabled",true);
    $("#tube_id_lc"). attr("disabled", "disabled");
    //$("#mgit_id"). removeAttr("disabled");
   $("#mgit_id"). removeAttr("readonly");

  }
  
  if((lpa_type == '')|| (lpa_type == 'LC and LJ Both') || (lpa_type == 'LC & LJ Both')){ //alert(lpa_type);
	  $('#tube_id_lj').val(sample_label);
	  $("#tube_id_lj").attr("disabled",false);
  }
  //$("#tube_id_lj").attr("disabled",true);
}


function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}

function openPrintModal(year,print_type){
  //console.log(obj.attr('data-sample'));
    $("#year").val(year);
    $("#print_type").val(print_type);
    $("#yeartpl").html(year);
    $('#myModal').modal('toggle');

}


</script>
<script>
$(document).ready(function(){
  // $(".single-input").attr("disabled",'disabled');
$(".single-checkbox").click(function(){
if($(this).prop("checked") == true){
 // alert($(this).attr("data-id"));
 var enable_input_id=$(this).attr("data-id");
var text='"#'+enable_input_id+'"';
// alert(text);
 // $(text).prop("disabled",true);
 // alert(enable_input_id);
}
else if($(this).prop("checked") == false){
var disable_input_id=$(this).attr("data-id");
var dtext='"#'+disable_input_id+'"';
// $("#"disable_input_id"").prop("disabled",true);
// alert(disable_input_id)
}

});

});
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
        stateSave: true,
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_afbculture_'+today+''
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
    //var allresults='3pos';
		var allresults =$("#allresults").val();  
    if(allresults){
      allresults =allresults;
    }else{
      allresults =null;
    }
		//var STATUS=$("#statusId").val();
		var tag=$("#tagId").val();
		var rec_flag=$("#recFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process1')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag+'/'+allresults,
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


              $.ajax({
                    url:"{{ url('/get_lc_result_data') }}"+'/'+$('#sampleID').val()+'/'+$('#enrollId').val(),
                    type:"GET",
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                    success:function(result){
                      console.log(result);
                      if(result.result != '0')
                      {
                        $('#allresults').find('option:selected').text(result.result);
                        $('#allresults').attr('disabled', 'disabled');
                        //$('#allresults').
                      } else { 

                        $('#allresults').removeAttr('disabled');

                      }             

                  }

                  });





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
});
</script>
@endsection
