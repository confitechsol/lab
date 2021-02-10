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
                      <h3 class="text-themecolor m-b-0 m-t-0">LJ Review</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/ljreview/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
					   <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
					
					
                 </div>
              </div>
              @include('admin/ljreview/nextpopup')
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
                                          <th>Enroll ID</th>
                    										  <th>Test Requested</th>
                                          <th>Next steps</th>
                                          <th>DX/FU/EQA</th>
                                          <th>FU month</th>
                                          <th>Week of Result</th>
                                          <th>Samples submitted</th>
                                          <th>Type of sample</th>
                                          <th>LPA Test requested</th>
                                          <th>Culture method S/L/Both</th>
                                          <th>Final result</th>
                                          <th>Date of Solid Culture Result</th>
                                          <th>If subjected to LC, LC Result</th>
                                          <th>If subjected to LC, date of LC result</th>
                                          
                                        </tr>
                                      </thead>
                                      <tbody>
									
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>                                            
                                            <input class="bulk-selected" type="checkbox" value="{{ $samples->log_id }}">
                                          </td>
                                          <td class="hide">{{$samples->ID}}</td>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
										                      <td <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                          <td>
                                            @if($samples->status==0)
                                            Done
                                            @else
                                            <button onclick="openNextForm('{{$samples->samples}}', {{$samples->log_id}},'{{$samples->tag}}',{{$samples->enrollID}},{{$samples->sampleID}},{{$samples->service_id}},{{$samples->rec_flag}},'{{$samples->final_result}}')" type="button" class = "btn btn-info btn-sm  nextbtn">Submit</button>
                                            @endif
                                          </td>
                                          <td>{{$samples->reason}}</td>
                                          <td>{{$samples->fu_month}}</td>
                                          <td>
                                            @if($samples->week==null)
                                            1
                                            @else
                                            {{$samples->week+1}}
                                            @endif
                                          </td>
                                          <td>{{$samples->no_of_samples}}</td>
										
											  
                                          <td>
                        											 @if($samples->sample_type=="Other" || $samples->sample_type=="Others")
                        												{{$samples->sample_type}}({{$samples->others_type}})
                        											@else
                        												{{$samples->sample_type}}
                        											@endif
                        											</td>
                                                                  <td>{{$samples->lpa_type}}</td>
                                                                  <td>{{$samples->culture_method}}</td>
                        										  <td>
                        											  <?php 
                        											  if($samples->final_result=='NTM'){
                        												  echo $samples->final_result.' ('.$samples->species.')';
                        											  }else if($samples->final_result=='Other Result'){
                        												  echo $samples->final_result.' ('.$samples->other_result.')';
                        											  }else{
                        												  echo $samples->final_result;
                        											  }
                        											  ?>
                        								</td>
                                          <!--<td>{{$samples->final_result}}</td>-->
                                          <td>{{$samples->lj_result_date}}</td>
                                          <td>{{$samples->lc_result}}</td>
                                          <td>{{$samples->lc_result_date}}</td>
                                          
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
                    <h4 class="modal-title">LJ Review</h4>
                </div>

                <form method="post"
                      class="form-horizontal form-material"
                      action="{{ route('reviewlj.send-review.bulk') }}" id="deconbulkform">
                    
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
                            <label class="col-md-12">Sample Sent for</label>
                            <div class="col-md-12">
                               <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                               <select name="service_id" id="service_id" class="form-control form-control-line test_reason" required>
                                 <option value="">--Select--</option>
                                 <option value="1">DNA Extraction LPA 1st line</option>
                                 <option value="2">DNA Extraction LPA 2nd line</option>
                                 <!--<option value="3">DNA Extraction LPA 1st line and LPA 2nd line</option>---->
                       <option value="4">LJ - DST Inoculation</option>
                                 <!--<option value="4">LJ - DST 1st Line</option>
                                 <option value="5">LJ - DST 2nd Line</option>
                       <option value="7">LJ - DST 1st & 2nd Line</option>-->
                                 <!--<option value="6">Microbiologist for further review</option>-->
                                 <option value="19">Result finalization</option>
                                 <!-- <option value="">MB for further review </option> -->
                               </select>
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
  $("#nxtpopup").on("submit", function(){
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

function openNextForm(sample_label, log_id,tag=null,enroll_id=null,sample_id=null,service_id=null,rec_flag=null,result){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  $("#rsltId").val(result);
  
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


 today = dd + '-' + mm + '-' + yyyy;
    $('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [,
            {
                extend: 'excelHtml5',
                title: 'LIMS_lj_review_'+today+''
				
            }
            ,
            {
                text: 'Submit',            
                action: bulk_action_review
            }            

        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.nextbtn, #nxtconfirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enrollId").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		var tag=$("#tagId").val();
		var rec_flag=$("#recFlagId").val();
	
		$.ajax({
				  url: "{{url('check_for_sample_already_process')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
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
                            $('#nxtconfirm').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#nxtconfirm').prop("type", "submit");
							//$("#nxtconfirm").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
	//Show hide option on the base of result	
	$('#nextpopupDiv').on('shown.bs.modal', function (e) {
      //alert($("#rsltId").val());
	  if($("#rsltId").val()=="Negative"){
	    $("#service_id option[value=1]").hide();
		$("#service_id option[value=2]").hide();
		$("#service_id option[value=4]").hide();
	  }else{
		$("#service_id option[value=1]").show();
		$("#service_id option[value=2]").show();
		$("#service_id option[value=4]").show();
	  }
   });
});

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
