<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/DNAextraction') }}" method="post" id="extractionpopup" novalidate>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="log_id" id="log_id" value="">
          <div class="row">
            <div class="col ">
                <div class="col-md-12">
                   <h4>You want to continue with Sample ID <span id="sample"></span> ?</h4>
               </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" id="extract">Ok</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#extractionpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });
 $('#extract').click(function(e){
   $(this).attr("disabled", true);
   var form = $(document).find('form#extractionpopup');
   console.log( form );
     form.submit();
 });
</script>
