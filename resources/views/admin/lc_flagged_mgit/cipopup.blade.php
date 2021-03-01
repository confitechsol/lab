<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC Fagged MGIT Tube</h4>
      </div>
	   <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/lc_flagged_mgit') }}" method="post" id="extractionpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div id="mff_result">
            <label class="col-md-12">Result : </label>
            <input type="text" style="margin-left: 15px;   width: 93%;" name="result" class="form-control form-control-line sampleId" value="Negative" id="result" readonly>
            <!-- <input type="text" name="result" id="result" readonly value="Negative" /> -->
            <label class="col-md-12">ICT, Culture Microscopy & BHI : </label>
            <input type="text" style="margin-left: 15px;    width: 93%;" name="report_result" class="form-control form-control-line sampleId" value="Not required" id="report_result" readonly>
            <!-- <input type="text" name="report_result" readonly id="report_result" value="Not required" /> -->
          </div>
          <div class="col-md-12 my_con">
            <input type="radio" name="test_type" id="test_type_1" class="set_radio" value="1" >&nbsp;LC Reporting
            <br>
            <input type="radio" name="test_type" id="test_type_2" class="set_radio" value="2" >&nbsp;Microbiologist
            </div>
            


          <div class="col-md-12" id="node"></div>

        {{-- <input type="hidden" name="log_id" id="log_id" value="">		  
		   <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value=""> --}}
          {{-- <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Sample ID : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="sample_id" required>
                  </div>
               </div>
            </div>
          </div> --}}
          <div class="row hide">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">GU : </label>
                   <div class="col-md-12">
                      <input type="text" name="gu" class="form-control form-control-line" value="" id="gu">
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col" style="padding: 0px;" >
                <div class="col-md-12">
                   <label class="col-md-12">Date of flagging  by MGIT : <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="date" id="flagging_date" name="flagging_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line" required>
                  </div>
               </div>
            </div>
          </div>



          <div class="row">
            <div class="col" style="padding: 0px;">
                <div class="col-md-12">
                   <label class="col-md-12">Comments:</label>
                   <div class="col-md-12">
                <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                  </div>
               </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="submit">Ok</button>
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

</script>
