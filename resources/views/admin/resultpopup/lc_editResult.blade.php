<!-- Modal Dialog -->
<div class="modal fade" id="lc_editResult" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC Result</h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/further_lc_flagged_mgit') }}" method="post" enctype='multipart/form-data' id="resultpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="enrollId" id="enrollIdlc" value="">
          <input type="hidden" name="service_log_id" id="result_log_id" value="">
          <input type="hidden" name="editresult" id="editresult" value="edit">
          <input type="hidden" name="service" id="service" value="17">
          <input type="hidden" name="type" id="type" value="">
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line" value="" id="sampleidlc" >
               </div>
            </div>
          </div>


          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">ICT : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <select name="ict" class="form-control form-control-line test_reason" id="ict" required>
                        <option value="">--Select--</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Invalid">Invalid</option>
                        <option value="Not required">Not required</option>
                      </select>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Smear from culture :<span class="red">*</span></label>
                   <div class="col-md-12">
                      <select name="culture_smear" class="form-control form-control-line test_reason" id ="culture_smear" required>
                        <option value="">--Select--</option>
                       <!--  <option value="Smear from culture">Smear from culture</option> -->
                        <option value="Positive, Cord factor">Positive, Cord factor</option>
                        <option value="Positive, No cord factor">Positive, No cord factor</option>
                        <option value="Negative">Negative</option>
                        <option value="Not required">Not required</option>
                      </select>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">BHI/Blood Agar : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <select name="bhi" class="form-control form-control-line test_reason" id="bhi" required>
                        <option value="">--Select--</option>
                        <!-- <option value="Agar">Agar</option> -->
                        <option value="Growth">Growth</option>
                        <option value="No Growth">No Growth</option>
                        <option value="Not required">Not required</option>
                      </select>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Final result : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <select name="result" class="form-control form-control-line test_reason" id="resultlc" required>
                        <option value="">--Select--</option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Contaminated">Contamination</option>
                        <option value="NTM">NTM</option>
                        <!--<option value="Mixed culture">Mixed culture</option>-->
						<option value="Other Result">Other Result</option>
                      </select>
                  </div>
               </div>

               <div class="col-md-12 hide" id="species">
                  <label class="col-md-12">Species Name :</label>
                  <div class="col-md-12">
                    <input type="text" name="species" id="speciesinp" class="form-control form-control-line" value="">
                </div>
              </div>

               <div class="col-md-12 hide" id="other_result">
                  <label class="col-md-12">Other Result :</label>
                  <div class="col-md-12">
                    <input type="text" name="other_result" id="otherresultinp" class="form-control form-control-line" value="">
                </div>
              </div>

            </div>
          </div>
          <div class="row hide">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Date of LC result :</label>
                   <div class="col-md-12">
                      <input type="test" name="result_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line datepicker" >
                  </div>
               </div>
            </div>
          </div>

          <div class="row">

            <div class="col">
            <label class="col-md-12">Reason for Edit: <span class="red">*</span></label>
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

  $("#resultlc").change(function(){
    var _sample = $(this).val();
    console.log(_sample);
    if(_sample=='NTM'){
      $("#species").removeClass("hide");
    }else{
      $("#species").addClass("hide");
    }
	
	if(_sample=='Other Result'){
      $("#other_result").removeClass("hide");
    }else{
      $("#other_result").addClass("hide");
    }
  });
});
$('#extractionpopupDiv').on('show.bs.modal', function (e) {
     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });
</script>
