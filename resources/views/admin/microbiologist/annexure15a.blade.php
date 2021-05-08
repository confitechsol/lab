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
                      <h3 class="text-themecolor m-b-0 m-t-0">Annexure 15A</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/microbiologist/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>
              @if($errors->any())
              <div class="modal fade" id="open_message" role="dialog" >
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button id="close_err" type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Alert</h4>
                      </div>

                        <div class="modal-body">
                          <div class="alert alert-danger"><p id="show"></p></div>
                        </div>  

                    </div>
                   </div>
              </div>
              <script type="text/javascript">
                var show_err='{{$errors->first()}}';
                $('#show').text(show_err);
                $('#open_message').modal('show');
                $('#close_err').click(function(){
                  $('#open_message').modal('hide');
                  location.reload();

                });

                $('#open_message').modal({
                backdrop: 'static',
                keyboard: false
            })
              </script>      
              @endif
              @include('admin/status_popup/current_status_modal')          

                <div class="row">
                    
					<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 " >
					<!-- Pradip -->
					<div class="card" >            
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                              
                                <div class="scroll-table scroll-table-micro" >
                                  
                                  <table>
                                    <tr>
                                      <td>
                                      <meta name="csrf-token" content="{{ csrf_token() }}">
                                      <input type="text" name="enrollment_no" id="enrollment_no"  placeholder="Search enrol. no from db" class="form-control" />
                                      </td>									  
                                    </tr>
                                    </table>

                                    <table id="example1" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th >Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Patient Name </th>
											  <th>Test Requested</th>
											  <th>Reason for Test</th>
											  <th>Test To  Review</th>
											  <!--/ Draft Result</th>-->
                                              <!--<th>Interim</th>-->
											  <th>Generate Form-15A</th>
                        <th>Add Test</th>
											  <th>Referal Facility</th>
                                              <th>Sample type /No. of Samples</th>
											  <th>Date of Receipt</th>
											  <th>Current Status</th>
											  <!--<th>Choose Drugs</th>
                                              <th>Next Step</th>--->
											  
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr class="sel">
                                                    <td class="hide"></td>
                                                    <td></td>
                                                    <td></td>
													<td></td>
													<td></td>
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


      



 

 
 <div class="modal fade micro_log" id="myModalForm15A" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Microbiologist</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result15A">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId1" id="enrollId15A" value="">
                <input type="hidden" name="sample" id="sampleID15A" value="">
                <input type="hidden" class="service1_class" name="service1" id="service15A" value="">                
                <input type="hidden" name="bwm_status" id="bwm_status15A" value="0">
				        <input type="hidden" name="lpa_tag" id="tag15A" value="">
                <input type="hidden" name="rec_flag" id="rec_flag" value="">
                <input type="hidden" name="drug_name" id="drug_name" value=""> 
                <input type="hidden" name="no_sample" class="form-control form-control-line" value="0" id="no_sample15A">
                <input type="hidden" name="nextStep" class="form-control form-control-line" value="Print Form-15A" id="nextStep15A">


                
				<label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <input type="text" readonly class="form-control form-control-line sampleId" name="sampleid1" id="sampleid15A">
                   </div>
                <br>
                <!--<label class="col-md-12 group-sample-detail"><h5>Detail:</h5></label>
                <div class="col-md-12 group-sample-detail">
                   <input type="text" class="form-control form-control-line sampleId" name="detail" id="detail15A">
               </div>
                <br>---->
				<div style="display:none;">
                <label class="col-md-12"><h5>Remark:</h5></label>
                <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="remark" id="remark15A" maxlength="250">
               </div>
			   </div>
                <br>
                  
                <div class="">
				 <input type="checkbox"  name="print15A" id="print15A15A" value="true" style="visibility:hidden;position:absolute " checked="checked">
               <!---<div id="microscopy_review_logic">
                        <label class="col-md-12"><h5>Print 15A form : </h5></label>
                        <div class="col-md-12">
                            <input type="checkbox" onclick="test(this);"  name="print15A" id="print15A">
                        </div>
                    </div>---->

                    <div id="microscopy_review_logic_disabled15A">
                        <div class="col-md-12">
                            <h5 class="text-danger small samplecontext">Sample has no enrolment. Please enroll to print Form 15A</h5>
                        </div>
                    </div>

                </div>

               

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok15A" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>

 <div class="modal fade micro_log" id="myModalAddtest" role="dialog"  id="confirmDelete">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Annexure 15a &nbsp;&nbsp;ADD TEST</h4>
      </div>

       <form class="form-horizontal form-material" action="{{ url('annexure15astore') }}" method="post" enctype='multipart/form-data' id="cbnaat_result_add">
                   <div class="alert alert-danger"><h4></h4></div>                  
          <div class="modal-body">

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="enrollId1" id="enrollId1Add" value="">
              <input type="hidden" name="sample" id="sampleIDAdd" value="">
              <input type="hidden" name="lpa_tag" id="lpa_tagAdd" value="">
              <input type="hidden" class="service1_class" name="service1" id="service1Add" value="">
              <input type="hidden" name="bwm_status" id="bwm_statusAdd" value="">
               <input type="hidden" name="no_sample" class="form-control form-control-line" value="" id="no_sample_add">
              <input type="hidden" name="oldSampleNo" id="oldSampleNo" value="">
              <input type="hidden" name="oldSampleID" id="oldSampleID" value="">
              <input type="hidden" name="nextStep" id="nextStepADD" value="Send Sample">
               <input type="hidden" name="rec_flag" id="recFlagID" value="">               
               <input type="hidden" name="third_onwards_afb_second_onwards_lcdst" id="third_onwards_afb_second_onwards_lcdst" value="0">       
               <input type="hidden" name="first_time_another_sample" id="first_time_another_sample" value="0">
              <label class="col-md-12"><h5>Sample ID:</h5></label>
                  <div class="col-md-12">
                     <input type="text" readonly class="form-control form-control-line sampleId" name="sampleid1" id="sampleid1">
                 </div>
              <br>
      
      <label class="col-md-12"><h5>Choose Sample:<span class="red">*</span></h5></label>
                  <div class="col-md-12">
                      <select class="form-control form-control-line" name="choose_sample" id="choose_sample">                            
                          <option value="1" selected>With Same Sample</option>
                          <option value="2">With Another Sample</option>
                      </select>
                 </div> 
                 <br>
              
              <label class="col-md-12 "><h5>Sample Send To:<span class="red">*</span></h5></label>
                   <div class="col-md-12">
                       <select class="form-control form-control-line sampleId " name="sentstep[]" value="" id="sentstepadd" >
                          @foreach($data['sendtolist'] as $sendtodata)
            <option value="{{ $sendtodata->test_id }}" data-tag="{{ $sendtodata->tag_name }}">{{ $sendtodata->test_name }}</option>
            @endforeach						
                       </select>
                  </div>
                 <br>
         
       <label class="col-md-12 "><h5>Add Test:<span class="red">*</span></h5></label>
                   <div class="col-md-12 row ajax_addtest_list">
        
         </div>
                 <br>   
         
               <!--<div class="disp_dst_drug_section">--->              
                  
         <div class="col-md-12 row ajax_druglist">
          
        </div>
                   <!--<div class="drug_section_data row"></div>--->
        <!--</div>-->
                       
                 <br>
                            </div>
          <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
            <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
            <button type="button" class="pull-right btn btn-primary btn-md" id="confirmokadd" >Ok</button>
          </div>

    </form>
    </div>
  </div>
</div>

<script>

function openCbnaatFormAddtest(enroll_id, sample_id, service, sample_ids,rec_flag){ //alert(rec_flag);
    //console.log("sample_ids", sample_ids.split(','));	
	$('#choose_sample').find('option:first').attr('selected', 'selected');
	$('.alert-danger').hide();
  $("#enrollId1Add").val(enroll_id);
	$("#sampleIDAdd").val(sample_id);	
  $("#service1Add").val(service);
	$("#recFlagID").val(rec_flag);
	$("#bwm_statusAdd").val(0);
	$("#no_sample_add").val(0);
	$(".sampleId").val(sample_ids);//set input type test
	$("#oldSampleNo").val(sample_ids);
	$("#oldSampleID").val(sample_id);
	$('#confirmokadd').prop('disabled', true);
	$('.dst_drugs_lc_section').hide();
	$('.dst_drugs_lj_section').hide();
	
    //$("#sample-id").val(sample_ids);
    
	//DST Drugs ajax
	$.ajax({
          url: "{{url('get_add_dst_drugs')}}"+'/'+enroll_id+'/'+service,
          type:"GET",
          processData: false,
          contentType: false,
          dataType : "html",		  
          success: function(data) {
              console.log(data);
              $(".ajax_druglist").html(data);
          },
          error: function() {
            console.log("err")
        }
      });
	  
	//DST Drugs ajax
	$.ajax({
          url: "{{url('get_add_test_list')}}"+'/'+enroll_id,
          type:"GET",
          processData: false,
          contentType: false,
          dataType : "html",
          success: function(data){
              console.log(data);
              $(".ajax_addtest_list").html(data);
          },
          error: function() {
            console.log("err")
        }
      });
	  
	//existing service ids
	$.ajax({
      url:"{{ url('get_existing_service_ids') }}"+'/'+enroll_id,
      method:"GET",
	  dataType:"JSON",
	  async: true,
      success:function(response){
           console.log("service ids"+response);

           var len = 0;
			if(response!= null){
				len = response.length;
			}
			//alert(len);
          $(".dst_drugs_lc_section").hide();
		    $(".dst_drugs_lj_section").hide();   

            if(len > 0){

				    $(".dst_drugs_lc_section").hide();
		         $(".dst_drugs_lj_section").hide();

          $.each(response, function (key, val) {
            
              /* $(".dst_drugs_lc_section").hide();
                $(".dst_drugs_lj_section").hide(); */ 

            if(val==21){ //alert(val);
            $(".dst_drugs_lc_section").show();
            }
            if(val==22){ //alert(val);
            //alert(e);
            $("div .ajax_druglist > .dst_drugs_lj_section").show();
            //break;
            }if(val==21 && val==22){ //alert(val);
                $(".dst_drugs_lc_section").show();
              $(".dst_drugs_lj_section").show();
            }				   
          });

		    }else{
          //alert('test');
				 $(".dst_drugs_lc_section").hide();
				 $(".dst_drugs_lj_section").hide();
			}
		   
		},
          error: function() {
            console.log("err");
			$(".dst_drugs_lc_section").hide();
				 $(".dst_drugs_lj_section").hide();
        }

    });
	  ///////////////////////////

    $('#myModalAddtest').modal('toggle');
 }

 $(document).on('change', '.addtest_array', function() {	   
        //alert(this.value);        
		 var enroll_id=$("#enrollId1Add").val();
		$.ajax({
				  url: "{{url('check_for_request_service')}}"+'/'+enroll_id,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					  
                        if(response==0){
							$('.alert-danger').show();
							$('.alert-danger').html("Please add atleast one test through test request interface");
							$('#confirmokadd').prop('disabled', true);
                            
                            
						}else{
							$('.alert-danger').hide();
							if($("#sentstepadd").val()!=""){
							  $('#confirmokadd').prop('disabled', false);	
							}
							
                        }
				  },
				failure: function(response){
					console.log("err")
				}
		});
      	if(this.value==21)
        {
			  $(".dst_drugs_lc_section").show();
		}
		if(this.value==22)
        {
			  $(".dst_drugs_lj_section").show();
		}
    if(this.value == 16)
    {
      $('.dst_drugs_lc_z_section').show();
    }
		
		 //on unchecked
        var ischecked= $(this).is(':checked');
		if(!ischecked){
		  //alert('uncheckd ' + $(this).val());
		   //$(this).prop('checked', false);
		   if($(this).val()==21){ //alert("here");
			$(".dst_drugs_lc_section").hide();   
		   }
		   if($(this).val()==22){ //alert("here");
			$(".dst_drugs_lj_section").hide();   
		   }
       if($(this).val()==16){ //alert("here");
			$(".dst_drugs_lc_z_section").hide();   
		   }
		}		
    });

 $('#confirmokadd').click(function(){ //alert("button click");
       
       var sentStep=$("#sentstepadd").val();
       var enroll_id=$("#enrollId1Add").val();	   
       var tag=$("#lpa_tagAdd").val();
       var rec_flag=$("#recFlagID").val();

       var tag=$("#sentstepadd").find(':selected').data('tag');

       if(tag != "")
       {
        $("#lpa_tagAdd").val(tag);

       } else {
        tag="NULL";
       }
  
       
       
       if(sentStep==3){//If decontamination
         $('#confirmokadd').prop('disabled', false);
         var form = $(document).find('form#cbnaat_result_add');
             form.submit();
       }else{
      $.ajax({
            url: "{{url('check_for_sample_exist')}}"+'/'+enroll_id+'/'+sentStep+'/'+tag+'/'+rec_flag,
            type:"GET",
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
              console.log(response);
              
                          if(response==0){
                              $('.alert-danger').hide();							
                var form = $(document).find('form#cbnaat_result_add');
                              form.submit();                            
              }else{
                $('.alert-danger').show();
                $('.alert-danger').html("Selected test already considered in the same enrollment");
                $('#confirmokadd').prop('disabled', true);							
                          }
            },
          failure: function(response){
            console.log("err")
          }
      });
      }
         
     });
     


  //choose sample onchange event
  $('#choose_sample').change(function(){
		if($(this).val()==2){//alert("with another sample");
		    $(".sampleId").val("");
			var enroll_id=$("#enrollId1Add").val();
			
			$.ajax({
				  url: "{{url('check_for_storage')}}"+'/'+enroll_id,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					  var len = 0;
                        if(response['items'] != null){
                            len = response['items'].length;
                        }
                        //alert(len);
                        
                        if(len > 0){
                            // data already exist 
                            for(var i=0; i<len; i++){
									//alert(response['items'][i].sample_id);
									 $('.alert-danger').hide();
									var sample_id = response['items'][i].sample_id;
									var sample_label = response['items'][i].sample_label;
								   
									$("#sampleIDAdd").val(sample_id);
									$(".sampleId").val(sample_label);
                  $('#service1Add').val('16');
                  //$('#recFlagID').val('0');

                  $('#choose_sample > option').removeAttr('selected');
                  document.getElementById('choose_sample').selectedIndex = 1;
                  //$('option:selected', $(this)).attr('selected', true);

                  /* If first time 2nd sample has choosen */
                  $('#first_time_another_sample').val('1');
                  $('#third_onwards_afb_second_onwards_lcdst').val('1');
                  /*  end  */

                              $.ajax({
                                      url: "{{ url('check_for_lcdst_sample_exist') }}"+'/'+enroll_id,
                                      type:"GET",
                                      processData: false,
                                      contentType: false,
                                      dataType: 'json',
                                      success: function(result){
                                        console.log(result.data.service_id);
                                        if(result.result)
                                        {                                          
                                          $('#recFlagID').val(result.data.rec_flag);                                          
                                        }
                                      }
                                  }); 

									if(typeof $("#sentstepadd option:selected").val()==='undefined'){
										$('#confirmokadd').prop('disabled', true);
									}else{
									   $('#confirmokadd').prop('disabled', false);
									}
								
                            }
                            
						}else{
                                    $('.alert-danger').show();
									$('.alert-danger').html("No Sample Found in the Storage");
									//alert($("#sentstepadd option:selected").val());
									$('#confirmokadd').prop('disabled', true);
                        }
				  },
				failure: function(response){
					console.log("err")
				}
			});


		}else{  //alert("with same sample");
			$(".sampleId").val($("#oldSampleNo").val());//set input type test
			$("#sampleIDAdd").val($("#oldSampleID").val());//set input type test
			
			$('.alert-danger').hide();
			//alert($("#sentstepadd option:selected").val());
			if(typeof $("#sentstepadd option:selected").val()==='undefined'){
				$('#confirmokadd').prop('disabled', true);
			}else{
			   $('#confirmokadd').prop('disabled', false);
			}
		}
	});

  $('#sentstepadd').change(function(){ //alert($(this).find(':selected').data('tag'));
	   var sentStep=$(this).val();
	   var enroll_id=$("#enrollId1Add").val();
     var sample_id = $('#sampleIDAdd').val();
	   var rec_flag=$("#recFlagID").val();

	   var tag=$("#sentstepadd").find(':selected').data('tag');

       if(tag != "")
       {
        $("#lpa_tagAdd").val(tag);

       } else {
        tag="NULL";
       }

	   if(sentStep==3){//If decontamination
		   $('#confirmokadd').prop('disabled', false);
	   }else{
		$.ajax({
				  url: "{{url('check_for_sample_exist')}}"+'/'+enroll_id+'/'+sentStep+'/'+tag+'/'+rec_flag,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);					  
                        if(response==0){
                            $('.alert-danger').hide();							
							//var sList = "";
							//$('input[type=checkbox]').each(function () {
							$("input[name='addtest[]']").each(function () {	
							 if(this.checked){ //alert("checked");
								//$('#confirmokadd').prop('disabled', false);	 
							 }
								//sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
							});
							//console.log (sList);

             if($('#choose_sample').val() == '2')
             {
              $.ajax({
                            url: "{{url('check_for_storage')}}"+'/'+enroll_id,
                            type:"GET",
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(response){
                              console.log(response);
                              var len = 0;
                                          if(response['items'] != null){
                                              len = response['items'].length;
                                          }
                                          //alert(len);
                                          
                                          if(len > 0){
                                              // data already exist
                                              $('#service1Add').val('16');
                                              $('#confirmokadd').prop('disabled', false);
                                              
                              }else{
                                                      $('.alert-danger').show();
                                    $('.alert-danger').html("No Sample Found in the Storage");
                                    //alert($("#sentstepadd option:selected").val());
                                    $('#confirmokadd').prop('disabled', true);
                                          }
                            },
                          failure: function(response){
                            console.log("err")
                          }
                        });        
             } else {

              $('#confirmokadd').prop('disabled', false);

             }
                            
						}else{
                      //alert(sentStep);
                      if( sentStep == '21' )
                      {
                        $('#confirmokadd').prop('disabled', false);
                        $.ajax({
                                      url: "{{ url('check_for_lcdst_sample_exist') }}"+'/'+enroll_id,
                                      type:"GET",
                                      processData: false,
                                      contentType: false,
                                      dataType: 'json',
                                      success: function(result){
                                        console.log(result.data.service_id);
                                        if(result.result)
                                        {
                                          $('#service1Add').val(result.data.service_id);
                                          $('#recFlagID').val(result.data.rec_flag);
                                          $('#third_onwards_afb_second_onwards_lcdst').val(result.data.third_onwards_afb_second_onwards_lcdst);
                                        }
                                      }
                                  });             
                      
                      
                      } else if( sentStep == '22' ) { 

                      $.ajax({
                                    url: "{{ url('check_for_ljdst_sample_exist') }}"+'/'+enroll_id,
                                    type:"GET",
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    success: function(result){
                                      console.log(result.data.service_id);
                                      if(result.result)
                                      {
                                        //$('#service1Add').val(result.data.service_id);
                                        $('#recFlagID').val(result.data.rec_flag);
                                        $('#third_onwards_afb_second_onwards_lcdst').val(result.data.third_onwards_afb_second_onwards_lcdst);
                                      }
                                    }
                                }); 

                            //alert(sentStep);
                            $('#confirmokadd').prop('disabled', false);
                            //$('#third_onwards_afb_second_onwards_lcdst').val(0);

                      } else {                               

                        $('.alert-danger').show();
                        $('.alert-danger').html("Selected test already considered in the same enrollment");
                        $('#confirmokadd').prop('disabled', true);

                      }						
							
                  }
				  },
				failure: function(response){
					console.log("err")
				}
		});
		}
  });

function resetfunction() {
            document.getElementById("cbnaat_resultrt").reset();
        }
// incorporated by niladri

function test(e){
  var next_step = $('#nextStep').val();
  var enable;
if($("#print15A").is(':checked')){
 // console.log($("#print15A").is(':checked'))
enable = true;
}else{
  enable = false;
}


if( next_step === 'Print Form-15A' ){
if(enable == true){
  $("#confirmok").prop('disabled',false);
}else if(enable == false){

 $("#confirmok").prop('disabled',true);
}

}
}




$( document ).ready(function(){

$("#myModal")
    .on("show.bs.modal", function(){
      clear_submit_inputs();
    });

    $(document).ready(function(){
        clear_submit_inputs();
    });

    function clear_submit_inputs(){
        $('#nextStep,#sentstep,#detail,#remark')
            .val('');

        $('.group-sample-sent-to,.group-sample-detail,.group-sample-remark,.group-sample-form15a')
            .hide();

        $('#print15A').prop('checked', false);

        validate_fields();
    }





    function validate_fields(){

        var enable = false;
        var next_step = $('#nextStep').val();

        if( next_step === 'Send Sample' ){
            var val = $('#sentstep').val();
            if(val !== '' && val.length >= 1){
                enable = true;
                for( var i in val ){
                    if( !val.hasOwnProperty(i) ) continue;
                    if( val[i] === '' ){
                        enable = false;
                        break;
                    }
                }
            }

        } else if( next_step === 'Print Form-15A' ){
           

            // incorporated by niladri 


	// if( $('#detail').val() === '' && $('#remark').val() === '' ){
 //            enable = false;
	// 		 } else {
	 			enable = false;
	// 		  }
			
        } else if( next_step === 'Request for Retest' ){
			 enable = true;
        } 

      /*  if( $('#detail').val() === '' || $('#remark').val() === '' ){
            enable = false;
        }
		*/

        $('#confirmok').prop('disabled', !enable);
    }









    $('#sentstep,#detail,#remark').change( validate_fields );

    $('#nextStep').change(function(){
        
        var next_step = $('#nextStep').val();

        $('#sentstep,#detail,#remark').val('');
        $('.group-sample-sent-to,.group-sample-detail,.group-sample-remark,.group-sample-form15a').hide();

        if( next_step === 'Send Sample' ){
            $('.group-sample-sent-to').show();
            $('.group-sample-detail,.group-sample-remark').show();

        }else if( next_step === 'Print Form-15A' ){
           $('.group-sample-form15a').show();
            $('.group-sample-detail,.group-sample-remark').show();

        }else if( next_step === 'Request for Retest' ){
          //  $('.group-sample-form15a').show();
            $('.group-sample-detail,.group-sample-remark').show();
        }

        validate_fields();
    });

});






$(function(){
	
	

  $('#nextStep').on('change', function (e) {
    var service = $("#nextStep").val();
    var no_sample = $("#no_sample").val();
    var service1 = $("#service1").val();

    if(service=='Request for Retest' && no_sample=='0' && service1=='26'){
      alert("standby sample not available");
      $("#nextStep").val('').trigger('change');
    }
   });

  // $('#example1').DataTable( {
  //      "order": [[ 0, "desc" ]],
  //      dom: 'Bfrtip',
  //       buttons: [
  //          // 'excel', 'pdf',
  //          'excel'
  //       ]
  //  } );




    $('#confirmDelete').on('show.bs.modal', function (e) {

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
  });

  /* Form confirm (yes/ok) handler, submits form*/
  $('#confirm1').click( function(){

    var form = $(document).find('form#cbnaat_result1');
      form.submit();
    // console.log( $('#cbnaat_result').serialize() );
    // var data = $('#cbnaat_result').serialize();
    // $.post(window.location.replace("{{ url('/PCR') }}"), data);
    //form.submit();
  });


  
  // $('#confirm').click( function(){
  //   alert('sgds');
  //   var form = $(document).find('form#cbnaat_result');
  //     form.submit();
  //
  // });
});
   
function openForm15AGenerate(enroll_id, sample_ids, service, sample, bwm_status, no, reg_by, tag, rec_flag, drug_name){
  //console.log(enroll_id, sample_ids, service);
  //console.log(sample_ids);
  //alert(reg_by);
  $("#enrollId15A").val(enroll_id);
  $("#service15A").val(service);
  $("#bwm_status15A").val(bwm_status);
  $("#sampleID15A").val(sample_ids);
  $("#sampleid15A").val(sample);//set input value
  $('#no_sample15A').val(no);
  $('#tag15A').val(tag);
  $('#rec_flag').val(rec_flag);

  if(drug_name == "")
  {
    $('#drug_name').val(0);
  } else {
    $('#drug_name').val(drug_name);
  }
 
  $('#print15A15A').prop('checked', true);

  if( reg_by ){
      //$('#microscopy_review_logic').show();
      $('#microscopy_review_logic_disabled15A').hide();
      $('#confirmok15A').prop('disabled',false);
  }else{  
      //$('#microscopy_review_logic').hide();
      $('#microscopy_review_logic_disabled15A').show();
      $('#confirmok15A').prop('disabled',true);
  }

  $('#myModalForm15A').modal('toggle');
  

  $("#confirmok15A").click(function(){
	  //alert($('input[name=print15A]:checked').length);
	   if($('input[name=print15A]:checked').length > 0){
        var sample = $("#sampleID15A").val();        
        //var detail = $("#detail2").val();
        var remark = $("#remark15A").val();
        var tag = $('#tag15A').val();
        var service_id = $('#service15A').val();
        var drug_name = $('#drug_name').val();
        var form = $(document).find('form#cbnaat_result15A');
        form.submit();
        //var url = '{{ url("/pdfview", "id") }}';

        if(drug_name == "")
        {
          drug_name = 0;
        }

        var url = '{{ route("pdfview", [ "id" => "sampleId", "service_id" => "serviceId", "tag" => "stag", "recFlag" => "rec_flag", "drug_name" => "drug_name" ] ) }}';
        
        // url = url.replace('id', sample+'/1');
        url = url.replace('sampleId',sample);
        url = url.replace('serviceId',service_id);
        url = url.replace('stag',tag);
        url = url.replace('rec_flag',rec_flag);
        url = url.replace('drug_name',drug_name);

       // url = url.replace('detail', detail);
       // url = url.replace('remark', remark);
        // url = url.replace('type', '1');

         window.open(url, '_blank');
	   }
    
       var form = $(document).find('form#cbnaat_result15A');
       form.submit(); 
   });

  
 }
 
 function deactivate_inputs(selectors, $parent){
     $parent = (typeof $parent === 'undefined') ? $parent = $('body') : $parent;
     for( var i in selectors ){
         if( !selectors.hasOwnProperty(i) ) continue;
         $parent.find( selectors[i] )
             .prop('disabled', true)
             .val('');
     }

 }

 function activate_inputs(selectors, $parent){
     $parent = (typeof $parent === 'undefined') ? $parent = $('body') : $parent;
     for( var i in selectors ){
         if( !selectors.hasOwnProperty(i) ) continue;
         $parent.find( selectors[i] )
             .prop('disabled', false);
     }

 }

</script>
<script>
// function displayform15(service){
//     // alert(service)
//
//     if(service == 1 || service == 2){
//
//     $("#microscopy_review_logic").hide();
//     }else{
//     $("#microscopy_review_logic").show();
//     }
//
// }


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
    $('#example1').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
		processing: true,
		language: {
            loadingRecords: '&nbsp;',
            //processing: 'Loading...'
            processing: '<div class="spinner"></div>'
        } , 
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
	   ajax: {
			    url: "{{url('ajax_annexure15A_list')}}",			  
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
		 columns: [
		   { data: 'ID',className: "hide_column"},
		   { data: 'enroll_id'},
		   { data: 'sample_id'},
		   { data: 'patient_name' },
		   { data: 'test_requested' },
		   { data: 'reason_for_test' },
		   { data: 'test_review' },
		   { data: 'generate15a' },		 
       { data: 'add_test' }, 
		   { data: 'referal_facility' },
		   { data: 'sample_type' },
		   { data: 'date_of_receipt' },
		   { data: 'current_status' },
		],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_microbilogist_current_'+today+'',
                 exportOptions: {
                    columns: [  1, 2, 3,4,5,6,7]
                }
            }
        ],
        order: [[ 1, 'desc' ]],
		columnDefs: [
			  { targets: [1,2,3,4,5,6,7,8,9,10,11], orderable: false }
		  ]
    });

    $('#enrollment_no').keyup(function () { //alert();
        dataTable.draw();
    });
} );
</script>


<script>

function getdetailsform(id,enrolls_id,sample_label){
$("#det_modal > tbody").empty();
var sample_id=id;
var enroll_id=enrolls_id;
var label=sample_label;
// alert(label);
// alert(sample_label)
    $.ajax({

      url:"{{ url('/searchform/get_current_status') }}",
      method:"POST",
      data:{"sample_id":sample_id,'enroll_id':enroll_id,"label":label,"_token":"{{ csrf_token() }}"},
      dataType:"JSON",
      success:function(response){
        console.log(response);
        $.each(response, function (key, val) {

// $(".display_status_material").append("<div><span>Type of Test :</span><br/><span>Reported On :</span><br/><span>Released On :</span><br/><span>Current Status :</span><br/><br/></div>");
var type_test=val.service_name;
var tag=val.tag;
if(tag!= ''){

  type_test=type_test+" - "+tag;

}
var status=val.status;
var rptnewDate;
var rlsnewDate;
var reported_date=val.reported_dt;
var released_date=val.released_dt;

// if(reported_date == '' || reported_date == null){
// rptnewDate='';
//
// }else{
//   var rptdateAr = reported_date.split('-');
//   var rptnewDate = rptdateAr[1] + '-' + rptdateAr[2] + '-' + rptdateAr[0];
// }


// if(released_date == '' || released_date == null){
//
// rlsnewDate='';
// }else{
//   var rlsdateAr = released_date.split('-');
//  rlsnewDate = rlsdateAr[1] + '-' + rlsdateAr[2] + '-' + rlsdateAr[0];
// }







// alert(rptnewDate);

var teststatus='';
if(status == 0){

  teststatus="Done";

}else{
  teststatus="In Progress";
}

$("#sample_name").text(val.sample_label);

$("#det_modal > tbody").append("<tr><td>"+type_test+"</td><td>"+reported_date+"</td><td >"+released_date+"</td><td>"+teststatus+"</td><td>"+val.tested_by+"</td><td>"+val.comments+"</td></tr>");

});

$("#progressdetailpopup").modal('toggle');

}

    });




}

</script>

<script>
$(".sel").click(function(){
$("tr").removeClass("activa");
$(this).addClass("activa");
});
</script>


<script>

$(".sel2").click(function(){
  $("tr").removeClass("history-activa");
   $(this).addClass("history-activa");

});


    $('.result-with-remarks').click(function(e){
        e.preventDefault();
        var $btn = $(this);
        var url = $btn.attr('href');
        var remarks = $.trim( prompt('Provide Remarks') );
        if( !remarks.length ) return;
        window.open( url + '&remarks=' + encodeURIComponent(remarks) );
    });

  </script>

         


               

@endsection
