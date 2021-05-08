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
                    <h3 class="text-themecolor m-b-0 m-t-0" id="dash">Decontamination</h3>

                </div>
                <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/dashboardDecontamination/print') }}" method="post">
                        <!--   <input type ="hidden" name="enroll" value = "1"> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="pull-right btn-sm btn-info">Print</a>
                    </form>
                </div>

            </div>
			
            <div class="row">
              
                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">

                                <!-- <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%"> -->
                                <style>
                                    table, th, td {
                                        border: 1px solid black;
                                    }
                                </style>
                                <table style="width:100%">
                                    <thead>
                                    <tr>

                                        <th>Test to be performed</th>
                                        <th>Tests in process</th>
                                        <th>Tests for review</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>


                                        <td>{{$data['decontamination_test']}}</td>
                                        <td>{{$data['decontamination_tested']}}</td>
                                        <td>{{$data['decontamination_review']}}</td>
                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                   <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                            <div class="table-scroll">
                                <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="bulk-select-all"></th>
                                        <th class="hide">ID</th>
                                        <th>Enrolment ID</th>
                                        <th>Sample ID</th>
                                        <th>Date of Decontamination</th>
                                        <th>Action</th>
                                        <th>Sample Type</th>
										<th>Test Requested</th>
                                        <th>DX/FU</th>
                                        <th>Follow up month</th>
                                        <th>Microscopy Result</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>

                                        {{-- {{ dd($data['sample']) }} --}}

                                    @if($data['sample'])
                                        @foreach ($data['sample'] as $key => $samples)
                                            <tr>
                                                <td>
                                                    @if($samples->status && $samples->status==1)
                                                    <input class="bulk-selected" type="checkbox" value="{{ $samples->sample_id }}">
                                                    @endif
                                                </td>
                                                <td class="hide">{{$samples->ID}}</td>
                                                <td>{{$samples->enroll_label}}</td>
                                                <td>{{$samples->samples}}</td>
                                                
                                                <td>
                                                    @if($samples->date=='')
                                                        pending
                                                    @else
                                                        {{$samples->date}}
                                                    @endif
                                                </td>
                                                @if($samples->status && $samples->status==1)
                                                    <td>
                                                        <button type="button"
                                                                onclick="openCbnaatForm({{$samples->enroll_id}},'{{$samples->samples}}','{{$samples->sent_for}}','{{$samples->tag}}',{{$samples->sample_id}},{{$samples->service_id}},{{$samples->rec_flag}},{{$samples->Deconta_sent_for}})"
                                                                class="btn btn-info btn-sm resultbtn">Send for review
                                                        </button>
                                                    </td>
                                                @else
                                                    <td>sent</td>
                                                @endif
                                                <td>
                                                    {{ $samples->sample_type == 'Others'? $samples->others_type : $samples->sample_type }}
                                                  </td>
												<td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                                <td>{{$samples->test_reason}}</td>
                                                <td>{{$samples->fu_month}}</td>
                                                <td>{{$samples->result}}</td>
                                                

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
        <footer class="footer"> </footer>
    </div>

    <div class="modal fade" id="myModal" role="dialog" id="confirmDelete">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sending sample for review...</h4>
                </div>

                <form class="form-horizontal form-material" action="{{ url('/dash_decontamination') }}" method="post"
                      enctype='multipart/form-data' id="cbnaat_result">
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
					 <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enrollId" id="enrollId" value="">
						
						<input type="hidden" name="tag" id="tag" value="">				
						<input type="hidden" name="sampleID" id="sampleID" value="">
						<input type="hidden" name="serviceId" id="serviceId" value="">				
						<input type="hidden" name="rec_flag" id="recFlagId" value="">
						<input type="hidden" name="decontamination_sent_for" id="decontamination_sent_for" value="">

                        <label class="col-md-12"><h5>Sample ID:</h5></label>
                        <div class="col-md-12">
                            <input type="text" name="sample_ids" class="form-control form-control-line sample_ids"
                                   id="sample_ids" readonly>

                        </div>
                        <br>
                        <label class="col-md-12"><h5>Date of Decontamination<span class="red">*</span></h5></label>
                        <div class="col-md-12">
                            <input type="date" name="test_date" class="form-control form-control-line sampleId"
                                   value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>" id="test_date"
                                   required>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                        <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="pull-right btn btn-primary btn-md" id="confirm">Ok
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- MODAL FOR BULK REVIEW --}}
    <div class="modal fade" id="modal-bulk-review" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bulk Sending samples for review...</h4>
                </div>

                <form method="post"
                      class="form-horizontal form-material"
                      action="{{ route('decontamination.send-review.bulk') }}" id="deconbulkform">
                    
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
                    <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sample_ids" value="">

                        <br>
                        <label class="col-md-12">
                            <h5>Date of Decontamination<span class="red">*</span></h5>
                        </label>
                        <div class="col-md-12">
                            <input type="date"
                                   name="test_date"
                                   class="form-control form-control-line sampleId"
                                   value="<?php echo date("Y-m-d");?>"
                                   max="<?php echo date("Y-m-d");?>"
                                   required>
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
		  $("#cbnaat_result,#deconbulkform").on("submit", function(){
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


        

        $(function () {

            $('input.single-checkbox').on('change', function (evt) {
                if ($('[name="category[]"]:checked').length > 2) {
                    this.checked = false;
                    $("#caterralert").text("You can select only 2 services!");
                } else {
                    $("#caterralert").text("");
                }
            });

            // $("#sent_for").change(function(){

            //   if($( "#sent_for option:selected" ).text()=='Other'){
            //     $('#other').removeClass('hide');
            //   }
            //   else{
            //     $('#other').addClass('hide');
            //   }
            // });

            $(".resultbtn").click(function () {
                $('#sample_id').val($(this).val());
            });

            $('#confirmDelete').on('show.bs.modal', function (e) {

                // Pass form reference to modal for submission on yes/ok
                var form = $(e.relatedTarget).closest('form');
                $(this).find('.modal-footer #confirm').data('form', form);
            });

            /* Form confirm (yes/ok) handler, submits form*/
            $('#confirm').click(function (e) { //alert();
                //alert('test');
                
				var enroll_id=$("#enrollId").val();
				var sample_id=$("#sampleID").val();
				var service_id=$("#serviceId").val();
				//var STATUS=$("#statusId").val();
				var tag=$("#tag").val();
				var rec_flag=$("#recFlagId").val();
				if(typeof $("#decontamination_sent_for").val() !== 'undefined' &&  $("#decontamination_sent_for").val()!= ''){
				  var decontamination_sent_for=$("#decontamination_sent_for").val();
				}else{
				  var decontamination_sent_for=0;
				}

                var msg_alert = false;

                /* Date validation checking */

                $.ajax({
						  url: "{{url('check_sample_receive_date')}}"+'/'+sample_id+'/'+enroll_id,
						  type:"GET",
						  processData: false,
						  contentType: false,
						  dataType: 'json',
						  success: function(response){
							  console.log(response);
							  //alert(response.receive_date);
								if(response.success){
                                    //alert(response);
                                    var deconta_date = new Date($('#test_date').val());
                                    var sample_receive_date = new Date(response.receive_date);
                                    
                                    if(deconta_date.getTime() < sample_receive_date.getTime())
                                    {
                                        //alert(sample_receive_date);
                                        
                                        $('.alert-danger').removeClass('hide');
                                        $('.alert-danger').show();
                                        $('.alert-danger').html("Sorry!! Decontamination Date is less than Sample receive date");
                                        $('#confirm').prop("type", "button");
                                        e.preventDefault(); 
                                        //setTimeout(location.reload.bind(location), 1000);
                                        
                                    } else {
                                        
                                        $('.alert-danger').addClass('hide');
                                        $('.alert-danger').hide();									
                                        var form = $(document).find('form#cbnaat_result');

                                        $.ajax({
                                                    url: "{{url('check_for_sample_already_process_decontamination')}}"+'/'+sample_id+'/'+enroll_id+'/'+decontamination_sent_for,
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
                                                                $('#confirm').prop("type", "button");
                                                                e.preventDefault(); 
                                                                setTimeout(location.reload.bind(location), 1000);  // After 5 secs										
                                                                
                                                            }else{
                                                                $('.alert-danger').addClass('hide');
                                                                $('.alert-danger').hide();                                                                
                                                                var form = $(document).find('form#cbnaat_result');
                                                                form.submit();
                                                                
                                                            }
                                                    },
                                                    failure: function(response){
                                                        console.log("err")
                                                    }
                                            }); 
                                    }                                    
									  // After 5 secs										
									
								}
						  },
						failure: function(response){
							console.log("err")
						}
				});

               
				

                

               

                    //return false;
				
            });

        });


        function openCbnaatForm(enroll_id, sample_ids, sent_for, tag,sample_id,service_id,rec_flag,Deconta_sent_for) {
            //console.log("sample_ids", sample_ids.split(','));
            $("#sample_ids").val(sample_ids);
            $("#enrollId").val(enroll_id);
            $("#sent_for").val(sent_for);
			
			 $("#tag").val(tag);
  
			  $("#sampleID").val(sample_id);
			  $("#serviceId").val(service_id);	
			  $("#recFlagId").val(rec_flag);
			  $("#decontamination_sent_for").val(Deconta_sent_for);
            // 	var sampleArray = sample_ids.split(',');
            // 	$('#sampleid option').remove();
            // 	$.each(sampleArray, function (i, item) {
            //     $('#sampleid').append($('<option>', {
            //         text : item
            //     }));
            // });
            $('.alert-danger').addClass('hide');
                $('.alert-danger').hide();
            $('#myModal').modal('toggle');
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
                stateSave: true,
				pageLength:25,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'LIMS_Decontamination_' + today + ''
                    },
                    {
                        text: 'Send for Review',						
                        action: bulk_action_review
                    }
                ]
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
