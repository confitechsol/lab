<!-- Modal Dialog -->
<div class="modal fade" id="nextpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">Microscopy Next Step</h4>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <form class="form-horizontal form-material" action=""  method="post"  id="nxtpopup">
      <div class="modal-body">
        <p></p>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="service_log_id" id="next_log_id" value="">
          <input type="hidden" name="serviceID" id="serviceID" value="">
          <input type="hidden" name="tag" id="tag" value="">
		  
		    <input type="hidden" name="enrollId" id="enrollID" value="">				
			<input type="hidden" name="sampleID" id="SampleID" value="">
			<input type="hidden" name="serviceId" id="ServiceID" value="">				
			<input type="hidden" name="rec_flag" id="recFlagID" value="">
			<input type="hidden" name="tagID" id="tagID" value="">
		  
		  
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="next_sample_id" required>
               </div>
            </div>
          </div>
          <div class="row">
              <div class="col">
                  <label class="col-md-12">Sample Sent for</label>
                  <div class="col-md-12">
                     <select name="service_id" class="form-control form-control-line test_reason" id="service_id" required>
                       <option value="">--Select--</option>
                       <!--<option value="3" id="dna">Decontamination DNA extraction</option>
                       <option value="3" id="lc">Decontamination for AFB Culture Liquid</option>
                       <option value="3" id="lj">Decontamination for AFB Culture Solid</option>
                       <option value="3" id="Sent_for">Decontamination for Culture LC and LJ both</option>-->
					   <option value="3" id="dna">Decontamination</option>
                       <option value="4" id="cbnaat">CBNAAT</option>
                       <option value="8" id="dna1">LPA 1st Line</option>
					   <option value="8" id="dna2">LPA 2nd Line</option>
					    <option value="8" id="dnaboth">LPA 1st and 2nd Line</option>
                       <option value="16" id="solid_culture">Solid Culture</option>
                       <option value="16" id="liquid_culture">Liquid Culture</option>
                       <option value="16" id="both">Solid and Liquid Culture</option>
                       <option value="11" id="storage">Sent for storage</option>
						           <option value="25" id="Sent_for">Sent for microbiologist</option> 
                       <!-- <option value="12" id="Sent_for">Sent for microbiologist</option> -->

                     </select>
                 </div>
              </div>
          </div>



          <div class="row">
              <div class="col">
                  <label class="col-md-12">Comments</label>
                  <div class="col-md-12">
                    <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                 </div>
              </div>
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <input type="submit" class="pull-right btn btn-primary btn-md  " id="conbuttonOK" onclick="return submit_form()" value="OK">
      </div>
    </form>
    </div>
  </div>
</div>

<script>
$(function(){


  $("#service_id").change(function() {
    var id = $(this).children(":selected").attr("id");
    //console.log(id);
    if(id=='dna'){
      $('#tag').val('DECONTAMINATION');
    }else if(id=='cbnaat'){
      $('#tag').val('CBNAAT');
    }else if(id=='dna1'){
      $('#tag').val('LPA 1st Line');
    }else if(id=='dna2'){
      $('#tag').val('LPA 2nd Line');
    }else if(id=='dnaboth'){
      $('#tag').val('LPA 1st and 2nd Line');
    }else if(id=='lc'){
      $('#tag').val('AFB Culture Liquid');
    }else if(id=='lj'){
      $('#tag').val('AFB Culture Solid');
    }else if(id=='solid_culture'){
      $('#tag').val('LJ');
    }else if(id=='liquid_culture'){
      $('#tag').val('LC');
    }else if(id=='both'){
      $('#tag').val('LC & LJ Both');
    }else{
      $('#tag').val('');
    }
  });
  $('#nextpopupDiv').on('show.bs.modal', function (e) {

       // Pass form reference to modal for submission on yes/ok
       var form = $(e.relatedTarget).closest('form');
       $(this).find('.modal-footer #confirm').data('form', form);
   });


});
function submit_form(){ //alert();
        var enroll_id=$("#enrollID").val();
		var sample_id=$("#SampleID").val();
		var service_id=$("#ServiceID").val();
		//var STATUS=$("#statusId").val();
		if(typeof $("#tagID").val() !== 'undefined' &&  $("#tagID").val()!= ''){
		  var tag=$("#tagID").val();
	    }else{
			var tag="NULL";
		}
		var rec_flag=$("#recFlagID").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process_mcroscopy_next')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
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
                            $('#conbuttonOK').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#conbuttonOK').prop("type", "submit");
							$("#conbuttonOK").text("OK");
							
							var form = $("#nxtpopup").serialize();
							 $.ajax({
								type: "POST",
								url: "{{ url('/serviceLog') }}",
								data: form,
								async: false,
								dataType: "json",
								success: function(data) {
								  console.log(data);
								  window.location.replace("{{ url('/review_microscopy') }}");
								},
								error: function() {
									alert('error handing here');
								}
							});
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
     $('#nxtconfirm').attr("disabled", true);
     

     return false;
}
</script>
