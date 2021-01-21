<!-- Modal Dialog -->
<div class="modal fade" id="resultpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">Microscopy Result</h4>
      </div>
	   <div class="alert alert-danger rslterror hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/microscopy') }}" method="post" enctype='multipart/form-data' id="resultpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="service_log_id" id="result_log_id" value="">
          <input type="hidden" name="results" id="result" value="">
          <input type="hidden" name="serviceID" id="serviceID" value="">
          <input type="hidden" name="type" id="type" value="">
		  
		  
		
		<input type="hidden" name="enrollId" id="rsltenrollId" value="">
		<input type="hidden" name="sampleID" id="rsltsampleId" value="">	
		<input type="hidden" name="serviceId" id="rsltserviceId" value="">				
		<input type="hidden" name="rec_flag" id="rsltrecFlagId" value="">
		<input type="hidden" name="tag" id="rslttagId" value="">  
		
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="sample_id" required>
               </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
                <label class="col-md-12">Result<span class="red">*</span></label>
                <div class="col-md-12">
                   <!-- <input type="text" name="sample_quality[]" class="form-control form-control-line" required> -->
                   <select name="result" id="allresults" class="form-control form-control-line" required>
                     <!-- <option value="">--Select--</option>
                     <option value="Negative">Negative</option>
                     <option value="Scanty">Scanty</option>
                     <option value="1+positive">1+positive</option>
                     <option value="2+positive">2+positive</option>
                     <option value="3+positive">3+positive</option> -->
                   </select>
               </div>
            </div>		   
          </div>
		  <p style="color:red;" id="error_result"></p>
		  
          <div class="row">
            <div class="col" id="reason_other">
                <label class="col-md-12">Reason for Edit</label>
                <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="reason_other" id="reason_other">
               </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(function(){
   //Confirm ok submit
	$('#confirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#rsltenrollId").val();
		var sample_id=$("#rsltsampleId").val();
		var service_id=$("#rsltserviceId").val();
		//var STATUS=$("#statusId").val();
		if(typeof $("#rslttagId").val() !== 'undefined' &&  $("#rslttagId").val()!= ''){
		  var tag=$("#rslttagId").val();
	    }else{
			var tag="NULL";
		}
		var rec_flag=$("#rsltrecFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  //console.log(response);
					  
                        if(response==1){
							$('.rslterror').removeClass('hide');
							$('.rslterror').show();
							$('.rslterror').html("Sorry!! Action already taken of the selected Sample");
                            $('#confirm').prop("type", "button");
                            e.preventDefault(); 
                            //window.location.reload(true);	
							//setTimeout(location.reload.bind(location), 1000);  // After 5 secs							
                            
						}else{
							//var form =  $(document).find('#resultpopup');
                            //$('#confirm').prop("type", "submit");							
							$('.rslterror').addClass('hide');
							$('.rslterror').hide();							
							//$('#confirm').prop("type", "submit");
							//$("#confirm").text("OK");
							if (!$.trim( $('#allresults').val())) 
							{
								//alert('Result is required!');
								$("#error_result").html("Result is required.");
								return false;
							}else{ 							    
							   
								$("#error_result").html("");								
								//form.submit();
								$('#resultpopup').get(0).submit();
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

$('#resultpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });



</script>
