
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
                      <h3 class="text-themecolor m-b-0 m-t-0">PCR</h3>

                  </div>

                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/pcr/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>
              <div class="row"> </div>

                <div class="row">
                    <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="table-scroll" >

                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Enrollment ID</th>
                                              <th>Sample ID</th>
                                              <th>Date of Decontamination </th>
                                              <th>Microscopy result</th>
                                              <th>Date of Extraction</th>
                                              <th>LPA test type</th>
                                              <th>PCR completed</th>
                                              <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)

                                                  <tr>
                                                    <td class="hide">{{$samples->ID}}</td>
                                                    <td>{{$samples->enroll_label}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    <td>
                                                    <?php
													if(!empty($samples->test_date))
                                                       echo date('d/m/Y', strtotime($samples->test_date)); 
                                                    ?>
                                                    </td>
                                                    <td>{{$samples->result}}</td>
                                                     <td><?php echo date('d/m/Y', strtotime($samples->created_extraction)); ?></td>
                                                    <td>{{$samples->tag}}</td>
                                                    <td>
                                                      @if($samples->completed==1)
                                                      yes
                                                      @else
                                                      no
                                                      @endif
                                                    </td>
                                                    <td>
                                                      @if($samples->STATUS==0)
                                                      Done
                                                      @else
                                                    <button type="button" onclick="openCbnaatForm({{$samples->enroll_id}},'{{$samples->samples}}','{{$samples->tag}}',{{$samples->sample_id}},{{$samples->service_id}},{{$samples->rec_flag}})" class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                    @endif
                                                    </td>


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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">PCR Result</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/PCR') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
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

                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid">

                       </select>
                   </div>
                <br>

                <label class="col-md-12"><h5>PCR Completed:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="completed" value="" id="completed" required>
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">Repeat PCR</option>
                       </select>
                   </div>
                <br>

                <label class="col-md-12"><h5>Comments:</h5></label>
                    <div class="col-md-12">
                      <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                   </div>



            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<script>
$(document).ready(function(){
	  $("#cbnaat_result").on("submit", function(){
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
$(function(){

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
  });

});





 function openCbnaatForm(enroll_id, sample_ids, tag,sample_id,service_id,rec_flag){
  //console.log("sample_ids", sample_ids.split(','));
  $("#enrollId").val(enroll_id);
  $("#tag").val(tag);
  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);

  var sampleArray = sample_ids.split(',');
  $('#sampleid option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleid').append($('<option>', {
          text : item
      }));
  });

  $('#myModal').modal('toggle');
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
                title: 'LIMS_Pcr_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.resultbtn, #confirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enrollId").val();
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
					  //console.log(response);
					  
                        if(response==1){
							$('.alert-danger').removeClass('hide');
							$('.alert-danger').show();
							$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                            $('#confirm').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#confirm').prop("type", "submit");
							$("#confirm").text("OK");
							
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
