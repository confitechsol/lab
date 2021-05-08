@extends('admin.layout.app-plain')
@section('content')

<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<style>
.seperator {
  height: 100%;
  width: 1px;
  background: black;
  top: 0;
  bottom: 0;
  position: absolute;
  left: 45%;
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
<div class="row page-titles">
<div class="col-md-5 col-8 align-self-center">
<h3 class="text-themecolor m-b-0 m-t-0">Test Request</h3>
@if($data['enroll_label'])
<h5>Enrolment ID: {{$data['enroll_label']}}</h5>
@endif
</div>
<!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
<!----------loader------------>
<div class="col-md-7 col-4 align-self-center">
<!-- <p  class="pull-right ">Enrolment ID : {{ str_pad($data['enroll_id'], 10, "0", STR_PAD_LEFT) }}</p> -->
</div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- Row -->


<div class="col-lg-12 col-xlg-12 col-md-12">
<div class="card">

<!-- Nav tabs -->
<ul class="nav nav-tabs profile-tab" role="tablist">
@if($data['reason']=='DX')

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#tab1" role="tab" aria-expanded="true">DX TB</a>
</li>
<!-- <li class="nav-item hide">
<a class="nav-link " data-toggle="tab" href="#tab2" role="tab" aria-expanded="false">FU TB</a>
</li> -->
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#tab3" role="tab" aria-expanded="false">DX DR TB</a>
</li>
<!--  <li class="nav-item hide">
<a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-expanded="false">FU DR TB</a>
</li> -->

@elseif($data['reason']=='FU')

<!--  <li class="nav-item hide">
<a class="nav-link" data-toggle="tab" href="#tab1" role="tab" aria-expanded="false">DX TB</a>
</li> -->
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#tab2" role="tab" aria-expanded="true">FU TB</a>
</li>
<!-- <li class="nav-item hide">
<a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-expanded="false">DX DR TB</a>
</li> -->
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-expanded="false">FU DR TB</a>
</li>

@endif
<!--  <li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-expanded="true">Diagnosis TB</a>
</li>
<li class="nav-item">
<a class="nav-link " data-toggle="tab" href="#tab2" role="tab" aria-expanded="false">Follow Up (smear)</a>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#tab3" role="tab">DSTB</a>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#tab4" role="tab">DRTB</a>
</li> -->
</ul>
 
<!-- Tab panes -->
<div class="tab-content">
@if($data['reason']=='DX')
<div class="tab-pane" id="tab1" role="tabpanel" >
<div class="card-block">

<form action="{{ url('/test_request') }}" method="post" id="dxtbform" class="form-horizontal form-material">
<h6>Name and type of referring facility</h6>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
<div class="row">
<div class="col ">
<label class="col-sm-12">Facility Type <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line facility_type" name="facility_type" required>

<option value="">--Select--</option>
<!-- @foreach ($data['facility_type'] as $key=> $facility_type)
<option
value="{{$facility_type['facility_type_id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility_type['facility_type_id'])
selected
@endif
>
{{$facility_type['name']}}
</option>

@endforeach -->
@foreach ($data['facility_types'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility['id'])
selected
@endif
>
{{$facility['name']}}
</option>

@endforeach
</select>
</div>


</div>
<div class="col hide facility_type_other">
<label class="col-md-6">Facility Type Other </label>
<div class="col-md-6">
<input type="text"  value="{{ old('facility_type_other', $data['testrequestservices']->facility_type_other) }}" class="form-control form-control-line" name="facility_type_other">
</div>
</div>
<div class="col ">
<label class="col-sm-12">State  <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="state" id="state3" required>
<option value="">--Select--</option>
@foreach ($data['state'] as $key=> $state)
<option
value="{{$state['STOCode']}}"
@if(isset($data['testrequest']->state) && $data['testrequest']->state == $state['STOCode'])
selected
@endif
>
{{$state['name']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">District  <span class="red">*</span>  </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="district" id="district3" required>
<option value="">--Select--</option>
@foreach ($data['district'] as $key=> $district)
<option
value="{{$district['DTOCode']}}"
@if(isset($data['testrequest']->district) && $data['testrequest']->district == $district['DTOCode'])
selected
@endif
>
{{$district['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">TBU  <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="tbu" id="tbu3"required>

<option value="">--Select--</option>
@foreach ($data['tbunit'] as $key=> $tbunit)
<option
value="{{$tbunit['TBUnitCode']}}"
@if(isset($data['testrequest']->tbu) && $data['testrequest']->tbu == $tbunit['TBUnitCode'])
selected
@endif
>
{{$tbunit['TBUnitName']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">Name of Facility  <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="facility_id" id="facility_id3"required>
<option value="">--Select--</option>
@foreach ($data['facility'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_id) && $data['testrequest']->facility_id == $facility['id'])
selected
@endif
>
{{$facility['DMC_PHI_Name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">H/O anti TB Rx for > 1 month   </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="ho_anti_tb" >
  <option value="">Choose</option>
<option value="yes"
@if($data['testrequestservices']->ho_anti_tb=="yes")
selected="selected"
@endif
>yes</option>
<option value="no"
@if($data['testrequestservices']->ho_anti_tb=="no")
selected="selected"
@endif
>no</option>
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">Diagnosis of TB   </label>
<div class="col-sm-12">

<select class="form-control form-control-line" name="diagnosis[]" multiple >
<option value="">--Select--</option>
@foreach ($data['diagnosis'] as $key=> $diagnosis)
<option
value="{{$diagnosis['diagnosis_id']}}"
@if(in_array($diagnosis['diagnosis_id'],$data['diagnosis_value']))
selected
@endif
>
{{$diagnosis['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">Predominant Symptom  </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="predmnnt_symptoms" >
<option value="">--Select--</option>
@foreach ($data['predominan_symptom'] as $key=> $predominan_symptom)
<option
value="{{$predominan_symptom['symptom_id']}}"
@if(isset($data['testrequest']->predmnnt_symptoms) && $data['testrequest']->predmnnt_symptoms == $predominan_symptom['symptom_id'])
selected
@endif
>
{{$predominan_symptom['name']}}
</option>

@endforeach

</select>
</div>
</div>
</div>
<div class="row">
  <div class="col">
  <label class="col-sm-12">No. of HCP visited before diagnosis of current episode  </label>
  <div class="col-sm-12">
  <input class="form-control form-control-line" type="text" name="no_of_hcp_visit" id="no_of_hcp_visit" value="<?php if(!empty($data['testrequestservices']->no_of_hcp_visit)){
    echo $data['testrequestservices']->no_of_hcp_visit;
  } ?>">
  </div>
  </div>

  <div class="col">
  <label class="col-sm-12">History of Previous ATT <span class="red">*</span> </label>
  <div class="col-sm-12">
    <select class="form-control form-control-line" name="history_previous_att" id="history_previous_att" required>
    <option value="">-- Choose --</option>
    <option value="yes" <?php if(!empty($data['testrequestservices']->history_previous_att)){
      if($data['testrequestservices']->history_previous_att == 'yes'){
        echo "selected";
      }
    } ?>>Yes</option>
    <option value="no" <?php if(!empty($data['testrequestservices']->history_previous_att)){
      if($data['testrequestservices']->history_previous_att == 'no'){
        echo "selected";
      }
    } ?>>No</option>
  </select>
  </div>
  </div>
</div>

<div class="row">
  @php( $sample_type_lower = strtolower( $data['sample_type'] ) )
  <div class="col">
    <label class="col-sm-12">Specimen Type Tested</label>
      <div class="col-sm-12">
      <select name="specimen_type_test" id="specimen_type_test" class="form-control form-control-line">
          <option value="">-- Choose --</option>
          <option value="sputum" {{ $sample_type_lower == 'sputum' ? 'selected' : '' }}>Sputum</option>
          <option value="other" {{ $sample_type_lower != 'sputum' ? 'selected' : '' }}>Other</option>
      </select>
    </div>
</div>
<div class="col" id="sputum">
  <label class="col-sm-12">Visual Appearance of Sputum <span class="red">*</span></label>
    <div class="col-sm-12">
    <select name="visual_appearance_sputum" id="visual_appearance_sputum" class="form-control form-control-line">
        <option value="">-- Choose --</option>
        <option value="Mucopurulent" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
          if($data['testrequestservices']->visual_appearance_sputum == 'Mucopurulent'){
            echo "selected";
          }
        } */  echo $data['sample_quality']=="Mucopurulent"?"selected":""; ?>>Mucopurulent</option>
        <option value="Blood Stained" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
          if($data['testrequestservices']->visual_appearance_sputum == 'Blood Stained'){
            echo "selected";
          }
        }*/ echo $data['sample_quality']=="Blood Stained"?"selected":""; ?>>Blood Stained</option>
          <option value="Saliva" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
            if($data['testrequestservices']->visual_appearance_sputum == 'Saliva'){
              echo "selected";
            }
          } */ echo $data['sample_quality']=="Saliva"?"selected":""; ?>>Saliva</option>
    </select>
  </div>
</div>
<div class="col" id="other">
    <div class="col-sm-12">
      <label>Detail of Others <?php //echo $sample_type_lower.' '.$data['sample_type_other']; ?></label>
      <input value="{{ $sample_type_lower != 'sputum' ? $sample_type_lower!='others'?$data['sample_type']:$data['sample_type_other'] : '' }}"
             type="text"
             id="specimen_type_other"
             name="specimen_type_other"
             class="form-control form-control-line"
			 placeholder="{{ $sample_type_lower != 'sputum' ? $sample_type_lower!='others'?$data['sample_type']:$data['sample_type_other'] : '' }}"/>

  </div>
</div>

</div>


<div class="row">
<div class="col ">
<label class="col-md-6">Duration in days  </label>
<div class="col-md-6">
<input type="number" value="{{ old('duration', $data['testrequest'] ? $data['testrequest']->duration : '') }}" class="form-control form-control-line" name="duration" >
</div>
</div>
<div class="col hide">
<label class="col-md-6">type <span class="red">*</span> </label>
<div class="col-md-6">
<input type="text"  class="form-control form-control-line" name="req_test_type" value="1" required>
</div>
</div>

</div>
<div class="row">

@foreach ($data['services'] as $key=> $services)
<div class="col-md-4 top5px">
<input class="service_array" id="{{$services['id']}}"
value="{{$services['id']}}"
@if(isset($data['_reqservices']) && is_array($data['_reqservices']) && in_array($services['id'], $data['_reqservices']))
checked=""
@endif
name="services[]"
type="checkbox">{{$services['name']}}
</div>
@endforeach
</div>

<!--<div class="dst_drugs hide">--->
<div class="row col-md-12 ">
<!--<label class="col-md-12">DST Drugs</label>---->
<div class="row col-md-6 dst_drugs_lc">
	
	<label class="col-md-12">LC DST Drugs</label>
	
	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlc = "";
		  //dd($data['existing_drugs_lc']);
	  if(!empty($data['existing_drugs_lc'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lc']))						  
		  {
			  
			  $checkedlc = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" value="{{$drugs['id']}}" <?php echo $checkedlc; ?> name="drugs[lcdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach

	</div>
	
	<div class="seperator"></div>
	<!---<div class="clearfix"></div>--->
	<div class="row col-md-6 dst_drugs_lj">
	
	<label class="col-md-12">LJ DST Drugs</label>
	
	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlj = "";
		  //dd($data['existing_drugs_lj']);
	  if(!empty($data['existing_drugs_lj'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lj']))						  
		  {
			  
			  $checkedlj = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checkedlj; ?> value="{{$drugs['id']}}" name="drugs[ljdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
</div>
<!--</div>--->

<div class="row">
<div class="col ">
<label class="col-md-12">Requestor Name   </label>
<div class="col-md-12">
<input type="text"  class="form-control form-control-line" name="requestor_name" value="{{ old('requestor_name', $data['testrequest'] ? $data['testrequest']->requestor_name : '') }}">
</div>
</div>
<?php // dd($data['testrequest']->designation); ?>
<div class="col ">
<label class="col-md-12">Designation   </label>
<div class="col-md-12">
<select  class="form-control form-control-line" name="designation" >
<option value="">--Select--</option>
@foreach ($data['designations'] as $key=> $designations)
<option
value="{{$designations['name']}}"
@if(isset($data['testrequest']->designation) && $data['testrequest']->designation == $designations['name'])
selected
@endif
>
{{$designations['name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-12">Contact Number   </label>
<div class="col-md-12">
<input type="text" maxlength="10" class="form-control form-control-line" id="contact_no_dxtb" name="contact_no" value="{{ old('contact_no', $data['testrequest'] ? $data['testrequest']->contact_no : '') }}" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)" oninvalid="setCustomValidity('Contact number can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}">
</div>
<p style="color:red;" id="error_contact_no_dxtb"></p>
</div>
<div class="col ">
<label class="col-md-12">Email Id   </label>
<div class="col-md-12">
<input type="email"  class="form-control form-control-line" value="{{ old('email_id', $data['testrequest'] ? $data['testrequest']->email_id : '') }}" name="email_id" >
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-6">Request Date  <span class="red">*</span> </label>
<div class="col-md-6">
<input type="date" value="{{ old('request_date', $data['testrequest'] ? $data['testrequest']->request_date : '') }}" class="form-control form-control-line "  max="<?php echo date("Y-m-d");?>" name="request_date" required>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<button id="save-btn" class="btn btn-info saveBtn">Save</button>
<button class="btn btn-warning" onclick="window.close();">Cancel</button>

</div>

</div>
</form>


</div>
</div>
<div class="tab-pane active" id="tab3" role="tabpanel" >
<div class="card-block">
<form action="{{ url('/test_request') }}" method="post" id="dxdrtbform" class="form-horizontal form-material">
<h6>Name and type of referring facility</h6>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
<div class="row">
<div class="col ">
<label class="col-sm-12">Facility Type <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line facility_type" name="facility_type" required>

<option value="">--Select--</option>
<!-- @foreach ($data['facility_type'] as $key=> $facility_type)
<option
value="{{$facility_type['facility_type_id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility_type['facility_type_id'])
selected
@endif
>
{{$facility_type['name']}}
</option>

@endforeach -->
@foreach ($data['facility_types'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility['id'])
selected
@endif
>
{{$facility['name']}}
</option>

@endforeach
</select>
</div>

</div>
<div class="col hide facility_type_other">
<label class="col-md-6">Facility Type Other </label>
<div class="col-md-6">
<input type="text"  value="{{ old('facility_type_other', $data['testrequestservices']->facility_type_other) }}" class="form-control form-control-line" name="facility_type_other">
</div>
</div>
<div class="col ">
<label class="col-sm-12">State <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="state" id="state2" required>
<option value="">--Select--</option>
@foreach ($data['state'] as $key=> $state)
<option
value="{{$state['STOCode']}}"
@if(isset($data['testrequest']->state) && $data['testrequest']->state == $state['STOCode'])
selected
@endif
>
{{$state['name']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">District <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="district" id="district2" required>
<option value="">--Select--</option>
@foreach ($data['district'] as $key=> $district)
<option
value="{{$district['DTOCode']}}"
@if(isset($data['testrequest']->district) && $data['testrequest']->district == $district['DTOCode'])
selected
@endif
>
{{$district['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">TBU <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="tbu" id="tbu2"required>

<option value="">--Select--</option>
@foreach ($data['tbunit'] as $key=> $tbunit)
<option
value="{{$tbunit['TBUnitCode']}}"
@if(isset($data['testrequest']->tbu) && $data['testrequest']->tbu == $tbunit['TBUnitCode'])
selected
@endif
>
{{$tbunit['TBUnitName']}}
</option>

@endforeach
</select>
</div>
</div>
</div>

<div class="row">
<div class="col ">
<label class="col-sm-12">Name of Facility <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="facility_id" id="facility_id2"required>
<option value="">--Select--</option>
@foreach ($data['facility'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_id) && $data['testrequest']->facility_id == $facility['id'])
selected
@endif
>
{{$facility['DMC_PHI_Name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<br>


<div class="row">
  <div class="col">
  <label class="col-sm-12">No. of HCP visited before diagnosis of current episode  </label>
  <div class="col-sm-12">
  <input class="form-control form-control-line" type="text" name="no_of_hcp_visit" id="no_of_hcp_visit" value="<?php if(!empty($data['testrequestservices']->no_of_hcp_visit)){
    echo $data['testrequestservices']->no_of_hcp_visit;
  } ?>">
  </div>
  </div>

  <div class="col">
  <label class="col-sm-12">History of Previous ATT <span class="red">*</span></label>
  <div class="col-sm-12">
    <select class="form-control form-control-line" name="history_previous_att" id="history_previous_att" required>
    <option value="">-- Choose --</option>
    <option value="yes" <?php if(!empty($data['testrequestservices']->history_previous_att)){
      if($data['testrequestservices']->history_previous_att == 'yes'){
        echo "selected";
      }
    } ?>>Yes</option>
    <option value="no" <?php if(!empty($data['testrequestservices']->history_previous_att)){
      if($data['testrequestservices']->history_previous_att == 'no'){
        echo "selected";
      }
    } ?>>No</option>
  </select>
  </div>
  </div>
</div>

<div class="row">

  <div class="col">
    <label class="col-sm-12">Specimen Type Tested</label>
      <div class="col-sm-12">
      <select name="specimen_type_test" id="specimen_type_test1" class="form-control form-control-line">
          <option value="">-- Choose --</option>
          <option value="sputum" <?php /*if(!empty($data['testrequestservices']->specimen_type_test)){
            if($data['testrequestservices']->specimen_type_test == 'sputum'){
              echo "selected";
            }
          }*/ echo $data['sample_type']=="Sputum"?"selected":""; ?>>Sputum</option>
          <option value="other" <?php /*if(!empty($data['testrequestservices']->specimen_type_test)){
            if($data['testrequestservices']->specimen_type_test == 'other'){
              echo "selected";
            }
          }*/ echo $data['sample_type']!="Sputum"?"selected":""; ?>>Other</option>
      </select>
    </div>
</div>
<div class="col" id="sputum1">
  <label class="col-sm-12">Visual Appearance of Sputum</label>
    <div class="col-sm-12">
    <select name="visual_appearance_sputum" id="visual_appearance_sputum1" class="form-control form-control-line">
        <option value="">-- Choose --</option>
        <option value="Mucopurulent" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
          if($data['testrequestservices']->visual_appearance_sputum == 'Mucopurulent'){
            echo "selected";
          }
        }*/ echo $data['sample_quality']=="Mucopurulent"?"selected":""; ?>>Mucopurulent</option>
        <option value="Blood Stained" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
          if($data['testrequestservices']->visual_appearance_sputum == 'Blood Stained'){
            echo "selected";
          }
        }*/ echo $data['sample_quality']=="Saliva"?"selected":"";  echo $data['sample_quality']=="Blood Stained"?"selected":""; ?>>Blood Stained</option>
          <option value="Saliva" <?php /*if(!empty($data['testrequestservices']->visual_appearance_sputum)){
            if($data['testrequestservices']->visual_appearance_sputum == 'Saliva'){
              echo "selected";
            }
          }*/  echo $data['sample_quality']=="Saliva"?"selected":"";?>>Saliva</option>
    </select>
  </div>
</div>
<div class="col" id="other1">
    <div class="col-sm-12">
      <label>Detail of Others</label>
    <input type="text" id="specimen_type_other1" name="specimen_type_other" class="form-control form-control-line" placeholder="" value="<?php echo  $data['sample_type'] != 'Sputum' ? $data['sample_type']!='Others'?$data['sample_type']:$data['sample_type_other'] : ''; ?>"/>

  </div>
</div>

</div>
<h6>Drug Susceptibility Testing DST :</h6>
<div class="row">
<div class="col ">
<label class="col-sm-12">Regimen </label>
<select class="form-control form-control-line" name="regimen[]" multiple >
<option value="New"
@if(in_array("New",$data['regimen']))
selected="selected"
@endif
>New</option>
<option value="Previously Treated"
@if(in_array("Previously Treated",$data['regimen']))
selected="selected"
@endif
>Previously Treated</option>

</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">Type of Presumptive DRTB</label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="type_of_prsmptv_drtb[]" multiple >

  <?php foreach($data['master_presumptive_drtb'] as $master_drtbs): ?>
<option value="<?php echo $master_drtbs->typeof_Presumptive_DRTB; ?>"
  <?php foreach ($data['type_of_prsmptv_drtb'] as $key => $value) {
  if($value == $master_drtbs->typeof_Presumptive_DRTB){
    echo "selected";
  }
  } ?>
><?php echo $master_drtbs->typeof_Presumptive_DRTB; ?></option>
<?php endforeach; ?>

</select>
</div>
</div>

</div>



<div class="row hide">
<div class="col ">
<label class="col-md-6">type <span class="red">*</span></label>
<div class="col-md-6">
<input type="text"  class="form-control form-control-line" name="req_test_type" value="3" required>
</div>
</div>
</div>
<div class="row col-md-12">

@foreach ($data['services'] as $key=> $services)
<div class="col-md-4 top5px">
<input class="service_array"
id="{{$services['id']}}-s"
value="{{$services['id']}}"
@if(isset($data['_reqservices']) && is_array($data['_reqservices']) && in_array($services['id'], $data['_reqservices']))
checked=""
@endif
name="services[]"
type="checkbox">{{$services['name']}}
</div>
@endforeach


</div>

<!--<div class="dst_drugs hide">--->
<div class="row col-md-12 ">

<!--<label class="col-md-12">DST Drugs</label>--->

	
	
	<div class="row col-md-6 dst_drugs_lc">
	
	<label class="col-md-12">LC DST Drugs</label>
	

	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlc = ""; 
		  //dd($data['existing_drugs_lc']);
	  if(!empty($data['existing_drugs_lc'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lc']))						  
		  {
			  
			  $checkedlc = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checkedlc; ?> value="{{$drugs['id']}}" name="drugs[lcdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
	
	<div class="seperator"></div>
	<!---<div class="clearfix"></div>--->
	<div class="row col-md-6 dst_drugs_lj">
	
	<label class="col-md-12">LJ DST Drugs</label>
	
	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlj = "";
		  //dd($data['existing_drugs_lj']);
	  if(!empty($data['existing_drugs_lj'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lj']))						  
		  {
			  
			  $checkedlj = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checkedlj; ?> value="{{$drugs['id']}}" name="drugs[ljdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
</div>
<!--</div>--->

<div class="row">
<div class="col ">
<label class="col-md-12">Requestor Name </label>
<div class="col-md-12">
<input type="text"  class="form-control form-control-line" value="{{ old('requestor_name', $data['testrequest'] ? $data['testrequest']->requestor_name : '') }}" name="requestor_name" >
</div>
</div>
<div class="col ">
<label class="col-md-12">Designation </label>
<div class="col-md-12">
<select  class="form-control form-control-line" name="designation" >
<option value="">--Select--</option>
@foreach ($data['designations'] as $key=> $designations)
<option
value="{{$designations['name']}}"
@if(isset($data['testrequest']->designation) && $data['testrequest']->designation == $designations['designation_id'])
selected
@endif
>
{{$designations['name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-12">Contact Number</label>
<div class="col-md-12">
  <input type="text"  class="form-control form-control-line" id="contact_no" name="contact_no" maxlength="10" value="{{ old('contact_no', $data['testrequest'] ? $data['testrequest']->contact_no : '') }}" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)"  oninvalid="setCustomValidity('Contact number can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" >
</div>
 <p style="color:red;" id="error_contact_no"></p>
</div>
<div class="col ">
<label class="col-md-12">Email Id </label>
<div class="col-md-12">
<input type="email" value="{{ old('email_id', $data['testrequest'] ? $data['testrequest']->email_id : '') }}" class="form-control form-control-line" name="email_id" >
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-6">Request Date <span class="red">*</span></label>
<div class="col-md-6">
<input type="date" value="{{ old('request_date', $data['testrequest'] ? $data['testrequest']->request_date : '') }}" class="form-control form-control-line " name="request_date" max="<?php echo date("Y-m-d");?>" required>


</div>
</div>
</div>
<br>
<div class="row">
<div class="col-12">
<button id="save-btn" class="btn btn-info saveBtn">Save</button>
<a class="btn btn-warning" href="{{url('/test_request')}}">Cancel</a>
<!-- <button class="btn btn-success">Preview</button>
<button class="btn ">Print</button> -->
</div>

</div>
</form>
</div>
</div>
@endif
@if($data['reason']=='FU')
<!--second tab-->
<div class="tab-pane active" id="tab2" role="tabpanel" >
<div class="card-block">
<form action="{{ url('/test_request') }}" id="futbform" method="post" class="form-horizontal form-material">
<h6>Name and type of referring facility</h6>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
<div class="row">
<div class="col ">
<label class="col-sm-12">Facility Type  <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line facility_type" name="facility_type" required>

<option value="">--Select--</option>
<!-- @foreach ($data['facility_type'] as $key=> $facility_type)
<option
value="{{$facility_type['facility_type_id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility_type['facility_type_id'])
selected
@endif
>
{{$facility_type['name']}}
</option>

@endforeach -->
@foreach ($data['facility_types'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility['id'])
selected
@endif
>
{{$facility['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col hide facility_type_other">
<label class="col-md-6">Facility Type Other </label>
<div class="col-md-6">
<input type="text"  value="{{ old('facility_type_other', $data['testrequestservices']->facility_type_other) }}" class="form-control form-control-line" name="facility_type_other">
</div>
</div>
<div class="col ">
<label class="col-sm-12">State  <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="state" id="state" required>
<option value="">--Select--</option>
@foreach ($data['state'] as $key=> $state)
<option
value="{{$state['STOCode']}}"
@if(isset($data['testrequest']->state) && $data['testrequest']->state == $state['STOCode'])
selected
@endif
>
{{$state['name']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">District  <span class="red">*</span> </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="district" id="district" required>
<option value="">--Select--</option>
@foreach ($data['district'] as $key=> $district)
<option
value="{{$district['DTOCode']}}"
@if(isset($data['testrequest']->district) && $data['testrequest']->district == $district['DTOCode'])
selected
@endif
>
{{$district['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">TBU  <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="tbu" id="tbu" required>

<option value="">--Select--</option>
@foreach ($data['tbunit'] as $key=> $tbunit)
<option
value="{{$tbunit['TBUnitCode']}}"
@if(isset($data['testrequest']->tbu) && $data['testrequest']->tbu == $tbunit['TBUnitCode'])
selected
@endif
>
{{$tbunit['TBUnitName']}}
</option>

@endforeach
</select>
</div>
</div>
</div>

<div class="row">
<div class="col ">
<label class="col-sm-12">Name of Facility  <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" id="facility_id" name="facility_id"required>
<option value="">--Select--</option>
@foreach ($data['facility'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_id) && $data['testrequest']->facility_id == $facility['id'])
selected
@endif
>
{{$facility['DMC_PHI_Name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">

<label class="col-md-12">RNTCP TB Reg No x  </label>
<div class="col-md-12">
<input type="number"  class="form-control form-control-line" value="{{ old('rntcp_reg_no', $data['testrequestservices']->rntcp_reg_no) }}" name="rntcp_reg_no" >

</div>
</div>
</div>
<br>
<h6>Follow Up (Smear and Culture) :</h6>
<div class="row">
<div class="col ">
<label class="col-sm-12">Regimen   </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="regimen" >
<option value="New"
@if($data['testrequestservices']->regimen=="New")
selected="selected"
@endif
>New</option>
<option value="Previously Treated"
@if($data['testrequestservices']->regimen=="Previously Treated")
selected="selected"
@endif
>Previously Treated</option>

</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">Follow-up Reasons  </label>
<div class="col-sm-12">

<select class="form-control form-control-line" name="reason" id="reason">  
	<option value="End IP" <?php if($data['fu_month']=="End IP"){ echo "selected='selected'"; } ?>>End IP</option>
	<option value="End CP" <?php if($data['fu_month']=="End CP"){ echo "selected='selected'"; } ?>>End CP</option>
	<option value="6 M" <?php if($data['fu_month']=="6 M"){ echo "selected='selected'"; } ?>>6 M</option>
	<option value="12 M" <?php if($data['fu_month']=="12 M"){ echo "selected='selected'"; } ?>>12 M</option>
	<option value="18 M" <?php if($data['fu_month']=="18 M"){ echo "selected='selected'"; } ?>>18 M</option>
	<option value="24 M" <?php if($data['fu_month']=="24 M"){ echo "selected='selected'"; } ?>>24 M</option>
	<option value="Other" <?php if(!in_array($data['fu_month'],array("End IP","End CP","6 M","12 M","18 M","24 M"))){ echo "selected='selected'"; } ?>>Other</option>
 </select>
</div>
</div>

<div class="col <?php if(in_array($data['fu_month'],array("End IP","End CP","6 M","12 M","18 M","24 M"))){ ?>hide<?php } ?> followup-other" id="followup-other">
	<label class="col-md-12">Other </label>
	<div class="col-md-12">
	   <input type="number" id="followup_otherA" name="followup_otherA" class="form-control form-control-line followup_otherA" <?php if(!in_array($data['fu_month'],array("End IP","End CP","6 M","12 M","18 M","24 M"))){ ?> value="<?php echo $data['fu_month']; ?>"<?php } ?>>
	</div>
</div>

<div class="col hide" id="other_post_treatment">
<label class="col-sm-12">Other</label>
<div class="col-sm-12">
<input type="text"  class="form-control form-control-line" name="other_post_treatment">
</div>
</div>
</div>
<div class="row hide">
<div class="col ">
<label class="col-md-6">type <span class="red">*</span> </label>
<div class="col-md-6">
<input type="text"  class="form-control form-control-line" name="req_test_type" value="2" required>
</div>
</div>
</div>
<div class="row">
@foreach ($data['services'] as $key=> $services)
<div class="col-md-4 top5px">
<input class="service_array"
id="{{$services['id']}}"
value="{{$services['id']}}"
@if(isset($data['_reqservices']) && is_array($data['_reqservices']) && in_array($services['id'], $data['_reqservices']))
checked=""
@endif
name="services[]"
type="checkbox">{{$services['name']}}
</div>
@endforeach
</div>
<!--<div class="dst_drugs hide">--->
<div class="row col-md-12 ">

<!--<label class="col-md-12">DST Drugs</label>--->

	
	
	<div class="row col-md-6 dst_drugs_lc">
	
	<label class="col-md-12">LC DST Drugs</label>
	
	
	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checked_lc = ""; 
		  //dd($data['existing_drugs_lc']);
	  if(!empty($data['existing_drugs_lc'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lc']))						  
		  {
			  
			  $checked_lc = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checked_lc; ?> value="{{$drugs['id']}}" name="drugs[lcdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
	
	<div class="seperator"></div>
	<!---<div class="clearfix"></div>--->
	<div class="row col-md-6 dst_drugs_lj">
	
	<label class="col-md-12">LJ DST Drugs</label>

	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	   $checked_lj = "";
		  //dd($data['existing_drugs_lj']);
	  if(!empty($data['existing_drugs_lj'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lj']))						  
		  {
			  
			  $checked_lj = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checked_lj; ?> value="{{$drugs['id']}}" name="drugs[ljdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
</div>
<!--</div>--->
<div class="row">
<div class="col ">
<label class="col-md-12">Requestor Name </label>
<div class="col-md-12">
<input type="text"  class="form-control form-control-line" name="requestor_name" value="{{ old('requestor_name', $data['testrequest'] ? $data['testrequest']->requestor_name : '') }}" >
</div>
</div>
<div class="col ">
<label class="col-md-12">Designation </label>
<div class="col-md-12">
<select  class="form-control form-control-line" name="designation" >
<option value="">--Select--</option>
@foreach ($data['designations'] as $key=> $designations)
<option
value="{{$designations['name']}}"
@if(isset($data['testrequest']->designation) && $data['testrequest']->designation == $designations['name'])
selected
@endif
>
{{$designations['name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-12">Contact Number </label>
<div class="col-md-12">
  <input type="text"  class="form-control form-control-line" id="contact_no_2" name="contact_no" maxlength="10"  value="{{ old('contact_no', $data['testrequest'] ? $data['testrequest']->contact_no : '') }}" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)" oninvalid="setCustomValidity('Contact number can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" >
</div>
 <p style="color:red;" id="error_contact_no_2"></p>
</div>
<div class="col ">
<label class="col-md-12">Email Id </label>
<div class="col-md-12">
<input type="email" value="{{ old('email_id', $data['testrequest'] ? $data['testrequest']->email_id : '') }}"  class="form-control form-control-line" name="email_id" >
</div>
</div>

</div>

<div class="row">
<div class="col ">
<label class="col-md-6">Request Date <span class="red">*</span></label>
<div class="col-md-6">
<input type="date" value="{{ old('request_date', $data['testrequest'] ? $data['testrequest']->request_date : '') }}"  max="<?php echo date("Y-m-d");?>" class="form-control form-control-line " name="request_date" required>
</div>
</div>
</div>
<br>
<div class="row">
<div class="col-12">
<button id="save-btn" class="btn btn-info saveBtn">Save</button>
<a class="btn btn-warning" href="{{url('/test_request')}}">Cancel</a>
<!-- <button class="btn btn-success">Preview</button>
<button class="btn ">Print</button> -->
</div>

</div>

</form>

</div>
</div>
<div class="tab-pane" id="tab4" role="tabpanel" >
<div class="card-block">

<form action="{{ url('/test_request') }}" id="fudrtbform" method="post" class="form-horizontal form-material">
<h6>Name and type of referring facility</h6>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="enroll_id" value="{{$data['enroll_id']}}">
<div class="row">
<div class="col ">
<label class="col-sm-12">Facility Type <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line facility_type" name="facility_type" required>

<option value="">--Select--</option>
<!-- @foreach ($data['facility_type'] as $key=> $facility_type)
<option
value="{{$facility_type['facility_type_id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility_type['facility_type_id'])
selected
@endif
>
{{$facility_type['name']}}
</option>

@endforeach -->
@foreach ($data['facility_types'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_type) && $data['testrequest']->facility_type == $facility['id'])
selected
@endif
>
{{$facility['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col hide facility_type_other">
<label class="col-md-6">Facility Type Other </label>
<div class="col-md-6">
<input type="text"  value="{{ old('facility_type_other', $data['testrequestservices']->facility_type_other) }}" class="form-control form-control-line" name="facility_type_other">
</div>
</div>
<div class="col ">
<label class="col-sm-12">State <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="state" id="state4" required>
<option value="">--Select--</option>
@foreach ($data['state'] as $key=> $state)
<option
value="{{$state['STOCode']}}"
@if(isset($data['testrequest']->state) && $data['testrequest']->state == $state['STOCode'])
selected
@endif
>
{{$state['name']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">District <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="district" id="district4" required>
<option value="">--Select--</option>
@foreach ($data['district'] as $key=> $district)
<option
value="{{$district['DTOCode']}}"
@if(isset($data['testrequest']->district) && $data['testrequest']->district == $district['DTOCode'])
selected
@endif
>
{{$district['name']}}
</option>

@endforeach
</select>
</div>
</div>
<div class="col ">
<label class="col-sm-12">TBU <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="tbu" id="tbu4"required>

<option value="">--Select--</option>
@foreach ($data['tbunit'] as $key=> $tbunit)
<option
value="{{$tbunit['TBUnitCode']}}"
@if(isset($data['testrequest']->tbu) && $data['testrequest']->tbu == $tbunit['TBUnitCode'])
selected
@endif
>
{{$tbunit['TBUnitName']}}
</option>

@endforeach
</select>
</div>
</div>
</div>
<div class="row">
<div class="col ">
<label class="col-sm-12">Name of Facility <span class="red">*</span></label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="facility_id" id="facility_id4"required>
<option value="">--Select--</option>
@foreach ($data['facility'] as $key=> $facility)
<option
value="{{$facility['id']}}"
@if(isset($data['testrequest']->facility_id) && $data['testrequest']->facility_id == $facility['id'])
selected
@endif
>
{{$facility['DMC_PHI_Name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<br>
<h6>Follow Up (Culture) :</h6>
<div class="row">
<div class="col ">
<label class="col-sm-6">PMDT TB No. </label>
<div class="col-md-6">
<input type="number" class="form-control form-control-line" value="{{ old('pmdt_tb_no', $data['testrequestservices']->pmdt_tb_no) }}" name="pmdt_tb_no" >
</div>
</div>
<div class="col hide">
<label class="col-sm-12">Presumptive XDR TB </label>
<div class="col-sm-12">
<select class="form-control form-control-line" name="prsmptv_xdr_tb" >
<option>At diagnosis</option>
<option>Contact of MDR/RR TB</option>
<option>Follow up SM+VE at  END IP</option>
<option>Private Referral</option>
<option>Presumptive H mono/poly</option>
<option>MDR/RR TB at Diagnosis</option>
<option>>= 4 months culture positive</option>
<option>3 monthly for persistent culture positives</option>
<option>Culture reversion</option>
<option>Failure of MDR/RR-TB regimen</option>
<option>Recurrant case of Second Line Treatment</option>


</select>
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-sm-6">Treatment (Month/Week) </label>
<div class="col-sm-6">
<select class="form-control form-control-line" name="month_week" >
<option value="Month"
@if($data['testrequestservices']->month_week=="Month")
selected="selected"
@endif
>Month</option>
<option value="Week"
@if($data['testrequestservices']->month_week=="Week")
selected="selected"
@endif
>Week</option>

</select>

</div>
<label class="col-sm-6">Month/Week No. </label>
<div class="col-sm-6">

<input type="text" class="form-control form-control-line" value="{{ old('treatment', $data['testrequestservices']->treatment) }}" name="treatment" >
</div>
</div>

<div class="col ">
<label class="col-sm-6">Follow-up Test Reason </label>
<div class="col-sm-6">
<select class="form-control form-control-line" name="regimen_fu" id="regimen_fu" >


@foreach($data['master_follow_up_testreasons'] as $master_follow_up_testreasons)
<option value="{{$master_follow_up_testreasons->Follow_up_TestReason }}"
@if($data['testrequestservices']->regimen_fu==$master_follow_up_testreasons->Follow_up_TestReason )
selected="selected"
@endif
>{{$master_follow_up_testreasons->Follow_up_TestReason }}</option>
@endforeach

<option value="Other"
@if($data['testrequestservices']->regimen_fu=="Other")
selected="selected"
@endif
>Other</option>

</select>
</div>
</div>
<div class="col hide" id="fudrtb_regimen_other">
<label class="col-sm-6">Follow-up Test Reason Other</label>
<div class="col-sm-6">
<input type="text" class="form-control form-control-line" value="{{ old('fudrtb_regimen_other', $data['testrequestservices']->fudrtb_regimen_other) }}" name="fudrtb_regimen_other">
</div>
</div>


<div class="col hide">
<label class="col-md-6">type <span class="red">*</span></label>
<div class="col-md-6">
<input type="text"  class="form-control form-control-line" name="req_test_type" value="4" required>
</div>
</div>

</div>
<br>
<div class="row">
@foreach ($data['services'] as $key=> $services)
<div class="col-md-4 top5px">
<input class="service_array"
id="{{$services['id']}}-fu"
value="{{$services['id']}}"
@if(isset($data['_reqservices']) && is_array($data['_reqservices']) && in_array($services['id'], $data['_reqservices']))
checked=""
@endif
name="services[]"
type="checkbox">{{$services['name']}}
</div>
@endforeach
</div>
<!--<div class="dst_drugs hide">--->
<div class="row col-md-12 ">

<!--<label class="col-md-12">DST Drugs</label>--->

	
	
	<div class="row col-md-6 dst_drugs_lc">
	
	<label class="col-md-12">LC DST Drugs</label>

	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlc = "";
		  //dd($data['existing_drugs_lc']);
	  if(!empty($data['existing_drugs_lc'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lc']))						  
		  {
			  
			  $checkedlc = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checkedlc; ?> value="{{$drugs['id']}}" name="drugs[lcdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
	
	<div class="seperator"></div>
	<!---<div class="clearfix"></div>--->
	<div class="row col-md-6 dst_drugs_lj">
	
	<label class="col-md-12">LJ DST Drugs</label>
	
	@foreach ($data['dstdrugs'] as $key=> $drugs)
	<?php 
	  $checkedlj = ""; 
		  //dd($data['existing_drugs_lj']);
	  if(!empty($data['existing_drugs_lj'])){
		  if (in_array($drugs['id'],$data['existing_drugs_lj']))						  
		  {
			  
			  $checkedlj = "checked";
			 
		  }
	  }
	?>
	<div class="col-md-4 ">
	   <input class="drugs_array" <?php echo $checkedlj; ?> value="{{$drugs['id']}}" name="drugs[ljdst][]" type="checkbox">{{$drugs['name']}}
	</div>
	@endforeach
	
	</div>
</div>
<!--</div>--->

<div class="row">
<div class="col ">
<label class="col-md-12">Requestor Name </label>
<div class="col-md-12">
<input type="text"  class="form-control form-control-line" name="requestor_name" value="{{ old('requestor_name', $data['testrequest'] ? $data['testrequest']->requestor_name : '') }}" >
</div>
</div>
<div class="col ">
<label class="col-md-12">Designation </label>
<div class="col-md-12">
<select  class="form-control form-control-line" name="designation" >
<option value="">--Select--</option>
@foreach ($data['designations'] as $key=> $designations)
<option
value="{{$designations['name']}}"
@if(isset($data['testrequest']->designation) && $data['testrequest']->designation == $designations['designation_id'])
selected
@endif
>
{{$designations['name']}}
</option>

@endforeach
</select>
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-12">Contact Number </label>
<div class="col-md-12">
  <input type="text"  class="form-control form-control-line" id="contact_no_3" name="contact_no" maxlength="10" value="{{ old('contact_no', $data['testrequest'] ? $data['testrequest']->contact_no : '') }}" onkeypress="return isNumberKey(event)" oninvalid="setCustomValidity('Contact number can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}">
</div>
 <p style="color:red;" id="error_contact_no_3"></p>
</div>
<div class="col ">
<label class="col-md-12">Email Id </label>
<div class="col-md-12">
<input type="email" value="{{ old('email_id', $data['testrequest'] ? $data['testrequest']->email_id : '') }}" class="form-control form-control-line" name="email_id" >
</div>
</div>

</div>
<div class="row">
<div class="col ">
<label class="col-md-6">Request Date <span class="red">*</span></label>
<div class="col-md-6">
<input type="date"  value="{{ old('request_date', $data['testrequest'] ? $data['testrequest']->request_date : '') }}" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line " name="request_date" required>


</div>
</div>

</div>
<br>

<div class="row">
<div class="col-12">
<button id="save-btn" class="btn btn-info saveBtn">Save</button>
<a class="btn btn-warning" href="{{url('/test_request')}}">Cancel</a>
<!-- <button class="btn btn-success">Preview</button>
<button class="btn ">Print</button> -->
</div>

</div>

</form>


</div>
</div>
@endif

</div>
</div>
</div>




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

	$("#contact_no").on("keyup",function(){
	// console.log(isNaN(this.value))

		if(this.value.length == '' || this.value.length == null){
			document.getElementById('error_contact_no').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		}else{

		  if(this.value.length < 10 || this.value.length > 10 || isNaN(this.value) == true){
			document.getElementById('error_contact_no').innerHTML="Please specify a 10 digit numeric value";
			//document.getElementsByClassName("saveBtn").disabled=true;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}
		  }else{
			document.getElementById('error_contact_no').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }
		}

	});
	$("#contact_no").on("keyup paste",function(){ //alert();
		  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
			document.getElementById('error_contact_no').innerHTML="Please specify a 10 digit numeric value"; 
             var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}			
		  }else if(this.value.trim().length==0){
			document.getElementById('error_contact_no').innerHTML="";
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}			
		  }else {
			document.getElementById('error_contact_no').innerHTML="";
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }

   });
   
   $("#contact_no_dxtb").on("keyup",function(){
	// console.log(isNaN(this.value))

		if(this.value.length == '' || this.value.length == null){
			document.getElementById('error_contact_no_dxtb').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		}else{

		  if(this.value.length < 10 || this.value.length > 10 || isNaN(this.value) == true){
			document.getElementById('error_contact_no_dxtb').innerHTML="Please specify a 10 digit numeric value";
			//document.getElementsByClassName("saveBtn").disabled=true;
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}
		  }else{
			document.getElementById('error_contact_no_dxtb').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }
		}

	});
	$("#contact_no_dxtb").on("keyup paste",function(){ //alert();
		  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
			document.getElementById('error_contact_no_dxtb').innerHTML="Please specify a 10 digit numeric value"; 
            //document.getElementsByClassName("saveBtn").disabled=true;
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}			
		  }else if(this.value.trim().length==0){
			document.getElementById('error_contact_no_dxtb').innerHTML=""; 
            //document.getElementsByClassName("saveBtn").disabled=false;
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}			
		  }else {
			document.getElementById('error_contact_no_dxtb').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }

   });
   $("#contact_no_2").on("keyup",function(){
	// console.log(isNaN(this.value))

		if(this.value.length == '' || this.value.length == null){
			document.getElementById('error_contact_no_2').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		}else{

		  if(this.value.length < 10 || this.value.length > 10 || isNaN(this.value) == true){
			document.getElementById('error_contact_no_2').innerHTML="Please specify a 10 digit numeric value";
			//document.getElementsByClassName("saveBtn").disabled=true;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}

		  }else{
			document.getElementById('error_contact_no_2').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }
		}

	});
	$("#contact_no_2").on("keyup paste",function(){ //alert();
		  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
			document.getElementById('error_contact_no_2').innerHTML="Please specify a 10 digit numeric value";
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}			
		  }else if(this.value.trim().length==0){
			document.getElementById('error_contact_no_2').innerHTML=""; 
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}			
		  }else {
			document.getElementById('error_contact_no_2').innerHTML="";
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }

   });
   
   $("#contact_no_3").on("keyup",function(){
	// console.log(isNaN(this.value))

		if(this.value.length == '' || this.value.length == null){
			document.getElementById('error_contact_no_3').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		}else{

		  if(this.value.length < 10 || this.value.length > 10 || isNaN(this.value) == true){
			document.getElementById('error_contact_no_3').innerHTML="Please specify a 10 digit numeric value";
			//document.getElementsByClassName("saveBtn").disabled=true;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}

		  }else{
			document.getElementById('error_contact_no_3').innerHTML="";
			//document.getElementsByClassName("saveBtn").disabled=false;
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }
		}

	});
	$("#contact_no_3").on("keyup paste",function(){ //alert();
		  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
			document.getElementById('error_contact_no_3').innerHTML="Please specify a 10 digit numeric value";
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = true;
			}			
		  }else if(this.value.trim().length==0){
			document.getElementById('error_contact_no_3').innerHTML=""; 
            var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}			
		  }else {
			document.getElementById('error_contact_no_3').innerHTML="";
			var elems = document.getElementsByClassName("saveBtn");
			for(var i = 0; i < elems.length; i++) {
				elems[i].disabled = false;
			}
		  }

   });
   
   
});
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
	}else{	
	       //alert( document.getElementById("primary_no").value);
	       //var y = document.createForm.mobile_number.value;
	       if(($('#contact_no').length && document.getElementById("contact_no").value.charAt(0)=="0")||($('#contact_no_dxtb').length && document.getElementById("contact_no_dxtb").value.charAt(0)=="0")||($('#contact_no_2').length && document.getElementById("contact_no_2").value.charAt(0)=="0")||($('#contact_no_3').length && document.getElementById("contact_no_3").value.charAt(0)=="0"))
           {
                //alert("it should start with 9 ");
                return false
           }else{
              return true;
		   }
		   
	}
}
</script>
<script>
$(document).ready(function(){
  $("#dxtbform,#dxdrtbform,#fudrtbform,#futbform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready

@if(isset($data['testrequest']->req_test_type))
activaTab('tab{{$data['testrequest']->req_test_type}}')
@endif
var dst_id = [{{$data['dst_id']}}];
function activaTab(tab){
$('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
$(document).ready(function() {
$("#reason").change(function(){ 
	var _sample = $(this).find(":selected").val();
	//alert(_sample);
	if(_sample=='Other'){
		$("#followup-other").removeClass("hide");
		document.getElementById("followup_otherA").setAttribute("required",true);
		//alert($("#followup_otherA").val());
	    $(this).find(":selected").val($("#followup_otherA").val());
	}else{
	  $("#followup-other").addClass("hide");
	  document.getElementById("followup_otherA").removeAttribute("required",false);
	  $("#reason option").last().val("Other");
	}
});
$("#followup_otherA").on("change keyup paste click", function(){
    //alert($(this).val());
	 $("#reason option").last().val($(this).val());
})
var _sample = $('#regimen_fu').find(":selected").val();
if(_sample=='Other'){
$("#fudrtb_regimen_other").removeClass("hide");
}else{
$("#fudrtb_regimen_other").addClass("hide");
}

var _sample = $('.facility_type').find(":selected").val();
if(_sample==13){
$(".facility_type_other").removeClass("hide");
}else{
$(".facility_type_other").addClass("hide");
}


//hide drugs
$(".dst_drugs_lc").hide();
$(".dst_drugs_lj").hide();


$('.service_array').each(function () {
	if(this.checked){ //alert($(this).val());
		if($(this).val()==21||$(this).val()==22){
			$(".dst_drugs_lc").show();
            $(".dst_drugs_lj").show();
		}else{
			//Tab click hide
				$('a[data-toggle=tab]').click(function(){
					$(".dst_drugs_lc").hide();
					$(".dst_drugs_lj").hide();
				});
		}
	}
  
});

$('.service_array').click(function(){
	if($(this).is(':checked')){
		//var index = dst_id.indexOf(parseInt($(this).val()));
		if(parseInt($(this).val())==21){
			console.log("lc dst checked",$(this).val());
			$(".dst_drugs_lc").show();
		}
		if(parseInt($(this).val())==22){
			console.log("lj dst checked",$(this).val());
			$(".dst_drugs_lj").show();
		}
	}else{
		//alert(parseInt($(this).val()));
		//var index = dst_id.indexOf(parseInt($(this).val()));
		//alert(index);
		if(parseInt($(this).val())==21){
			console.log("lc dst unchecked",$(this).val());
			$(".dst_drugs_lc").hide();
		}
		if(parseInt($(this).val())==22){
			console.log("lj dst unchecked",$(this).val());
			$(".dst_drugs_lj").hide();
		}
	}
});

$("#regimen_fu").change(function(){
var _sample = $(this).find(":selected").val();
if(_sample=='Other'){
$("#fudrtb_regimen_other").removeClass("hide");
document.getElementById("fudrtb_regimen_other").setAttribute("required",true);
}else{
$("#fudrtb_regimen_other").addClass("hide");
document.getElementById("fudrtb_regimen_other").removeAttribute("required",false);
}
});

$(".facility_type").change(function(){
var _sample = $(this).find(":selected").val();
if(_sample==13){
	$(".facility_type_other").removeClass("hide");
	$(".facility_type_other").removeAttr("required",true);
}else{
	$(".facility_type_other").addClass("hide");
	$(".facility_type_other").removeAttr("required",false);
}
});

$("#post_treatment").change(function(){
var _sample = $(this).find(":selected").val();
if(_sample=='Other'){
$("#other_post_treatment").removeClass("hide");
document.getElementById("other_post_treatment").setAttribute("required",true);
}else{
$("#other_post_treatment").addClass("hide");
document.getElementById("other_post_treatment").removeAttribute("required",false);
}
});

$("#state").change( function() {
var state = $(this).val();

$.ajax({
url: "{{url('district')}}"+'/'+state,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#district option").remove();
$('#district').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.district, function (i, item) {
$('#district').append($('<option>', {
value: item.DTOCode,
text : item.name
}));
});
},
error: function() {
console.log("err")
}
});
});
$("#district3").change( function() {
var district = $(this).val();
var state = $('#state3').val();"facility_type"
// $.ajax({
//     url: "{{url('phi')}}"+'/'+state+'/'+district,
//     type:"GET",
//     processData: false,
//     contentType: false,
//     dataType : "json",
//     success: function(items) {
//
//         //$('#district').html();
//         $("#facility_id3 option").remove();
//         $('#facility_id3').append($('<option>', {
//             value: '',
//             text : 'Select'
//         }))
//         $.each(items.phi, function (i, item) {
//             $('#facility_id3').append($('<option>', {
//                 value: item.id,
//                 text : item.DMC_PHI_Name
//             }));
//         });
//     },
//     error: function() {
//       console.log("err")
//   }
// });
$.ajax({
url: "{{url('tbunit')}}"+'/'+state+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#tbu3 option").remove();
$('#tbu3').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.tbunit, function (i, item) {
$('#tbu3').append($('<option>', {
value: item.TBUnitCode,
text : item.TBUnitName
}));
});
},
error: function() {
console.log("err")
}
});

});

$("#tbu3").change( function() {
var tbu = $(this).val();
var state = $('#state3').val();
var district = $('#district3').val();

//alert(district,state);

$.ajax({
url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#facility_id3 option").remove();
$('#facility_id3').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.phi, function (i, item) {
$('#facility_id3').append($('<option>', {
value: item.id,
text : item.DMC_PHI_Name
}));
});
},
error: function() {
console.log("err")
}
});
});

$("#district").change( function() {
var district = $(this).val();
var state = $('#state').val();
// $.ajax({
//     url: "{{url('phi')}}"+'/'+state+'/'+district,
//     type:"GET",
//     processData: false,
//     contentType: false,
//     dataType : "json",
//     success: function(items) {
//
//         //$('#district').html();
//         $("#facility_id option").remove();
//         $('#facility_id').append($('<option>', {
//             value: '',
//             text : 'Select'
//         }))
//         $.each(items.phi, function (i, item) {
//             $('#facility_id').append($('<option>', {
//                 value: item.id,
//                 text : item.DMC_PHI_Name
//             }));
//         });
//     },
//     error: function() {
//       console.log("err")
//   }
// });

$.ajax({
url: "{{url('tbunit')}}"+'/'+state+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#tbu option").remove();
$('#tbu').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.tbunit, function (i, item) {
$('#tbu').append($('<option>', {
value: item.TBUnitCode,
text : item.TBUnitName
}));
});
},
error: function() {
console.log("err")
}
});
});

$("#tbu").change( function() {
var tbu = $(this).val();
var state = $('#state').val();
var district = $('#district').val();
//alert(district,state);

$.ajax({
url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#facility_id option").remove();
$('#facility_id').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.phi, function (i, item) {
$('#facility_id').append($('<option>', {
value: item.id,
text : item.DMC_PHI_Name
}));
});
},
error: function() {
console.log("err")
}
});
});

$("#district4").change( function() {
var district = $(this).val();
var state = $('#state4').val();
// $.ajax({
//     url: "{{url('phi')}}"+'/'+state+'/'+district,
//     type:"GET",
//     processData: false,
//     contentType: false,
//     dataType : "json",
//     success: function(items) {
//
//         //$('#district').html();
//         $("#facility_id4 option").remove();
//         $('#facility_id4').append($('<option>', {
//             value: '',
//             text : 'Select'
//         }))
//         $.each(items.phi, function (i, item) {
//             $('#facility_id4').append($('<option>', {
//                 value: item.id,
//                 text : item.DMC_PHI_Name
//             }));
//         });
//     },
//     error: function() {
//       console.log("err")
//   }
// });

$.ajax({
url: "{{url('tbunit')}}"+'/'+state+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#tbu4 option").remove();
$('#tbu4').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.tbunit, function (i, item) {
$('#tbu4').append($('<option>', {
value: item.TBUnitCode,
text : item.TBUnitName
}));
});
},
error: function() {
console.log("err")
}
});
});

$("#tbu4").change( function() {
var tbu = $(this).val();
var state = $('#state4').val();
var district = $('#district4').val();

//alert(district,state);

$.ajax({
url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#facility_id4 option").remove();
$('#facility_id4').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.phi, function (i, item) {
$('#facility_id4').append($('<option>', {
value: item.id,
text : item.DMC_PHI_Name
}));
});
},
error: function() {
console.log("err")
}
});
});


$("#district2").change( function() {
var district = $(this).val();
var state = $('#state2').val();
// $.ajax({
//     url: "{{url('phi')}}"+'/'+state+'/'+district,
//     type:"GET",
//     processData: false,
//     contentType: false,
//     dataType : "json",
//     success: function(items) {
//
//         //$('#district').html();
//         $("#facility_id2 option").remove();
//         $('#facility_id2').append($('<option>', {
//             value: '',
//             text : 'Select'
//         }))
//         $.each(items.phi, function (i, item) {
//             $('#facility_id2').append($('<option>', {
//                 value: item.id,
//                 text : item.DMC_PHI_Name
//             }));
//         });
//     },
//     error: function() {
//       console.log("err")
//   }
// });

$.ajax({
url: "{{url('tbunit')}}"+'/'+state+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#tbu2 option").remove();
$('#tbu2').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.tbunit, function (i, item) {
$('#tbu2').append($('<option>', {
value: item.TBUnitCode,
text : item.TBUnitName
}));
});
},
error: function() {
console.log("err")
}
});
});


$("#tbu2").change( function() {
var tbu = $(this).val();
var state = $('#state2').val();
var district = $('#district2').val();
//alert(district,state);

$.ajax({
url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#facility_id2 option").remove();
$('#facility_id2').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.phi, function (i, item) {
$('#facility_id2').append($('<option>', {
value: item.id,
text : item.DMC_PHI_Name
}));
});
},
error: function() {
console.log("err")
}
});
});


$("#state4").change( function() {
var state = $(this).val();

$.ajax({
url: "{{url('district')}}"+'/'+state,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#district4 option").remove();
$('#district4').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.district, function (i, item) {
$('#district4').append($('<option>', {
value: item.DTOCode,
text : item.name
}));
});
},
error: function() {
console.log("err")
}
});
});
$("#state2").change( function() {
var state = $(this).val();

$.ajax({
url: "{{url('district')}}"+'/'+state,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#district2 option").remove();
$('#district2').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.district, function (i, item) {
$('#district2').append($('<option>', {
value: item.DTOCode,
text : item.name
}));
});
},
error: function() {
console.log("err")
}
});
});
$("#state3").change( function() {
var state = $(this).val();

$.ajax({
url: "{{url('district')}}"+'/'+state,
type:"GET",
processData: false,
contentType: false,
dataType : "json",
success: function(items) {

//$('#district').html();
$("#district3 option").remove();
$('#district3').append($('<option>', {
value: '',
text : 'Select'
}))
$.each(items.district, function (i, item) {
$('#district3').append($('<option>', {
value: item.DTOCode,
text : item.name
}));
});
},
error: function() {
console.log("err")
}
});
});

});
</script>
<script>
$(document).ready(function(){

$("#contact_no").on("keyup",function(){
console.log(isNaN(this.value))
  if(isNaN(this.value)){
    var confirm=alert("Not a valid Number");
  $("#save-btn").css("display","none");

  }else{

  $("#save-btn").css("display","inline-block");
  $("#save-btn").css("margin-left", "1%");
  }

});
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"/></script>
<script>
$(document).ready(function(){

$("#4").live('click',function(){

if(this.checked){
$("#5").prop("disabled","true");
$("#6").prop("disabled","true");
}else{
$("#5").removeAttr("disabled");
$("#6").removeAttr("disabled");
}

});


$("#5").live('click',function(){
if(this.checked){
$("#4").prop("disabled","true");
$("#6").prop("disabled","true");
}else{
$("#4").removeAttr("disabled");
$("#6").removeAttr("disabled");
}
});


$("#6").live('click',function(){
if(this.checked){
$("#4").prop("disabled","true");
$("#5").prop("disabled","true");
}else{
$("#4").removeAttr("disabled");
$("#5").removeAttr("disabled");
}
});


});
</script>
<script>
$(document).ready(function(){

$("#4-s").live('click',function(){

if(this.checked){
$("#5-s").prop("disabled","true");
$("#6-s").prop("disabled","true");
}else{
$("#5-s").removeAttr("disabled");
$("#6-s").removeAttr("disabled");
}

});


$("#5-s").live('click',function(){
if(this.checked){
$("#4-s").prop("disabled","true");
$("#6-s").prop("disabled","true");
}else{
$("#4-s-s").removeAttr("disabled");
$("#6-s-s").removeAttr("disabled");
}
});


$("#6-s").live('click',function(){
if(this.checked){
$("#4-s").prop("disabled","true");
$("#5-s").prop("disabled","true");
}else{
$("#4-s").removeAttr("disabled");
$("#5-s").removeAttr("disabled");
}
});


});
</script>

<script>
$(document).ready(function(){

$("#4-fu").live('click',function(){

if(this.checked){
$("#5-fu").prop("disabled","true");
$("#6-fu").prop("disabled","true");
}else{
$("#5-fu").removeAttr("disabled");
$("#6-fu").removeAttr("disabled");
}

});


$("#5-fu").live('click',function(){
if(this.checked){
$("#4-fu").prop("disabled","true");
$("#6-fu").prop("disabled","true");
}else{
$("#4-fu").removeAttr("disabled");
$("#6-fu").removeAttr("disabled");
}
});


$("#6-fu").live('click',function(){
if(this.checked){
$("#4-fu").prop("disabled","true");
$("#5-fu").prop("disabled","true");
}else{
$("#4-fu").removeAttr("disabled");
$("#5-fu").removeAttr("disabled");
}
});


});
</script>

<script>
$(document).ready(function(){

    function sample_type_fields(){

        var specimen_val = $("#specimen_type_test").val();

        if(specimen_val == '' || specimen_val == null ){
            $("#other").addClass("hide");
            $("#sputum").addClass("hide");
            $("#specimen_type_other").removeAttr("required",false);
            $("#visual_appearance_sputum").removeAttr("required",false);
        }else if(specimen_val == 'sputum'){
            $("#sputum").removeClass("hide");
            $("#other").addClass("hide");
            $("#visual_appearance_sputum").attr("required",true);
            $("#specimen_type_other").removeAttr("required",false);
        } else {
            $("#visual_appearance_sputum").removeAttr("required",false);
            $("#specimen_type_other").attr("required",true);
            $("#other").removeClass("hide");
            $("#sputum").addClass("hide");
        }

        //$('#specimen_type_other').val('');
    }

    sample_type_fields();
    $("#specimen_type_test").change(sample_type_fields);
	
	function sample_type_fields1(){

        var specimen_val = $("#specimen_type_test1").val();

        if(specimen_val == '' || specimen_val == null ){
            $("#other1").addClass("hide");
            $("#sputum1").addClass("hide");
            $("#specimen_type_other1").removeAttr("required",false);
            $("#visual_appearance_sputum1").removeAttr("required",false);
        }else if(specimen_val == 'sputum'){
            $("#sputum1").removeClass("hide");
            $("#other1").addClass("hide");
            $("#visual_appearance_sputum1").removeAttr("required",true);
            $("#specimen_type_other1").removeAttr("required",false);
			//$("input").prop('required',true);
        } else { alert
            $("#visual_appearance_sputum1").removeAttr("required",false);
            $("#specimen_type_other1").removeAttr("required",true);
            $("#other1").removeClass("hide");
            $("#sputum1").addClass("hide");
        }

        //$('#specimen_type_other1').val('');
    }

    sample_type_fields1();
    $("#specimen_type_test1").change(sample_type_fields1);

});
</script>
@endsection
