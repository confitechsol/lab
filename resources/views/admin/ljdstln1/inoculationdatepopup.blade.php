<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">Add Date</h4>
      </div>
	  <div class="alert alert-danger  hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/') }}" method="post" id="extractionpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="sample_id" id="sample_id" value="">
          <input type="hidden" name="enroll_id" id="enroll_id" value="">
          <input type="hidden" name="service_log_id" id="service_log_id" value="">
          <input type="hidden" name="inoculation_for" id="inoculation_for" value="1">

          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Date of Inoculation</label>
                   <div class="col-md-12">
                      <input type="text" name="inoculation_date" id="inoculation_date" class="form-control form-control-line datepicker" required>
                  </div>
               </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="submit">Ok</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  $('#submit').click(function(e){
	  
	 var enroll_id=$("#enroll_id").val();
		
	
		$.ajax({
				  url: "{{url('check_for_inaucolation_date_already_process')}}"+'/'+enroll_id,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  //console.log(response);
					  
                        if(response==1){
							$('.datealertClss').removeClass('hide');
							$('.datealertClss').show();
							$('.datealertClss').html("Sorry!! Action already taken of the selected Sample");
                            //$('#submit').prop("type", "button");
                            e. preventDefault(); 
                            //window.location.reload(true);	
							setTimeout(location.reload.bind(location), 1000);  // After 5 secs			
                             							
                            
						}else{

							//alert('here');
							$('.datealertClss').addClass('hide');
							$('.datealertClss').hide();
							    $.ajax({
								  type: "POST",
								  url: "{{url('lj_dst_ln1/inoculation')}}",
								  data: {
									_token:"{{ csrf_token() }}",
									sample_id: $("#sample_id").val(),
									enroll_id: $("#enroll_id").val(),
									service_log_id: $("#service_log_id").val(),
									inoculation_for: $("#inoculation_for").val(),
									inoculation_date: $("#inoculation_date").val(),
								  },
								  success: function(data){
									console.log(data)
									if(data == true){
									  window.location.reload(true);
									}
								  },
								  dataType: "json"
								});
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		}); 
	  
	  
	  
	  
	  

  });
});

</script>
