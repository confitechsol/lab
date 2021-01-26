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
                      <h3 class="text-themecolor m-b-0 m-t-0">Hybridization</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/hybrid/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/hybridization/nextsteppopup')
                <div class="row">
                    <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
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
                                            <th>Samples submitted</th>
                                            <th>Date of Decontamination</th>
                                            <th>Microscopy result</th>
                                            <th>Date of Extraction</th>
                                            <th>LPA test type</th>
                                            <th>PCR completed</th>
                                            <th>Results/ Next Step (Drop down)</th>
                                          </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td>
                                                    @if($samples->status && $samples->status==1)
                                                    <input class="bulk-selected" type="checkbox" value="{{ $samples->log_id }}">
                                                    @endif
                                                </td>
                                            <td class="hide">{{$samples->ID}}</td>
                                            <td>{{$samples->samples}}</td>
                                            <td>{{$samples->no_of_samples}}</td>
                                            <td>
                                              @if($samples->decontamination_date)
                                              <?php echo date('d/m/Y', strtotime($samples->decontamination_date)); ?>
                                              @endif
                                            </td>
                                            <td>{{$samples->result}}</td>
                                            <td>
                                              @if($samples->date_of_extraction)
                                                <?php echo date('d/m/Y', strtotime($samples->date_of_extraction)); ?>
                                              @endif
                                            </td>
                                            <td>{{$samples->tag}}</td>
                                            <td>
                                              @if($samples->pcr_completed==1)
                                              yes
                                              @else
                                              no
                                              @endif
                                            </td>
                                            <td>
                                              @if($samples->STATUS == 0)
                                              Done
                                              @else
                                              <button onclick="openNextForm('{{$samples->samples}}', {{$samples->log_id}}, {{$samples->enroll_id}},'{{$samples->tag}}','{{$samples->no_sample}}',{{$samples->sample_id}},{{$samples->service_id}},{{$samples->rec_flag}})" type="button" class = "btn btn-default btn-sm  nextbtn">Next</button>
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


  {{-- MODAL FOR BULK REVIEW --}}
    <div class="modal fade" id="modal-bulk-review" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Microscopy Result</h4>
                </div>

                <form method="post"
                      class="form-horizontal form-material"
                      action="{{ route('hybridization.send-review.bulk') }}" id="deconbulkform">
                    
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
                    <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sample_ids" value="">                        

                        <div class="row">
                          <div class="col">
                              <label class="col-md-12">Sample Sent for:(<span id="spantag"></span>)</label>
                              <div class="col-md-12">
                                 <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                                 <select name="service_id" id="service_id" class="form-control form-control-line test_reason" required>
                                   <option value="">--Select--</option>
                                   @foreach ($data['services'] as $key => $service)
                                    <option value={{$key}}>{{$service}}</option>
                                   @endforeach
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
                        <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                        <button class="btn btn-default add-button cancel btn-md"
                                type="button"
                                data-dismiss="modal">Cancel</button>

                        <button class="pull-right btn btn-primary btn-md" type="submit">Ok</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- MODAL FOR BULK REVIEW - ENDS --}}

<script>
   $(document).ready(function(){
	  $("#nextpopupDiv").on("submit", function(){ alert();
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
 
function openNextForm(sample_label, log_id, enroll_id, tag, no,sample_id,service_id,rec_flag){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#spantag').text(tag);
  $('#no_sample').val(no);
  $('#tag').val(tag);
  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  
  $('#nextpopupDiv').modal('toggle');
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
                title: 'LIMS_HYBRIDIZATION_'+today+''
            }
            ,
            {
                text: 'Send Selected to Review',            
                action: bulk_action_review
            }
        ],
       // "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.nextbtn, #nxtconfirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enroll_id").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		var tag=$("#tag").val();
		var rec_flag=$("#recFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					  
                        if(response==1){
							$('.alert-danger').removeClass('hide');
							$('.alert-danger').show();
							$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                            $('#nxtconfirm').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							//$('#nxtconfirm').prop("type", "submit");
							//$("#nxtconfirm").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
} );



// ==================================================
        // =========== SCRIPT FOR BULK REVIEW ===============
        // ==================================================

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

// Open bulk editing modal on clicking "Send Selected to Review" button.
        function bulk_action_review(){
            var $modal = $('#modal-bulk-review');
            var selected = [];
            var $checkboxes = $('.bulk-selected:checked');

            // Display an error message and stop if no checkboxes are selected.
            if( $checkboxes.length === 0 ){
                alert("First select one or more items from the list.");
                return;
            }

            $modal.modal('show');

            $checkboxes.each(function(i, e){
                selected.push( $(e).val() );

                // Last iteration of the loop.
                if( i === $checkboxes.length - 1 ){
                    $modal.find('input[name="sample_ids"]').val( selected.join(',') );
                }
            });
        }

        // ==================================================
        // ========= SCRIPT FOR BULK REVIEW - ENDS ==========
        // ==================================================
</script>

@endsection
