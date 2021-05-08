<!-- Modal Dialog -->
<div class="modal fade" id="readingpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><!--Week <span id="lblweek"></span>-->Reading</h4>
      </div>
	  <div class="alert alert-danger datealertClss hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <!--form class="form-horizontal form-material" id="readingForm"-->
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="sample_id" id="sample_id" value="">
          <input type="hidden" name="enroll_id" id="enroll_id" value="">
          <input type="hidden" name="service_log_id" id="service_log_id" value="">
          <input type="hidden" name="week_no" id="week_no" value="">
		  
		  <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value="">

          <fieldset>
           <!-- <legend><label class="col-md-12">10<sup>-2</sup> Dilution Neat :</label></legend>-->
            <div class="row">
                <div class="col-md-6">
                   <label class="col-md-12">Drug Media 1 <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input name="dil_2_drug_media_1" id="dil_2_drug_media_1" class="form-control form-control-line " required>
                  </div>
               </div>
               <div class="col-md-6">
                  <label class="col-md-12">Drug Media 2</label>
                  <div class="col-md-12">
                     <input name="dil_2_drug_media_2" id="dil_2_drug_media_2" class="form-control form-control-line ">
                 </div>
              </div>
            </div>

          <div class="row" id="drug_names"> </div> 

         </fieldset>

         <fieldset>
         <!-- <legend><label class="col-md-12">10<sup>-4</sup> Dilution Neat:</label></legend> -->

           <div class="row" id="drug_names_result"> 

           </div>

        </fieldset>
		


      </div>
	   
	   <label class="col-md-12">Comments: </label>
		<div class="col-md-12">
	  <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
	   </div>
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md SaveRdngBtn" onclick="saveReading()">SUBMIT</button>
      </div>
      <!--/form-->
    </div>
  </div>
</div>

<script>
$(function(){

});

function saveReading(){

  var dl_2 = [],dl_4 =[];
  var dl_2_repeat = [],dl_4_repeat =[];

  $(".dil_2").each(function( index ) {
    var element = {
      name: $(this).find('[name="dil_2_drugName[]"]').val(),
      value:$(this).find('[name="dil_2_drugVal[]"]').val()
    };
    dl_2.push(element);

  });
  dl_2_repeat = $('input[name=repeat]:checked').map(function(){
      return  this.value;
  }).get();

  //console.log(dl_2_repeat);


  $(".dil_4").each(function( index ) {
    var element = {
      name: $(this).find('[name="dil_4_drugName[]"]').val(),
      value:$(this).find('[name="dil_4_drugVal[]"]').val()
    };
    dl_4.push(element);

  });
  dl_4_repeat = $('input[name=repeat]:checked').map(function(){
      return  this.value;
  }).get();

  var dil_2_drugVal_flag=true;
  $('.dil_2_drugVal').each(function(){
  if($(this).val()==""){
    dil_2_drugVal_flag=false;
  }
});

 var dil_4_drugVal_flag=true;
  $('.dil_4_drugVal').each(function(){
  if($(this).val()==""){
    dil_4_drugVal_flag=false;
  }
});

  if($("#dil_2_drug_media_1").val()!="" && dil_2_drugVal_flag && dil_4_drugVal_flag){
	  
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
                            $('.SaveRdngBtn').prop("type", "submit");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('.SaveRdngBtn').prop("type", "submit");
							
							$.ajax({
							  type: "POST",
							  url: "{{url('lj_dst_ln1/reading')}}",
							  data: {
								_token:"{{ csrf_token() }}",
								sample_id: $("#sample_id").val(),
								enroll_id: $("#enroll_id").val(),
								service_log_id: $("#service_log_id").val(),
								week_no: $("#week_no").val(),
								drug_media_1: $("#dil_2_drug_media_1").val(),
								drug_media_2: $("#dil_2_drug_media_2").val(),
								comments:$("#comments").val(),
								allData: {
								  dil_2: dl_2,
								  dil_4: dl_4,
								},
								allData_repeat: {
								  dl_2_repeat: dl_2_repeat,

								},

							  },
							  success: function(data){
								console.log(data)
								if(data == 1){
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
	  
	  

    
  
  }

}

</script>
