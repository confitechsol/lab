<!-- Modal Dialog -->
<div class="modal fade" id="lj_editResult" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LJ Result</h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/dashboardlj') }}" method="post" enctype='multipart/form-data' id="resultpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="enrollId" id="enrollIdlj" value="">
          <input type="hidden" name="service_log_id" id="result_log_id" value="">
          <input type="hidden" name="editresult" id="editresult" value="edit">
          <input type="hidden" name="type" id="type" value="">
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line" value="" id="sampleidlj" >
               </div>
            </div>
          </div>


          <div class="row">
            <div class="col ">
                <label class="col-md-12">ID  test</label>
                <div class="col-md-12">
                   <input type="hidden" name="is_pos" value="0" id="is_pos" >
                   <select name="test_id" class="form-control form-control-line test_reason" id="test_id" >
                     <option value="">--Select--</option>
                     <option value="Positive">Positive</option>
                     <option value="Negative">Negative</option>
                     <option value="Invalid">Invalid</option>
                     <option value="Not required">Not required</option>
                   </select>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Smear from culture </label>
                <div class="col-md-12">
                   <select name="culture_smear" class="form-control form-control-line test_reason" id="culture_smear_lj" >
                     <option value="">--Select--</option>
                     <option value="Positive">Positive</option>
                     <option value="Cord factor positive">Cord factor positive</option>
                     <option value="No cord factor positive">No cord factor positive</option>
                     <option value="Negative">Negative</option>
					 <option value="Not required">Not required</option>
                   </select>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col ">
			<div class="col-md-12">
                <label class="col-md-12">Final result</label>
                <div class="col-md-12">
                   
					   <select name="final_result" class="form-control form-control-line test_reason" id="final_result_lj" >
						 <option value="">--Select--</option>
						 <!--option value="Positive">Positive</option>
						 <option value="Negative">Negative</option>
						 <option value="Contamination">Contamination</option>
						 <option value="NTM">NTM</option>-->
						  <option value="Negative">Negative</option>
						  <option value="1+">1+</option>
						  <option value="2+">2+</option>
						  <option value="3+">3+</option>
						  <option value="Contaminated">Contaminated</option>
						  <option value="NTM">NTM</option>
						  <!--<option value="Mixed Culture">Mixed Culture</option> -->
						  <option value="Other Result">Other Result</option>
							<!--<option value="Other Result">Other</option>-->
					   </select>
					
               </div>
			 </div> 
				<div class="col-md-12 hide" id="other_result_div">
                  <label class="col-md-12">Other Result</label>
                  <div class="col-md-12">
                    <input type="text" name="other_result" id="otherresultinptxt" class="form-control form-control-line" value="">
                </div>
              </div>
			    <div class="col-md-12 hide" id="speciesdiv">
                  <label class="col-md-12">Species Name</label>
                  <div class="col-md-12">
                    <input type="text" name="species" id="speciesinptxt" class="form-control form-control-line" value="">
                </div>
              </div>

               
            </div>
          </div>
          
		  <!--<div class="row hide">
            <div class="col ">
                <label class="col-md-12">Date of LJ result <span class="red">*</span></label>
                <div class="col-md-12">
                   <input type="text" name="lj_result_date" max="<?php //echo date("Y-m-d");?>" class="form-control form-control-line datepicker" id="lj_result_date" required>
               </div>
            </div>
          </div>--->

          <div class="row">

            <div class="col">
            <label class="col-md-12">Reason for Edit:<span class="red">*</span></label>
               <div class="col-md-12">
                   <input type="text" name="reason_edit" class="form-control form-control-line"  id="reason_edit" required>
               </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){

  $("#final_result_lj").change(function(){
    var _sample = $(this).val();
    //console.log(_sample);
    if(_sample=='NTM'){
      $("#speciesdiv").removeClass("hide");
    }else{
      $("#speciesdiv").addClass("hide");
    }
	
	if(_sample=='Other Result'){
      $("#other_result_div").removeClass("hide");
    }else{
      $("#other_result_div").addClass("hide");
    }
  });
});
$('#resultpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });

</script>
