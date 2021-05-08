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
                      <h3 class="text-themecolor m-b-0 m-t-0">DNA Extraction</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/DNA/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/DNAextraction/nextsteppopup')
              @include('admin/DNAextraction/extractionpopup')
                <div class="row">
                <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
				@if($errors->any())
					<!---<div class="alert alert-danger" style="text-align:center !important"><h4>{{$errors->first()}}</h4></div>---->
				@endif
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">
                                  <button class="btn-sm btn-info filterBtn" id="default-btn" value="1st line LPA">1st line LPA&nbsp;<span id="tot_1st_lpa">( 0 )</span></button>
                                  <button class="btn-sm btn-info filterBtn" value="2nd line LPA">2nd line LPA&nbsp;<span id="tot_2nd_lpa">( 0 )</span></button>
                                  <button class="btn-sm btn-info filterBtn" value="Both 1st line and 2nd line LPA">Both 1st line and 2nd line LPA&nbsp;<span id="tot_1st_2nd_lpa">( 0 )</span></button>
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th><input type="checkbox" id="bulk-select-all"></th>
                                              <th class="hide">ID</th>
                                              <th>Sample ID</th>
                                              <!-- <th>LPA test requested</th> -->
                                              <th>LPA test requested</th>
                                              <th>Samples submitted</th>
                                              <th>Next step</th>
											                        <th>Test Requested</th>
                                              <th>Date of Decontamination</th>
                                              <th>Microscopy result</th>
                                              <th>Date of Extraction</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <tr class="sel"> 
                                              <td></td>
                                              <td class="hide"></td>                                                                                                                      
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
            <footer class="footer">  </footer>
        </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Barcodes</h4>
      </div>
      <div class="modal-body" id="printCode">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function(){
	  $("#nextpopupDiv").on("submit", function(){
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
 });//document ready
function openForm(sample_label, log_id){
  console.log(sample_label);
  $('#sample').text(sample_label);
  $('#log_id').val(log_id);
  $('#extractionpopupDiv').modal('toggle');
}
function openNextForm(sample_id){

  $("#node").html("");
  $('.bulk-selected').prop('checked', false);
  $('#bulk-select-all').prop('checked', false);
  $('#smpl_log_id_'+sample_id).prop('checked', true);
    bulk_action_review();

  /* $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#next_enroll_id').val(enroll_id);
  $('#spantag').text(tag);
  $('#no_sample').val(no); 
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);
  $("#statusId").val(STATUS);
  $("#tagId").val(tag);
  $("#recFlagId").val(rec_flag);
  $('#nextpopupDiv').modal('toggle'); */
}
</script>


<script>

function arrangeTable(tag)
{

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

  var url = '{{ route("ajax_dnaextra_list") }}';

    $('#exampl').DataTable({
        dom: 'Bfrtip',
        bDestroy: true,
            //stateSave: true,
		pageLength:25,
    processing: true,
    serverSide: true,
            serverMethod: 'post',
                          language: {
                              loadingRecords: '&nbsp;',
                              //processing: 'Loading...'
                              processing: '<div class="spinner"></div>'
                          } ,        
                ajax: {
                          url: url,	
                          data: {tag: tag},	  
                          headers: 
                          {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                        },
                        drawCallback: function (settings) { 
                            // Here the response
                            var response = settings.json;
                            //console.log(response);                            
                             $('#tot_1st_lpa').html('('+response.no_1st_lpa+')');
                            $('#tot_2nd_lpa').html('('+response.no_2st_lpa+')');
                            $('#tot_1st_2nd_lpa').html('('+response.both_1st_2st+')'); 
                          },
                columns: [  
                          { data: 'inputs'}, 
                          { data: 'ID',className: "hide_column"},                                                                                    
                          { data: 'sample_label'},
                          { data: 'tag' },
                          { data: 'sample_submitted' },
                          { data: 'action' },
                          { data: 'test_requested' },
                          { data: 'deconta_date' },
                          { data: 'microscopy_result' },
                          { data: 'extraction_date' },                        
                      ],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_DNAextraction_'+today+''
            },
            {
              text: 'Submit',            
                action: bulk_action_review
            }
        ],
        "order": [[ 1, "desc" ]],
        columnDefs: [
                          { targets: [0], orderable: false }
                        ]
    });
}
	
	//Confirm ok submit
	$('.nextbtn, #nxtconfirm').click( function(e) {

            $('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#nxtconfirm').prop("type", "submit");
							$("#nxtconfirm").text("OK");	
	});



$(document).ready(function() {

  arrangeTable('1st line LPA'); 

  $('#default-btn').css('background', '#1e88e5');
    $('#default-btn').css('border', '#1e88e5');

    $('#default-btn').css('background', '#FFA500');
    $('#default-btn').css('border', '#FFA500');
  

  $('.filterBtn').on('click', function(){

var tag = "";

tag = $(this).val();

$('.filterBtn').css('background', '#1e88e5');
    $('.filterBtn').css('border', '#1e88e5');

    $(this).css('background', '#FFA500');
    $(this).css('border', '#FFA500');

arrangeTable(tag);

});

});

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

        function bulk_action_review(){
          //$('#nextpopupDiv').modal('toggle');
          var $modal = $('#nextpopupDiv');
            //var selected = [];
            var $checkboxes = $('.bulk-selected:checked');          

            // Display an error message and stop if no checkboxes are selected.
            if( $checkboxes.length === 0 ){
                alert("First select one or more items from the list.");
                return;
            }
              var smpl_log_id = "";
              var samples = "";
              var sample_log_id = "";
              var sample_enroll_id = "";
              var sample_tag = "";
              var sample_no_sample = "";
              var sample_id = "";
              var sample_service_id = "";
              var sample_status = "";
              var sample_rec_flag = "";
              var err_html = "";
              var success_html = "";
              var html = "";
              var full_html = "";              
              var err_sample_id = [];
              var success_sample_id = "";
              var samples_data = [];
              $("#node").html("");
            //
            $checkboxes.each(function(i, e){
              
              smpl_log_id = $("#smpl_log_id_"+$(e).val()).val();
              samples = $("#samples_"+$(e).val()).val();
              sample_log_id = $("#sample_log_id_"+$(e).val()).val();
              sample_enroll_id = $("#sample_enroll_id_"+$(e).val()).val();

              if(typeof $("#sample_tag_").val() !== 'undefined' &&  $("#sample_tag_").val()!= ''){
                var sample_tag=$("#sample_tag_").val();
                }else{
                var sample_tag="NULL";
              }

              //sample_tag = $("#sample_tag_"+$(e).val()).val();
              sample_no_sample = $("#sample_no_sample_"+$(e).val()).val();
              sample_id = $("#sample_id_"+$(e).val()).val();
              sample_service_id = $("#sample_service_id_"+$(e).val()).val();
              sample_status = $("#sample_status_"+$(e).val()).val();
              sample_rec_flag = $("#sample_rec_flag_"+$(e).val()).val();                        

              samples_data.push({
                sample_id: sample_id,                
                enroll_id: sample_enroll_id,
                service_id: sample_service_id,
                tag: sample_tag,
                rec_flag: sample_rec_flag,               
              });

            });

            //console.log(samples_data);

            for(i=0; i < samples_data.length; i++)
            {
                      $.ajax({
                      url: "{{url('check_for_sample_already_process_dnr')}}"+'/'+samples_data[i].sample_id+'/'+samples_data[i].enroll_id+'/'+samples_data[i].service_id+'/'+samples_data[i].tag+'/'+samples_data[i].rec_flag,
                      type:"GET",
                      processData: false,
                      contentType: false,
                      dataType: 'json',
                      success: function(response){
                        console.log(response);
                        
                      if(response.result == 1){
                          $('.alert-danger').removeClass('hide');
                          $('.alert-danger').show();
                          $('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                                        $('#nxtconfirm').prop("type", "button");
                                        e. preventDefault();                                        
                        }else{
                          /* $('.alert-danger').addClass('hide');
                          $('.alert-danger').hide();                          
                          $('#nxtconfirm').prop("type", "submit");
                          $("#nxtconfirm").text("OK"); */
                            html+='<input type="hidden" name="service_log_id'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_log_id_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="enroll_id'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_enroll_id_"+response.sample_id).val()+'">';                          
                            html+= '<input type="hidden" name="no_sample'+$("#sample_log_id_"+response.sample_id).val()+'" class="form-control form-control-line sampleId" value="'+$("#sample_no_sample_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="sampleID'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_id_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="logID[]"  value="'+$("#sample_log_id_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="serviceId'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_service_id_"+response.sample_id).val()+'">';				
                            html+='<input type="hidden" name="status'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_status_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="tag'+$("#sample_log_id_"+response.sample_id).val()+'" value="'+$("#sample_tag_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="rec_flag'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#sample_rec_flag_"+response.sample_id).val()+'">';
                            html+='<input type="hidden" name="sample_id'+$("#sample_log_id_"+response.sample_id).val()+'"  value="'+$("#samples_"+response.sample_id).val()+'">';
                            
                            $("#node").append(html);
                            html = "";                          
                          }
                      },
                    failure: function(response){
                      console.log("err")
                    }
                });
            }

            $('#nextpopupDiv').modal('toggle');

        }
</script>

@endsection
