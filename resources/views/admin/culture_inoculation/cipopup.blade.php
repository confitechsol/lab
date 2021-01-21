<!-- Modal Dialog -->
<div class="modal fade" id="extractionpopupDiv" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <h4 class="modal-title">AFB Culture Inoculation</h4>
      </div>
	  <div class="alert alert-danger hide"><h4></h4></div>
      <div class="modal-body">
        <p></p>
        <form class="form-horizontal form-material" action="{{ url('/culture_inoculation') }}" method="post" id="extractionpopup">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="log_id" id="log_id" value="">
		  
		  <input type="hidden" name="enrollId" id="enrollId" value="">
		  <input type="hidden" name="tagId" id="tagId" value="">				
		  <input type="hidden" name="sampleID" id="sampleID" value="">
		  <input type="hidden" name="serviceId" id="serviceId" value="">				
		  <input type="hidden" name="rec_flag" id="recFlagId" value="">
		  
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Sample ID</label>
                   <div class="col-md-12">
                      <input type="text" name="sample_id" class="form-control form-control-line sampleId" value="" id="sample_id" required>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">MGIT  sequence ID (LC) <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" name="mgit_id" class="form-control form-control-line" value="" id="mgit_id" required>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">Date of Inoculation <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="date" name="inoculation_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line" required>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">TUBE 1 sequence ID (LJ) <span class="red">*</span></label>
                   <div class="col-md-12">
                      <input type="text" id="tube_id_lj" name="tube_id_lj" class="form-control form-control-line" value="" required>  
					  <p class="scanerr"></p>
					  
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <div class="col-md-12">
                   <label class="col-md-12">TUBE 2 sequence ID (LJ)</label>
                   <div class="col-md-12">
                      <input type="text" id="tube_id_lc" name="tube_id_lc" class="form-control form-control-line scan_barcode" value="">
                          <p class="scanerr1"></p>
                  </div>
               </div>
            </div>
          </div>
          <div class="row">
              <div class="col">
                  <label class="col-md-12">Sample Sent for:(<span id="ssentfor"></span>)</label>
                  <div class="col-md-12">
                     <select name="service_id" class="form-control form-control-line test_reason" id="service_id" required>
                       <option value="">--Select--</option>
                       <option value="1">LC</option>
                       <option value="2">LJ</option>
                       <option value="3">LC & LJ Both</option>
                       <option value="Send to BWM">Send to BWM</option>
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
        <button type="button" class="pull-right btn btn-primary btn-md" id="submit">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
$(function(){

});


$('#extractionpopupDiv').on('show.bs.modal', function (e) {

     // Pass form reference to modal for submission on yes/ok
     var form = $(e.relatedTarget).closest('form');
     $(this).find('.modal-footer #confirm').data('form', form);
 });

</script>

<script>
// $(".scan_barcode").live("keyup",function(){
//
//     var scanval=$(this).attr('id');
//     alert(scanval);
//
// });

//
// function generate(val){
//
//   console.log(val)
// }

$(document).ready(function(){
  // $("#sampleId").setAttribute("readonly");
  //   $("#enroll_label").setAttribute("readonly");
$("#tube_id_lj").change(function(){

  var scanval= $(this).val();
  var err=0;
if(scanval.length < 6 || scanval.length > 6){
  err++;
  $(".scanerr").html("Please scan a valid code");
  // alert("Please enter a valid code");
  $("#tube_id_lj").val(null);

}

  if(isNaN(scanval) !== false ){
    err++;
    $(".scanerr").html("Alphabets are not allowed.Please enter a valid digit");
    //  alert("Alphabets are not allowed.Please enter a valid digit");
      $("#tube_id_lj").val(null);

  }

  if(scanval == '' || scanval == null ){
  err++;
      $(".scanerr").html("It cannot be empty");
  //alert("It cannot be empty");

  }

if(/^[a-z0-9_]+$/i.test(scanval) == false){

  err++;
    $(".scanerr").html("No spaces are allowed");
  //alert("No spaces are allowed");
  $("#tube_id_lj").val(null);
}

  if(err == 0){

  $.ajax({
    url:"{{ url('/getsample')}}",
    type:"POST",
    data:{
      "_token":"{{ csrf_token() }}",
      "scanval":scanval},
    success:function(response){


      if(response == "false"){
        alert("No Barcode Matches Found In The Database. Please Enter a valid Code !")
        $("#tube_id_lj").val(null);
      }else{
        // fstr= str.toUpperCase();
        var str = response;

         
		  fstr = str.slice(0, -1);
			lstr=str.slice(-1);
		   $("#tube_id_lj").val(str);


      }

    }

  });

  }


});
});
</script>


<script>
// $(".scan_barcode").live("keyup",function(){
//
//     var scanval=$(this).attr('id');
//     alert(scanval);
//
// });

//
// function generate(val){
//
//   console.log(val)
// }

$(document).ready(function(){
  // $("#sampleId").setAttribute("readonly");
  //   $("#enroll_label").setAttribute("readonly");
$("#tube_id_lc").change(function(){

  var scanval= $(this).val();
  var err=0;
if(scanval.length < 6 || scanval.length > 6){
  err++;
  $(".scanerr1").html("Please scan a valid code");
  // alert("Please enter a valid code");
  $("#tube_id_lc").val(null);

}

  if(isNaN(scanval) !== false ){
    err++;
    $(".scanerr").html("Alphabets are not allowed.Please enter a valid digit");
    //  alert("Alphabets are not allowed.Please enter a valid digit");
      $("#tube_id_lc").val(null);

  }

  if(scanval == '' || scanval == null ){
  err++;
      $(".scanerr1").html("It cannot be empty");
  //alert("It cannot be empty");

  }

if(/^[a-z0-9_]+$/i.test(scanval) == false){

  err++;
    $(".scanerr1").html("No spaces are allowed");
  //alert("No spaces are allowed");
  $("#tube_id_lc").val(null);
}

  if(err == 0){

  $.ajax({
    url:"{{ url('/getsample')}}",
    type:"POST",
    data:{
      "_token":"{{ csrf_token() }}",
      "scanval":scanval},
    success:function(response){


      if(response == "false"){
        alert("No Barcode Matches Found In The Database. Please Enter a valid Code !")
        $("#tube_id_lc").val(null);
      }else{
        // fstr= str.toUpperCase();
        var str = response;
          $("#tube_id_lc").val(str);

      }

    }

  });

  }


});
});
</script>
