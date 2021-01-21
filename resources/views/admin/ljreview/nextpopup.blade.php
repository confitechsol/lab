<!-- Modal Dialog -->
<div class="modal fade" id="nextpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <div class="col-md-5 col-8 align-self-center">
                      <h4 class="text-themecolor m-b-0 m-t-0">LJ Review</h4>

                  </div>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/reviewlj') }}" method="post"  id="nxtpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="service_log_id" id="next_log_id" value="">
		  
		  <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value="">
		  <input type="hidden" name="result" id="rsltId" value="">
		  
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
                     <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                     <select name="service_id" id="service_id" class="form-control form-control-line test_reason" required>
                       <option value="">--Select--</option>
                       <option value="1">DNA Extraction LPA 1st line</option>
                       <option value="2">DNA Extraction LPA 2nd line</option>
                       <!--<option value="3">DNA Extraction LPA 1st line and LPA 2nd line</option>---->
					   <option value="4">LJ - DST Inoculation</option>
                       <!--<option value="4">LJ - DST 1st Line</option>
                       <option value="5">LJ - DST 2nd Line</option>
					   <option value="7">LJ - DST 1st & 2nd Line</option>-->
                       <!--<option value="6">Microbiologist for further review</option>-->
                       <option value="19">Result finalization</option>
                       <!-- <option value="">MB for further review </option> -->
                     </select>
                 </div>
              </div>
          </div>


          <div class="row">
              <div class="col">
                  <label class="col-md-12">Comments:</label>
                  <div class="col-md-12">
                    <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                 </div>
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
  $('#nextpopupDiv').on('show.bs.modal', function (e) {

       // Pass form reference to modal for submission on yes/ok
       var form = $(e.relatedTarget).closest('form');
       $(this).find('.modal-footer #confirm').data('form', form);
   });


});
</script>
