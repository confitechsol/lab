@extends('admin.layout.app')
@section('content')
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

                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th><input type="checkbox" id="bulk-select-all"></th>
                                              <th class="hide">ID</th>
                                              <th>Sample ID</th>
                                              <!-- <th>LPA test requested</th> -->
                                              <th>LPA test requested</th>
                                              <th>Samples submitted</th>
											  <th>Test Requested</th>
                                              <th>Date of Decontamination</th>
                                              <th>Microscopy result</th>
                                              <th>Date of Extraction</th>
                                              <th>Next step</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td>
                                              @if($samples->status!=0)
                                                <input class="bulk-selected" type="checkbox" id="smpl_log_id_{{ $samples->sample_id }}" value="{{ $samples->sample_id }}" />                                    
                                                <input type="hidden" name="samples_{{$samples->sample_id}}" id="samples_{{$samples->sample_id}}" value="{{ $samples->samples }}" />
                                                <input type="hidden" name="sample_log_id_{{$samples->sample_id}}" id="sample_log_id_{{$samples->sample_id}}" value="{{ $samples->log_id }}" />
                                                <input type="hidden" name="sample_enroll_id_{{$samples->sample_id}}" id="sample_enroll_id_{{$samples->sample_id}}" value="{{ $samples->enroll_id }}" />
                                                <input type="hidden" name="sample_tag_{{$samples->sample_id}}" id="sample_tag_{{$samples->sample_id}}" value="{{ $samples->tag }}" />
                                                <input type="hidden" name="sample_no_sample_{{$samples->sample_id}}" id="sample_no_sample_{{$samples->sample_id}}" value="{{ $samples->no_sample }}" />
                                                <input type="hidden" name="sample_id_{{$samples->sample_id}}" id="sample_id_{{$samples->sample_id}}" value="{{ $samples->sample_id }}" />
                                                <input type="hidden" name="sample_service_id_{{$samples->sample_id}}" id="sample_service_id_{{$samples->sample_id}}" value="{{ $samples->service_id }}" />
                                                <input type="hidden" name="sample_status_{{$samples->sample_id}}" id="sample_status_{{$samples->sample_id}}" value="{{ $samples->STATUS }}" />
                                                <input type="hidden" name="sample_rec_flag_{{$samples->sample_id}}" id="sample_rec_flag_{{$samples->sample_id}}" value="{{ $samples->rec_flag }}" />
                                                 
                                              @endif
                                            </td>
                                            <td class="hide">{{$samples->ID}}</td>
                                            <td>{{$samples->samples}}</td>
                                           <!--  <td></td> -->
                                            <td>											
                                              @if($samples->tag == '1st line LPA' || $samples->tag =='LPA1' || $samples->tag =='LPA 1st line' || $samples->tag =='LPA 1st Line' )
                                                LPA 1st Line
                                              @elseif($samples->tag == '2nd line LPA' || $samples->tag == 'LPA2' || $samples->tag =='LPA 2nd line' || $samples->tag =='LPA 2nd Line')
                                                LPA 2nd Line
											 @elseif($samples->tag =='1st line LPA  and for 2nd line LPA'||$samples->tag =='LPA 1st and 2nd Line')
                                               1st line LPA  and for 2nd line LPA
                                              @else
                                                Pending
                                              @endif
                                            </td>
                                            <td>{{$samples->no_of_samples}}</td>
											<td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                            <td>
                                              @if($samples->decontamination_date)
                                              {{$samples->decontamination_date}}</td>
                                              @endif
                                            <td>{{$samples->result}}</td>
                                            <td>
                                              @if(!$samples->extraction_date)
                                              <!-- <button onclick="openForm('{{$samples->samples}}', {{$samples->log_id}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Submit</button> -->
                                              Pending 
											                        @else
                                              <?php echo date('d/m/Y', strtotime($samples->extraction_date)); ?>
                                              @endif
                                            </td>
                                            <td>
                                              @if($samples->status==0)
                                              Done
                                              @else
                                              <button onclick="openNextForm('{{$samples->sample_id}}')" type="button" class = "btn btn-default btn-sm  nextbtn">Next</button>
                                              @endif
                                            </td>
                                          </tr>
                                          @endforeach
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
    $('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_DNAextraction_'+today+''
            },
            {
              text: 'Send Selected to Review',            
                action: bulk_action_review
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.nextbtn, #nxtconfirm').click( function(e) {

            $('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#nxtconfirm').prop("type", "submit");
							$("#nxtconfirm").text("OK");	
	});

} );

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

            console.log(samples_data);

            for(i=0; i < samples_data.length; i++)
            {
                      $.ajax({
                      url: "{{url('check_for_sample_already_process')}}"+'/'+samples_data[i].sample_id+'/'+samples_data[i].enroll_id+'/'+samples_data[i].service_id+'/'+samples_data[i].tag+'/'+samples_data[i].rec_flag,
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
