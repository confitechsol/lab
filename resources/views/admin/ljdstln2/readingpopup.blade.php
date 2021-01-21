<!-- Modal Dialog -->
<div class="modal fade" id="readingpopupDiv2" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Week<span id="lblweek"></span></h4>
      </div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" id="readingForm">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="sample_id" id="sample_id" value="">
          <input type="hidden" name="enroll_id" id="enroll_id" value="">
          <input type="hidden" name="service_log_id" id="service_log_id" value="">
          <input type="hidden" name="week_no" id="week_no" value="">


          <fieldset>
            <legend><label class="col-md-12">10<sup>-2</sup> Dilution Neat :</label></legend>
            <div class="row">
                <div class="col-md-6">
                   <label class="col-md-12">Drug Media 1</label>
                   <div class="col-md-12">
                      <input name="dil_2_drug_media_1" id="dil_2_drug_media_1" class="form-control form-control-line " required>
                  </div>
               </div>
               <div class="col-md-6">
                  <label class="col-md-12">Drug Media 2</label>
                  <div class="col-md-12">
                     <input name="dil_2_drug_media_2" id="dil_2_drug_media_2" class="form-control form-control-line " required>
                 </div>
              </div>
            </div>

            <div class="row" id="drug_names">

            </div>

         </fieldset>

         <fieldset>
           <legend><label class="col-md-12">10<sup>-4</sup> Dilution Neat :</label></legend>

           <div class="row" id="drug_names_result">

           </div>

        </fieldset>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Cancel</button>
        <button type="submit" class="pull-right btn btn-primary btn-md" onclick="saveReading()">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
function saveReading(){

  var dl_2 = [],dl_4 =[];
  var dl_2_repeat = [],dl_4_repeat =[];

  $(".dil_2").each(function( index ) {
    var element = {
      name: $(this).find('[name="dil_2_drugName[]"]').val(),
      value:$(this).find('[name="dil_2_drugVal[]"]').val()
    };
    dl_2.push(element);
  });

  dl_2_repeat = $('input[name=repeat]:checked').map(function(){
      return  this.value;
  }).get();

  console.log(dl_2_repeat);

  $(".dil_4").each(function( index ) {
    var element = {
      name: $(this).find('[name="dil_4_drugName[]"]').val(),
      value:$(this).find('[name="dil_4_drugVal[]"]').val()
    };
    dl_4.push(element);
  });
  dl_4_repeat = $('input[name=repeat]:checked').map(function(){
      return  this.value;
  }).get();
  
   var dil_2_drugVal_flag=true;
  $('.dil_2_drugVal').each(function(){
  if($(this).val()==""){
    dil_2_drugVal_flag=false;
  }
});
  var dil_4_drugVal_flag=true;
  $('.dil_4_drugVal').each(function(){
  if($(this).val()==""){
    dil_4_drugVal_flag=false;
  }
});

  if($("#dil_2_drug_media_1").val()!="" && $("#dil_2_drug_media_2").val()!="" && dil_2_drugVal_flag && dil_4_drugVal_flag){
    $.ajax({
      type: "POST",
      url: "{{url('lj_dst_ln2/reading')}}",
      data: {
        _token:"{{ csrf_token() }}",
        sample_id: $("#sample_id").val(),
        enroll_id: $("#enroll_id").val(),
        service_log_id: $("#service_log_id").val(),
        week_no: $("#week_no").val(),
        drug_media_1: $("#dil_2_drug_media_1").val(),
        drug_media_2: $("#dil_2_drug_media_2").val(),
        allData: {
          dil_2: dl_2,
          dil_4: dl_4,
        },
        allData_repeat: {
          dl_2_repeat: dl_2_repeat,

        },

      },
      success: function(data){
        //console.log(data);
        if(data == true){
          window.location.reload(true);
        }
      },
      dataType: "json"
    });
  }

}

</script>
