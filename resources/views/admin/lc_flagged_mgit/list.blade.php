@extends('admin.layout.app')
@section('content')
<style>
  .setradio{
      position: static !important;
      left: 0 !important;
      opacity: 1 !important;
  
  }
  .set_radio{
      position: static !important;
      left: 0 !important;
      opacity: 1 !important;
  
  }
  </style>
<style>
#pageloader
{
	top: 0;
    bottom: 0;
    left: 0;
    right: 0;
	position: fixed;
    height:100%;
	width:100%;
	background:rgba(0, 0, 0, 0.2);
	opacity:.7;
	z-index:9999;
	display:none;
}
#pageloader .loader
{
  left: 50%;
  margin-left: -32px;
  margin-top: -32px;
  position: absolute;
  top: 50%;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
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
                      <h3 class="text-themecolor m-b-0 m-t-0">LC Flagged MGIT Tube</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lcflag/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/lc_flagged_mgit/cipopup')
                <div class="row">
                <!--loader-->
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!--loader-->
				    <!---<div class="alert alert-danger hide"><h4></h4></div>-->
				<!----------loader------------>
            <!---<div class="alert alert-danger hide"><h4></h4></div>----->
            
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">                              
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">
                                  <div class="col-md-12 my_con" style="padding: 0px;">
                                    <input type="radio" name="sector_radio" class="setradio" value="1" checked="" required="">&nbsp;>= 42 days
                                    <!-- <br> -->
                                    <input type="radio" name="sector_radio" class="setradio" value="2" required="" style="margin-left: 20px;">&nbsp;< 42 days
                                    <div id="no_sample"></div>  
                                  </div>                                    
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>                                         
                                          <th class="hide">ID</th>
                                          <th><input type="checkbox" id="bulk-select-all"></th>
                                          <th>Sample ID</th>
                                          <th>MGIT Tube sequence ID</th>
                                          <th>Date of Inoculation</th>
                                          <th>Results</th>
                                          <th>Initial Smear  result</th>
										                      <th>Test Requested</th>
                                          <th>Reason for test (DX/FU)</th>
                                          <th>Follow up month</th>
                                          <th>No. of days <br>left after Inoculation</th>
                                          <th>Date of flagging  by MGIT</th>                                  
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

<script>
$(document).ready(function(){	
  $("#extractionpopupDiv").on("submit", function(){
    $("#pageloader").fadeIn();
	var zIndex = 9999;

    if ($('body').hasClass('modal-open')) {
        zIndex = parseInt($('div.modal').css('z-index')) + 1;
    }

    $("#pageloader").css({
        'display': 'block',
        'z-index': zIndex
    });

    setTimeout(function(){$("#pageloader").css("display", "none");}, 5000);
  });//submit

  $('.setradio').on('click', function() {
      var id = ($(this).val());
      arrangeTable(id);
  });
});//document ready

function arrangeTable(rd_val)
{
  //alert(rd_val);
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

  var url = '{{ route("ajax_lc_flagged_mgit_list", ":id") }}';
    url = url.replace(':id', rd_val );
      
	//Ajax call 

 
	$('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
    bDestroy: true,
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
			    url: url,			  
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
      drawCallback: function (settings) { 
        // Here the response
        var response = settings.json;
        //console.log(response);
        $('#no_sample').html('No. of Sample(s): '+response.rc_count);
    },
		 columns: [
       { data: 'ID',className: "hide_column"},
       { data: 'inputs'},
		   { data: 'sample_id'},		   
		   { data: 'mgit_tube_seq_id'},		   
		   { data: 'date_of_inocculation'},
       { data: 'submit_btn' },	
		   { data: 'sample_result'},		   
		   { data: 'test_requested' },		   
		   { data: 'reason_for_test' },		   
		   { data: 'follow_up_month' },		   
		   { data: 'no_of_days' },
		   { data: 'flagging_date'},		   
		   		   
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_lc_flagged_mgit_'+today+'',
                 exportOptions: {
                    /*columns: [  1, 2, 3,4,5,6,7]*/
					columns: "thead th:not(.noExport)"
                }
            },
            {
              text: 'Submit',            
                action: bulk_action_review
            }
        ],
        order: [[ 1, 'desc' ]],
		columnDefs: [
			  { targets: [1,2,3,4,5,6,7,8,9,10], orderable: false }
		  ]
    });
}

var $bulk_checkboxes = $('.bulk-selected');
        var $bulk_select_all_checkbox = $('#bulk-select-all');


        // Automatically Check or Uncheck "all select" checkbox
        // based on the state of checkboxes in the list.
        $bulk_checkboxes.click(function(){
            if( $bulk_checkboxes.length === $bulk_checkboxes.filter(':checked').length ){
                $bulk_select_all_checkbox.prop('checked', true);
            }
        });


        // Check or Uncheck checkboxes based on the state
        // of "all select" checkbox.
        $bulk_select_all_checkbox.click(function(){
            var checked = $(this).prop('checked');
            $('.bulk-selected').prop('checked', checked);
        });

function openForm(sample_id, lpa_type){
  /* $('#sample_id').val(sample_label);
  $('#log_id').val(log_id);
  $('#gu').val(gu);
  $('#flagging_date').val(flagging_date);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag); */
  
  //$('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }

  $('#sampleID_'+sample_id).prop('checked', true);
  showButtonWisePopup(2);
}
function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}
</script>

<script>

$(document).ready(function() {

  var radio_val = $('input[name="sector_radio"]:checked').val();  

  arrangeTable(radio_val);  
	
	//Confirm ok submit
	$('.resultbtn, #submit').click( function(e) {
		//alert("here");

    $('.alert-danger').addClass('hide');
		$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
		$('#submit').prop("type", "submit");

		/* var enroll_id=$("#enrollId").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		var tag=$("#tagId").val();
		var rec_flag=$("#recFlagId").val(); */
	
		/* $.ajax({
				  url: "{{url('check_for_sample_already_process_migit')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  //console.log(response);
					  
                        if(response==1){
							$('.alert-danger').removeClass('hide');
							$('.alert-danger').show();
							$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                            $('#submit').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#submit').prop("type", "submit");
							//$("#submit").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		}); */
		
	});
} );

function bulk_action_review()
{
  //ar $modal = $('#myModal');
            //var selected = [];
            showButtonWisePopup(1);
            
}

function showButtonWisePopup(id)
{
        var $checkboxes = $('.bulk-selected:checked');          

      // Display an error message and stop if no checkboxes are selected.
      if( $checkboxes.length === 0 ){
          alert("First select one or more items from the list.");
          return;
      }

      var err_html = "";
        var success_html = "";
        var html = "";
        var full_html = "";
        var enroll_id="";
        var sample_id="";
        var service_id="";
        var tag="";
        var rec_flag="";            
        var log_id = "";
        var lpa_type = "";
        var gu = "";
        var flagging_date = "";             
        var samples ="";
        var err_sample_id = [];
        var success_sample_id = "";
        var samples_data = [];

      //
      $checkboxes.each(function(i, e){
        //console.log($("#enroll_id_7").val());

        enroll_id=$("#enrollID_"+$(e).val()).val();
        log_id=$("#log_id_"+$(e).val()).val();
        lpa_type = $("#lpa_type_"+$(e).val()).val();
        gu = $("#gu_"+$(e).val()).val();
        flagging_date = $("#flagging_date_"+$(e).val()).val();
        tag=$("#tag_"+$(e).val()).val();
        service_id=$("#service_id_"+$(e).val()).val();
        sample_id=$(e).val();
        rec_flag=$("#rec_flag_"+$(e).val()).val();
        samples = $("#samples_"+$(e).val()).val();             

        samples_data.push({
          sample_id: sample_id,
          enroll_id: enroll_id,
          service_id: service_id,
          tag: tag,
          rec_flag: rec_flag,               
        });

      });

      //console.log(samples_data);
      $("#node").html("");

      for(i=0; i < samples_data.length; i++)
      {
        $.ajax({
              url: "{{url('check_for_sample_already_process_migit')}}"+'/'+samples_data[i].sample_id+'/'+samples_data[i].enroll_id+'/'+samples_data[i].service_id+'/'+samples_data[i].tag+'/'+samples_data[i].rec_flag,
              type:"GET",
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function(response){
                //console.log(response);
                
              if(response.result == 1==1){
                  $('.alert-danger').removeClass('hide');
                  $('.alert-danger').show();
                  $('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                                $('#submit').prop("type", "button");
                                e. preventDefault(); 							
                                
                }else{                               

                  html+= '<input type="hidden" name="log_id'+response.sample_id+'" value="'+$("#log_id_"+response.sample_id).val()+'">';
                  html+= '<input type="hidden" name="enrollId'+response.sample_id+'" value="'+$("#enrollID_"+response.sample_id).val()+'">';
                  html+= '<input type="hidden" name="tagId'+response.sample_id+'" value="'+$("#tag_"+response.sample_id).val()+'">';
                  html+='<input type="hidden" name="sampleID[]"  value="'+response.sample_id+'">';
                  html+= '<input type="hidden" name="serviceId'+response.sample_id+'" value="'+$("#service_id_"+response.sample_id).val()+'">';
                  html+= '<input type="hidden" name="rec_flag'+response.sample_id+'" value="'+$("#rec_flag_"+response.sample_id).val()+'">';
                  html+='<input type="hidden" name="sample_id'+response.sample_id+'"  value="'+$("#samples_"+response.sample_id).val()+'">';
                  
                  $("#node").append(html);
                    html = "";
                }
              },
            failure: function(response){
              console.log("err")
            }
        });
      }


      if(id == '1' && $('input[name="sector_radio"]:checked').val() == '1')
      {
        $('#test_type_2').prop('disabled', false);
        $('#test_type_2').prop('checked', true);
        $('#test_type_1').prop('disabled', true);
        $('#mff_result').show();
      }
      else if(id == '2' && $('input[name="sector_radio"]:checked').val() == '1')
      {
        $('#test_type_2').prop('disabled', false);
        $('#test_type_2').prop('checked', true);
        $('#test_type_1').prop('disabled', false);
        
      }
      else if(id == '1' && $('input[name="sector_radio"]:checked').val() == '2')
      {
        $('#test_type_1').prop('disabled', false);
        $('#test_type_1').prop('checked', true);
        $('#test_type_2').prop('disabled', true);
        $('#mff_result').hide();
      }
      else if(id == '2' && $('input[name="sector_radio"]:checked').val() == '2')
      {
        $('#test_type_2').prop('disabled', false);
        $('#test_type_1').prop('checked', true);
        $('#test_type_1').prop('disabled', false);
        $('#mff_result').hide();
      }
      

      $('#extractionpopupDiv').modal('toggle');
}

$('.set_radio').on('click', function() {
  if($(this).val() == '1')
  {
    $('#mff_result').hide();
  }
  else
  {
    $('#mff_result').show();
  }
});
</script>
@endsection
