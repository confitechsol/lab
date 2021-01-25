<!-- Modal Dialog -->
<div class="modal fade" id="nextpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
         <div class="col-md-5 col-8 align-self-center">
                      <h4 class="text-themecolor m-b-0 m-t-0">DNA Extraction</h4>

                  </div>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/DNANext') }}" method="post"  id="nxtpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="col-md-12" id="node"></div>

          {{-- <input type="hidden" name="service_log_id" id="next_log_id" value="">
          <input type="hidden" name="enroll_id" id="next_enroll_id" value="">
          <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample">
		  
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">
		  <input type="hidden" name="status" id="statusId" value="">
		  <input type="hidden" name="tag" id="tagId" value="">
		  <input type="hidden" name="rec_flag" id="recFlagId" value=""> --}}
          {{-- <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="next_sample_id" required>
               </div>
            </div>
          </div> --}}
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Date of extraction</label>
                <div class="col-md-12">

                   <input type="text" name="date_ext" class="form-control form-control-line sampleId datepicker" value="<?php echo date("d-m-Y");?>"  max="<?php echo date("Y-m-d");?>" id="date_ext" >

               </div>
            </div>
          </div>
          <div class="row">
              <div class="col">
                  <label class="col-md-12">Sample Sent for:(<span id ="spantag"></span>)</label>
                  <div class="col-md-12">
                     <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                     <select name="service_id" id="service_id" class="form-control form-control-line test_reason" required>
                       <option value="">--Select--</option>
					    <option value="4">Send for 1st line LPA</option>
						<option value="5">Send for 2nd line LPA</option>
                        <!--<option value="6">Both 1st & 2nd line LPA</option>-->
						<option value="3">Repeat extraction same sample</option>
                        <option value="1">Decontamination with stand by sample</option>
                        <option value="2">Extraction with stand by sample</option>
                       <!-- <option value="3">Repeat extraction same sample</option> -->
                      
                      
                      
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

  $('#service_id').on('change', function (e) {
    var service = $("#service_id").val();
    var no_sample = $("#no_sample").val();
  //  alert(service);
    if((service=='2' && no_sample=='0') || (service=='1' && no_sample=='0')){
      alert("standby sample not available");
      $("#service_id").val('');
    }

   });

  $('#nextpopupDiv').on('show.bs.modal', function (e) {

       // Pass form reference to modal for submission on yes/ok
       var form = $(e.relatedTarget).closest('form');
       $(this).find('.modal-footer #confirm').data('form', form);
   });

});
</script>
