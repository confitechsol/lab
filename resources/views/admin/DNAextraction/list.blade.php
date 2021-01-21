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
                                              <button onclick="openNextForm('{{$samples->samples}}', {{$samples->log_id}},{{$samples->enroll_id}}, '{{ $samples->tag }}','{{$samples->no_sample}}','{{$samples->sample_id}}','{{$samples->service_id}}','{{$samples->STATUS}}','{{$samples->rec_flag}}')" type="button" class = "btn btn-default btn-sm  nextbtn">Next</button>
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
function openNextForm(sample_label, log_id, enroll_id, tag, no,sample_id,service_id,STATUS,rec_flag){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#next_enroll_id').val(enroll_id);
  $('#spantag').text(tag);
  $('#no_sample').val(no);
  
  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);
  $("#statusId").val(STATUS);
  $("#tagId").val(tag);
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
                title: 'LIMS_DNAextraction_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.nextbtn, #nxtconfirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#next_enroll_id").val();
		var sample_id=$("#sampleID").val();
		var service_id=$("#serviceId").val();
		//var STATUS=$("#statusId").val();
		//var tag=$("#tagId").val();
		if(typeof $("#tagId").val() !== 'undefined' &&  $("#tagId").val()!= ''){
		  var tag=$("#tagId").val();
	    }else{
			var tag="NULL";
		}
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
							$('#nxtconfirm').prop("type", "submit");
							$("#nxtconfirm").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
} );
</script>

@endsection
