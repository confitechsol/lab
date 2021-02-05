@extends('admin.layout.app')
@section('content')
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="{{ url('/css/bootstrap-toggle.min.css') }}"/>
<style>
.overlay {
    background-color:#EFEFEF;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 1000;
    top: 0px;
    left: 0px;
    opacity: .5; /* in FireFox */
    filter: alpha(opacity=50); /* in IE */
}

.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #5cb85c;
}
.btn-success:hover {background-color: #5cb85c;
border-color: #5cb85c;
}
.toggle-off {
    border: 1px solid #ccc;
    background: #eee;
        background-image: none;
}
.off .toggle-handle {
    background: #fff;
    position: relative;
    z-index: 9;
    border: 1px solid #999;
    width: 14px;
    margin-left: 23px !important;
    padding-left: 0px;
}
#scan_barcode_val {

    margin-left: 15px;

}
.btn {
    padding: 15px 16px;
        padding-right: 16px;
    font-size: 14px;
    cursor: pointer;

}
.toggle-handle{ background: #fff;}

#display_codediv {
    float: right;
}

.toggle.btn.btn-success {
    margin-left: 3%;
    margin-bottom: 1%;
}
.btn-default{
  margin-left: 3%;
  margin-bottom: 1%;
}

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
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <body>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <div class="row page-titles">
                    <div style="align:right;" class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Sample Opening</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <!-- <p  class="pull-right ">Enrolment ID : <?php //echo str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT); ?></p> -->
                       <div class="hide"  id="display_codediv">
                       <h4>BARCODE NUMBER :: <span style="color:#60ABEF;" id="display_barcode"></span></h4>
                       </div>
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
                {{-- <form class="form-horizontal form-material" id="addsampleform" action="{{ url('/sample') }}" method="post" enctype='multipart/form-data'> --}}
                  <form class="form-horizontal form-material" id="addsampleform" action="{{ url('/sample/sample-update') }}" method="post" enctype='multipart/form-data'>
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
                
                    <div class="row">
                      <div class="col">
                            <div class="card">
                                <div class="card-block">
                                  <div class="row">
                                    <div class="col" id="noOfSampleDiv">
                                      <label class="col-md-12">No. of samples submitted <span class="red">*</span> </label>
                                      <div class="col-md-12">
                                          <select  class="form-control form-control-line" id="noOfSample" name="no_of_samples" required>
                                              <option value="1" <?php if(count($data['sample_detail']) == 1){ ?> selected="selected" <?php }  ?> >1</option>
                                              <option <?php if(count($data['sample_detail']) == 2){ ?> selected="selected" <?php }  ?> value="2">2</option>
                                              <!-- <option>3</option>
                                              <option>4</option> -->
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col">

                                      <label class="col-md-6">Enrolment Number </label>
                                      <div class="col-md-6">
                                        <!-- <input type="text" name="enroll_label" class="form-control form-control-line" value="<?php //echo  str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT); ?>" id="enroll_label" required> -->

                                        <input type="text" id="enroll_label" name="enroll_label" class="form-control form-control-line" onKeyPress="if(this.value.length==11) return false;" id="enroll_label" readonly required value="{{$data['enroll'][0]->enroll}}">
                                      </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Name <span class="red">*</span> </label>
                                            <div class="col-md-12">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <!--<input type="hidden" name="enroll_id" value="<?php //echo str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT); ?>" id="enrollId">---->
                                               <input type="text" name="name" style="text-transform:capitalize;" class="form-control form-control-line" onkeyup="nospaces(this)" readonly value="{{ $data['sample_detail'][0]['name'] }}">
                                           </div>
                                        </div>
                                        <div class="col ">
										  <!-- <label class="col-md-12">Nikshay ID</label>
                                            <div class="col-md-12">
                                               <input type="number" name="nikshay_id" class="form-control form-control-line" required>
                                           </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                      {{-- {{ dd($data) }} --}}
                      @if(count($data['sample_detail']) > 0 )
                        @if(count($data['sample']) > 0 )                       
                          @foreach($data['sample'] as $key => $value) 

                              <div class="row sampleForm" id="sampleForm">
                                  <div class="col-12">
                                      <div class="card">
                                          <div class="card-block">
                                              <h4>Sample </h4>
                                              <div class="row">
                                                  <div class="col ">
                                                      <label class="col-md-12">Sample ID <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                         <!-- <input type="text" name="sample_id[]" class="form-control form-control-line sampleId" value="<?php //echo str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT); ?>A" id="sampleId" required> -->
                                                         <input style="width: 88%;" type="text" name="sample_id[]" class="form-control form-control-line sampleId" id="sampleId" readonly required value="{{ $value['sample_label'] }} ">
                                                         <input type="text" name="sample_ID[]" class="sampID" value="{{ $value['id'] }}" />
                                                         <input type="text" name="EnrollID[]" value="{{ $value['enroll_id'] }}" />
                                                     </div>
                                                  </div>
                                                  <div class="col ">
                                                     <label class="col-md-12">Date of Receipt <span class="red">*</span></label>
                                                      <div class="col-md-12">

                                                         <input id="submit_date" type="date"  name="receive_date[]" max="{{date('Y-m-d')}}" class="form-control form-control-line submit_date"  readonly  value="<?php echo date('Y-m-d', strtotime($value['receive_date'])); ?>">
                                                         <input type="hidden" class="actualtime"  id="actualtime" name="actualtime" value="<?php echo date('h:i:s', strtotime($value['receive_date'])); ?>" />
                                                     </div>
                                                  </div>  
                                              </div>
                                              <div class="row">
                                                  <div class="col">
                                                      <label class="col-md-12">Sample type <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                        <select name="sample_type[]" class="form-control form-control-line sample_type" id="sample_typeA" required>
                                                          <option value="">--Select--</option>
                                                          <option value="Sputum" @if($value['sample_type'] =='Sputum') selected="selected" @endif>Sputum</option>
                                                          <option value="Other" @if($value['sample_type'] =='Others') selected="selected" @endif >Other</option>
                                                        </select>
                                                     </div>
                                                  </div>
                                                  @if($value['sample_type']  == 'Others')
                                                  <div class="col {{-- @if($value['sample_type']  != 'Others') hide @endif; --}} other_sample_type" id="other_sample_typeA">
                                                      <label class="col-md-12">Other sample type <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                        {{-- {{ dd($data['other_sample_type']) }} --}}
                                                        <select id="other_sample_type" name="other_sample_type[]" class="form-control form-control-line ed_other_sample_type">
                                                          <option value="">--Select--</option>
                                                          <option value="BAL" @if($value['sample_type'] == 'BAL') selected="selected" @endif >BAL</option>
                                                          <option value="Pus" @if($value['sample_type'] == 'Pus') selected="selected" @endif >Pus</option>
                                                          <option value="CSF" @if($value['sample_type'] == 'CSF') selected="selected" @endif >CSF</option>
                                                          <option value="GA"  @if($value['sample_type'] == 'GA') selected="selected" @endif >GA</option>
                                                          <option value="Pericardial fluid" @if($value['sample_type'] == 'Pericardial fluid') selected="selected" @endif>Pericardial fluid</option>
                                                          <option value="EB tissue" @if($value['sample_type'] == 'EB tissue') selected="selected" @endif >EB tissue</option>
                                                          <option value="Urine" @if($value['sample_type'] == 'Urine') selected="selected" @endif>Urine</option>
                                                          <option value="AFB MTB positive culture (LJ or LC)" @if($value['sample_type'] == 'AFB MTB positive culture (LJ or LC)') selected="selected" @endif >AFB MTB positive culture (LJ or LC)</option>
                                                          <option value="Pleural fluid" @if($value['sample_type'] == 'Pleural fluid') selected="selected" @endif >Pleural fluid</option>
                                                          <option value="FNAC" @if($value['sample_type'] == 'FNAC') selected="selected" @endif >FNAC</option>
                                                          <option value="Others" @if($value['sample_type'] == 'Others') selected="selected" @endif >Others</option>                                                          
                                                        </select>
                                                     </div>
                                                  </div>
                                                  @else
                                                  <div class="col @if($value['sample_type']  != 'Others') hide @endif;  other_sample_type" id="other_sample_typeA">
                                                    <label class="col-md-12">Other sample type <span class="red">*</span> </label>
                                                    <div class="col-md-12">
                                                      {{-- {{ dd($data['other_sample_type']) }} --}}
                                                      <select id="other_sample_type" name="other_sample_type[]" class="form-control form-control-line ed_other_sample_type">
                                                        <option value="">--Select--</option>
                                                        <option value="BAL" @if($value['sample_type'] == 'BAL') selected="selected" @endif >BAL</option>
                                                        <option value="Pus" @if($value['sample_type'] == 'Pus') selected="selected" @endif >Pus</option>
                                                        <option value="CSF" @if($value['sample_type'] == 'CSF') selected="selected" @endif >CSF</option>
                                                        <option value="GA"  @if($value['sample_type'] == 'GA') selected="selected" @endif >GA</option>
                                                        <option value="Pericardial fluid" @if($value['sample_type'] == 'Pericardial fluid') selected="selected" @endif>Pericardial fluid</option>
                                                        <option value="EB tissue" @if($value['sample_type'] == 'EB tissue') selected="selected" @endif >EB tissue</option>
                                                        <option value="Urine" @if($value['sample_type'] == 'Urine') selected="selected" @endif>Urine</option>
                                                        <option value="AFB MTB positive culture (LJ or LC)" @if($value['sample_type'] == 'AFB MTB positive culture (LJ or LC)') selected="selected" @endif >AFB MTB positive culture (LJ or LC)</option>
                                                        <option value="Pleural fluid" @if($value['sample_type'] == 'Pleural fluid') selected="selected" @endif >Pleural fluid</option>
                                                        <option value="FNAC" @if($value['sample_type'] == 'FNAC') selected="selected" @endif >FNAC</option>
                                                        <option value="Others" @if($value['sample_type'] == 'Others') selected="selected" @endif >Others</option>                                                          
                                                      </select>
                                                   </div>
                                                </div>
                                                  @endif
                                                    @if($value['sample_type'] == 'Others')
                                                  <div class="col" >
                                                  <div class="col @if($value['sample_type'] !='Others') hide @endif others" id="othersA">
                                                      <label class="col-md-12">Other</label>
                                                      <div class="col-md-12">
                                                           <input type="text" id="others_typeA" name="others_type[]" class="form-control form-control-line others_type" value="{{ $value['others_type'] }}" >
                                                     </div>
                                                  </div>
                                                </div>
                                                @else
                                                <div class="col" >
                                                  <div class="col hide others" id="othersA">
                                                      <label class="col-md-12">Other</label>
                                                      <div class="col-md-12">
                                                           <input type="text" id="others_typeA" name="others_type[]" class="form-control form-control-line others_type" >
                                                     </div>
                                                  </div>
                                                </div>
                                                @endif


                                              </div>

                                              <div class="row">
                                                 <div class="col">
                                                      <label class="col-md-12">Sample Accepted/Rejected <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                        <select name="is_accepted[]" id="sample_statusA" class="form-control form-control-line sample_status" disabled >
                                                          <option value="">--Select--</option>
                                                          <option value="Accepted" @if($value['is_accepted'] =='Accepted') selected="selected" @endif>Accepted</option>
                                                          <option value="Rejected" @if($value['is_accepted'] =='Rejected') selected="selected" @endif >Rejected</option>
                                                        </select>
                                                     </div>
                                                </div>                                                
                                                @if(trim($value['is_accepted']) =='Rejected')  
                                                                                    
                                                <div class="col @if(trim($value['is_accepted']) =='Rejected') @else hide @endif  reject" id="rejectA">
                                                      <label class="col-md-12">Reason of Rejection <span class="red">*</span> </label>
                                                      <div class="col-md-12">

                                                        <select  class="form-control form-control-line rejection" id="rejectionA" name="rejection">
                                                          <option value="">--Select--</option>
                                                        <option @if($value['rejection'] =='Sample leakage in the box') selected="selected" @endif value="Sample leakage in the box">Sample leakage in the box</option>
                                                        <option @if($value['rejection'] =='Wrong forms') selected="selected" @endif value="Wrong forms">Wrong forms</option>
                                                        <option @if($value['rejection'] =='Insufficient quantity of sample') selected="selected" @endif value="Insufficient quantity of sample">Insufficient quantity of sample</option>
                                                        <option @if($value['rejection'] =='Wrong labelling') selected="selected" @endif value="Wrong labelling">Wrong labelling</option>
                                                        <option @if($value['rejection'] =='Sample transport with out cold chain') selected="selected" @endif value="Sample transport with out cold chain">Sample transport with out cold chain</option>
                                                        <option @if($value['rejection'] =='Sample received outside of the TAT time') selected="selected" @endif value="Sample received outside of the TAT time">Sample received outside of the TAT time</option>
                                                        <option @if($value['rejection'] =='Other reason') selected="selected" @endif value="Other reason">Other reason</option>
                                                    </select>
                                                     </div>
                                                  </div>
                                                  @else
                                                  <div class="col hide reject" id="rejectA">
                                                    <label class="col-md-12">Reason of Rejection <span class="red">*</span> </label>
                                                    <div class="col-md-12">
        
                                                      <select  class="form-control form-control-line rejection" id="rejectionA" name="rejection[]">
                                                        <option value="">--Select--</option>
                                                      <option value="Sample leakage in the box">Sample leakage in the box</option>
                                                      <option value="Wrong forms">Wrong forms</option>
                                                      <option value="Insufficient quantity of sample">Insufficient quantity of sample</option>
                                                      <option value="Wrong labelling">Wrong labelling</option>
                                                      <option value="Sample transport with out cold chain">Sample transport with out cold chain</option>
                                                      <option value="Sample received outside of the TAT time">Sample received outside of the TAT time</option>
                                                      <option value="Other reason">Other reason</option>
                                                  </select>
                                                   </div>
                                                </div>
                                                  @endif
                                                   @if($value['is_accepted'] =='Rejected' && ($value['rejection'] =='Other reason' ))
                                                  <div class="col" >
                                                  <div class="col @if($value['is_accepted'] =='Rejected' && ($value['rejection'] =='Other reason' )) @else hide @endif other" id="otherA">
                                                      <label class="col-md-12">Mention Reason of Rejection</label>
                                                      <div class="col-md-12">
                                                           <input type="text" id="otherRA" name="reason_reject" class="form-control form-control-line" >
                                                     </div>
                                                  </div>
                                                </div>
                                               @else
                                                <div class="col" >
                                                  <div class="col hide other" id="otherA">
                                                      <label class="col-md-12">Mention Reason of Rejection</label>
                                                      <div class="col-md-12">
                                                           <input type="text" id="otherRA" name="reason_reject[]" class="form-control form-control-line" >
                                                     </div>
                                                  </div>
                                                </div>
                                                @endif;
                                              </div>
                                              <div class="row">
                                                  <div class="col">

                                                      <label class="col-md-12">Sample Quality <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                         <!-- <input type="text" name="sample_quality[]" class="form-control form-control-line" required> -->
                                      
                                                        <select name="sample_quality[]" class="form-control form-control-line sample_quality" id="sample_qualityA" required>
                                                           <option value="" selected>--Select--</option>
                                                           <option value="Blood-stained purulent" @if($value['sample_quality'] =='Blood-stained purulent') selected="selected" @endif>Blood-stained purulent</option>
                                                           <option value="Thick mucoid" @if($value['sample_quality'] =='Thick mucoid') selected="selected" @endif >Thick mucoid</option>
                                                           <option value="Mucopurulent"@if($value['sample_quality'] =='Mucopurulent') selected="selected" @endif >Mucopurulent</option>
                                                           <option value="Saliva" @if($value['sample_quality'] =='Saliva') selected="selected" @endif >Saliva</option>
                                                           <option value="Food particles" @if($value['sample_quality'] =='Food particles') selected="selected" @endif >Food particles</option>
                                                           <option value="other" @if($value['sample_quality'] =='other') selected="selected" @endif >Other</option>
                                                         </select>

                                                     </div>
                                                  </div>


                                              @if($value['sample_quality'] =='other')
                                                 <div class="col other_sample_quality">
                                                      <label class="col-md-12 qualitylabel @if($value['sample_quality'] !='other') hide @endif; ">Other Sample Quality <span class="red">*</span></label>
                                                      <div class="col-md-12">
                                                  <input @if($value['sample_quality'] !='other') type="hidden" @else type="text" @endif; id="othersample_quality" name="othersample_quality" class="form-control othersample_quality" @if($value['sample_quality'] !='other')  @else value="{{ $value['other_samplequality'] }}" @endif;  />
                                                     </div>
                                                  </div>
                                                  @else
                                                  <div class="col other_sample_quality">
                                                    <label class="col-md-12 qualitylabel hide">Other Sample Quality <span class="red">*</span></label>
                                                    <div class="col-md-12">
                                                  <input type="hidden" id="othersample_quality" name="othersample_quality[]" class="form-control othersample_quality"/>
                                                   </div>
                                                </div>
                                                  @endif
                                              </div>
                                              <div class="row">
                                                  <div class="col">
                                                      <label class="col-md-12">Reason for Test <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                         <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                                                         <select name="test_reason[]" class="form-control form-control-line test_reason" id="test_reasonA" required>
                                                           <option value="">--Select--</option>
                                                           <option value="DX" @if($value['test_reason'] =='DX') selected="selected" @endif; >Diagnosis</option>
                                                           <option value="FU" @if($value['test_reason'] =='FU') selected="selected" @endif; >Follow up</option>
                                                           <!--<option value="EQA">EQA</option>-->
                                                         </select>
                                                     </div>
                                                  </div>                                                  
                                                  @if($value['test_reason'] =='FU')
                                                  <div class="col @if($value['test_reason'] !='FU') hide  @endif fu_month" id="fu_monthA">
                                                      <label class="col-md-12">Follow up month <span class="red">*</span></label>
                                                      <div class="col-md-12">
                                                        <select id="fu_month_valueA" name="fu_month[]" class="form-control form-control-line fu_month_value month" >
                                                          <option value="">--Select--</option>
                                                          <option value="End IP" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >End IP</option>
                                                          <option value="End CP" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >End CP</option>
                                                          <option value="6 M" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >6 M</option>
                                                          <option value="12 M" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >12 M</option>
                                                          <option value="18 M" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >18 M</option>
                                                          <option value="24 M" @if(in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >24 M</option>
                                                          <option value="Other"@if(!in_array($value['fu_month'] ,$data['fu_month_list'])) selected="selected" @endif >Other</option>
                                                        </select>
                                                     </div>
                                                  </div>
                                                  @else
                                                  <div class="col hide fu_month" id="fu_monthA">
                                                    <label class="col-md-12">Follow up month <span class="red">*</span></label>
                                                    <div class="col-md-12">
                                                      <select id="fu_month_valueA" name="fu_month[]" class="form-control form-control-line fu_month_value month" >
                                                        <option value="">--Select--</option>
                                                        <option value="End IP">End IP</option>
                                                        <option value="End CP">End CP</option>        
                                                        <option value="6 M">6 M</option>
                                                        <option value="12 M">12 M</option>
                                                        <option value="18 M">18 M</option>
                                                        <option value="24 M">24 M</option>        
                                                        <option value="Other">Other</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                  @endif  

                                                  @if( $value['test_reason'] =='FU' && (!in_array($value['fu_month'] , $data['fu_month_list'])))                                              
                                                  <div class="col @if( $value['test_reason'] =='FU' && (!in_array($value['fu_month'] , $data['fu_month_list']))) @else hide @endif followup-other" id="followup-otherA">
                                                      <label class="col-md-12">Other </label>
                                                      <div class="col-md-12">
                                                         <input type="number" id="followup_otherA" name="followup_other[]" class="form-control form-control-line followup_other" min=1 max=50  value="{{ $value['fu_month'] }}">
                                                      </div>
                                                  </div>
                                                  @else
                                                  <div class="col hide followup-other" id="followup-otherA">
                                                    <label class="col-md-12">Other </label>
                                                    <div class="col-md-12">
                                                       <input type="number" id="followup_otherA" name="followup_other[]" class="form-control form-control-line followup_other" min=1 max=50 >
                                                    </div>
                                                </div>
                                                  @endif
                                              </div>                                                                                            
                                              <div class="row">
                                                  <div class="col">
                                                      <label class="col-md-12">Sample Sent to <span class="red">*</span> </label>
                                                      <div class="col-md-12">
                                                         <!-- <textarea rows="5" name="test_reason[]" class="form-control form-control-line" required></textarea> -->
                                                         <select name="service_id[]" class="form-control form-control-line test_reason next_test" id="next_testA" disabled >
                                                          <option value="">--Select--</option>                                                
                                                          <option value="1" @if($value['service_id'] =='1') selected="selected" @endif >ZN Microscopy</option>
                                                          <option value="2" @if($value['service_id'] =='2') selected="selected" @endif >FM Microscopy</option>
                                                          <option value="3" @if($value['service_id'] =='3') selected="selected" @endif >Decontamination</option>
                                                          <option value="4" @if($value['service_id'] =='4') selected="selected" @endif >CBNAAT MTB/RIF</option>
                                                          <option value="16" @if($value['service_id'] =='16') selected="selected" @endif >AFB Culture Innoculation</option>
                                                          <option value="8F" @if($value['service_id'] =='8F') selected="selected" @endif>LPA 1st line</option>
                                                          <option value="8S" @if($value['service_id'] =='8S') selected="selected" @endif >LPA 2nd line</option>
                                                          <option value="11" @if($value['service_id'] =='11') selected="selected" @endif >Storage</option>
                                                         </select>
                                                     </div>
                                                  </div>
                                              </div>


                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                        @endif
                      @endif
                    <div id="moreSample"></div>
                    <p style="color:red;" id="error_bothSameNextStep"></p>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info" id="submit_sample">Save</button>
                            <!-- <button class="btn btn-success">Preview</button>
                            <button class="btn ">Print</button> -->
                            <!-- <a class="btn btn-default btn-sm" href="/sample_preview/<?php //echo $data['enroll_id'];?>">Preview </a> -->
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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>

</body>
<script>
$(document).on('change',"#next_testB", function(){	
    //alert($("#next_testA").val());
	if($(this).val()==$("#next_testA").val())
	{
		$("#error_bothSameNextStep").html("Sample A & B can not send to the same process");
		$('#submit_sample').prop('disabled', true);
	}else{
		$("#error_bothSameNextStep").html("");
		$('#submit_sample').prop('disabled', false);
	}	
});
$(document).on('change',"#next_testA", function(){	
    //alert($("#next_testB").val());
	if($("#next_testB").val()!="undefined" ||$("#next_testB").val()!=""){
		if($(this).val()==$("#next_testB").val())
		{
			$("#error_bothSameNextStep").html("Sample A & B can not send to the same process");
			$('#submit_sample').prop('disabled', true);
		}else{
			$("#error_bothSameNextStep").html("");
			$('#submit_sample').prop('disabled', false);
		}	
	}
});
$(document).ready(function(){
  $("#addsampleform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
$( document ).ready(function() {
	//ajax call for modal
	$(document).on('change', '#sample_statusA', function(){
		if($(this).val()=='Accepted'){
			$('#otherA').hide();
			$('#otherRA').hide();
		    $('#rejectionA').val(null);  // incorporated by niladri
		    $('#rejectionA').val(null); // incorporated by niladri
		    $('#otherRA').prop('required',false); // incorporated by niladri
		    $('#otherRA').prop('required',false); // incorporated by niladri
		}else{
			$('#otherRA').show();
			if($('#rejectionA').val()=='Other reason'){			    
				$('#otherA').show();
			}else{
				$('#otherA').hide();
			}
		}
	});
	$(document).on('change', '#rejectionA', function(){
		if($(this).val()=='Other reason'){
			$('#otherA').show();
			
		}else{
			
	      $('#otherA').hide();
			
		}
	});
});
var alpha = ["A","B","C","D","E"];
    $(function(){
        $("#enroll_label").keyup(function(){
          var _sample = $(this).val()+"A";
          $("#sampleId").val(_sample);
        //  $("#noOfSampleDiv").removeClass("hide");
        });
        $("#noOfSample").change(function(){
            $("#moreSample").html('');
            var _noOfSample = $(this).val();

            for(var i = 1; i < _noOfSample; i++) {
            //    $(".scan_bar").css("display","none");
                $( "#sampleForm" ).clone().appendTo( "#moreSample" );

            }
            var enroll_id = $("#enroll_label").val();
            $(".sampleForm").each(function(i){
              $(this).find(".sampID").attr('id', 'sampID'+alpha[i]);
              $(this).find(".sampleId").val(enroll_id+alpha[i]);
              $(this).find(".sample_type").attr('id', "sample_type"+alpha[i]);
              $(this).find(".other_sample_type").attr('id', "other_sample_type"+alpha[i]);
              $(this).find(".test_reason").attr('id', "test_reason"+alpha[i]);
              $(this).find(".next_test").attr('id', "next_test"+alpha[i]);
              $(this).find(".followup-other").attr('id', "followup-other"+alpha[i]);
              $(this).find(".followup_other").attr('id', "followup_other"+alpha[i]);
              $(this).find(".sample_quality").attr('id', "sample_quality"+alpha[i]);
              $(this).find(".fu_month").attr('id', "fu_month"+alpha[i]);
              $(this).find(".fu_month_value").attr('id', "fu_month_value"+alpha[i]);
              $(this).find(".sample_status").attr('id', "sample_status"+alpha[i]);
              $(this).find(".rejection").attr('id', "rejection"+alpha[i]);
              $(this).find(".reject").attr('id', "reject"+alpha[i]);
              $(this).find(".other").attr('id', "other"+alpha[i]);
              $(this).find(".others").attr('id', "others"+alpha[i]);
              $(this).find(".others_type").attr('id', "others_type"+alpha[i]);
            });

            if(_noOfSample > 1)
            {
              $("#sampIDB").val('0');
              $('#next_testB > option').removeAttr('selected');
              document.getElementById('next_testB').selectedIndex = 8;
              //$( "#next_testB option:selected" ).text('st');
                
            }
        });
        $(".sampleId").change(function(){
          var sample = $(this).val().slice(0,-1);
          $("#enroll_label").val(sample);

          $(".sampleForm:not(:first)").each(function(i){
            $(this).find(".sampleId").val(sample+alpha[i+1]);
          })
        });
        $("#sample_typeA").change(function(){
            var _sample = $(this).val();
            var _noOfSample = $(this).val();
            $(".sampleForm").each(function(i){
              $(this).find(".sample_type").val(_sample);
            });

            $('#other_sample_type').val('').trigger('change');
            $('#others_typeA').val('');

        });

      
		$("#sample_statusA").change(function(){
            var _sample = $(this).val();
            var _noOfSample = $(this).val();
            $(".sampleForm").each(function(i){
              $(this).find(".sample_status").val(_sample);
            });

        });

        $("#other_sample_type").change(function(){
            var _sample = $(this).find(":selected").val();
            if(_sample=='Others'){
              $("#othersA").removeClass("hide");
              $("#othersB").removeClass("hide");
              $("#othersC").removeClass("hide");
              $("#othersD").removeClass("hide");
              // document.getElementById("others_typeA").setAttribute("required","required");
            }else{
              $("#othersA").addClass("hide");
              $("#othersB").addClass("hide");
              $("#othersC").addClass("hide");
              $("#othersD").addClass("hide");
            }

            $('#others_typeA').val('');

        });

        $("#sample_typeA").change(function(){
            var _sample = $("#sample_typeA").val();
            if(_sample=='Other'){
              $("#other_sample_typeA").removeClass("hide");
              $("#other_sample_typeB").removeClass("hide");
              $("#other_sample_typeC").removeClass("hide");
              $("#other_sample_typeD").removeClass("hide");
              document.getElementById("other_sample_type").setAttribute("required","required");
            }else{
              $("#other_sample_typeA").addClass("hide");
              $("#other_sample_typeB").addClass("hide");
              $("#other_sample_typeC").addClass("hide");
              $("#other_sample_typeD").addClass("hide");
              document.getElementById("other_sample_type").removeAttribute("required","required");
            }

            $('#other_sample_type').val('');
        });

        $("#other_sample_typeA").change(function(){
            var _sample = $(this).find(":selected").val();
              $("#other_sample_typeB select").val(_sample).change();
              $("#other_sample_typeC select").val(_sample).change();
              $("#other_sample_typeD select").val(_sample).change();


        });

        $("#others_typeA").change(function(){
            var _sample = $(this).val();
              $("#others_typeB").val(_sample).change();
              $("#others_typeC").val(_sample).change();
              $("#others_typeD").val(_sample).change();


        });

        $("#fu_monthA").change(function(){
            var _sample = $(this).find(":selected").val();

              $("#fu_monthB select").val(_sample).change();
             // $("#fu_monthC select").val(_sample).change();
              //$("#fu_monthD select").val(_sample).change();


        });



        $("#test_reasonA").change(function(){
            var _sample = $(this).val();
            var _noOfSample = $(this).val();
            $(".sampleForm").each(function(i){
              $(this).find(".test_reason").val(_sample);
            })

        });
        $("#sample_qualityA").change(function(){
            var _sample = $(this).val();
            var _noOfSample = $(this).val();
            $(".sampleForm").each(function(i){
              $(this).find(".sample_quality").val(_sample);
            });

        });

        $("#fu_monthA").change(function(){
          var _sample = $("#fu_monthA").find(":selected").val();

          if(_sample=='Other'){
            $("#followup-otherA").removeClass("hide");
            $("#followup-otherA").attr("required","required");
            $("#followup-otherB").removeClass("hide");
            $("#followup-otherB").attr("required","required");
            $("#followup-otherC").removeClass("hide");
            $("#followup-otherC").attr("required","required");
            $("#followup-otherD").removeClass("hide");
            $("#followup-otherD").attr("required","required");
          }
          else {
            $("#followup-otherA").addClass("hide");
            $("#followup-otherB").addClass("hide");
            $("#followup-otherC").addClass("hide");
            $("#followup-otherD").addClass("hide");
          }

        });



        $("#test_reasonA").change(function(){
            var _sample = $("#test_reasonA").val();
			var noOfSample=$("#noOfSample").val();
			//alert(noOfSample);
            if(_sample=='FU'){
              $("#fu_monthA").removeClass("hide");
              document.getElementById("fu_month_valueA").setAttribute("required","required");
			  if(noOfSample>1){
				  $("#fu_monthB").removeClass("hide");
				  document.getElementById("fu_month_valueB").setAttribute("required","required");
				  //$("#fu_monthC").removeClass("hide");
				  //document.getElementById("fu_month_valueC").setAttribute("required","required");
				  //$("#fu_monthD").removeClass("hide");
				  //document.getElementById("fu_month_valueD").setAttribute("required","required");
				  document.getElementById(".month").setAttribute("required","required");
              }
              
            }else{
			 document.getElementById("fu_month_valueA").removeAttribute("required","required");	
			  $("#fu_month_valueA").val("");	
              $("#fu_monthA").addClass("hide");
              $("#fu_monthB").addClass("hide");
              //$("#fu_monthC").addClass("hide");
              //$("#fu_monthD").addClass("hide");			  
			  $(".followup-other").val("");
			  $(".followup-other").addClass("hide");		  
			  if(noOfSample>1){				 
				  document.getElementById("fu_month_valueB").removeAttribute("required","required");
              }
            }
        });

        $("#test_reasonB").change(function(){
            var _sample = $("#test_reasonB").val();
            if(_sample=='FU'){
              $("#fu_monthA").removeClass("hide");
              document.getElementById("fu_month_valueA").setAttribute("required","required");
              $("#fu_monthB").removeClass("hide");
              document.getElementById("fu_month_valueB").setAttribute("required","required");
              //$("#fu_monthC").removeClass("hide");
             // document.getElementById("fu_month_valueC").setAttribute("required","required");
              //$("#fu_monthD").removeClass("hide");
              //document.getElementById("fu_month_valueD").setAttribute("required","required");

              document.getElementById(".month").setAttribute("required","required");
            }else{
              $("#fu_monthA").addClass("hide");
              $("#fu_monthB").addClass("hide");
              //$("#fu_monthC").addClass("hide");
              //$("#fu_monthD").addClass("hide");
			  document.getElementById("fu_month_valueA").removeAttribute("required","required");
			  document.getElementById("fu_month_valueB").removeAttribute("required","required");
			  //document.getElementById("fu_monthC").removeAttribute("required","required");
			  //document.getElementById("fu_monthD").removeAttribute("required","required");
            }
        });
        if($("#noOfSample").val()>1){
          var _sample = $("#test_reasonB").val();
          if(_sample=='FU'){
            $("#fu_monthB").removeClass("hide");
            document.getElementById("fu_month_valueB").setAttribute("required","required");
            document.getElementById(".month").setAttribute("required","required");
          }else{
            $("#fu_monthB").addClass("hide");
			document.getElementById("fu_month_valueB").removeAttribute("required","required");
          }
		}
        $("#followup_otherA").change(function(){
            var _sample = $("#followup_otherA").val();
            // alert(_sample);
			var noOfSample=$("#noOfSample").val();
			if(noOfSample>1){
              document.getElementById("followup_otherB").value = _sample;
              document.getElementById("followup_otherC").value = _sample;
              document.getElementById("followup_otherD").value = _sample;
            }
        });


        $("#test_reasonA").change(function(){
              var _sample = $("#test_reasonA").val();
			  var noOfSample=$("#noOfSample").val();
			  if(noOfSample>1){
				  document.getElementById("test_reasonB").value = _sample;
				  document.getElementById("test_reasonC").value = _sample;
				  document.getElementById("test_reasonD").value = _sample;
              }
        });


        $("#sample_statusA").change(function(){
            var _sample = $("#sample_statusA").val();
            if(_sample=='Rejected'){
                $('#sample_qualityA').val('').trigger('change');
              $('#next_testA').append($("<option></option>").attr("value",24).text('BWM'));
              $("#rejectA").removeClass("hide");
              document.getElementById("test_reasonA").value = "";
              document.getElementById("sample_qualityA").value = "";
              document.getElementById("test_reasonA").setAttribute("disabled","disabled");
              document.getElementById("next_testA").value = "24";
              document.getElementById("next_testA").setAttribute("disabled","disabled");
              document.getElementById("sample_qualityA").setAttribute("disabled","disabled");
              document.getElementById("rejectionA").setAttribute("required","required");
              document.getElementById("test_reasonA").removeAttribute("required","required");
              document.getElementById("next_testA").removeAttribute("required","required");
              document.getElementById("sample_qualityA").removeAttribute("required","required");

            }else{
              $("#next_testA option[value='24']").remove();
              document.getElementById("rejectionA").removeAttribute("required","required");
              $("#test_reasonA").removeAttr("disabled");
              $("#sample_qualityA").removeAttr("disabled");
              $("#next_testA").removeAttr("disabled");
              $("#rejectA").addClass("hide");
            }
        });

        $("#rejectA").change(function(){
            var _sample = $("#rejectionA").val();
            if(_sample=='Other reason'){
              $("#otherA").removeClass("hide");
              document.getElementById("otherRA").setAttribute("required","required");

            }else{
              $("#otherA").addClass("hide");
              document.getElementById("otherRA").removeAttribute("required","required");
            }
        });
        $(document).on("change", "#sample_statusB" , function() {
          var _sample = $(this).val();
          if(_sample=='Rejected'){
          $('#sample_qualityB').val('').trigger('change');
            $("#rejectB").removeClass("hide");
            $('#next_testB').append($("<option></option>").attr("value",24).text('BWM'));
            document.getElementById("test_reasonB").value = "";
            document.getElementById("sample_qualityB").value = "";
            document.getElementById("test_reasonB").setAttribute("disabled","disabled");
            document.getElementById("next_testB").value = "24";
            document.getElementById("next_testB").setAttribute("disabled","disabled");
            document.getElementById("sample_qualityB").setAttribute("disabled","disabled");
            document.getElementById("rejectionB").setAttribute("required","required");
            document.getElementById("test_reasonB").removeAttribute("required","required");
            document.getElementById("next_testB").removeAttribute("required","required");
            document.getElementById("sample_qualityB").removeAttribute("required","required");
          }else{
            //$("#otherB").removeClass("hide");
            $("#next_testB option[value='24']").remove();
            document.getElementById("rejectionB").removeAttribute("required","required");
            $("#test_reasonB").removeAttr("disabled");
            $("#sample_qualityB").removeAttr("disabled");
            $("#next_testB").removeAttr("disabled");
            $(".other").addClass("hide");
            $("#rejectB").addClass("hide");
          }
        });
        $(document).on("change", "#rejectionB" , function() {
          var _sample = $(this).val();
          console.log(_sample);
          if(_sample=='Other reason'){
            $("#otherB").removeClass("hide");
            document.getElementById("otherRB").setAttribute("required","required");
          }else{
            $("#otherB").addClass("hide");
            document.getElementById("otherRB").removeAttribute("required","required");
          }
        });
        $(document).on("change", "#sample_statusC" , function() {
          var _sample = $(this).val();
          if(_sample=='Rejected'){
            $("#rejectC").removeClass("hide");
            $('#next_testC').append($("<option></option>").attr("value",24).text('BWM'));
            document.getElementById("test_reasonC").value = "";
            document.getElementById("sample_qualityC").value = "";
            document.getElementById("test_reasonC").setAttribute("disabled","disabled");
            document.getElementById("next_testC").value = "24";
            document.getElementById("next_testC").setAttribute("disabled","disabled");

            document.getElementById("sample_qualityC").setAttribute("disabled","disabled");
            document.getElementById("rejectionC").setAttribute("required","required");
            document.getElementById("test_reasonC").removeAttribute("required","required");
            document.getElementById("next_testC").removeAttribute("required","required");
            document.getElementById("sample_qualityC").removeAttribute("required","required");

          }else{
            $(".other").addClass("hide");
            $("#next_testC option[value='24']").remove();
            document.getElementById("rejectionC").removeAttribute("required","required");
            $("#test_reasonC").removeAttr("disabled");
            $("#sample_qualityC").removeAttr("disabled");
            $("#next_testC").removeAttr("disabled");
            $(".other").addClass("hide");
            //$("#otherC").removeClass("hide");
            $("#rejectC").addClass("hide");
          }
        });
        $(document).on("change", "#rejectionC" , function() {
          var _sample = $(this).val();
          console.log(_sample);
          if(_sample=='Other reason'){
            $("#otherC").removeClass("hide");
            document.getElementById("otherRC").setAttribute("required","required");
          }else{
            $("#otherC").addClass("hide");
            document.getElementById("otherRC").removeAttribute("required","required");
          }
        });
        $(document).on("change", "#sample_statusD" , function() {
          var _sample = $(this).val();
          if(_sample=='Rejected'){
            $("#rejectD").removeClass("hide");
            document.getElementById("test_reasonD").value = "";
            $('#next_testD').append($("<option></option>").attr("value",24).text('BWM'));
            document.getElementById("sample_qualityD").value = "";
            document.getElementById("test_reasonD").setAttribute("disabled","disabled");
            document.getElementById("next_testD").value = "24";
            document.getElementById("next_testD").setAttribute("disabled","disabled");
            document.getElementById("sample_qualityD").setAttribute("disabled","disabled");
            document.getElementById("rejectD").setAttribute("required","required");
            document.getElementById("test_reasonD").removeAttribute("required","required");
            document.getElementById("next_testD").removeAttribute("required","required");
            document.getElementById("sample_qualityD").removeAttribute("required","required");
          }else{
            $(".other").addClass("hide");
            $("#next_testD option[value='24']").remove();
            document.getElementById("rejectionD").removeAttribute("required","required");
            $("#test_reasonD").removeAttr("disabled");
            $("#sample_qualityD").removeAttr("disabled");
            $("#next_testD").removeAttr("disabled");
            $(".other").addClass("hide");
            //$("#otherD").removeClass("hide");
            $("#rejectD").addClass("hide");
          }
        });
        $(document).on("change", "#rejectionD" , function() {
          var _sample = $(this).val();
          console.log(_sample);
          if(_sample=='Other reason'){
            $("#otherD").removeClass("hide");
            document.getElementById("otherRD").setAttribute("required","required");
          }else{
            $("#otherD").addClass("hide");
            document.getElementById("otherRD").removeAttribute("required","required");
          }
        });



        $(document).on("change", "#sample_typeB" , function() {
          var _sample = $(this).val();
          if(_sample=='Other'){
            $("#other_sample_typeB").removeClass("hide");
            document.getElementById("other_sample_typeB").setAttribute("required","required");
          }else{
            $("#other_sample_typeB").addClass("hide");
            document.getElementById("other_sample_typeB").removeAttribute("required","required");
          }
        });
        $(document).on("change", "#sample_typeC" , function() {
          var _sample = $(this).val();
          if(_sample=='Other'){
            $("#other_sample_typeC").removeClass("hide");
            document.getElementById("other_sample_typeC").setAttribute("required","required");
          }else{
            $("#other_sample_typeC").addClass("hide");
            document.getElementById("other_sample_typeC").removeAttribute("required","required");
          }
        });
        $(document).on("change", "#sample_typeD" , function() {
          var _sample = $(this).val();
          if(_sample=='Other'){
            $("#other_sample_typeD").removeClass("hide");
            document.getElementById("other_sample_typeD").setAttribute("required","required");
          }else{
            $("#other_sample_typeD").addClass("hide");
            document.getElementById("other_sample_typeD").removeAttribute("required","required");
          }
        });

        $(document).on("change", "#test_reasonB" , function() {
          var _sample = $(this).val();
          if(_sample=='FU'){
            $("#fu_monthB").removeClass("hide");
            document.getElementById("fu_month_valueB").setAttribute("required","required");
          }else{
            $("#fu_monthB").addClass("hide");
            document.getElementById("fu_month_valueB").removeAttribute("required","required");
          }
        });
        /*$(document).on("change", "#test_reasonC" , function() {
          var _sample = $(this).val();
          if(_sample=='FU'){
            $("#fu_monthC").removeClass("hide");
            document.getElementById("fu_monthC").setAttribute("required","required");
          }else{
            $("#fu_monthC").addClass("hide");
              document.getElementById("fu_monthC").removeAttribute("required","required");
          }
        });*/
       /* $(document).on("change", "#test_reasonD" , function() {
          var _sample = $(this).val();
          if(_sample=='FU'){
            $("#fu_monthD").removeClass("hide");
            document.getElementById("fu_monthD").setAttribute("required","required");
          }else{
            $("#fu_monthD").addClass("hide");
              document.getElementById("fu_monthD").removeAttribute("required","required");
          }
        });*/
        $("#datep").datepicker({
            dateFormat: "dd/mm/yyyy"
        }).datepicker("setDate", "0");

        $("#submit_sample").on('click',function(){
		 var noOfSample=$("#noOfSample").val();
			
          document.getElementById("test_reasonA").removeAttribute("disabled","disabled");
          document.getElementById("next_testA").removeAttribute("disabled","disabled");
          document.getElementById("sample_qualityA").removeAttribute("disabled","disabled");
          //==
		  if(noOfSample>1){
			  document.getElementById("test_reasonB").removeAttribute("disabled","disabled");
			  document.getElementById("next_testB").removeAttribute("disabled","disabled");
			  document.getElementById("sample_qualityB").removeAttribute("disabled","disabled");
			  //document.getElementById("test_reasonC").removeAttribute("disabled","disabled");
			  //document.getElementById("next_testC").removeAttribute("disabled","disabled");
			  //document.getElementById("sample_qualityC").removeAttribute("disabled","disabled");
          }
        });

    });

    function nospaces(t){
    if(t.value.match(/\s/g)){
    alert('Sorry, you are not allowed to enter any spaces');
    t.value=t.value.replace(/\s/g,'');
    }
    }
</script>

<script>
$(document).ready(function(){
$(".submit_date").mouseover(function(){
//alert(submit_date);
var current_date=new Date;
var systime= current_date.getHours()+':'+current_date.getMinutes()+':'+current_date.getSeconds();
var actualtime=systime;
$(".actualtime").val(actualtime);
});

});
</script>
<script src="{{url('js/newjquery.min.js')}}"/></script>
<script src="{{url('js/bootstrap-toggle.min.js')}}"/></script>
<script>
// $(".scan_barcode").live("keyup",function(){
//
//     var scanval=$(this).attr('id');
//     alert(scanval);
//
// });

//
// function generate(val){
//
//   console.log(val)
// }

$(document).ready(function(){
  // $("#sampleId").setAttribute("readonly");
  //   $("#enroll_label").setAttribute("readonly");
$(".scan_barcode") .live('blur',function(){

  var scanval= $(this).val();
  var err=0;
if(scanval.length < 6 || scanval.length > 6){
  err++;
  $(".scanerr").html("Please enter a valid code");
  // alert("Please enter a valid code");
  $("#scan_barcode_val").val(null);

}

  if(isNaN(scanval) !== false ){
    err++;
    $(".scanerr").html("Alphabets are not allowed.Please enter a valid digit");
    //  alert("Alphabets are not allowed.Please enter a valid digit");
      $("#scan_barcode_val").val(null);

  }

  if(scanval == '' || scanval == null ){
  err++;
      $(".scanerr").html("It cannot be empty");
  //alert("It cannot be empty");
  $("#scan_barcode_val").val(null);
  }

if(/^[a-z0-9_]+$/i.test(scanval) == false){

  err++;
    $(".scanerr").html("No spaces are allowed");
  //alert("No spaces are allowed");
  $("#scan_barcode_val").val(null);
}

  if(err == 0){

  $.ajax({
    url:"{{ url('/getcode')}}",
    type:"POST",
    data:{
      "_token":"{{ csrf_token() }}",
      "scanval":scanval},
    success:function(response){


      if(response == "false"){
        alert("No Barcode Matches Found In The Database. Please Enter a valid Code !")
        $("#scan_barcode_val").val(null);
        $("#noOfSampleDiv").css("display","none");
      }else if(response == "access_denied"){
          alert("Barcode is already alloted for Enrolment! Please provide a valid Code")
          $("#scan_barcode_val").val(null);
          $("#noOfSampleDiv").css("display","none");
      }else{
        // fstr= str.toUpperCase();
        var str = response;
        fstr = str.slice(0, -1);

		lstr=str.slice(-1);
      if(lstr == 'B'){
        alert("Sample B Code is not available");
        var div= document.createElement("div");
        div.className += "overlay";
        document.body.appendChild(div);
        $("#scan_barcode_val").val(null);
        $("#noOfSampleDiv").css("display","none");
        $("#enroll_label").val(null);
        $(".sampleId").val(null);
        location.reload();
      }else{
        // alert(lstr);
        // alert(no_of_sample)
          $("#enroll_label").val(fstr);
          $(".sampleId").val(response);
          display_codediv
          $("#noOfSampleDiv").css("display","block");
          $("#scan").addClass("hide");
          $("#display_codediv").removeClass("hide");
          $("#display_barcode").text(response);

      }

      }

    }

  });

  }


});
});
</script>
<script>
  $(document).ready(function() {
    $("#enter").addClass("hide");
    $('#toggle-event').change(function() {
      switchStatus = $(this).is(':checked');
      if(switchStatus == true){
      $("#scan").addClass("hide");
      $("#enter").removeClass("hide");
      $("#scan_barcode_val").val(null);
      $("#enroll_label").val(null);
      $(".sampleId").val(null);
      $("#display_codediv").addClass("hide");
      $("#display_barcode").text();
      $("#moreSample").empty();
      $("#noOfSampleDiv").css("display","none");
      $("#noOfSample").val(null);
      }else{
        $("#scan").removeClass("hide");
        $("#enter").addClass("hide");
          $("#enter_barcode_val").val(null);
          $("#enroll_label").val(null);
          $(".sampleId").val(null);
          $("#display_codediv").addClass("hide");
          $("#display_barcode").text();
          $("#moreSample").empty();
          $("#noOfSample").val(null);

      }

    })
  });
</script>

<script>
$(document).ready(function(){
$(".enter_barcode_val").live("blur",function(){
var enter_scanval=$(this).val();
var err=0;
if(enter_scanval.length < 11 || enter_scanval.length > 11){
err++;
$(".entererr").html("Please enter a valid code");
// alert("Please enter a valid code");
$("#enter_barcode_val").val(null);

}


if(enter_scanval == '' || enter_scanval == null ){
err++;
    $(".entererr").html("It cannot be empty");
//alert("It cannot be empty");
$("#enter_barcode_val").val(null);
}

if(err == 0){

  $.ajax({
    url:"{{ url('/entercode')}}",
    type:"POST",
    data:{
      "_token":"{{ csrf_token() }}",
      "enter_scanval":enter_scanval},
    success:function(response){

            if(response == "false"){
              alert("No Barcode Matches Found In The Database. Please Enter a valid Code !")
              $("#enter_barcode_val").val(null);
              $("#noOfSampleDiv").css("display","none");
            }else if(response == "access_denied"){
                alert("Barcode is already alloted for Enrolment! Please provide a valid Code")
                $("#enter_barcode_val").val(null);
                $("#noOfSampleDiv").css("display","none");
            }else{
              // fstr= str.toUpperCase();
              var str = response;
              fstr = str.slice(0, -1);

            lstr=str.slice(-1);
            if(lstr == 'B'){
              alert("Sample B Code is not available");
              var div= document.createElement("div");
              div.className += "overlay";
              document.body.appendChild(div);
              $("#enter_barcode_val").val(null);
              $("#noOfSampleDiv").css("display","none");
              $("#enroll_label").val(null);
              $(".sampleId").val(null);
              location.reload();
            }else{
              // alert(lstr);
              // alert(no_of_sample)
                $("#enroll_label").val(fstr);
                $(".sampleId").val(response);

                $("#noOfSampleDiv").css("display","block");
                $("#enter").addClass("hide");
                $("#display_codediv").removeClass("hide");
                $("#display_barcode").text(response);

            }

            }
    }
  });
}

});

});
</script>
<script>
// $("#other_sample_quality").
$(document).ready(function(){
      // $(".qualitylabel").removeClass("hide");
      // $(".othersample_quality").attr("required",true);
      // $(".othersample_quality").prop("type","text");
	$(".sample_quality").live('change', function(){
		var qualityval=$(this).val();
		// alert(qualityval);
		if(qualityval== 'other'){
		  $(".qualitylabel").removeClass("hide");
		  $(".othersample_quality").attr("required",true);
			$(".othersample_quality").prop("type","text");
		}else{

		  $(".qualitylabel").addClass("hide");
		  $(".othersample_quality").attr("required",false);
			$(".othersample_quality").prop("type","hidden");
		}
	});
	$('.submit_date').change(function(){
	   // alert(this.value);         
		
		$('.submit_date').val(this.value);
	});
});
</script>
@endsection
