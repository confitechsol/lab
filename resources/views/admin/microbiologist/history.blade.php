@extends('admin.layout.app')

@section('content')
<style>
.activa{
  background-color:#FFDFBF!important;
  color:#1E88E5;
  font-weight: bold;
  font-family: serif;
}
.history-activa{
  background-color:#FFDFBF!important;
  color:#1E88E5;
  font-weight: bold;
  font-family: serif;
}
input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">History</h3>

                  </div>
                  <!--<div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/microbiologist/print') }}" method="post" >                    
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>---->

              </div>
              @if($errors->any())
              <div class="modal fade" id="open_message" role="dialog" >
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button id="close_err" type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Alert</h4>
                      </div>

                        <div class="modal-body">
                          <div class="alert alert-danger"><p id="show"></p></div>
                        </div>  

                    </div>
                   </div>
              </div>
              <script type="text/javascript">
                var show_err='{{$errors->first()}}';
                $('#show').text(show_err);
                $('#open_message').modal('show');
                $('#close_err').click(function(){
                  $('#open_message').modal('hide');
                  location.reload();

                });

                $('#open_message').modal({
                backdrop: 'static',
                keyboard: false
            })
              </script>      
              @endif
              @include('admin/status_popup/current_status_modal')
              @include('admin/resultpopup/cbnaat_editResult')
              @include('admin/resultpopup/editresults')
              @include('admin/resultpopup/microscopy_editResult')
              @include('admin/resultpopup/lc_editResult')
              @include('admin/resultpopup/lj_editResult')
              @include('admin/resultpopup/lc_dst_editResult')
              @include('admin/resultpopup/ljdst1_editResult')
              @include('admin/resultpopup/ljdst2_editResult')
              
                <div class="card">
					<div class="card-block p-2">
					 <form id="historysampleform" action="{{ url('/history') }}" method="get"> 
						<div class="form-group row col-sm-12">
                             <div class="form-group row col-sm-4">
							    <label class="col-sm-6">Search by <span style="color:red;">*</span></label>
								 <div class="col-sm-6"> 
									<select class="form-control" name="srch_by" id="srch_by" required>
											<option value="">-- Please Select --</option>
											<option value="1" <?php echo (!empty($_REQUEST['srch_by'])&&($_REQUEST['srch_by']==1))?'selected':'';  ?>>Patient Name</option> 
											<option value="2" <?php echo (!empty($_REQUEST['srch_by'])&&($_REQUEST['srch_by']==2))?'selected':'';  ?>>Patient District</option>
                                            <option value="3" <?php echo (!empty($_REQUEST['srch_by'])&&($_REQUEST['srch_by']==3))?'selected':'';  ?>>Patient Mobile No.</option>
                                            <option value="4" <?php echo (!empty($_REQUEST['srch_by'])&&($_REQUEST['srch_by']==4))?'selected':'';  ?>>Patient Nikshay ID.</option> 
											
                                            <option value="6" <?php echo (!empty($_REQUEST['srch_by'])&&($_REQUEST['srch_by']==6))?'selected':'';  ?>>Enrolment No.</option>											
									</select>
											   
								  </div>
						     </div>						
							 
							 <div class="form-group col-sm-6">
							   <input type="text" name="srch" id="srch_id" class="form-control "   value="<?php  if(!empty($_REQUEST['srch'])){ echo $_REQUEST['srch']; } ?>" required>
							 </div>	
							 
							 
                             <div class="form-group col-sm-2">
							   <button class="btn btn-info btn-sm">Search</button>
							 </div>	                            					 
						</div>
					</form>				
							
					</div>
	            </div>


                <div class="row" >
                   
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="scroll-table scroll-table-micro" >
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Enrollment ID</th>                                             
											  <th>Nikshay ID</th>
                                              <th>Patient Name </th>
											  <th>Mobile Number</th>
											  <th>District</th>
											  <th>Referal Facility</th>
                                             

                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php //dd($data['done']); die; ?>
                                          @if($data['done'])
                                            @foreach ($data['done'] as $key=> $samples)
                                            <?php  //dd($samples); ?>
											
                                                  <tr id="<?php echo $key; ?>" class="sel2">
                                                    <td class="hide" >{{$samples->sample_id}}</td>
                                                    <td <?php if(($samples->sample_id)==""){?>colspan="2" align="center"<?php } ?>><?php if(($samples->sample_id)==""){?>No Records Found <?php }else{ echo $samples->enroll_label; } ?></td>
                                                    <td>{{$samples->nikshay_id}}</td>
                                                    <td>{{$samples->patient_name}}</td>
													<td>{{$samples->mobile_number}}</td>
													<td>{{$samples->district}}</td>
													<td>{{$samples->referal_facility}}</td>
                                                   
                                                    <td>
													   <?php if(($samples->sample_id)!=""){?>
													    <a target="_blank" href="{{url('pdfview/'.$samples->sample_id)}}?d=1" class="btn btn btn-sm result-with-remarks">Result</a>
                                                       <?php } ?>
													</td>
                                                  <!--<td><a class="detail_modal" style="color:#1E88E5; cursor:pointer; font-size:12px;" onclick="getdetailsform(<?php //echo $id=$samples->sample_id; ?>,<?php //echo $enrolls_id=$samples->enroll_label; ?>,'<?php //echo $sample_label=$samples->sample_label; ?>')">Show Status</a></td>--->
                                                   
                                                </tr>
                                          
                                          @endforeach
                                        @endif
                                      </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
        </div>

<script>





$( document ).ready(function(){
	
    $(document).ready(function(){
        clear_submit_inputs();
    });

    function clear_submit_inputs(){
        $('#nextStep,#sentstep,#detail,#remark')
            .val('');

        $('.group-sample-sent-to,.group-sample-detail,.group-sample-remark,.group-sample-form15a')
            .hide();

        $('#print15A').prop('checked', false);

        validate_fields();
    }





    function validate_fields(){

        var enable = false;
        var next_step = $('#nextStep').val();

        if( next_step === 'Send Sample' ){
            var val = $('#sentstep').val();
            if(val !== '' && val.length >= 1){
                enable = true;
                for( var i in val ){
                    if( !val.hasOwnProperty(i) ) continue;
                    if( val[i] === '' ){
                        enable = false;
                        break;
                    }
                }
            }

        } else if( next_step === 'Print Form-15A' ){
           

            // incorporated by niladri 


	// if( $('#detail').val() === '' && $('#remark').val() === '' ){
 //            enable = false;
	// 		 } else {
	 			enable = false;
	// 		  }
			
        } else if( next_step === 'Request for Retest' ){
			 enable = true;
        } 

      /*  if( $('#detail').val() === '' || $('#remark').val() === '' ){
            enable = false;
        }
		*/

        $('#confirmok').prop('disabled', !enable);
    }









    $('#sentstep,#detail,#remark').change( validate_fields );

   

});






$(function(){

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
  });

  /* Form confirm (yes/ok) handler, submits form*/
  $('#confirm1').click( function(){

    var form = $(document).find('form#cbnaat_result1');
      form.submit();
    // console.log( $('#cbnaat_result').serialize() );
    // var data = $('#cbnaat_result').serialize();
    // $.post(window.location.replace("{{ url('/PCR') }}"), data);
    //form.submit();
  });


});

 function deactivate_inputs(selectors, $parent){
     $parent = (typeof $parent === 'undefined') ? $parent = $('body') : $parent;
     for( var i in selectors ){
         if( !selectors.hasOwnProperty(i) ) continue;
         $parent.find( selectors[i] )
             .prop('disabled', true)
             .val('');
     }

 }

 function activate_inputs(selectors, $parent){
     $parent = (typeof $parent === 'undefined') ? $parent = $('body') : $parent;
     for( var i in selectors ){
         if( !selectors.hasOwnProperty(i) ) continue;
         $parent.find( selectors[i] )
             .prop('disabled', false);
     }

 }

</script>

<script>

    $(document).ready(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = dd + '-' + mm + '-' + yyyy;
        $('#exampl').DataTable({
            dom: 'Bfrtip',
			sDom: 'lrtip',
			pageLength:25,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'LIMS_microbilogist_history_' + today + '',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8]
                    }

                }
            ],
            "order": [[1, "desc"]]
        });
    });

</script>



<script>

function getdetailsform(id,enrolls_id,sample_label){
$("#det_modal > tbody").empty();
var sample_id=id;
var enroll_id=enrolls_id;
var label=sample_label;
// alert(label);
// alert(sample_label)
    $.ajax({

      url:"{{ url('/searchform/get_current_status') }}",
      method:"POST",
      data:{"sample_id":sample_id,'enroll_id':enroll_id,"label":label,"_token":"{{ csrf_token() }}"},
      dataType:"JSON",
      success:function(response){
        console.log(response);
        $.each(response, function (key, val) {

// $(".display_status_material").append("<div><span>Type of Test :</span><br/><span>Reported On :</span><br/><span>Released On :</span><br/><span>Current Status :</span><br/><br/></div>");
var type_test=val.service_name;
var tag=val.tag;
if(tag!= ''){

  type_test=type_test+" - "+tag;

}
var status=val.status;
var rptnewDate;
var rlsnewDate;
var reported_date=val.reported_dt;
var released_date=val.released_dt;

// if(reported_date == '' || reported_date == null){
// rptnewDate='';
//
// }else{
//   var rptdateAr = reported_date.split('-');
//   var rptnewDate = rptdateAr[1] + '-' + rptdateAr[2] + '-' + rptdateAr[0];
// }


// if(released_date == '' || released_date == null){
//
// rlsnewDate='';
// }else{
//   var rlsdateAr = released_date.split('-');
//  rlsnewDate = rlsdateAr[1] + '-' + rlsdateAr[2] + '-' + rlsdateAr[0];
// }







// alert(rptnewDate);

var teststatus='';
if(status == 0){

  teststatus="Done";

}else{
  teststatus="In Progress";
}

$("#sample_name").text(val.sample_label);

$("#det_modal > tbody").append("<tr><td>"+type_test+"</td><td>"+reported_date+"</td><td >"+released_date+"</td><td>"+teststatus+"</td><td>"+val.tested_by+"</td><td>"+val.comments+"</td></tr>");

});

$("#progressdetailpopup").modal('toggle');

}

    });




}

</script>

<script>
$(".sel").click(function(){
$("tr").removeClass("activa");
$(this).addClass("activa");
});
</script>


<script>

$(".sel2").click(function(){
  $("tr").removeClass("history-activa");
   $(this).addClass("history-activa");

});


    $('.result-with-remarks').click(function(e){
        e.preventDefault();
        var $btn = $(this);
        var url = $btn.attr('href');
        var remarks = $.trim( prompt('Provide Remarks') );
        if( !remarks.length ) return;
        window.open( url + '&remarks=' + encodeURIComponent(remarks) );
    });

  </script>

         


<script type="text/javascript">
 
  //textarea comment on change 
   $(document).on('change keyup paste', '#microbio_comments', function() {
		//alert("Onchange event" ); 
		 $('#confirmokrt').prop('disabled', false);
		 $('#confirmokrt').prop("disabled", !$('input[name="updated_drugs[]"]').is(":checked")?true:false);//if not checked
	});		  
	


  </script>


@endsection
