<!-- Modal Dialog -->
<div class="modal fade" id="ljdst1_editResult" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LJ DST Result</h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" method="post" enctype='multipart/form-data' id="resultpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="enrollId" id="enrollIdljdst1" value="">
          <input type="hidden" name="editresult" id="editresultljdst1" value="edit">
          <input type="hidden" name="service_log_id" id="next_log_id" value="">
          <input type="hidden" name="lc_dst_tr_id" id="lc_dst_tr_id" value="">
          <input type="hidden" name="type" id="type" value="">
          <div class="row">
            <div class="col ">
                <label class="col-md-12">Sample ID</label>
                <div class="col-md-12">
                   <input type="text" name="sample_id" class="form-control form-control-line" value="" id="sampleidljdst1" >
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


          <div class="row" id="drug_names_ljdst">

          </div>
          <div class="row">

            <div class="col">
            <label class="col-md-12">Reason for Edit: <span class="red">*</span></label>
               <div class="col-md-12">
                   <input type="text" name="reason_edit" class="form-control form-control-line"  id="reason_editljdst1" required >
               </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="button" class="pull-right btn btn-primary btn-md" onclick="saveReadingljdst1()">Ok</button>
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

 function saveReadingljdst1(){
   var drug_names_ljdst=[];
   $(".drug_names_ljdst").each(function( index ) {
     var element = {
       name: $(this).find('[name="drugname[]"]').val(),
       value:$(this).find('[name="drugvalue[]"]').val()
     };
     drug_names_ljdst.push(element);

   });

   $.ajax({
     type: "POST",
     url: "{{url('lj_dst_ln1/readingReview')}}",
     data: {
       _token:"{{ csrf_token() }}",
       sample_id: $("#sampleidljdst1").val(),
       enroll_id: $("#enroll_idljdst1").val(),
       editresult: $("#editresultljdst1").val(),
       reason_edit: $("#reason_editljdst1").val(),
       service: 22,
       allData: {
         dil_4: drug_names_ljdst,
       },
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

</script>
