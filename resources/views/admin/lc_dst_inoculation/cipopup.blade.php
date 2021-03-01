<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC DST Innoculation</h4>
      </div>
	   <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/lc_dst_inoculation') }}" method="post" id="extractionpopupform">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="log_id" id="log_id" value="">
		  
		  <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value="">
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Sample ID <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="sample_id" id="sample_id" class="form-control form-control-line sampleId" value=""  required>
                  </div>
               </div>
            </div>
          </div>
		  <p style="color:red;" id="error_sample_id"></p>
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Positive MGIT sequence ID <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="mgit_seq_id" id="mgit_seq_id" class="form-control form-control-line" value=""  required>
                  </div>
               </div>
            </div>
          </div>
		  <p style="color:red;" id="error_mgit_seq_id"></p>
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">DST carrier set ID  1 <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="dst_c_id1" id="dst_c_id1" class="form-control form-control-line" value="" required>
                  </div>
               </div>
            </div>
          </div>
		  <p style="color:red;" id="error_dst_c_id1"></p>
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">DST carrier set ID 2</label>
                   <div class="col-md-12">
                      <input type="text" name="dst_c_id2" class="form-control form-control-line" value="" id="dst_c_id2" >
                  </div>
               </div>
            </div>
          </div>
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">DST carrier set ID 3</label>
                   <div class="col-md-12">
                      <input type="text" name="dst_c_id3" class="form-control form-control-line" value="" id="dst_c_id3" >
                  </div>
               </div>
            </div>
          </div>
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Date of DST inoculation<span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="inoculation_date" id="inoculation_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line datepicker" required>
                  </div>
               </div>
            </div>
          </div>
		  <p style="color:red;" id="error_inoculation_date"></p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="submitOK">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$('#extractionpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });
$(function(){
  $('#submitOK').click(function(e){
	  $('.alert-danger').addClass('hide');
	  $('.alert-danger').hide(); 
	 var enroll_id=$("#enrollId").val();
	 var sample_id=$("#sampleID").val();
	 var service_id=$("#serviceId").val();
	 var rec_flag=$("#recFlagId").val();
	 if(typeof $("#tagId").val() !== 'undefined' &&  $("#tagId").val()!= ''){
	  var tag=$("#tagId").val();
	}else{
		var tag="NULL";
	}
		
	
		$.ajax({
				  url: "{{url('check_for_lcdst_inaucolation_already_process')}}"+'/'+enroll_id+'/'+rec_flag,
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
                            $('#submitOK').prop("type", "button");
                            e. preventDefault(); 
                            //window.location.reload(true);	
							setTimeout(location.reload.bind(location), 1000);  // After 5 secs			
                             							
                            
						}else{
							if (!$.trim( $('#sample_id').val())) 
							{
								//alert('Result is required!');
								$("#error_sample_id").html("Sample ID is required.");
								return false;
							}else if (!$.trim( $('#mgit_seq_id').val())) 
							{
								$("#error_sample_id").html("");
								$("#error_mgit_seq_id").html("Positive MGIT sequence ID isrequired.");
								return false;
							}else if (!$.trim( $('#dst_c_id1').val())) 
							{
								$("#error_mgit_seq_id").html("");
								$("#error_dst_c_id1").html("DST carrier set ID 1 is required.");
								return false;
							}else if (!$.trim( $('#inoculation_date').val())) 
							{
								$("#error_dst_c_id1").html("");
								$("#error_inoculation_date").html("Date of DST inoculation is required.");
								return false;
							}else{ 
                                						
								$('.alert-danger').addClass('hide');
								$('.alert-danger').hide();
								
								$("#error_sample_id").html("");
								$("#error_mgit_seq_id").html("");
								$("#error_dst_c_id1").html("");
								$("#error_inoculation_date").html("");
								//$('#submitOK').prop("type", "submit");
								//$('#submitOK').trigger('click');
								//$('#extractionpopupform').submit();
								//alert("here");	
								$('#extractionpopupform').submit();
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
