<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC Reporting</h4>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/further_lc_flagged_mgit') }}" method="post" id="extractionpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="log_id" class="log_id" id="log_id" value="">
		  
		  <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value="">
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Sample ID : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="sample_id" class="form-control form-control-line sampleId sample_id" value="" id="sample_id" required>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
          <div class="col">
              <div class="col-md-12">
                 <label class="col-md-12">GU : </label>
                 <div class="col-md-12">
                    <input type="text" name="gu" class="form-control form-control-line" value="" id="gu" >
                </div>
             </div>
          </div>
        </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">ICT</label>
                   <div class="col-md-12">
                     <p style="color:#3F99E9; font-size:16px;" id="ict_val"></p>
                      <!-- <select name="ict" class="form-control form-control-line test_reason" id="ict" >
                        <option value="">select</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Invalid">Invalid</option>
                        <option value="Not required">Not required</option>
                      </select> -->
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Smear from culture</label>
                   <div class="col-md-12">
                     <p style="color:#3F99E9; font-size:16px;" id="smearcul_val"></p>
                      <!-- <select name="culture_smear" class="form-control form-control-line test_reason" id ="culture_smear" required>
                        <option value="">Select</option>
                        <option value="Smear from culture">Smear from culture</option>
                        <option value="Positive, Cord factor">Positive, Cord factor</option>
                        <option value="Positive, No cord factor">Positive, No cord factor</option>
                        <option value="Negative">Negative</option>
                        <option value="Not required">Not required</option>
                      </select> -->
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">BHI/Blood Agar</label>
                   <div class="col-md-12">
                      <p style="color:#3F99E9; font-size:16px;" id="bhi_val"></p>
                      <!-- <select name="bhi" class="form-control form-control-line test_reason" id="bhi" required>
                        <option value="">Select</option>
                      <option value="Agar">Agar</option>
                        <option value="Growth">Growth</option>
                        <option value="No Growth">No Growth</option>
                        <option value="Not required">Not required</option>
                      </select> -->
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Final result : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <select name="result" class="form-control form-control-line test_reason" id="result" required>
                        <option value="">--Select--</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Contaminated">Contaminated</option>
                        <option value="NTM">NTM</option>
                        <!--<option value="Mixed culture">Mixed culture</option>-->
                        <option value="Other Result">Other Result</option>
                      </select>
                  </div>
               </div>
               <div class="col-md-12 hide" id="species">
                  <label class="col-md-12">Species Name</label>
                  <div class="col-md-12">
                    <input type="text" name="species" class="form-control form-control-line">
                </div>
              </div>
              <div class="col hide" id="other_result">
                  <label class="col-md-12">Enter Details </label>
                  <div class="col-md-12">
                     <input type="text" name="other_result"  class="form-control form-control-line" >
                 </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Date of LC result <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="result_date" id="result_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line datepicker" required>
                  </div>
               </div>
            </div>
          </div>
		  <div class="row"></div>

      </div>
      <div class="modal-footer" style="margin-top:100px;">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md submitOK" id="submit">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(function(){
  $("#result").change(function(){
    var _sample = $(this).val();
    console.log(_sample);
    if(_sample=='NTM'){
      $("#species").removeClass("hide");
      document.getElementById("species").setAttribute("required","required");
    }else{
      $("#species").addClass("hide");
      document.getElementById("species").removeAttribute("required","required");
    }
  });
  $("#result").change(function(){
      var _sample = $("#result").val();
      if(_sample=='Other Result'){
        $("#other_result").removeClass("hide");
        document.getElementById("other_result").setAttribute("required","required");

      }else{
        $("#other_result").addClass("hide");
        document.getElementById("other_result").removeAttribute("required","required");
      }
  });
});
$('#extractionpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });
</script>
