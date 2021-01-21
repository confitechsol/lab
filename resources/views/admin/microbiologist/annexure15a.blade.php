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
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.hide_column {
    display : none;
}
@keyframes spinner {
  to {transform: rotate(360deg);}
}
 
.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 2px solid #ccc;
  border-top-color: #333;
  animation: spinner .6s linear infinite;
}
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Annexure 15A</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/microbiologist/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

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

                <div class="row">
                    
					<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 " >
					<!-- Pradip -->
					<div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="scroll-table scroll-table-micro" >

                                    <table id="example1" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th >Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Patient Name </th>
											  <th>Test Requested</th>
											  <th>Reason for Test</th>
											  <th>Test To  Review</th>
											  <!--/ Draft Result</th>-->
                                              <!--<th>Interim</th>-->
											  <th>Generate Form-15A</th>
											  <th>Referal Facility</th>
                                              <th>Sample type /No. of Samples</th>
											  <th>Date of Receipt</th>
											  <th>Current Status</th>
											  <!--<th>Choose Drugs</th>
                                              <th>Next Step</th>--->
											  
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr class="sel">
                                                    <td class="hide"></td>
                                                    <td></td>
                                                    <td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
                                                   
                                                </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
					
					
					</div>
                   

                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>


      



 

 
 <div class="modal fade micro_log" id="myModalForm15A" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Microbiologist</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result15A">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId1" id="enrollId15A" value="">
                <input type="hidden" name="sample" id="sampleID15A" value="">
                <input type="hidden" class="service1_class" name="service1" id="service15A" value="">
                <input type="hidden" name="bwm_status" id="bwm_status15A" value="0">
				<input type="hidden" name="lpa_tag" id="tag15A" value="">
                <input type="hidden" name="no_sample" class="form-control form-control-line" value="0" id="no_sample15A">
                <input type="hidden" name="nextStep" class="form-control form-control-line" value="Print Form-15A" id="nextStep15A">


                
				<label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <input type="text" readonly class="form-control form-control-line sampleId" name="sampleid1" id="sampleid15A">
                   </div>
                <br>
                <!--<label class="col-md-12 group-sample-detail"><h5>Detail:</h5></label>
                <div class="col-md-12 group-sample-detail">
                   <input type="text" class="form-control form-control-line sampleId" name="detail" id="detail15A">
               </div>
                <br>---->
				<div style="display:none;">
                <label class="col-md-12"><h5>Remark:</h5></label>
                <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="remark" id="remark15A" maxlength="250">
               </div>
			   </div>
                <br>
                  
                <div class="">
				 <input type="checkbox"  name="print15A" id="print15A15A" value="true" style="visibility:hidden;position:absolute " checked="checked">
               <!---<div id="microscopy_review_logic">
                        <label class="col-md-12"><h5>Print 15A form : </h5></label>
                        <div class="col-md-12">
                            <input type="checkbox" onclick="test(this);"  name="print15A" id="print15A">
                        </div>
                    </div>---->

                    <div id="microscopy_review_logic_disabled15A">
                        <div class="col-md-12">
                            <h5 class="text-danger small samplecontext">Sample has no enrolment. Please enroll to print Form 15A</h5>
                        </div>
                    </div>

                </div>

               

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok15A" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<script>
function resetfunction() {
            document.getElementById("cbnaat_resultrt").reset();
        }
// incorporated by niladri

function test(e){
  var next_step = $('#nextStep').val();
  var enable;
if($("#print15A").is(':checked')){
 // console.log($("#print15A").is(':checked'))
enable = true;
}else{
  enable = false;
}


if( next_step === 'Print Form-15A' ){
if(enable == true){
  $("#confirmok").prop('disabled',false);
}else if(enable == false){

 $("#confirmok").prop('disabled',true);
}

}
}




$( document ).ready(function(){

$("#myModal")
    .on("show.bs.modal", function(){
      clear_submit_inputs();
    });

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

    $('#nextStep').change(function(){
        
        var next_step = $('#nextStep').val();

        $('#sentstep,#detail,#remark').val('');
        $('.group-sample-sent-to,.group-sample-detail,.group-sample-remark,.group-sample-form15a').hide();

        if( next_step === 'Send Sample' ){
            $('.group-sample-sent-to').show();
            $('.group-sample-detail,.group-sample-remark').show();

        }else if( next_step === 'Print Form-15A' ){
           $('.group-sample-form15a').show();
            $('.group-sample-detail,.group-sample-remark').show();

        }else if( next_step === 'Request for Retest' ){
          //  $('.group-sample-form15a').show();
            $('.group-sample-detail,.group-sample-remark').show();
        }

        validate_fields();
    });

});






$(function(){
	
	

  $('#nextStep').on('change', function (e) {
    var service = $("#nextStep").val();
    var no_sample = $("#no_sample").val();
    var service1 = $("#service1").val();

    if(service=='Request for Retest' && no_sample=='0' && service1=='26'){
      alert("standby sample not available");
      $("#nextStep").val('').trigger('change');
    }
   });

  // $('#example1').DataTable( {
  //      "order": [[ 0, "desc" ]],
  //      dom: 'Bfrtip',
  //       buttons: [
  //          // 'excel', 'pdf',
  //          'excel'
  //       ]
  //  } );




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


  
  // $('#confirm').click( function(){
  //   alert('sgds');
  //   var form = $(document).find('form#cbnaat_result');
  //     form.submit();
  //
  // });
});
   
function openForm15AGenerate(enroll_id, sample_ids, service, sample, bwm_status, no, reg_by,tag){
  //console.log(enroll_id, sample_ids, service);
  //console.log(sample_ids);
  //alert(reg_by);
  $("#enrollId15A").val(enroll_id);
  $("#service15A").val(service);
  $("#bwm_status15A").val(bwm_status);
  $("#sampleID15A").val(sample_ids);
  $("#sampleid15A").val(sample);//set input value
  $('#no_sample15A').val(no);
  $('#tag15A').val(tag);
  $('#print15A15A').prop('checked', true);




  if( reg_by ){
      //$('#microscopy_review_logic').show();
      $('#microscopy_review_logic_disabled15A').hide();
      $('#confirmok15A').prop('disabled',false);
  }else{  
      //$('#microscopy_review_logic').hide();
      $('#microscopy_review_logic_disabled15A').show();
      $('#confirmok15A').prop('disabled',true);
  }



  $('#myModalForm15A').modal('toggle');
  

  $("#confirmok15A").click(function(){
	  //alert($('input[name=print15A]:checked').length);
	   if($('input[name=print15A]:checked').length > 0){
        var sample = $("#sampleID15A").val();        
        //var detail = $("#detail2").val();
        var remark = $("#remark15A").val();
        var form = $(document).find('form#cbnaat_result15A');
        form.submit();
        var url = '{{ url("/pdfview", "id") }}';
        // url = url.replace('id', sample+'/1');
        url = url.replace('id',sample);
       // url = url.replace('detail', detail);
       // url = url.replace('remark', remark);
        // url = url.replace('type', '1');
         window.open(url, '_blank');
	   }
    
       var form = $(document).find('form#cbnaat_result15A');
       form.submit(); 
   });

  
 }
 
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
// function displayform15(service){
//     // alert(service)
//
//     if(service == 1 || service == 2){
//
//     $("#microscopy_review_logic").hide();
//     }else{
//     $("#microscopy_review_logic").show();
//     }
//
// }


</script>
<script>

$(document).ready(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd = '0'+dd
  }

  if(mm<10) {
      mm = '0'+mm
  }

  today = dd + '-' + mm + '-' + yyyy;
    $('#example1').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
		processing: true,
		language: {
            loadingRecords: '&nbsp;',
            //processing: 'Loading...'
            processing: '<div class="spinner"></div>'
        } , 
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
	   ajax: {
			    url: "{{url('ajax_annexure15A_list')}}",			  
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
		 columns: [
		   { data: 'ID',className: "hide_column"},
		   { data: 'enroll_id'},
		   { data: 'sample_id'},
		   { data: 'patient_name' },
		   { data: 'test_requested' },
		   { data: 'reason_for_test' },
		   { data: 'test_review' },
		   { data: 'generate15a' },		  
		   { data: 'referal_facility' },
		   { data: 'sample_type' },
		   { data: 'date_of_receipt' },
		   { data: 'current_status' },
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_microbilogist_current_'+today+'',
                 exportOptions: {
                    columns: [  1, 2, 3,4,5,6,7]
                }
            }
        ],
        order: [[ 1, 'desc' ]],
		columnDefs: [
			  { targets: [1,2,3,4,5,6,7,8,9,10,11], orderable: false }
		  ]
    });
} );
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

         


               

@endsection
