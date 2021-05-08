@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LJ DST Inoculation</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/ljdstfirst/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>
              @include('admin/ljdstln1/inoculationdatepopup')
              @include('admin/ljdstln1/readingpopup')
              @include('admin/ljdstln1/readingdetailspopup')
                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="overflow-x:scroll;">

                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>Sample ID</th>
                                          <th>Enroll ID</th>
                                          <th>Inoculation Date</th>
                                          <th>Primary Culture Date</th>
                                          <th>Drug List</th>
                                          <th>Reading</th>
                                          <!--<th>6th Week Reading</th>--->
                                          <!---<th>Action</th>--->
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>
                                            @if($samples->inoculation_date)
                                              {{$samples->inoculation_date}}
                                            @else
                                            <a href="javascript:void(0);" onclick="openDateForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}')" class="btn btn-info btn-sm inaucodtclss">Add Date</a>
                                            @endif
                                          </td>
                                          <td>{{$samples->lj_result_date}}</td>
                                          <td>{{$samples->druglist}}</td>
                                          <td>
                                            @if(is_null($samples->status) || ($samples->week_no==4 && $samples->status==0))
                                            <a href="javascrip:void(0)" class="btn btn-info btn-sm readingSubBtnlj" onclick="openReadingForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}',4,'{{$samples->druglist}}','{{$samples->drug_ids}}','{{$samples->tag}}',{{$samples->service_id}},{{$samples->rec_flag}})">SUBMIT<!--Add Reading----></a>
                                            @else
                                              <a href="javascrip:void(0)" class="btn  btn-sm" onclick="openReading({{$samples->enroll_id}},4)">View Details</a>
                                            @endif

                                          </td>
                                         <!--- <td>
                                            @if(($samples->week_no==4 && $samples->status==1) || ($samples->week_no==6 && $samples->status==0))
                                              <a href="#" class="btn btn-info btn-sm" onclick="openReadingForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}',6,'{{$samples->druglist}}','{{$samples->drug_ids}}')">Add Reading</a>
                                            @elseif(($samples->week_no==6 && $samples->status==1))
                                              <a href="#" class="btn  btn-sm" onclick="openReading({{$samples->enroll_id}},6)">View Details</a>
                                            @endif

                                          </td>--->
                                          <!---<td>
                                            @if($samples->status==1 && $samples->week_no==4 && $samples->ljdst_status!=0)
                                            <button type="button" onclick="openCbnaatForm({{$samples->enroll_id}},'{{$samples->samples}}')"  class="btn btn-info btn-sm resultbtn" >Submit</button>
                                            @elseif($samples->ljdst_status==0)
                                            Done
                                            @else
                                            submit date and result
                                            @endif
                                          </td>--->
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
            <footer class="footer">  </footer>
        </div>

        <div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">LJ DST Result</h4>
                </div>
                 <form class="form-horizontal form-material" action="{{ url('/lj_dst_ln1') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                          @if(count($errors))
                            @foreach ($errors->all() as $error)
                               <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                           @endforeach
                         @endif
        		        <div class="modal-body">

        		           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
        		           	<input type="hidden" name="enrollId" id="enrollId" value="">

        		            <label class="col-md-12">Sample ID</label>
                            <div class="col-md-12">
                               <input type="text" name="sampleid" class="form-control form-control-line sampleid"  id="sampleid" readonly>
                           </div>

                       <label class="col-md-12">Next Step: </label>
        		            <div class="col-md-12">
        		              <select name="next_step" class="form-control form-control-line" id="next_step" required>
        		                <option value="">--Select--</option>
                            <option value="Results Finalization">Results Finalization</option>
                            <!-- <option value="Repeat DST">Repeat DST</option> -->

        		              </select>
        		           </div>

                       <label class="col-md-12">Comments: </label>
                        <div class="col-md-12">
                      <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                       </div>


        		        </div>
        		        <div class="modal-footer">
        		          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
        		          <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
                		  <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
        		        </div>

        		  </form>
              </div>
            </div>
        </div>

<script>
function openDateForm(enroll_id, sample_id, service_log_id){
  $('#sample_id').val(sample_id);
  $('#enroll_id').val(enroll_id);
  $('#service_log_id').val(service_log_id);
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy",
      autoclose:true,
  }).datepicker("setDate", "0");

}
function openReadingForm(enroll_id, sample_id, service_log_id, week, drugs, drugs_id,tag=null,service_id=null,rec_flag=null){
  console.log(enroll_id);
  console.log(sample_id);
  console.log(drugs);
  console.log(drugs_id);
  drugs=drugs.split(',');
  drugs_id=drugs_id.split(',');
  var text="";
  /*
  for(i=0;i<drugs.length;i++){
      text=text+"<div class='col-md-6 dil_2'><label class='col-md-12'>"+drugs[i]+"</label>"+
                  "<input type='hidden' id='dil_2_drugName' name='dil_2_drugName[]' value='"+drugs[i]+"'' />"+
                  "<div class='col-md-12'>"+
                    "<select name='dil_2_drugVal[]'' id='dil_2_drugVal' class='dil_2_drugVal form-control' required >"+
                      "<option value=''>---</option>"+
                      "<option value='Sensitive'>Sensitive</option>"+
                      "<option value='Resistance'>Resistance</option>"+
                      "<option value='Contaminated'>Contaminated</option>"+
                      "<option value='Not done'>Not done</option>"+
                    "</select>"+
                 "</div>"+
               "</div>"+
               "<div class='col'>"+
                   "<label class='col-md-12'>Repeat "+drugs[i]+"</label>"+
                   "<div class='col-md-12'>"+
                      "<input type='checkbox' class='form-control-line' name='repeat' value='"+drugs_id[i]+"'>"+
                  "</div>"+
               "</div></div>";
  }
*/
  document.getElementById("drug_names").innerHTML=text;

  var text="";
  for(i=0;i<drugs.length;i++){
      text=text+"<div class='col-md-6 dil_4'>"+
                 "<label class='col-md-12'>"+drugs[i]+"</label>"+
                 "<input type='hidden' id='dil_4_drugName' name='dil_4_drugName[]' value='"+drugs[i]+"' />"+
                 "<div class='col-md-12'>"+
                   "<select name='dil_4_drugVal[]' id='dil_4_drugVal' class='dil_4_drugVal form-control' required >"+
                    "<option value=''>---</option>"+
                     "<option value='Sensitive'>Sensitive</option>"+
                     "<option value='Resistance'>Resistance</option>"+
                     "<option value='Contaminated'>Contaminated</option>"+
                     "<option value='Not done'>Not done</option>"+
                   "</select>"+
                "</div>"+
              "</div>";

  } 
  document.getElementById("drug_names_result").innerHTML=text;

  $('#sample_id').val(sample_id);
  $('#enroll_id').val(enroll_id);
  $('#service_log_id').val(service_log_id);
  $('#week_no').val(week);
  $('#lblweek').html(week);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);

  $('#readingpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy",
      autoclose:true,
  }).datepicker("setDate", "0");

} 
function openReading(lj_dst_reading_id,week){
  $.ajax({
    type: "GET",
    url: "{{url('lj_dst_ln1/detail/')}}"+"/"+lj_dst_reading_id+"/"+week,
    success: function(obj){
      console.log(obj)
      var html = "<table>";
      for (const data in obj) {
        html +='<tr> \
                  <td style="padding: 15px 20px 5px 15px;">Dilution</td>\
                  <td style="padding: 15px 20px 5px 15px;">'+data+'</td>\
                </tr>';
        for (var i =0; i < obj[data].length; i++){
          console.log(obj[data][i].name,obj[data][i].value );
          html +='<tr> \
                    <td style="padding: 15px 20px 5px 15px;">'+obj[data][i].name+'</td>\
                    <td style="padding: 15px 20px 5px 15px;">\
                      '+obj[data][i].value+'\
                    </td>\
                  </tr>';
        }
      }
      html += "</table>";
      $("#detailsData").html(html);
      $('#readingdetpopupDiv').modal('toggle');
    },
    dataType: "json"
  });
}
function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}

function openCbnaatForm(enroll_id, sample_ids){
 $("#enrollId").val(enroll_id);
 $("#sampleid").val(sample_ids);

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
                title: 'LIMS_lj_dst_1st_line_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	//Confirm ok submit
	$('.readingSubBtn, #nxtconfirm').click( function(e) {
		//alert("here");
		var enroll_id=$("#enroll_id").val();
		var sample_id=$("#sample_id").val();
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
	
	
});
</script>

@endsection
