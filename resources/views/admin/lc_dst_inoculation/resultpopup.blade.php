<!-- Modal Dialog -->
<div class="modal fade" id="resultpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">LC DST Inoculation Result</h4>
        <h4 class="modal-title"></h4>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
          <form class="form-horizontal form-material" action="" method="post" id="nxtpopup">
          <input name="_method" type="hidden" value="patch">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="service_log_id" id="next_log_id" value="">
          <input type="hidden" name="lc_dst_tr_id" id="lc_dst_tr_id" value="">
		  
		  <input type="hidden" name="enrollId" id="rslt_enrollId" value="">
		  <input type="hidden" name="tagId" id="rslt_tagId" value="">				
		  <input type="hidden" name="sampleID" id="rslt_sampleID" value="">
		  <input type="hidden" name="serviceId" id="rslt_serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="rslt_recFlagId" value="">
		  
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="next_sample_id" disabled>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
               <label class="col-md-12">Date of Result<span class="red">*</span></label>
               <div class="col-md-12">
                 <input type="text" placeholder="dd-mm-yy" name="result_date" id="result_date" class="form-control datepicker" required="required">
                  <!-- <input type="date" max="<?php echo date("Y-m-d");?>" name="result_date" class="form-control form-control-line" required> -->
              </div>
            </div>
          </div>
		  
		  <p style="color:red;" id="error_result_date"></p>
		  
          <div class="row">
            <div class="col">
               <label class="col-md-12">Next step</label>
               <div class="col-md-12">
                 <select name="next_step" id="next_step" class="form-control form-control-line" required>
                   <!--<option value="">--Select--</option>------->
                   <option value="0">Results Finalization</option>
                   <!-- <option value="1">Repeat DST</option>
                    <option value="2">Interim Report</option> -->
                 </select>
              </div>
            </div>
          </div>
          <p style="color:red;" id="error_next_step"></p>
		  
          <div class="row" id="drug_names">

          </div>

          <div class="row">
        <div class="col">
               <label class="col-md-12">Comments</label>
                    <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                  </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="nxtconfirm">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(function(){
	//document.getElementById("next_step").disabled=true;
  $('#resultpopupDiv').on('show.bs.modal', function (e) {

       // Pass form reference to modal for submission on yes/ok
       var form = $(e.relatedTarget).closest('form');
       $(this).find('.modal-footer #confirm').data('form', form);
   });
   
   //Confirm ok submit
	$('#nxtconfirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#rslt_enrollId").val();		
		var sample_id=$("#rslt_sampleID").val();		
		var service_id=$("#rslt_serviceId").val();		
		
		//var STATUS=$("#statusId").val();
		if(typeof $("#rslt_tagId").val() !== 'undefined' &&  $("#rslt_tagId").val()!= ''){
		  var tag=$("#rslt_tagId").val();
	    }else{
			var tag="NULL";
		}
		var rec_flag=$("#rslt_recFlagId").val();
		
		
	
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
                            $('#nxtconfirm').prop("type", "button");
                            e. preventDefault(); 
                            //window.location.reload(true);	
							setTimeout(location.reload.bind(location), 1000);  // After 5 secs			
                             							
                            
						}else{
							if(!$.trim( $('#result_date').val())) 
							{
								//alert('Result is required!');
								$("#error_result_date").html("Date of Result is required.");
								return false;
							}else if(!$.trim( $('#next_step').val())) 
							{
								//alert('Result is required!');
								$("#error_result_date").html("");	
								$("#error_next_step").html("Next Step is required.");
								return false;
							}
							else if(!$.trim( $('.drugnm').val())) 
							{
								//alert('Result is required!');
								$("#error_result_date").html("");	
								$(".error_drugnm").html("Result is required.");
								return false;
							}else{ 	
								$('.alert-danger').addClass('hide');
								$('.alert-danger').hide();
								$("#error_result_date").html("");
                                $("#error_next_step").html("");	
                                 $(".error_drugnm").html("");									
								//$('#nxtconfirm').prop("type", "submit");							
								//$('#nxtpopup').submit();
								$('#nxtpopup').get(0).submit();
								return true;
                            }							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});

});
</script>
