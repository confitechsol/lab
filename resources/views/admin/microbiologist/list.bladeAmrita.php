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
.hide_column {
    display : none;
}
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Microbiologist</h3>

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
              @include('admin/resultpopup/cbnaat_editResult')
              @include('admin/resultpopup/editresults')
              @include('admin/resultpopup/microscopy_editResult')
              @include('admin/resultpopup/lc_editResult')
              @include('admin/resultpopup/lj_editResult')
              @include('admin/resultpopup/lc_dst_editResult')
              @include('admin/resultpopup/ljdst1_editResult')
              @include('admin/resultpopup/ljdst2_editResult')
              <div class="row">
                  <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                  <!---<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                      <style>
                                      table, th, td {
                                          border: 1px solid black;
                                      }
                                      </style>
                                      <table style="width:100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Test Name</th>
                                              <th>Tests to be reviewed</th>
                                              <th>Tests reviewed</th>

                                            </tr>

                                        </thead>
                                        <tbody>

                                         @foreach ($data['ret'] as $key=> $values)
                                          <tr>
                                            <td class="hide">{{$values['todo']->ID}}</td>
                                            <td>{{$values['todo']->name}}</td>

                                            <td>
                                                  @if($values['todo'])
                                                    {{$values['todo']->cnt}}
                                                  @else
                                                    0
                                                  @endif

                                            </td>
                                            <td>
                                                   @if($values['done'])
                                                      {{$values['done']->cnt}}
                                                   @else
                                                     0
                                                   @endif
                                            </td>
                                         </tr>
                                         @endforeach

                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>---->

                </div>




              

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12">
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="scroll-table scroll-table-micro" >

                                    <table id="example1" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th >Enrol. ID /
                                              Sample ID</th>
                                              <th>Patient Name </th>
											  <th>Test Requested</th>
											  <th>Reason for Test</th>
											  <th>Test To Review/ Interim Result</th>
											  <th class="noExport">View / Edit Result</th>
											  <th class="noExport">Request for Retest</th>
											  <th class="noExport">Add Another Test</th>
											  <th class="noExport">Result to Nikshay</th>
											  <th>Referal Facility</th>
											  <th>Sample type / No. of Samples </th>
											  <th>Date of Receipt</th>
											  <th class="noExport">Current Status</th>                                            
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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>


        <div class="modal fade" id="myModal_drug" role="dialog"  id="confirmDelete">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Microbiologist</h4>
                </div>

                 <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="drugform">
                          @if(count($errors))
                            @foreach ($errors->all() as $error)
                               <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                           @endforeach
                         @endif
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="enrollId1" id="enrollIddrug" value="">
                        <input type="hidden" name="service1" id="servicedrug" value="">
                        <input type="hidden" name="type" id="typedrug" value="drug">


                        <label class="col-md-12"><h5>Sample ID:</h5></label>
                            <div class="col-md-12">
                              <input type="text" name="sampleid1" class="form-control form-control-line sampleId"  id="sample-iddrugs">

                           </div>
                        <br>

                        <div class="row">
                          @foreach ($data['services'] as $key => $services)
                          <div class="col-md-4 top5px">
                            <input class="service_array"
                              value="{{$services['id']}}"
                              @if(isset($data['_reqservices']) && is_array($data['_reqservices']) && in_array($services['id'], $data['_reqservices']))
                                checked=""
                              @endif
                              name="services[]"
                              type="checkbox">{{$services['name']}}
                          </div>
                          @endforeach
                        </div>

                        <div class="dst_drugs hide">
                          <div class="row  ">

                            <label class="col-md-12">DST Drugs</label>
                            <?php foreach ($data['dstdrugs'] as $key=> $drugs){ ?>
                            <div class="col-md-4 ">
                              <input class="drugs_array" id="drug_list_name"
                                value="<?php echo $drugs['id']; ?>"<?php
                                if(!empty($data['sample'][0]['attributes']['drug_ids'])){
                                $drugs1=$data['sample'][0]['attributes']['drug_ids'];
                                $exploded_drugs=explode(',',$drugs1);
                                foreach ($exploded_drugs as $key => $exploded_drugs_val) {
                                if($drugs['id'] == $exploded_drugs_val){

                                  echo "checked";
                                }

                                }
                              }
                                 ?>
                                name="drugs[]"
                                type="checkbox">{{$drugs['name']}}
                            </div>
                          <?php } ?>

                          </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="pull-right btn btn-primary btn-md" id="confirmdrugs" data-dismiss="modal">Ok</button>
                    </div>

              </form>
              </div>
            </div>
         </div>






<div class="modal fade" id="myModal1" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Microbiologist</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result1">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollId" value="">
                <input type="hidden" name="service" id="service" value="">
                <input type="hidden" name="type" id="type" value="1">


                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                      <input type="text" name="sampleid" class="form-control form-control-line sampleId"  id="sample-id">

                   </div>
                <br>
                <label class="col-md-12"></label>
                    <div class="col-md-12">
                       <div id="resultData"></div>
                   </div>
				   
                <br>
            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <!-- <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button> -->
              <button type="button" class="pull-right btn btn-primary btn-md hide" id="confirm1" data-dismiss="modal">Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<div class="modal fade micro_log" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Microbiologist</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result2">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId1" id="enrollId2" value="">
                 <input type="hidden" name="sample" id="sampleID2" value="">
                <input type="hidden" class="service1_class" name="service1" id="service2" value="">
                <input type="hidden" name="bwm_status" id="bwm_status2" value="">
                 <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample2">


                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid1" id="sampleid2"></select>
                   </div>
                <br>
                <!-- <label class="col-md-12"><h5>Service ID:</h5></label>
                    <div class="col-md-12">
                       <input type="number" class="form-control form-control-line sampleId" name="service" id="service" disabled>

                       </input>
                   </div>
                <br> -->

                <label class="col-md-12"><h5>Next Step:</h5></label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line sampleId" name="nextStep" id="nextStep">
                            <option value="">--- Select Action ---</option>
                            <!-- <option value="Push to  Nikshay">Push to  Nikshay</option> -->
                            <option value="Send Sample">Send Sample</option>
                            <option value="Print Form-15A">Print Form-15A</option>
                            <option value="Request for Retest">Request for Retest</option>
                        </select>
                   </div>


                     <label class="col-md-12 group-sample-sent-to"><h5>Sample sent to:</h5></label>
                     <div class="col-md-12 group-sample-sent-to">
                         <!--<select class="form-control form-control-line sampleId multi-select-xl" name="sentstep[]" value="" id="sentstep" multiple>--->
						 <select class="form-control form-control-line sampleId " name="sentstep[]" value="" id="sentstep" >
                            <!--<option value="">--- Choose Step ---</option>-->
                            <option value="1">Zn Microscopy</option>
                            <option value="2">Fm Microscopy</option>
                            <option value="3">Decontamination</option>
                            <option value="4">CBNAAT</option>
                            <option value="8-1">LPA 1st Line - DNA Extraction</option>
                            <option value="12-1">LPA 1st Line - PCR</option>
                            <option value="14-1">LPA 1st Line - Hybridization</option>
                            <option value="15-1">LPA 1st Line - LPA Interpretation</option>
                            <option value="8-2">LPA 2nd Line - DNA Extraction</option>
                            <option value="12-2">LPA 2nd Line - PCR</option>
                            <option value="14-2">LPA 2nd Line - Hybridization</option>
                            <option value="15-2">LPA 2nd Line - LPA Interpretation</option>
                            <option value="16-LC">AFB Culture Inoculation - LC</option>
                            <option value="16-LJ">AFB Culture Inoculation - LJ</option>
                            <option value="16">AFB Culture Innoculation(LC & LJ)</option>
							<option value="21">LC- DST- Inoculation</option>
							<option value="20">LJ culture reporting</option>
                            <option value="11">Storage</option>
                         </select>
                    </div>
                   <br>
                <label class="col-md-12 group-sample-detail"><h5>Detail:</h5></label>
                <div class="col-md-12 group-sample-detail">
                   <input type="text" class="form-control form-control-line sampleId" name="detail" id="detail2">
               </div>
                <br>
                <label class="col-md-12 group-sample-remark"><h5>Remark:</h5></label>
                <div class="col-md-12 group-sample-remark">
                   <input type="text" class="form-control form-control-line sampleId" name="remark" id="remark2">
               </div>
                <br>
                   <!--pradip-->
                <br>
                <div class="group-sample-form15a">
                    <div id="microscopy_review_logic">
                        <label class="col-md-12"><h5>Print 15A form : </h5></label>
                        <div class="col-md-12">
                            <input type="checkbox" onclick="test(this);"  name="print15A" id="print15A2">
                        </div>
                    </div>

                    <div id="microscopy_review_logic_disabled">
                        <div class="col-md-12">
                            <h5 class="text-danger small samplecontext">Sample has no enrolment. Please enroll to print Form 15A</h5>
                        </div>
                    </div>

                </div>

                <div id="reason" class="hide">
                    <label class="col-md-12"><h5>Reason for sending sample to BWM</h5></label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line sampleId" name="reason_bwm" id="reason_bwm2">
                            <option value="">--select--</option>
                            <option value="Sample was drained during processes ">Sample was drained during processes </option>
                            <option value="Sample fall down ">Sample fall down </option>
                            <option value="Tube breakage during centrifugation"> Tube breakage during centrifugation</option>
                            <option value="Sample cross contaminated during processing ">Sample cross contaminated during processing </option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                 <div class="col hide" id="reason_other">
                     <label class="col-md-12"><h5>Reason for sending sample to BWM : Other </h5></label>
                     <div class="col-md-12">
                        <input type="text" class="form-control form-control-line" name="reason_other2">
                    </div>
                 </div>

<?php //dd($data['dp_result_value']); ?>

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok2" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
 
 <div class="modal fade micro_log" id="myModalRetest" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="resetfunction()">&times;</button>
          <h4 class="modal-title">Microbiologist&nbsp;&nbsp;&nbsp;Retest</h4>
        </div>
		
         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_resultrt">
                
                       <div class="alert alert-danger"><h4></h4></div>                  
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId1" id="enrollIdrt" value="">
                <input type="hidden" name="sample" id="sampleIDrt" value="">
                <input type="hidden" name="lpa_tag" id="lpa_tagrt" value="">
				<input type="hidden" name="lj_lc_tag" id="lj_lc_tagrt" value="">
                <input type="hidden" class="service1_class" name="service1" id="servicert" value="">
                <input type="hidden" name="retest_type" id="retest_type" value="true">
                <input type="hidden" name="bwm_status" id="bwm_statusrt" value="">
                <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_samplert">
				 <input type="hidden" name="rec_flag" id="rec_flag_rt" value="">


                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid1" id="sampleidrt"></select>
                   </div>
                <br>
                <!-- <label class="col-md-12"><h5>Service ID:</h5></label>
                    <div class="col-md-12">
                       <input type="number" class="form-control form-control-line sampleId" name="service" id="service" disabled>

                       </input>
                   </div>
                <br> -->

                <label class="col-md-12"><h5>Request for Retest:<span class="red">*</span></h5></label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line sampleId" name="nextStep" id="nextSteprt">
                            <option value="">--- Select Option ---</option>
                            <!-- <option value="Push to  Nikshay">Push to  Nikshay</option> -->
                            <option value="Request for Retest" retest="1">With Same Sample</option>
                            <option value="Request for Retest" retest="2">With Another Sample</option>
                        </select>
                   </div>


                    
                   <br>
				   <div id="send_to_div">
				   <label class="col-md-12"><h5>Send To:<span class="red">*</span></h5></label>
                    <div class="col-md-12">
                        <select class="form-control form-control-line" name="retest_sent_to" id="retest_sent_to">
                            
                        </select>
                   </div>
				   </div>
                   <br>
                   <div id="drg"></div>
                   <br>
                   <div id="micro_comm"></div>
                   <!--pradip-->
                

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button class="btn btn-default" data-dismiss="modal" onclick="resetfunction()">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirmokrt" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>



<div class="modal fade micro_log" id="myModalNikshay" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Microbiologist</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist/sendnikshay') }}" method="post" enctype='multipart/form-data' id="send_to_nikshay_form">
                   <div class="alert alert-danger testReqDanger hide"><h4></h4></div>
				   <div class="alert alert-danger nikshayDanger hide"><h4></h4></div>
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="tsl_id" id="tsl_id" value="">
                <!--<input type="hidden" name="reqServ_service_id" id="reqServ_service_id" value="">--->
               

                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <input type="text" readonly class="form-control form-control-line" name="sampleid1" id="sampleid_nikshay">
                   </div>
                <br/>                       
                
				<label class="col-md-12"><h5>Enrolment ID:</h5></label>
                    <div class="col-md-12">
                       <input type="text" readonly class="form-control form-control-line" name="enrolid1" id="enrolid_nikshay">
                   </div>
                <br/> 
				
            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirmok_nikshay" >Ok</button>
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
          <h4 class="modal-title">Microbiologist &nbsp;&nbsp;ADD TEST</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result_add">
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
                <label class="col-md-12"><h5>Remark:</h5></label>
                <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="remark" id="remark15A">
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
<script>
$(document).ready(function(){
  $("#cbnaat_resultrt,#cbnaat_result_add,#lc_editResult").on("submit",function(){
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
	//alert(($('#sentstep').val()));
	// $('#myModal').on('shown.bs.modal', function (e) {
	//     // alert('modal opened');
  //       //  alert($('.samplecontext').html());
  //       if(($('.samplecontext').is(":visible") && $('.samplecontext').html()=='Sample has no enrolment. Please enroll to print Form 15A') && ($('#sentstep').val() =='')){
  //           // alert('if');
  //           $('#confirmok').attr("disabled", true);
  //       }else{  //alert('else');
  //          $('#confirmok').attr("disabled",false);
  //       }
  //       $('#sentstep').change(function(){
  //         if(($('.samplecontext').html()=='Sample has no enrolment. Please enroll to print Form 15A') && ($('#sentstep').val() =='')){
  //             $('#confirmok').attr("disabled", true);
  //         }else{
  //              $('#confirmok').attr("disabled",false);
  //         }
  //       });
  // });
  // $(".modal").on("hidden.bs.modal", function(){
  //
  //   //location.reload(true);
  // });



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




function editResultForm(sample_id, enroll_id, sample_label,service,tag,druglist,drugid){
  $(function(){

      //alert( service );

    if(service==23){
      $("#enrollIdljdst2").val(enroll_id);
      $("#sampleidljdst2").val(sample_label);
      drugs=druglist.split(',');
      drugs_id=drugid.split(',');
      var text="";
       for(i=0;i<drugs.length;i++){
            text=text+" <div ><div class='col drug_names_ljdst'>"+
                "<label class='col-md-12'>"+drugs[i]+"</label>"+
                "<input type='hidden' name='drugname2[]' value='"+drugs[i]+"'' />"+
                "<div class='col-md-12'>"+
                   "<select  name='drugvalue2[]' id='drug"+i+"' class='form-control form-control-line' >"+
                     "<option value=''>--Select Result--</option>"+
                     "@foreach ($data['dp_result'] as $key => $result)"+
                      "<option value='{{$data['dp_result_value'][$key]}}'>{{$result}}</option>"+
                     "@endforeach"+
                   "</select>"+
               "</div>"+
            "</div>";
       }
      document.getElementById("drug_names_ljdst2").innerHTML=text;
      $(".datepi").datepicker({
          dateFormat: "dd/mm/yyyy"
      }).datepicker("setDate", "0");
      $.ajax({
            url: "{{url('edit_result_lj_dst2')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {
                //$("#ict").val(JSON.parse(data).ict);
            },
            error: function() {
              console.log("err")
          }
        });
		// var urll="{{url('edit_result_lj_dst2')}}"+'/'+sample_id;
		//alert(urll);
			
        $.ajax({
              url: "{{url('edit_result_lj_dst2')}}"+'/'+sample_id,
              type:"GET",
              processData: false,
              contentType: false,
              dataType : "html",
              success: function(data) {
				  //console.log(data);
                    var result = JSON.parse(data);
					//console.log(data);
                    var resultDrug = JSON.parse(result.drug_reading);
					console.log(resultDrug);
                    var drug = resultDrug.dil_4;
                    for(var i=0; i<drug.length; i++){
                      console.log(drug[i].value);
                      $("#drug"+i).val(drug[i].value);
                    }

              },
              error: function() {
                console.log("err");
            }
          });
      $('#ljdst2_editResult').modal('toggle');
    }
    else if(service==22){
      $("#enrollIdljdst1").val(enroll_id);
      $("#sampleidljdst1").val(sample_label);
      drugs=druglist.split(',');
      drugs_id=drugid.split(',');
      var text="";
       for(i=0;i<drugs.length;i++){
            text=text+" <div ><div class='col drug_names_ljdst'>"+
                "<label class='col-md-12'>"+drugs[i]+"</label>"+
                "<input type='hidden' name='drugname[]' value='"+drugs[i]+"'' />"+
                "<div class='col-md-12'>"+
                   "<select  name='drugvalue[]' id='ljdst"+i+"' class='form-control form-control-line' >"+
                     "<option value=''>--Select Result--</option>"+
                     "@foreach ($data['dp_result'] as $key => $result)"+
                      "<option value='{{$data['dp_result_value'][$key]}}'>{{$result}}</option>"+
                     "@endforeach"+
                   "</select>"+
               "</div>"+
            "</div>";
       }
      document.getElementById("drug_names_ljdst").innerHTML=text;
      $(".datepi").datepicker({
          dateFormat: "dd/mm/yyyy"
      }).datepicker("setDate", "0");
      $.ajax({
            url: "{{url('edit_result_lj_dst1')}}"+'/'+sample_id+'/'+service,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {
                var result = JSON.parse(data);
                var resultDrug = JSON.parse(result.drug_reading);
                  var drug = resultDrug.dil_4;
                  for(var i=0; i<drug.length; i++){
                    console.log(drug[i].value);
                    //$("#drug"+i).val(drug[i].value);
                    // alert(drug[i].value);
                   
                    //$("#"+i).val('');
                    $("#ljdst"+i).val(drug[i].value);
                  }

            },
            error: function() {
              console.log("err");
          }
        });
      $('#ljdst1_editResult').modal('toggle');
    }
    else if(service==21){

      $("#enrollIdlcdst").val(enroll_id);
      $("#sampleidlcdst").val(sample_label);
      drugs=druglist.split(',');
      drugs_id=drugid.split(',');
      var text="";
       for(i=0;i<drugs.length;i++){
            text=text+" <div ><div class='col'>"+
                "<label class='col-md-12'>"+drugs[i]+"</label>"+
                "<div class='col-md-12'>"+
                   "<select name='"+drugs[i]+"' id='"+i+"' class='form-control form-control-line' >"+
                     "<option value=''>--Select Result--</option>"+
                     "@foreach ($data['dp_result'] as $key => $result)"+
                      "<option value='{{$result}}'>{{$result}}</option>"+
                     "@endforeach"+
                   "</select>"+
               "</div>"+
            "</div>";
       }

      document.getElementById("drug_names").innerHTML=text;
      $(".datepi").datepicker({
          dateFormat: "dd/mm/yyyy"
      }).datepicker("setDate", "0");
      $.ajax({
            url: "{{url('edit_result_lc_dst')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {
                result = JSON.parse(data);
                console.log(result);
                for(var i=0; i<result.length; i++){
                  $("#"+i).val(result[i].result);
                }

            },
            error: function() {
              console.log("err")
          }
        });
      $('#lc_dst_editResult').modal('toggle');

    }
    else if(service==20){

      $("#enrollIdlj").val(enroll_id);
      $("#sampleidlj").val(sample_label);
      $.ajax({
            url: "{{url('edit_result_lj')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {
				 if(JSON.parse(data).species !== ''){
					  // alert(JSON.parse(data).species)
					  $("#speciesinptxt").val(JSON.parse(data).species);
					  $("#speciesdiv").removeClass("hide");
				  }else{
					$("#speciesinptxt").val(null);
					$("#speciesdiv").addClass("hide");
				  }
				 if(JSON.parse(data).other_result !== ''){
				  // alert(JSON.parse(data).other_result)
				  $("#otherresultinptxt").val(JSON.parse(data).other_result);
				  $("#other_result_div").removeClass("hide");
				}else{
					$("#otherresultinptxt").val(null);
					$("#other_result_div").addClass("hide");
				  }
                $("#test_id").val(JSON.parse(data).test_id);
                $("#culture_smear_lj").val(JSON.parse(data).culture_smear);
                $("#final_result_lj").val(JSON.parse(data).final_result);
            },
            error: function() {
              console.log("err")
          }
        });
      $('#lj_editResult').modal('toggle');

    }
    else if(service==17){

      $("#enrollIdlc").val(enroll_id);
      $("#sampleidlc").val(sample_label);
      $(".datep").datepicker({
          dateFormat: "dd/mm/yyyy"
      }).datepicker("setDate", "0");

      $.ajax({
            url: "{{url('edit_result_lc')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {
            if(JSON.parse(data).species !== ''){
              // alert(JSON.parse(data).species)
              $("#speciesinp").val(JSON.parse(data).species);
              $("#species").removeClass("hide");
            }else{
            $("#speciesinp").val(null);
            $("#species").addClass("hide");
          }
		     if(JSON.parse(data).other_result !== ''){
              // alert(JSON.parse(data).other_result)
              $("#otherresultinp").val(JSON.parse(data).other_result);
              $("#other_result").removeClass("hide");
            }else{
				$("#otherresultinp").val(null);
				$("#other_result").addClass("hide");
			  }
                $("#ict").val(JSON.parse(data).ict);
                $("#culture_smear").val(JSON.parse(data).culture_smear);
                $("#bhi").val(JSON.parse(data).bhi);
                $("#resultlc").val(JSON.parse(data).result);
            },
            error: function() {
              console.log("err")
          }
        });

      $('#lc_editResult').modal('toggle');

    }
    else if(service==1 || service==2){

      $("#enrollIdmicro").val(enroll_id);
      $("#sampleidmicro").val(sample_label);
      $("#service_micro").val(service);


      if(service=='1' || service == 1)
      {
        $('#result_microscopy option').remove();
        $('#result_microscopy').append($('<option>', {
            text : '--Select--',
            value : ''
        }));
        $('#result_microscopy').append($('<option>', {
             text : 'Negative/Not Seen',
			 value : 'Negative/Not Seen'
        }));
		
		$('#result_microscopy').append($('<option>', {
               text : 'Positive',
               value : 'Positive'
           }));
		  
		   $('#result_microscopy').append($('<option>', {
                text : '1+positive',
                value : '1+positive'
            }));
          $('#result_microscopy').append($('<option>', {
                text : '2+positive',
                value : '2+positive'
            }));
          $('#result_microscopy').append($('<option>', {
                text : '3+positive',
                value : '3+positive'
          }));
		   		  
        $('#result_microscopy').append($('<option>', {
              text : 'Sc 1',
              value : 'Sc 1'
          }));

        $('#result_microscopy').append($('<option>', {
              text : 'Sc 2',
              value : 'Sc 2'
          }));
        $('#result_microscopy').append($('<option>', {
              text : 'Sc 3',
              value : 'Sc 3'
          }));
        $('#result_microscopy').append($('<option>', {
              text : 'Sc 4',
              value : 'Sc 4'
        }));
        $('#result_microscopy').append($('<option>', {
              text : 'Sc 5',
              value : 'Sc 5'
          }));

        $('#result_microscopy').append($('<option>', {
              text : 'Sc 6',
              value : 'Sc 6'
          }));
        $('#result_microscopy').append($('<option>', {
              text : 'Sc 7',
              value : 'Sc 7'
          }));
         $('#result_microscopy').append($('<option>', {
              text : 'Sc 8',
              value : 'Sc 8'
          }));
          $('#result_microscopy').append($('<option>', {
                text : 'Sc 9',
                value : 'Sc 9'
            }));

         
         /* $('#result_microscopy').append($('<option>', {
                text : 'NA',
                value : 'NA'
          })); */
      }
      else
      {
        $('#result_microscopy option').remove();
        $('#result_microscopy').append($('<option>', {
            text : '--Select--',
            value : ''
        }));
        $('#result_microscopy').append($('<option>', {
            text : 'Negative/Not Seen',
            value : 'Negative/Not Seen'
        }));
		 $('#result_microscopy').append($('<option>', {
               text : 'Positive',
               value : 'Positive'
           }));
        $('#result_microscopy').append($('<option>', {
              text : '1+positive',
              value : '1+positive'
          }));
        $('#result_microscopy').append($('<option>', {
              text : '2+positive',
              value : '2+positive'
          }));
         $('#result_microscopy').append($('<option>', {
              text : '3+positive',
              value : '3+positive'
          }));
		    $('#result_microscopy').append($('<option>', {
          text : 'Sc 1',
          value : 'Sc 1'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 2',
          value : 'Sc 2'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 3',
          value : 'Sc 3'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 4',
          value : 'Sc 4'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 5',
          value : 'Sc 5'
      }));
	    $('#result_microscopy').append($('<option>', {
          text : 'Sc 6',
          value : 'Sc 6'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 7',
          value : 'Sc 7'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 8',
          value : 'Sc8'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 9',
          value : 'Sc 9'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 10',
          value : 'Sc 10'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 11',
          value : 'Sc 11'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 12',
          value : 'Sc 12'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 13',
          value : 'Sc 13'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 14',
          value : 'Sc 14'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 15',
          value : 'Sc 15'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 16',
          value : 'Sc 16'
      }));
		$('#result_microscopy').append($('<option>', {
          text : 'Sc 17',
          value : 'Sc 17'
      }));
	   $('#result_microscopy').append($('<option>', {
          text : 'Sc 18',
          value : 'Sc 18'
      }));
  
     $('#result_microscopy').append($('<option>', {
          text : 'Sc 19',
          value : 'Sc 19'
      }));
	  
	      $('#result_microscopy').append($('<option>', {
               text : 'NA',
               value : 'NA'
           }));
      }



      $.ajax({
            url: "{{url('edit_result_micro')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,
            dataType : "html",
            success: function(data) {


                $("#result_microscopy").val(JSON.parse(data).result);
            },
            error: function() {
              console.log("err")
          }
        });
      $('#microscopy_editResult').modal('toggle');

    }
    else if(service==4){ //alert();
      $("#enrollId").val(enroll_id);
      $("#sampleid").val(sample_label);





      $.ajax({
                beforeSend:function(){
                $.ajax({
                  url:"{{ url('/getequipmentlist') }}",
                  type:"GET",
                  data:{"name_cate":'CBNAAT Machines'},
                  dataType:"json",
                  success:function(resp){
                  console.log(resp);
                  var html2='';
                  html2 +='<option value="">--Select--</option>';
                  $.each(resp, function(index,val){
                      var dropdown_values=val.name;

                        html2 += '<option value="'+dropdown_values+'">'+dropdown_values+'</option>';

                  });
                  console.log(html2);
                $("#equipment_name").html(html2);

                  }

                });
            },
            url: "{{url('editResultCbnaat')}}"+'/'+sample_id,
            type:"GET",
            processData: false,
            contentType: false,

            dataType : "html",
            success: function(data) {
                $("#mtb").val(JSON.parse(data).result_MTB);
                $("#error_cbnaat").val(JSON.parse(data).error);
                $("#rif").val(JSON.parse(data).result_RIF);
                $("#equipment_name").val(JSON.parse(data).cbnaat_equipment_name);
                if(JSON.parse(data).result_MTB == 'Error'){
                    document.getElementById("rif").setAttribute("disabled","disabled");
                    $("#error_cbnaat").attr("required",true);
                    $('#error').removeClass('hide');
                }else{
                    document.getElementById("rif").removeAttribute("disabled","disabled");
                    $('#error').addClass('hide');
                  $("#error_cbnaat").attr("required",false);
                }
            },
            error: function() {
              console.log("err")
          }
        });
      $("#mtb").change(function(){
          var _sample = $("#mtb").val();
          if(_sample == 'Error'){
            		$('#error').removeClass('hide');
              document.getElementById("rif").value = "";
              document.getElementById("rif").setAttribute("disabled","disabled");
              $("#error_cbnaat").attr("required",true);
          }else{
            		$('#error').addClass('hide');
              document.getElementById("rif").removeAttribute("disabled","disabled");
              $("#error_cbnaat").attr("required",false);
          }
      });
      // $("#confirm").change(function(){
      //     var _sample = $("#mtb").val();
      //     if(_sample == 'Error'){
      //         document.getElementById("rif").removeAttribute("disabled","disabled");
      //     }
      // });


        $('#cbnaatresultpopupDiv').modal('toggle');

    } else if(service==15) {//LPA 1 st line / 2nd line

        $("#enrollIdlpa").val(enroll_id);
        $("#sampleidlpa").val(sample_label);
        $("#tag").val(tag);

        var _sample = $("#tag").val(); //alert(_sample);

        if (_sample == '1st line LPA'|| _sample == '1st Line LPA') {
            $("#secondLPA").addClass("hide");
            $(".slpa").removeAttr("required");
			$("#quinolone").val($("#quinolone option:first").val());
			$('#quinolone').attr('disabled',true);
			$('#quinolone').removeAttr('required');
			
			$("#slid").val($("#slid option:first").val());
			$('#slid').attr('disabled',true);
			$('#slid').removeAttr('required');
           
            $("#mtb_result").change(function () { //alert();
                var _sample = $("#mtb_result").val();
                if (_sample == 'Invalid' || _sample == 'MTB not detected') {
                     $("#inh").val($("#inh option:first").val());
					 $('#inh').attr('disabled',true);
					 $('#inh').removeAttr('required');                     
					
					 $(".main_rif_val").val($(".main_rif_val option:first").val());
					 $('.main_rif_val').attr('disabled',true);
					 $('.main_rif_val').removeAttr('required');
                    
                } else {
					 $('#inh').attr('disabled',false);
					 $('.main_rif_val').attr('disabled',false);
					 $("#inh").prop('required',true);
					 $(".main_rif_val").prop('required',true);
                    
                }
            });

        } else if (_sample == '2nd line LPA'||_sample == '2nd Line LPA') {

             $("#firstLPA").addClass("hide");
             $(".flpa").removeAttr("required");
			 $("#inh").val($("#inh option:first").val());            
			 $('#inh').attr('disabled',true);
			 $('#inh').removeAttr('required');
			 
			
			 $(".main_rif_val").val($(".main_rif_val option:first").val());
			 $('.main_rif_val').attr('disabled',true);
			 $('.main_rif_val').removeAttr('required');
			 
            $("#mtb_result").change(function () {
                var _sample = $("#mtb_result").val();
                if (_sample == 'Invalid' || _sample == 'MTB not detected') {
					 $("#quinolone").val($("#quinolone option:first").val());                     
					 $('#quinolone').attr('disabled',true);
					 $('#quinolone').removeAttr('required');
                     
					 
					 $("#slid").val($("#slid option:first").val());
					 $('#slid').attr('disabled',true);
					 $('#slid').removeAttr('required');
                } else {
                     $('#quinolone').attr('disabled',false);
					 $('#quinolone').attr('disabled',false);
					 $("#slid").prop('required',true);
					 $("#slid").prop('required',true);
                }
            });
        }
        else {

            if (_sample == 'Invalid' || _sample == 'MTB not detected') {

                document.getElementById("quinolone").value = "";
                document.getElementById("slid").value = "";
                document.getElementById("inh").value = "";
                document.getElementById("quinolone").setAttribute("disabled", "disabled");
                document.getElementById("inh").setAttribute("disabled", "disabled");
                document.getElementById("slid").setAttribute("disabled", "disabled");
                document.getElementById("rif").value = "";
                document.getElementById("rif").setAttribute("disabled", "disabled");


            } else {
                document.getElementById("quinolone").removeAttribute("disabled", "disabled");
                document.getElementById("inh").removeAttribute("disabled", "disabled");
                document.getElementById("slid").removeAttribute("disabled", "disabled");
                document.getElementById("rif").removeAttribute("disabled", "disabled");
            }

            $("#mtb_result").change(function () {
                var _sample = $("#mtb_result").val();
                if (_sample == 'Invalid' || _sample == 'MTB not detected') {

                    document.getElementById("quinolone").value = "";
                    document.getElementById("slid").value = "";
                    document.getElementById("inh").value = "";
                    document.getElementById("quinolone").setAttribute("disabled", "disabled");
                    document.getElementById("inh").setAttribute("disabled", "disabled");
                    document.getElementById("slid").setAttribute("disabled", "disabled");
                    document.getElementById("rif").value = "";
                    document.getElementById("rif").setAttribute("disabled", "disabled");


                } else {
                    document.getElementById("quinolone").removeAttribute("disabled", "disabled");
                    document.getElementById("inh").removeAttribute("disabled", "disabled");
                    document.getElementById("slid").removeAttribute("disabled", "disabled");
                    document.getElementById("rif").removeAttribute("disabled", "disabled");
                }
            });
        }
        //alert(tag);
        $.ajax({
            url: "{{url('editResultLpa')}}" + '/' + sample_id + '/' + tag,
            type: "GET",
            processData: false,
            contentType: false,
            dataType: "html",
            success: function (data) {
                console.log(data);				
				//alert($.parseJSON(data).id);
                $("#RpoB").val(JSON.parse(data).RpoB);
                $("#wt1").val(JSON.parse(data).wt1);
                $("#wt2").val(JSON.parse(data).wt2);
                $("#wt3").val(JSON.parse(data).wt3);
                $("#wt4").val(JSON.parse(data).wt4);
                $("#wt5").val(JSON.parse(data).wt5);
                $("#wt6").val(JSON.parse(data).wt6);
                $("#wt7").val(JSON.parse(data).wt7);
                $("#wt8").val(JSON.parse(data).wt8);
                $("#mut1DS16V").val(JSON.parse(data).mut1DS16V);
                $("#mut2aH526Y").val(JSON.parse(data).mut2aH526Y);
                $("#mut2bH526D").val(JSON.parse(data).mut2bH526D);
                $("#mut3S531L").val(JSON.parse(data).mut3S531L);
                $("#katg").val(JSON.parse(data).katg);
                $("#wt1315").val(JSON.parse(data).wt1315);
                $("#mut1S315T1").val(JSON.parse(data).mut1S315T1);
                $("#mut2S315T2").val(JSON.parse(data).mut2S315T2);
                $("#inha").val(JSON.parse(data).inha);
                $("#wt1516").val(JSON.parse(data).wt1516);
                $("#wt28").val(JSON.parse(data).wt28);
                $("#mut1C15T").val(JSON.parse(data).mut1C15T);
                $("#mut2A16G").val(JSON.parse(data).mut2A16G);
                $("#mut3aT8C").val(JSON.parse(data).mut3aT8C);
                $("#mut3bT8A").val(JSON.parse(data).mut3bT8A);

                $("#gyra").val(JSON.parse(data).gyra);
                $("#wt18590").val(JSON.parse(data).wt18590);
                $("#wt28993").val(JSON.parse(data).wt28993);
                $("#wt39297").val(JSON.parse(data).wt39297);
                $("#mut1A90V").val(JSON.parse(data).mut1A90V);
                $("#mut2S91P").val(JSON.parse(data).mut2S91P);
                $("#mut3aD94A").val(JSON.parse(data).mut3aD94A);
                $("#mut3bD94N").val(JSON.parse(data).mut3bD94N);
                $("#mut3cD94G").val(JSON.parse(data).mut3cD94G);
                $("#mut3dD94H").val(JSON.parse(data).mut3dD94H);
                $("#gyrb").val(JSON.parse(data).gyrb);
                $("#wt1536541").val(JSON.parse(data).wt1536541);
                $("#mut1N538D").val(JSON.parse(data).mut1N538D);
                $("#mut2E540V").val(JSON.parse(data).mut2E540V);
                $("#rrs").val(JSON.parse(data).rrs);
                $("#wt1140102").val(JSON.parse(data).wt1140102);
                $("#wt21484").val(JSON.parse(data).wt21484);
                $("#mut1A1401G").val(JSON.parse(data).mut1A1401G);
                $("#mut2G1484T").val(JSON.parse(data).mut2G1484T);
                $("#eis").val(JSON.parse(data).eis);
                $("#wt137").val(JSON.parse(data).wt137);
                $("#wt2141210").val(JSON.parse(data).wt2141210);
                $("#wt32").val(JSON.parse(data).wt32);
                $("#mut1c14t").val(JSON.parse(data).mut1c14t);
                $("#type").val(JSON.parse(data).type);
                $("#type_direct").val(JSON.parse(data).type_direct);
                $("#type_indirect").val(JSON.parse(data).type_indirect);
				//alert(JSON.parse(data).mtb_result);
                $("#mtb_result").val(JSON.parse(data).mtb_result);
				//alert(JSON.parse(data).rif);
                if(JSON.parse(data).rif=='Detected')
				{
				  $('.main_rif_val option[value="Detected"]').attr('selected','selected');	
                 //$("#rif").val('5');
				}else if(JSON.parse(data).rif=='Not detected')
				{					
					$('.main_rif_val option[value="Not detected"]').attr('selected','selected');
                   //$("#rif").val('Not detected');
				}
				
                $("#inh").val(JSON.parse(data).inh);
                $("#quinolone").val(JSON.parse(data).quinolone);
                $("#slid").val(JSON.parse(data).slid);
				//alert(JSON.parse(data).tub_band);
                $("#tbu_band").val(JSON.parse(data).tub_band);
				$("#hid_final_interpretation").val(JSON.parse(data).nikshey_final_interpretation);
				//alert(JSON.parse(data).nikshey_final_interpretation);
				
                var _sample = $("#mtb_result").val();
				//alert(_sample);
                if (_sample == 'Invalid' || _sample == 'MTB not detected') { //alert();
                    //document.getElementById("quinolone").value = "";
                    //document.getElementById("slid").value = "";
                    //document.getElementById("inh").value = "";
                    document.getElementById("quinolone").setAttribute("disabled", "disabled");
                    document.getElementById("inh").setAttribute("disabled", "disabled");
                    document.getElementById("slid").setAttribute("disabled", "disabled");
                    //document.getElementById("rif").value = "";
                    document.getElementById("rif").setAttribute("disabled", "disabled");
                } else {
                    document.getElementById("quinolone").removeAttribute("disabled", "disabled");
                    document.getElementById("inh").removeAttribute("disabled", "disabled");
                    document.getElementById("slid").removeAttribute("disabled", "disabled");
                    document.getElementById("rif").removeAttribute("disabled", "disabled");
                }

            },
            error: function () {
                console.log("err");
            }
        });
        $('#lparesultpopupDiv').modal('toggle');
    }

  });
}


$(function(){
	
	$('#tbu_band').on('change', function (e) { //alert($(this).val());
		  if($(this).val()==0){//Absent
		  //alert($('#rif').find('option:first').val());
			   $('#mtb_result option[value="MTB not detected"]').attr('selected','selected');
			    
    			 $("#inh").val($("#inh option:first").val());
				 $('#inh').attr('disabled',true);
				 $('#inh').removeAttr('required');
				 
				 $(".main_rif_val").val($(".main_rif_val option:first").val());
				 $('.main_rif_val').attr('disabled',true);
				 $('.main_rif_val').removeAttr('required');
				 
				 $("#quinolone").val($("#quinolone option:first").val());
				$('#quinolone').attr('disabled',true);
				$('#quinolone').removeAttr('required');
				
				$("#slid").val($("#slid option:first").val());
				$('#slid').attr('disabled',true);
				$('#slid').removeAttr('required');

		  }
	});

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




  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

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


  $('#confirmdrugs').click( function(){
if($('input[name="services[]"]:checked').length > 0){
    var form = $(document).find('form#drugform');
      form.submit();
}

  });
  // $('#confirm').click( function(){
  //   alert('sgds');
  //   var form = $(document).find('form#cbnaat_result');
  //     form.submit();
  //
  // });
});


 function openCbnaatForm1(enroll_id, sample_id, service, sample_ids,tag_service_nm=null){
    //console.log("sample_ids", sample_ids.split(','));
    $("#enrollId").val(enroll_id);
    $("#service").val(service);
    $("#sample-id").val(sample_ids);

    // var sampleArray = sample_ids.split(',');
    // $('#sampleid option').remove();
    // $.each(sampleArray, function (i, item) {
    //     $('#sampleid').append($('<option>', {
    //         text : item
    //     }));
    // });

    //load data
    var details = service + '/' + sample_id + '/' + enroll_id+'/'+tag_service_nm;
	//var urlll="{{url('result')}}"+'/'+details;
   // alert(urlll);
	//console.log(urlll);
    $.ajax({
          url: "{{url('result')}}"+'/'+details,
          type:"GET",
          processData: false,
          contentType: false,
          dataType : "html",
          success: function(data) {

             // console.log(data);
              $("#resultData").html(data);
          },
          error: function() {
            console.log("err")
        }
      });

     
		
    $('#myModal1').modal('toggle');
 }
$('#myModalRetest').on('hide.bs.modal', function (e) { //alert();
       //$('#nextSteprt').prop('selectedIndex',1);
 });
 function openCbnaatFormRetest(enroll_id, sample_id, service, sample_ids,bwm_status,no_ssample,reg_by,tag,reg_flag){
  $('#drg').empty();
  $('.alert-danger').hide();
  $("#enrollIdrt").val(enroll_id);
  $("#servicert").val(service);
  $("#bwm_statusrt").val(bwm_status);
  $("#sampleIDrt").val(sample_id);
  $("#rec_flag_rt").val(reg_flag);
  
  if(service==17||service==21){
	  $("#lj_lc_tagrt").val("LC");
  }
  if(service==20||service==22){
	  $("#lj_lc_tagrt").val("LJ");
  }
  // alert(service);
  // $('#no_samplert').val(no);
  //alert(tag);
  if(service == 14||service == 15){
    $("#lpa_tagrt").val(tag);
  }
  if(service == 21 || service == 22){
    somethingChecked=false;
    $('#micro_comm').empty();
	 	 
    $(document).on('click','input[name="updated_drugs[]"]', function(){	 	  
      var err=0;
	   if($('#retest_sent_to').val() != '' || $('#retest_sent_to').val() != null)
	   {														
	      $('#confirmokrt').prop("disabled", !$('input[name="updated_drugs[]"]').is(":checked")?true:false);//if not checked
	  
	   }
      $('input[name="updated_drugs[]"]').each(function() {          		  
         if(!$(this).is(':checked')) { //alert("unchecked");
            err++;
			//total--;
          }
       });
	  
      if(err > 0){
        $('#micro_comm').html('<textarea id="microbio_comments" name="microbio_comments" rows="5" cols="5" placeholder="Provide some Comments that why you are unchecking the drugs" class="form-control " ></textarea>');
        $('#confirmokrt').prop('disabled', true);
	  }else{
        $('#micro_comm').empty();
		if($('#retest_sent_to').val() != '' || $('#retest_sent_to').val() != null){
		 $('#confirmokrt').prop('disabled', false);
		}
      }
});

    $.ajax({
     url:'{{ url("/get_drugs") }}',
     type:'GET',
     data:{'enroll_id':enroll_id,'service_id':service,'_token':'{{ csrf_token() }}'},
     success:function(response){
      // console.log(parse_Json);
      var parse_Json=$.parseJSON(response);
      // console.log(parse_Json)
      $('#drg').html('<h5>Selected Drugs</h5>')
      $.each(parse_Json,function(index,c){
      $('#drg').append('<input type="checkbox" class="ischecked" name="updated_drugs[]" value="'+c.id+'" checked/>'+c.name+'<br/>');
     });
     } 

    });

  }
var error_print=0;
  var sampleArray = sample_id.split(',');
  //console.log(sampleArray);
  $('#sampleidrt option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleidrt').append($('<option>', {
          text : item
      }));
  });

   
    $("#send_to_div").hide();
    $('#myModalRetest').modal('toggle');
 }
 
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
	   var rec_flag=$("#recFlagID").val();
	   if ($(this).find(':selected').data('tag').length != 0){
		   var tag=$(this).find(':selected').data('tag'); 
		   $("#lpa_tagAdd").val(tag);
	   }else{
		    var tag="NULL";
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
 
	
   $('#confirmokadd').click(function(){ //alert("button click");
       
	   var sentStep=$("#sentstepadd").val();
	   var enroll_id=$("#enrollId1Add").val();	   
	   var tag=$("#lpa_tagAdd").val();
	   var rec_flag=$("#recFlagID").val();
	   
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
   
    
	$('#myModalAddtest').on('hide.bs.modal', function (e) { //alert("modal close");
       $('#choose_sample').prop('selectedIndex',0);
	   $(".addtest_array:checkbox").prop('checked', false);
	   //$(".disp_dst_drug_section").hide();
	   $(".dst_drugs_lc_section").hide();
	   $(".dst_drugs_lj_section").hide();
	   $(".readonly_class_test").each(function() {
		  $(this).prop('checked', true);
		});
	   //$(".drugs_array:checkbox").prop('checked', false);
	   //$(".drugs_array:checkbox").prop('readonly', false);
    });
	
	
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
          url: "{{url('get_add_dst_drugs')}}"+'/'+enroll_id,
          type:"GET",
          processData: false,
          contentType: false,
          dataType : "html",		  
          success: function(data) {
              //console.log(data);
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
             // console.log(data);
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
			      $(".dst_drugs_lc_section").hide();
		          $(".dst_drugs_lj_section").hide(); 
				   if(val==21){ //alert(val);
					 $(".dst_drugs_lc_section").show();
				   }
				   else if(val==22){ //alert(val);
					 $(".dst_drugs_lj_section").show();
				   }else if(val==21 && val==22){ //alert(val);
				      $(".dst_drugs_lc_section").show();
					  $(".dst_drugs_lj_section").show();
				   }
				   else{
					    $(".dst_drugs_lc_section").hide();
						$(".dst_drugs_lj_section").hide();
				   }
				   
			   });
		    }else{
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
    
function openForm15AGenerate(enroll_id, sample_ids, service, sample, bwm_status, no, reg_by){
  //console.log(enroll_id, sample_ids, service);
  //console.log(sample_ids);
  //alert(reg_by);
  $("#enrollId15A").val(enroll_id);
  $("#service15A").val(service);
  $("#bwm_status15A").val(bwm_status);
  $("#sampleID15A").val(sample_ids);
  $("#sampleid15A").val(sample);//set input value
  $('#no_sample15A').val(no);
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
        var form = $(document).find('form#cbnaat_result15A');
        form.submit();
        var url = '{{ url("/pdfview", "id") }}';
        // url = url.replace('id', sample+'/1');
        url = url.replace('id',sample);
       // url = url.replace('detail', detail);
       // url = url.replace('remark', remark);
        // url = url.replace('type', '1');
         window.open(url, '_blank');
	   }
    
       var form = $(document).find('form#cbnaat_result15A');
       form.submit(); 
   });

  
 }
	
 function openCbnaatFormNikshay(tServiceLogID,enroll_id,sample_id,service_id,sample_no,enroll_no,tag,reqServ_service_id){    
    $("#sampleid_nikshay").val(sample_no);
    $("#enrolid_nikshay").val(enroll_no);
	$("#tsl_id").val(tServiceLogID);
	//$("#reqServ_service_id").val(reqServ_service_id);
	if(tag=='')
	{
		var tag=null;
	}else{
		var tag=tag;
	}
   //alert(tag);
	var nikshayresult;
    var testreqresult;
	$.when(
	//check for nikshay id
    $.ajax({
				  url: "{{url('check_for_nikshayid_exist')}}"+'/'+enroll_id,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					  nikshayresult=response;
                        /*if(response==1){
                            $('.alert-danger').hide();
							$('#confirmok_nikshay').prop('disabled', false);	
                            						
                            
						}else{
							$('.alert-danger').show();
							$('.alert-danger').html("Nikshay ID is not available of the selected enrolment");
							$('#confirmok_nikshay').prop('disabled', true);
                        }*/
				  },
				failure: function(response){
					console.log("err")
				}
		}),
    //Check for test request		
    $.ajax({
				  url: "{{url('check_for_test_request')}}"+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+reqServ_service_id,
				  type:"GET",
				  processData: false,
				  contentType: false,
				  dataType: 'json',
				  success: function(response){
					  console.log(response);
					    testreqresult=response;
                        /*if(response==1){
                            $('.alert-danger').hide();
							$('#confirmok_nikshay').prop('disabled', false);	
                            						
                            
						}else{
							$('.alert-danger').show();
							$('.alert-danger').html("Atleast one test reqiuest is required for send the test result to nikshay");
							$('#confirmok_nikshay').prop('disabled', true);
                        }*/
				  },
				failure: function(response){
					console.log("err")
				}
		})
   ).then(function() {
		//$('#result1').html(testreqresult);
		//$('#result2').html(nikshayresult);
		//alert(testreqresult);
		//alert(nikshayresult);
		if(nikshayresult==0 && testreqresult==0){
			$('.testReqDanger').show();
			$('.testReqDanger').html("Selected Test Result is not available in Test Requests.");
			$('.nikshayDanger').show();
			$('.nikshayDanger').html("Nikshay ID is not available of the selected enrolment");
			$('#confirmok_nikshay').prop('disabled', true);										
			
		}else if(nikshayresult==1 && testreqresult==0){
			$('.testReqDanger').show();
			$('.testReqDanger').html("Selected Test Result is not available in Test Requests.");
			$('.nikshayDanger').hide();			
			$('#confirmok_nikshay').prop('disabled', true);	
			
		}else if(nikshayresult==0 && testreqresult==1){
			$('.testReqDanger').hide();			
			$('.nikshayDanger').show();
			$('.nikshayDanger').html("Nikshay ID is not available of the selected enrolment");
			$('#confirmok_nikshay').prop('disabled', true);	
		}
		else if(nikshayresult==1 && testreqresult==1){
			$('.testReqDanger').hide();			
			$('.nikshayDanger').hide();
			$('#confirmok_nikshay').prop('disabled', false);
		}
		
	});


    $('#myModalNikshay').modal('toggle');
 }

$('#confirmok_nikshay').click(function(){ //alert("button click");
	      var form = $(document).find('form#send_to_nikshay_form');
          form.submit();
   });
 
 function openCbnaatFormDrug(enroll_id, sample_id, service, sample_ids){
     $("#enrollIddrug").val(enroll_id);
    $("#servicedrug").val(service);
    $("#sample-iddrugs").val(sample_ids);

    $('.service_array').click(function(){
      if($(this).is(':checked')){

        // var index = dst_id.indexOf(parseInt($(this).val()));
        // if(index >= 0){
          console.log("dst checked",$(this).val());
          $(".dst_drugs").show();
        // }
      }else{

        // var index = dst_id.indexOf(parseInt($(this).val()));
        // if(index >= 0){
          console.log("dst unchecked",$(this).val());
          $(".dst_drugs").hide();
        // }
      }
    });
    $('#myModal_drug').modal('toggle');
 }

 


 function openCbnaatForm(enroll_id, sample_ids, service, sample, bwm_status, no, reg_by){
  //console.log(enroll_id, sample_ids, service);
  //console.log(sample_ids);

  $("#enrollId2").val(enroll_id);
  $("#service2").val(service);
  $("#bwm_status2").val(bwm_status);
  $("#sampleID2").val(sample);
  $('#no_sample2').val(no);

var error_print=0;
  var sampleArray = sample_ids.split(',');
  //console.log(sampleArray);
  $('#sampleid2 option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleid2').append($('<option>', {
          text : item
      }));
  });


  if( reg_by ){
      $('#microscopy_review_logic').show();
      $('#microscopy_review_logic_disabled').hide();
    //$('#confirmok').prop('disabled',false);
  }else{  
      $('#microscopy_review_logic').hide();
      $('#microscopy_review_logic_disabled').show();
     
  }



  $('#myModal').modal('toggle');
  if($('#bwm_status2').val()=='1'){
    $("#reason2").removeClass("hide");
  }
  else {
    $("#reason2").addClass("hide");
  }

  $("#reason_bwm2").change(function(){
      var _sample = $(this).find(":selected").val();
      if(_sample=='Other'){
        $("#reason_other2").removeClass("hide");
        document.getElementById("#reason_other2").setAttribute("required","required");
      }else{
        $("#reason_other").addClass("hide");
        document.getElementById("#reason_other2").removeAttribute("required","required");
      }
  });

  $("#confirmok2").click(function(){
   var next = $("#print15A2").val();
     if($('input[name=print15A]:checked').length > 0){
       // $("#nextStep").removeAttribute("required");
        var sample = $("#sampleID2").val();
        //pradip
        var detail = $("#detail2").val();
        var remark = $("#remark2").val();
        var form = $(document).find('form#cbnaat_result2');
       form.submit();
        var url = '{{ url("/pdfview", "id") }}';
        // url = url.replace('id', sample+'/1');
        url = url.replace('id',sample);
       // url = url.replace('detail', detail);
       // url = url.replace('remark', remark);
        // url = url.replace('type', '1');
         window.open(url, '_blank');

     }
     var form = $(document).find('form#cbnaat_result2');
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
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
		ajax: {
			    url: "{{url('ajax_microbiologist_list')}}",			  
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
		 columns: [
		   { data: 'ID',className: "hide_column"},
		   { data: 'enroll_id'},
		   { data: 'patient_name' },
		   { data: 'test_requested' },
		   { data: 'reason_for_test' },
		   { data: 'test_review' },
		   { data: 'view_result' },
		   { data: 'req_retest' },
		   { data: 'add_test' },
		   { data: 'result_to_nikshay' },
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
                    /*columns: [  1, 2, 3,4,5,6,7]*/
					columns: "thead th:not(.noExport)"
                }
            }
        ],
        "order": [[ 2, "desc" ]]
    });	
	
});
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

         


                <script type="text/javascript">
                  $(function(){
					  
					$('#confirmokrt').prop('disabled', true);
					  
                    $('#nextSteprt').change(function(){
					  var enroll_id=$("#enrollIdrt").val();	
                      var nextSteprt= $('option:selected', this).attr('retest');
                      var err=0;
                      //alert(nextSteprt);
                      if(nextSteprt == '' || nextSteprt == null){
						$('#confirmokrt').prop('disabled', true);  
                        err++;
                      }else{
						  ////////////create dropdown for retest//////////////
                        var service =$("#servicert").val();	
						//alert($("#lpa_tagrt").val().length);
						if ($("#lpa_tagrt").val().length == 0){ //null
                             var lpa_tag =1;	
						}else{
							
							var lpa_tag =$("#lpa_tagrt").val()=="1st line LPA"?1:2;
							
						}	
                        var option_id =nextSteprt;						
						var details = service + '/' + option_id + '/' + lpa_tag;
						
						//console.log(urlll);
						$.ajax({
							  url: "{{url('restest_sento_to_map')}}"+'/'+details,
							  type:"GET",
							  processData: false,
							  contentType: false,
							  dataType : "json",
							  success: function(resp) {
								//console.log(resp);
								  var html2='';
								  html2 +='<option value="">--Select--</option>';
								  $.each(resp, function(index,val){
									  var send_to_id=val.send_to_id;
									  var send_to_name=val.send_to_name;

										html2 += '<option value="'+send_to_id+'">'+send_to_name+'</option>';

								  });
								  //console.log(html2);
								  $("#send_to_div").show();
								$("#retest_sent_to").html(html2);

								 
							  },
							  error: function() {
								console.log("err")
							}
						  });

						  /////////////////////////////
                          if(nextSteprt == '1'){ //alert($('#retest_sent_to').val());
							//alert($("#sampleIDrt").val()); 
							$('#sampleidrt option').remove(); 
							$('#sampleidrt').append($('<option>', {text : $("#sampleIDrt").val()}));   
							$('.alert-danger').hide();  
                            $('#retest_type').val('true');
							if($('#retest_sent_to').val() == '' || $('#retest_sent_to').val() == null){
						        $('#confirmokrt').prop('disabled', true);
							}else{
								$('#confirmokrt').prop('disabled', false);
							}
                          }else if(nextSteprt == '2'){
                             $('#retest_type').val('false');
							 //$('#confirmokrt').prop('disabled', false);
							 //check for storage
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
												   
													$('#sampleidrt option').remove();
													$('#sampleidrt').append($('<option>', {text : sample_label}));
													if(typeof $("#sentstepadd option:selected").val()==='undefined'){
														$('#confirmokrt').prop('disabled', true);
													}else{ //alert();
													    if($('#retest_sent_to').val() == '' || $('#retest_sent_to').val() == null){
															$('#confirmokrt').prop('disabled', true);
														}else{
															$('#confirmokrt').prop('disabled', false);
														}
													}
												
											}
											
										}else{      //alert("ggg");
										            $('#sampleidrt option').remove();
													$('.alert-danger').show();
													$('.alert-danger').html("No Sample Found in the Storage");
													//alert($("#sentstepadd option:selected").val());
													$('#confirmokrt').prop('disabled', true);
										}
								  },
								failure: function(response){
									console.log("err")
								}
							});
                          }else{
							 //alert($("#sampleIDrt").val()); 
							 ///$('#sampleidrt option').remove(); 
							 //$('#sampleidrt').append($('<option>', {text : $("#sampleIDrt").val()})); 
							 $('.alert-danger').hide(); 
                             $('#retest_type').val(null);
							 $('#confirmokrt').prop('disabled', true);
                          }
                    }

                      if(err > 0){
                        $('#confirmokrt').prop('type','button');
                      }else{
                        $('#confirmokrt').prop('type','submit');
                      }

                    });
					
					$('#retest_sent_to').change(function(){					
						  if($('#retest_sent_to').val() == '' || $('#retest_sent_to').val() == null){
							$('#confirmokrt').prop('disabled', true);  
							
						 }else{
							$('#confirmokrt').prop('disabled', false);  
						 }
					 });
					
                  });
				  //textarea comment on change 
	               $(document).on('change keyup paste', '#microbio_comments', function() {
                        //alert("Onchange event" ); 
						 $('#confirmokrt').prop('disabled', false);
						 $('#confirmokrt').prop("disabled", !$('input[name="updated_drugs[]"]').is(":checked")?true:false);//if not checked
					});		  
	 //check for add test request_service data exist or not   
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
		}		
    });


  </script>

{{--<script>--}}
    {{--var $select_inputs = $('#firstLPA select,#secondLPA select');--}}

    {{--function select_option_colors(){--}}
        {{--$select_inputs.each(function(){--}}

            {{--var $select = $(this);--}}
            {{--var text = $.trim( $select.find('option').eq( this.selectedIndex ).text() ).toLowerCase();--}}

            {{--if( text == 'present' ){--}}
                {{--$select.css({'background-color': '#baffba'});--}}
            {{--}else if( text == 'absent' ){--}}
                {{--$select.css({'background-color': '#ffd1d1'});--}}
            {{--}else if( text == 'select' ){--}}
                {{--$select.css({'background-color': '#f9ff9d'});--}}
            {{--}else{--}}
                {{--$select.css({});--}}
            {{--}--}}

        {{--});--}}
    {{--}--}}

    {{--select_option_colors();--}}
    {{--$select_inputs.change( select_option_colors );--}}
{{--</script>--}}


@endsection
