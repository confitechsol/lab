<!-- Modal Dialog -->
<div class="modal fade" id="sc" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">LC Reporting</h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/further_lc_flagged_mgit/smearculture') }}" method="post" id="scform">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="log_id" class="log_id" id="log_id" value="">
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Sample ID: <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="sample_id" class="form-control form-control-line sampleId sample_id" value="" class="log_id" id="sample_id" required>
                  </div>
               </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Smear from culture : <span class="red">*</span></label>
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




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="submit" class="pull-right btn btn-primary btn-md" id="submit">Ok</button>
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
