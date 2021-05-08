@extends('admin.layout.app')
@section('content')
<style>
.primary{
  background-color: #20D88F;
  color:white;
}

.Secondary{
  background-color: #FF6633;
  color:white;

}

.tertiary{
  background-color: #FF4C70;
    color:white;
}
.btn-default{
  background-color: #006666;
    color:white;

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
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LC Reporting</h3>

                  </div>
              </div>
              @include('admin/lc_flagged_mgit_further/BHIform')
              @include('admin/lc_flagged_mgit_further/ICTform')
              @include('admin/lc_flagged_mgit_further/SCForm')
              @include('admin/lc_flagged_mgit_further/furtherpopup')
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

                                  <table class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>Sample ID</th>
                                          <th>MGIT Tube sequence ID</th>
                                          <th>Date of Inoculation</th>
                                          <th>Initial Smear  result</th>
                                          <th>DX/FU</th>
                                          <!-- <th>GU</th> -->
                                          <th>Date of flagging  by MGIT</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td>{{$data['sample']->samples}}</td>
                                          <td>{{$data['sample']->mgit_id}}</td>

                                          <td><?php echo date('d-m-Y',strtotime($data['sample']->inoculation_date)); ?></td>
                                          <td>{{$data['sample']->result}}</td>
                                          <td>{{$data['sample']->reason}}</td>
                                          <!-- <td>{{$data['sample']->gu}}</td> -->
                                          <td>{{date('d-m-Y',strtotime($data['sample']->flagging_date)) }}</td>
                                        </tr>

                                    </tbody>
                                      </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                  <table class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>ICT</th>
                                          <th>Smear from culture</th>
                                          <th>BHI</th>
                                          <th>Final result</th>
                                          <th>Date of LC result</th>
                                          <th>Result</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        <tr>
                                          <td style="color:#0099FF;">{{$data['sample']->ict}}  </td>

                                          <td style="color:#0099FF;">{{$data['sample']->culture_smear}} </td>

                                          <td style="color:#0099FF;">{{$data['sample']->bhi}}</td>

                                          <td>{{$data['sample']->final_result}}</td>
                                          <td>{{$data['sample']->result_date}}</td>
                                          <td>
                                            @if($data['sample']->status==1)
                                            <?php
                                            // dd($data['sample']->service_id);
                                            if($data['sample']->service_id == 18):
                                            $err=0;
                                             if(empty($data['sample']->ict)){
                                              echo "<span style='color:red;'>ICT Process pending</span> <br/>";
                                              $err++;
                                            }else{
                                                echo "<span style='color:darkgreen;'>ICT Process completed</span> <br/>";
                                            }

                                            if(empty($data['sample']->culture_smear)){
                                              echo "<span style='color:red;'>Smear Culture Process pending</span> <br/>";
                                              $err++;
                                           }else{
                                               echo "<span style='color:darkgreen;'>Smear Culture Process completed</span> <br/>";
                                           }

                                           if(empty($data['sample']->bhi)){
                                             echo "<span style='color:red;'>BHI Process pending </span> <br/>";
                                             $err++;
                                          }else{
                                              echo "<span style='color:darkgreen;'>BHI Process completed</span> <br/>";
                                          }

                                        endif;
                                            ?>
                                            @elseif($data['sample']->status==4)
                                            Sent to decontamination
                                            @else
                                            Sent for review
                                            @endif
                                          </td>
                                        </tr>

                                      @if($data['sample']->status==1)
                                        <tr>
                                            <?php if($data['sample']->service_id == 18){ ?>
                                          <td><button onclick="openICTForm('{{$data['sample']->samples}}', {{$data['sample']->log_id}}, '{{$data['sample']->lpa_type}}','{{$data['sample']->ict}}')"  value="" type="button" class = "btn primary btn-sm resultbtn">ICT Edit</button></td>

                                          <td><button onclick="openSCForm('{{$data['sample']->samples}}', {{$data['sample']->log_id}}, '{{$data['sample']->lpa_type}}','{{$data['sample']->culture_smear}}')"  value="" type="button" class = "btn Secondary btn-sm resultbtn">Smear & Culture Edit</button></td>

                                          <td><button onclick="openBHIForm('{{$data['sample']->samples}}', {{$data['sample']->log_id}}, '{{$data['sample']->lpa_type}}','{{$data['sample']->bhi}}')"  value="" type="button" class = "btn tertiary btn-sm resultbtn">BHI Edit</button></td>
                                          <?php }else{ ?>
                                          <td></td>
                                          <td></td>
                                          <td></td>


                                          <?php } ?>
                                          <td></td>
                                          <td></td>
                                            <?php if($data['sample']->service_id == 18){ ?>
                                          <td>
                                            @if($err < 1)
                                            <button onclick="openForm('{{$data['sample']->samples}}', {{$data['sample']->log_id}}, '{{$data['sample']->lpa_type}}','{{$data['sample']->ict}}','{{$data['sample']->culture_smear}}','{{$data['sample']->bhi}}','{{$data['sample']->tag}}',{{$data['sample']->enrollID}},{{$data['sample']->sampleID}},{{$data['sample']->service_id}},{{$data['sample']->rec_flag}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Submit</button>
                                            @endif
                                          </td>
                                        <?php }else{ ?>


                                            <button onclick="openForm('{{$data['sample']->samples}}', {{$data['sample']->log_id}}, '{{$data['sample']->lpa_type}}')"  value="" type="button" class = "btn btn-default btn-sm resultbtn">Submit</button>

                                      <?php   } ?>
                                        </tr>
                                        @endif
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

<script>
$(document).ready(function(){
  $("#extractionpopup").on("submit", function(){
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
  
  //Confirm ok submit
	$('.resultbtn, .submitOK').click( function(e) {
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
                            $('.submitOK').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('.submitOK').prop("type", "submit");
							//$(".submitOK").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
});//document ready


function openForm(sample_label, log_id, lpa_type,ict=null,culture_smear=null,bhi=null,tag=null,enroll_id=null,sample_id=null,service_id=null,rec_flag=null){
  $('.sample_id').val(sample_label);
  $('.log_id').val(log_id);
  $('#ict_val').html(ict);
  $('#smearcul_val').html(culture_smear);
  $('#bhi_val').html(bhi);
  
  $("#enrollId").val(enroll_id);
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}

function openBHIForm(sample_label, log_id, lpa_type){
  $('.sample_id').val(sample_label);
  $('.log_id').val(log_id);
  $('#bhi').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}
function openSCForm(sample_label, log_id, lpa_type){
  $('.sample_id').val(sample_label);
  $('.log_id').val(log_id);
  $('#sc').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}
function openICTForm(sample_label, log_id, lpa_type){
  $('.sample_id').val(sample_label);
  $('.log_id').val(log_id);
  $('#ict').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}
function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}
</script>


@endsection
