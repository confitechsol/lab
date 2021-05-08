@extends('admin.layout.app')
@section('content')
<style>
  
  #pageloader
{
  background: rgba( 255, 255, 255, 0.8 );
  display: none;
  height: 100%;
  position: fixed;
  width: 100%;
  z-index: 9999;
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
  /*z-index: 9999;*/
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

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" />

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">LJ individual Sample</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                   </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
				  <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                  <form class="form-horizontal form-material" action="{{ url('/dashboardlj/'.$data['sample']->log_id) }}" id="ljreporting" method="post" enctype='multipart/form-data' novalidate>
                    <input name="_method" type="hidden" value="patch">
                      @if(count($errors))
                        @foreach ($errors->all() as $error)
                           <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                       @endforeach
                     @endif
					  <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-block">
                                  <div class="row">
                                    <div class="col">
                                      <label class="col-md-12">Lab Enrolment  ID</label>
                                      <div class="col-md-12">
                                          <input type="text" name="enroll_label" class="form-control form-control-line" value="{{$data['sample']->enroll_label}}" id="enroll_label" disabled>
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
										  <input type="hidden" name="enrollId" id="enrollId" value="{{$data['sample']->enrollID}}">
										  <input type="hidden" name="tagId" id="tagId" value="{{$data['sample']->tag}}">				
										  <input type="hidden" name="sampleID" id="sampleID" value="{{$data['sample']->sampleID}}">
										  <input type="hidden" name="serviceId" id="serviceId" value="{{$data['sample']->service_id}}">				
										  <input type="hidden" name="rec_flag" id="recFlagId" value="{{$data['sample']->rec_flag}}">
									  </div>
                                    </div>
                                    <div class="col">
                                      <label class="col-md-12">Sample ID</label>
                                      <div class="col-md-12">
                                          <input type="text" name="sample_label" class="form-control form-control-line" value="{{$data['sample']->samples}}" id="sample_label" disabled>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Date of Inoculation</label>
                                          <div class="col-md-12">
                                            
                                             <input type="text" name="inoculation_date" class="form-control form-control-line datepicker" value="{{$data['sample']->inoculation_date}}" disabled>
                                         </div>
                                      </div>
                                      <div class="col ">
                                          <label class="col-md-12">DX/FU/EQA</label>
                                          <div class="col-md-12"><input type="text" name="reason" class="form-control form-control-line" value="{{$data['sample']->reason}}" disabled>
                                         </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Initial Smear result</label>
                                          <div class="col-md-12">
                                             <input type="text" name="result" class="form-control form-control-line" value="{{$data['sample']->result}}" disabled>
                                         </div>
                                      </div>
                                      <div class="col ">
                                          <label class="col-md-12">Week reading</label>
                                          <div class="col-md-12">
                                             <input type="number" name="status" class="form-control form-control-line" value="{{$data['sample']->week_log}}" disabled>
                                         </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <label class="col-md-12">Result <span class="red">*</span> </label>
                                          <div class="col-md-12">
                                            <input type="hidden" name="week" value="{{$data['sample']->status}}">
                                            <select name="result" class="form-control form-control-line test_reason" id="lj_result" required>
                                              <option value="">--Select--</option>
                                              @foreach ($data["dp"] as $key => $dp)
                                               <option value="{{$dp}}" {{ $data['sample']->lj_result === $dp ? 'selected' : '' }}>{{$dp}}</option>
                                              @endforeach
                                            </select>
                                         </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hide" id="detail_div">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-md-12">ID  test</label>

                                            <div class="col-md-8">
                                               <input type="hidden" name="is_pos" value="0" id="is_pos" required>
                                               <select name="test_id" class="form-control form-control-line test_reason" id="test_id" required>
                                                 <option value="">--Select--</option>
                                                 <option value="Positive" @if(!empty($data['sample']->test_id)) @if($data['sample']->test_id == 'Positive')selected @endif @endif >Positive</option>
                                                 <option value="Negative"@if(!empty($data['sample']->test_id)) @if($data['sample']->test_id == 'Negative')selected @endif @endif

                                                 >Negative</option>
                                                 <option value="Invalid"@if(!empty($data['sample']->test_id)) @if($data['sample']->test_id == 'Invalid')selected @endif @endif
                                                 >Invalid</option>
                                                 <option value="Not required"@if(!empty($data['sample']->test_id)) @if($data['sample']->test_id == 'Not required')selected @endif @endif
                                                 >Not required</option>
                                               </select>
                                           </div>
                                           <input style="float: right;margin-top: -7%;" type="button" class="btn btn-info btn-sm" id="idsubmit" name="idsubmit" value="Update ID"/>

                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Smear from culture </label>
                                            <div class="col-md-8">
                                               <select name="culture_smear" class="form-control form-control-line test_reason" id="culture_smear" required>
                                                 <option value="">--Select--</option>
                                                 <option value="Positive"@if(!empty($data['sample']->culture_smear)) @if($data['sample']->culture_smear == 'Positive')selected @endif @endif
                                                 >Positive</option>
                                                 <option value="Cord factor positive"@if(!empty($data['sample']->culture_smear)) @if($data['sample']->culture_smear == 'Cord factor positive')selected @endif @endif
                                                 >Cord factor positive</option>
                                                 <option value="No cord factor positive"@if(!empty($data['sample']->culture_smear)) @if($data['sample']->culture_smear == 'No cord factor positive')selected @endif @endif
                                                 >No cord factor positive</option>
												 <option value="Negative"@if(!empty($data['sample']->culture_smear)) @if($data['sample']->culture_smear == 'Negative')selected @endif @endif
                                                 >Negative</option>
                                                 <option value="Not required"@if(!empty($data['sample']->culture_smear)) @if($data['sample']->culture_smear == 'Not required')selected @endif @endif
                                                 >Not required</option>
												
                                               </select>
                                           </div>

                                              <input style="float: right;margin-top: -7%;" type="button" class="btn btn-info btn-sm" id="smearsubmit" name="smearsubmit" value="Update Smear"/>
                                        </div>
                                    </div>
                                    <div class="row">

                                      <?php if(!empty($data['sample']->test_id ) && !empty($data['sample']->culture_smear )){ ?>

                                        <div class="col ">
                                            <label class="col-md-12">Final result</label>
                                            <div class="col-md-12">
                                               <select name="final_result" class="form-control form-control-line test_reason" id="final_result" required>
                                                 <option value="">--Select--</option>
                                                 <!-- <option value="Positive">Positive</option>
                                                 <option value="Negative">Negative</option>
                                                 <option value="Contamination">Contamination</option>
                                                 <option value="NTM">NTM</option> -->

                                                 <option value="Negative">Negative</option>
                                                 <option value="1+">1+</option>
                                                 <option value="2+">2+</option>
                                                 <option value="3+">3+</option>
                                                 <option value="Contaminated">Contaminated</option>
                                                 <option value="NTM">NTM</option>
                                                 <!--<option value="Mixed Culture">Mixed Culture</option>-->
                                                 <option value="Other Result">Other Result</option>
                                               </select>
                                           </div>
                                           <p id="er_id" style="color:red;"></p>
                                        </div>

<?php } ?>



                                        <div class="col hide" id="other_result">
                                            <label class="col-md-12">Enter Details </label>
                                            <div class="col-md-12">
                                               <input type="text" name="other_result"  class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col hide" id="species">
                                            <label class="col-md-12">Species name </label>
                                            <div class="col-md-12">
                                               <input type="text" name="species"  class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-md-12">Date of LJ result  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text" name="lj_result_date" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line datepicker" id="lj_result_date" required>
                                           </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="moreSample"></div>


                    <div class="row">
                        <div class="col-12">
                            <input id ="lj_butt" type="submit" name="lj_main" class="btn btn-info" value="Submit"/>
                        </div>

                    </div>
                </form>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">  </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>


<script>
$(document).ready(function(){
  $("#ljreporting").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
  //Confirm ok submit
	$('#lj_result').change( function(e) {
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
                            $('#lj_butt').prop("type", "button");
                            e. preventDefault(); 							
                            
						}else{
							$('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#lj_butt').prop("type", "submit");
							//$("#nxtconfirm").text("OK");
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		
	});
});//document ready

$(function(){
  $("#final_result").change(function(){
      var _sample = $("#final_result").val();
      if(_sample=='Other Result'){
        $("#other_result").removeClass("hide");
        document.getElementById("other_result").setAttribute("required","required");

      }else{
        $("#other_result").addClass("hide");
        document.getElementById("other_result").removeAttribute("required","required");
      }
  });
  $("#final_result").change(function(){
      var _sample = $("#final_result").val();
      if(_sample=='NTM'){
        $("#species").removeClass("hide");
        document.getElementById("species").setAttribute("required","required");

      }else{
        $("#species").addClass("hide");
        document.getElementById("species").removeAttribute("required","required");
      }
  });

  function lj_result_details() { //alert($("#lj_result").val());
      $("#lj_butt").attr("disabled",false);
      var $select = $("#lj_result");
      if( $select.val()=="POS" || $select.val()=="NEG" || $select.val()=="CONTA" || $select.val()=="NTM"){ //alert("if");
          $("#detail_div").show();
          $("#lj_butt").attr("disabled",true);
          $("#is_pos").val(1);
      }else{  //alert("else");
          $("#detail_div").hide();
          $("#is_pos").val(0);
		  if( $select.val()=="" || $select.val()==null){
			  $("#lj_butt").attr("disabled",true);
		  }else{
			  $("#lj_butt").attr("disabled",false);
		  }
      }
  }

  $(document).ready(lj_result_details);
  $("#lj_result").change(lj_result_details);
  
  
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
});
</script>


<script>

  $(document).ready(function(){

    $("#idsubmit").click(function(){

    var test_id=$("#test_id").val();
    // alert(test_id)
      err=0;
    if(test_id == '' || test_id ==null){
      err++;
    }

    if(err == 0){

      $("#idsubmit").prop("type","submit");
    }else{
       $("#idsubmit").prop("type","button");
    }

    });


        $("#smearsubmit").click(function(){

    var culture_smear=$("#culture_smear").val();
    // alert(test_id)
      errr=0;
    if(culture_smear == '' || culture_smear ==null){
      // alert(culture_smear)
      errr++;
    }

    if(errr == 0){

      $("#smearsubmit").prop("type","submit");
    }else{
       $("#smearsubmit").prop("type","button");
    }

    });


  });

</script>

<script type="text/javascript">

$(document).ready(function(){
		 
	
$("#final_result").change(function(){ //alert();
var final_result=$("#final_result").val();
er=0;

if(final_result == '' || final_result == null){
  $("#er_id").html("Please Specify Some Result");
  er++;
}else{
  $("#er_id").html("");
}

if($("#lj_result_date").val()==null || $("#lj_result_date").val()==""){
	er++;  
}else{
	er=0;
}

if(er == 0){
  $("#lj_butt").attr("disabled",false);
}else{
  $("#lj_butt").attr("disabled",true);
}



});



  if($("#lj_result_date").val()==null ||$("#lj_result_date").val()==""){
	 $("#lj_butt").attr("disabled",true);  
  }/*else{
	 $("#lj_butt").attr("disabled",false);
  }*/
  
$("#lj_result_date").change(function(){ //alert($("#lj_result_date").val());
	  if($("#lj_result_date").val()==null ||$("#lj_result_date").val()==""){
		 $("#lj_butt").attr("disabled",true);  
	  }else{
		 $("#lj_butt").attr("disabled",false);
	  }
});

});

</script>


@endsection
