<!-- Modal Dialog -->
<div class="modal fade" id="lc_dst_editResult" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC DST Result</h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/lc_dst_inoculation') }}" method="post" enctype='multipart/form-data' id="resultpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="enrollId" id="enrollIdlcdst" value="">
          <input type="hidden" name="editresult" id="editresult" value="edit">
          <input type="hidden" name="service_log_id" id="next_log_id" value="">
          <input type="hidden" name="lc_dst_tr_id" id="lc_dst_tr_id" value="">
          <input type="hidden" name="service" id="service" value="21">
          <input type="hidden" name="type" id="type" value="">
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line" value="" id="sampleidlcdst" >
               </div>
            </div>
          </div>


          <div class="row hide">
            <div class="col">
               <label class="col-md-12">Date of Result</label>
               <div class="col-md-12">
                 <input type="text" placeholder="dd-mm-yy" name="result_date"  class="form-control datepicker">

              </div>
            </div>
          </div>



          <div class="row" id="drug_names">

          </div>
          <div class="row">

            <div class="col">
            <label class="col-md-12">Reason for Edit</label>
               <div class="col-md-12">
                   <input type="text" name="reason_edit" class="form-control form-control-line"  id="reason_edit" >
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
$('#resultpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });

</script>
