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
                      <h3 class="text-themecolor m-b-0 m-t-0">CBNAAT </h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/cbnaat/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
                    </form>
                 </div>

              </div>

                <div class="row">

                <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
				@if($errors->any())
					<!----<div class="alert alert-danger" style="text-align:center !important"><h4>{{$errors->first()}}</h4></div>----->
				@endif
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >

                                  <div class="table-scroll">
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th class="hide">ID</th>
                                            <th>Enrolment ID</th>
                                            <th>Sample ID</th>
											<th>Test Requested</th>
                                            <th>Visual Appearance</th>
                                            <th>Next Step</th>
                                            <th>Date of Receipt</th>
                                            <th>Samples submitted</th>
                                            <th>Sample Type</th>
                                            <th class="noExport">Field NAAT Result</th>
                                            <th>Result MTB</th>
                                            <th>Result RIF</th>
                                            <th>Date Tested</th>
                                            
                                            <!-- <th>Action</th> -->
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td class="hide">{{$samples->ID}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>{{$samples->samples}}</td>
										  <td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                          <td>{{$samples->sample_quality}}</td>
                                          <td>
                                            @if($samples->STATUS == 1)
                                            <button type="button" onclick="openCbnaatForm({{$samples->enroll_id}},'{{$samples->samples}}','{{$samples->result_MTB}}','{{$samples->result_RIF}}','{{$samples->next_step}}','{{$samples->error}}','{{$samples->no_sample}}','{{$samples->sample_id}}','{{$samples->service_id}}','{{$samples->STATUS}}','{{$samples->tag}}','{{$samples->rec_flag}}')"  class="btn btn-info btn-sm resultbtn" >Submit</button>
                                            @else
                                            Done
                                            @endif
                                          </td>
                                          <td><?php echo date('d-m-Y',strtotime($samples->receive)) ?></td>
                                          <td>{{$samples->no_of_samples}}</td>
                                          <td>{{$samples->sample_type}}</td>
                                          <td><a class='detail_modal bmwoff' style='color:#1E88E5; cursor:pointer; font-size:12px;' onclick="showNaatResult()">View Naat Result</a></td>
                                          @if($samples->result_MTB)
                                          <td>{{$samples->result_MTB}}</td>
                                          @else
                                          <td>Pending</td>
                                          @endif
                                          @if($samples->result_RIF)
                                          <td>{{$samples->result_RIF}}</td>
                                          @else
                                          <td>Pending</td>
                                          @endif
                                          @if($samples->test_date)
                                          <td>{{$samples->test_date}}</td>
                                          @else
                                          <td>Pending</td>
                                          @endif

                                          
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

<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CBNAAT Details</h4>
        </div>
         <form class="form-horizontal form-material" action="{{ url('/cbnaat') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
				 <div class="alert alert-danger hide"><h4></h4></div>
		        <div class="modal-body">

		           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		           	<input type="hidden" name="enrollId" id="enrollId" value="">
					<input type="hidden" name="sampleID" id="sampleID" value="">
					<input type="hidden" name="serviceId" id="serviceId" value="">
					<input type="hidden" name="status" id="statusId" value="">
					<input type="hidden" name="tag" id="tagId" value="">
					<input type="hidden" name="rec_flag" id="recFlagId" value="">

		            <label class="col-md-12">Sample ID</label>
                    <div class="col-md-12">
                       <!-- <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid">

                       </select> -->
                       <input type="text" name="sampleid" class="form-control form-control-line sampleid"  id="sampleid" readonly>
                   </div>

                   	<label class="col-md-12">Result of MTB:<span class="red">*</span></label>
		            <div class="col-md-12">
		              <select name="mtb" id="mtb" class="form-control form-control-line" id="mtb" required>
		                <option>--Select--</option>
		                <option value="MTB Detected">MTB Detected</option>
		                <option value="MTB Not Detected">MTB Not Detected</option>
		                <option value="Invalid">Invalid</option>
		                <option value="Error">Error</option>
						<option value="No Result">No Result</option>
						<option value="NA">NA</option>
		              </select>
		           </div>

		           <div id="error" class="hide">
		           	 <label class="col-md-12">Error:</label>
		            <div class="col-md-12">
                       <input type="number" name="error" value="" class="form-control form-control-line">
                   </div>
               		</div>


		            <label class="col-md-12">Result of RIF:<span class="red">*</span></label>
		            <div class="col-md-12">
		              <select name="rif" id="rif" class="form-control form-control-line" id="rif" required>
		                <option>--Select--</option>
		                <option value="RIF Detected">RIF Resistance Detected</option>
		                <option value="RIF Not Detected">RIF Resistance Not Detected</option>
		                <option value="RIF Indeterminate">RIF Indeterminate</option>
		                <option value="NA">NA</option>
		              </select>
		           </div>

		          <!--  <label class="col-md-12">Date Tested: {{$data['today']}}</label>
		           <div></div> -->
		           <label class="col-md-12">Date Tested</label>
                    <div class="col-md-12">
                       <input type="date" name="test_date" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line" >
                   </div>



                           <label class="col-md-12">Machine Serial No.</label>
                           <div class="col-md-12">
                             <select name="cbnaat_equipment_name" class="form-control form-control-line">

                               <option value="">--Select--</option>
                               <?php foreach ($data['equipments_list'] as $key => $equipments_list) {
                                echo "<option value='$equipments_list->eqipments'>$equipments_list->eqipments</option>";
                               } ?>


                             </select>
                          </div>





		           <label class="col-md-12">Next Step: </label>
		            <div class="col-md-12">
		              <select name="next_step" class="form-control form-control-line" id="next_step" required>
		                <option value="">--Select--</option>
						<!--<option value="Interim Report Submit another sample">Interim Report Submit another sample</option>--->
						<option value="Repeat Test with another sample">Repeat Test with another sample</option>
		                <option value="Repeat Test with same sample">Repeat Test with same sample</option>
		                <option value="Submit result for finalization">Submit result for finalization</option>
                        <option value="Send to BWM">Send to BWM</option>
		              </select>
		           </div>



                       <label class="col-md-12">Comments:</label>
                       <div class="col-md-12">
                         <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                      </div>



		        </div>
		        <div class="modal-footer">
		          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
		          <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
        		  <button type="button" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
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

$(document).ready(function(){
  $("#cbnaat_result").on("submit", function(){
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


$(function(){

        $('#next_step').on('change', function (e) {
          var service = $("#next_step").val();
          var no_sample = $("#no_sample").val();
          if(service=='Repeat Test with another sample' && no_sample=='0'){
            alert("standby sample not available");
            $("#next_step").val('');
          }

         });
        $("#mtb").change(function(){
            var _sample = $("#mtb").val();

            if(_sample == 'Error' || _sample == 'No Result'){
                document.getElementById("rif").value = "";
                document.getElementById("rif").setAttribute("disabled","disabled");
            }else{
                document.getElementById("rif").removeAttribute("disabled","disabled");
            }


        });

        $("#confirm").change(function(){
            var _sample = $("#mtb").val();
            if(_sample == 'Error' || _sample == 'No Result'){
                document.getElementById("rif").removeAttribute("disabled","disabled");
            }
            else {
              document.getElementById("rif").addAttribute("disabled","disabled");
            }


        });




	$("#mtb").change(function(){

    	if($( "#mtb option:selected" ).text()=='Error'){
    		$('#error').removeClass('hide');
    	}
    	else{
    		$('#error').addClass('hide');
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

	/* Form confirm (yes/ok) handler, submits form*/

});
// function openPrintModal(obj){
//   //console.log(obj.attr('data-sample'));
//   var samples = obj.attr('data-sample');
//   $.ajax({
//     method: "GET",
//     url: "{{url('cbnaat/submit/')}}"+'/'+samples,
//     data: { samples: samples }
//   }).done(function( msg ) {
//     $("#printCode").html(msg)
//     $('#myModal').modal('toggle');
//   });

// }




 function openCbnaatForm(enroll_id, sample_ids, mtb, rif, next_step, error, no,sample_id,service_id,STATUS,tag,rec_flag){
 	//console.log("sample_ids", sample_ids.split(','));
 	$("#enrollId").val(enroll_id);
 	$("#mtb").val(mtb);
 	$("#rif").val(rif);
 	$("#error").val(error);
 	$("#next_step").val(next_step);
    $('#no_sample').val(no);
	$("#sampleid").val(sample_ids);
    
	$("#sampleID").val(sample_id);
	$("#serviceId").val(service_id);
	$("#statusId").val(STATUS);
	$("#tagId").val(tag);
	$("#recFlagId").val(rec_flag);
	
	
   //var sampleArray = sample_ids.split(',');
   //$('#sampleid option').remove();
   //$.each(sampleArray, function (i, item) {
	//$('#sampleid').append($('<option>', {
	//         text : item
	//}));
	// });

 	$('#myModal').modal('toggle');
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
    $('#exampl').DataTable( {
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_Cbnaat_'+today+''
            }
        ],
         "order": [[ 1, "desc" ]]
    });
	//Confirm ok submit
	$('.resultbtn, #confirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enrollId").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		//var tag=$("#tagId").val();
		if(typeof $("#tagId").val() !== 'undefined' &&  $("#tagId").val()!= ''){
		  var tag=$("#tagId").val();
	    }else{
			var tag="NULL";
		}
		
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
                            $('#confirm').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#confirm').prop("type", "submit");
							$("#confirm").text("OK");
							
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
