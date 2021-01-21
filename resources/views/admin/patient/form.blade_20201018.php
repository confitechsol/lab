<?php $edit_patient = $data['patient']->id > 0; ?>
@extends($edit_patient > 0 ? 'admin.layout.app-plain' : 'admin.layout.app')
@section('content')
<?php // dd($masters); ?>
<style>

input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}

.sector_radio {
    opacity: 1 !important;
    position: relative !important;
    left: 0px !important;
    padding-right: 10px !important;
    margin-right: 5px;
    font-size: 12px !important;

}
.my_con {

    font-size: 12px;
    margin-bottom: 10px;
    margin-top: 10px;
    font-weight: unset;
    line-height: 24px;
    background: #eee;
    padding: 10px;

}

#sec_heading {

    margin-left: 1%;
    margin-bottom: 2%;

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
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="{{ $edit_patient ? '' : 'page-wrapper' }}">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> Enrolment</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <p  class="pull-right ">Enrolment ID : {{$data['label']}}</p>
                   </div>
                </div>

               <!--  <form action="{{ url('/enroll') }}" class="form-horizontal form-material" method="post" enctype='multipart/form-data'>
 -->                
                 <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                @if($data['patient']->id > 0)
                   <form id="createForm" action="{{ url('/enroll/patient/'.$data['patient']->id) }}" method="post">
                     <input name="_method" type="hidden" value="patch">
                   @else
                   <form id="createForm" action="{{ url('/enroll/patient') }}" method="post" role="alert">
                 @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">
                                  <div class="row">
                                    <div class="col ">
                                       <label class="col-md-12">I want to add a patient from <span class="red">*</span></label>
                                        <div class="col-md-12 my_con">
                                <input type="radio"  name="sector_radio" class="sector_radio" value="public" {{ (empty( $data['patient']->sector_radio ) OR $data['patient']->sector_radio == 'public') ? 'checked' : '' }} required />Public Sector
                                <br/>
                                <input type="radio"  name="sector_radio" class="sector_radio" value="private" @if( $data['patient']->sector_radio == 'private')checked @endif  required />Private Sector
                                       </div>
                                    </div>
                                  </div>
                                  <h4 id="sec_heading"></h4>
                                    <div class="row">

                                        <div class="col ">
                                           <label class="col-md-12">Nikshay ID </label>
                                            <div class="col-md-12">
                                               <input type="text"  name="nikshay_id" value="{{ old('nikshay_id', $data['patient']->nikshay_id) }}" class="form-control form-control-line" readonly>
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12"> Health Establishment ID </label>
                                            <div class="col-md-12">
                                               <input type="text" name="health_establish_id" value="{{ old('health_establish_id', $data['patient']->health_establish_id) }}"  class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State  <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="state" class="form-control form-control-line" id="state" required>
                                                        <option value="">Select</option>
                                                        @foreach ($data['state'] as $key=> $state)
														    <?php 
															$sel="";
															if(!empty($data['patient']->state)){
																if($data['patient']->state==$state['STOCode']){
																	$sel='selected="selected"';
																}	
															}else{ 
															   if($data['login_user_phi_rln']->STOCode==$state['STOCode']){ 
																   $sel='selected="selected"';
																} 
															}
															?>
                                                                <option value="{{$state['STOCode']}}" <?php echo $sel; ?>>{{$state['name']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>

                                        <div class="col ">
                                            <label class="col-sm-12">District  <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="district" class="form-control form-control-line"  id="district" required>
                                                        <option value="">Select</option>
                                                        <!-- @foreach ($data['district'] as $key=> $district)
                                                                @if($data['patient']->district==$district->id)
                                                                 <option value="{{$district['id']}}"  selected="selected">{{$district['name']}}</option>>
                                                                @endif

                                                        @endforeach -->
                                                        @foreach ($data['district'] as $key=> $facility)
                                                          <option
                                                            value="{{$facility['DTOCode']}}"
                                                            <?php if(isset($data['patient']->district) && $data['patient']->district == $facility['DTOCode']){ ?>
                                                              selected="selected"
															<?php }elseif($data['login_user_phi_rln']->DTOCode==$facility['DTOCode']){ ?>
                                                                   selected="selected"
															<?php } ?>  
                                                           
                                                          >
                                                          {{$facility['name']}}
                                                          </option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-sm-12">TU <span class="red">*</span> </label>
                                                <div class="col-sm-12">
                                                    <select name="tb" id="tb" class="form-control form-control-line" required >
                                                        <option>--Select--</option>
                                                         <!-- @foreach ($data['tb'] as $key=> $tb)

                                                                @if($data['patient']->tb==$tb->id)
                                                                 <option value="{{$tb->id}}"  selected="selected">{{$tb->name}}</option>

                                                                @endif
                                                                <option value="{{$tb->id}}" >{{$tb->name}}</option>

                                                        @endforeach -->

                                                        @foreach ($data['tb'] as $key=> $facility)
                                                          <option
                                                            value="{{$facility['TBUnitCode']}}"
                                                            @if(isset($data['patient']->tb) && $data['patient']->tb == $facility['TBUnitCode'])
                                                              selected
                                                            @endif
                                                          >
                                                          {{$facility['TBUnitName']}}
                                                          </option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">PHI <span class="red">*</span> </label>
                                                <div class="col-sm-12">
                                                    <select name="phi" id="phi" class="form-control form-control-line" required>

                                                         <option>--Select--</option>
                                                         <!-- @foreach ($data['phi'] as $key=> $phi)

                                                                @if($data['patient']->phi==$phi->id)
                                                                 <option value="{{$phi->id}}"  selected="selected">{{$phi->name}}</option>

                                                                @endif
                                                                <option value="{{$phi->id}}" >{{$phi->name}}</option>

                                                        @endforeach -->
                                                        @foreach ($data['phi'] as $key=> $facility)
                                                          <option
                                                            value="{{$facility['id']}}"
                                                            @if(isset($data['patient']->phi) && $data['patient']->phi == $facility['id'])
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
<?php //dd($data['patient']->gender); ?>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">First Name  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="firstname" id="firstname" value="<?php echo !empty($data['first_name'])?$data['first_name']:$data['name'];?>" class="form-control form-control-line" required>
                                           </div>
                                           <label class="col-md-12"> Gender  <span class="red">*</span></label>
                                           <div class="col-md-12">
                                             <select name="gender" id="gender" class="form-control" required>
                                               <option value="male" <?php if($data['patient']->gender == 'male'){
                                                 echo "selected";
                                               } ?>>Male</option>
                                               <option value="female" <?php if($data['patient']->gender == 'female'){
                                                 echo "selected";
                                               } ?>>Female</option>
                                                  <option value="transgender" <?php if($data['patient']->gender == 'transgender'){
                                                    echo "selected";
                                                  } ?>>Transgender</option>
                                             </select>
                                              <input type="hidden"  name="name" id="patient_name" value="{{ $data['patient_name'] }}" class="form-control form-control-line" required readonly >
                                          </div>

                                        </div>
                                        <div class="col">
                                          <label class="col-md-12"> Middle & Last Name  <span class="red">*</span></label>
                                          <div class="col-md-12">
                                             <input type="text"  name="surname" id="lastname" value="{{ $data['last_name'] }}" class="form-control form-control-line getnamer" required>
                                         </div>

                                         <label class="col-md-12">Age (in years)  <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="number"  name="age"  value="{{ old('age', $data['patient']->age) }}" class="form-control form-control-line" min="1" max="120" oninvalid="setCustomValidity('Plz give the Age in between 1 and 120')" onchange="try{setCustomValidity('')}catch(e){}"  required>
											    
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col">
                                            <label class="col-sm-12">Primary Phone <span class="red">*</span></label>
                                                <div class="col-md-12">
                                               <input type="text" maxlength="10"  name="mobile_number" id="primary_no" value="{{ old('mobile_number', $data['patient']->mobile_number) }}" class="form-control form-control-line"  min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)" oninvalid="setCustomValidity('Primary Phone can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" required>
											   											   
                                           </div>
                                           <p  style="color:red;" id="er0"></p>
                                           <label class="col-sm-12">Secondary Phone 1</label>
                                           <div class="col-md-12">
                                               <input type="text" maxlength="10" name="secondary_no_1" id="secondary_no_1" value="{{ $data['patient']->secondary_no_1 }}" class="form-control form-control-line" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)" oninvalid="setCustomValidity('Secondary Phone 1 can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" />
                                      </div>
                                      <p style="color:red;" id="er1"></p>
                                      <label class="col-sm-12">Secondary Phone 2</label>
                                      <div class="col-md-12">
                                              <input type="text" maxlength="10"  name="secondary_no_2" id="secondary_no_2"  value="{{ $data['patient']->secondary_no_2}}" class="form-control form-control-line" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)"  oninvalid="setCustomValidity('Secondary Phone 2 can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" />
                                 </div>
                                 <p style="color:red;" id="er2"></p>
                                        </div>
                                        <div class="col">
                                          <label class="col-sm-12">Secondary Phone 3</label>
                                          <div class="col-md-12">
                                         <input type="text" maxlength="10" name="secondary_no_3" id="secondary_no_3"  value="{{ $data['patient']->secondary_no_3}}" class="form-control form-control-line" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)"  oninvalid="setCustomValidity('Secondary Phone 3 can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}"/>
                                     </div>
                                       <p style="color:red;" id="er3"></p>
                                                    <label class="col-md-12">Father / Husband's Name   </label>
                                                    <div class="col-md-12">
                                                       <input type="text"  name="father_or_husband_name"  value="{{ $data['father_or_husband_name'] }}" class="form-control form-control-line" >
                                                   </div>
                                            <label class="col-md-12">Aadhar Number </label>
                                            <div class="col-md-12">
                                            <input type="text"  id="adhar_no" name="adhar_no" value="  <?php if(!empty($data['adhaar_no']->adhar_no)){
                                                    echo '********'.substr($data['adhaar_no']->adhar_no,8);
                                                  } ?>" class="form-control form-control-line" minlength="12" maxlength="12" >

                                      <!--input type="text" id="adhar_no" name="adhar_no" placeholder="{{ old('adhar_no', $data['adhaar_no']->adhar_no) }}" value="{{ old('adhar_no', $data['adhaar_no']->adhar_no) }}" class="form-control form-control-line"  >-->
                                               <p style="color:red;" id="eradh"></p>
                                           </div>



                                        </div>
                                    </div>


                                    <div class="row">
                                      <div class="col">
                                        <h4>Patient Address with Landmark:</h4>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Address <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text" name="house_no" value="{{ old('house_no', $data['patient']->house_no) }}" class="form-control form-control-line" required>
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Street </label>
                                            <div class="col-md-12">
                                               <input type="text"  name="street" value="{{ old('street', $data['patient']->street) }}" class="form-control form-control-line">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                           <label class="col-md-12">Ward / Village </label>
                                            <div class="col-md-12">
                                               <input type="text" name="ward" value="{{ old('ward', $data['patient']->ward) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Town/City/Village </label>
                                                <div class="col-md-12">
                                               <input type="text"  name="city" value="{{ old('city', $data['patient']->city) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Taluk / Block </label>
                                            <div class="col-md-12">
                                               <input type="text"  name="taluka" value="{{ old('taluka', $data['patient']->taluka) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Landmark </label>
                                            <div class="col-md-12">
                                               <input type="text" name="landmark"  value="{{ old('landmark', $data['patient']->landmark) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label class="col-sm-12">State <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_state" id="landmark_state" class="form-control form-control-line" value="{{ old('landmark_state', $data['patient']->landmark_state) }}" required>
                                                         <option value="">Select</option>
                                                        @foreach ($data['state'] as $key=> $state)
														    <?php 
															$sel2="";
															if(!empty($data['patient']->landmark_state)){
																if($data['patient']->landmark_state==$state['STOCode']){
																   $sel2='selected="selected"';
																}	
															}else{ 
															   if($data['login_user_phi_rln']->STOCode==$state['STOCode']){ 
																   $sel2='selected="selected"';
																} 
															}
															?>
                                                                <option value="{{$state['STOCode']}}" <?php echo $sel2; ?>>{{$state['name']}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">District  <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_district" class="form-control form-control-line" id="landmark_district"  required>
                                                         <option value="">Select</option>
                                                        @foreach ($data['district2'] as $key=> $facility)
                                                          <option
                                                            value="{{$facility['DTOCode']}}"
                                                            @if($data['patient']->landmark_district == $facility['DTOCode'])
                                                              selected
                                                            @endif
                                                          >
                                                          {{$facility['name']}}
                                                          </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
									     <div class="col">
                                           <label class="col-sm-12">TU <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="landmark_tu_id" id="landmark_tu_id" class="form-control form-control-line" required >
                                                        <option>--Select--</option>                                                         
                                                        @foreach ($data['landmark_tu'] as $key=> $facility)
                                                          <option
                                                            value="{{$facility['TBUnitCode']}}"
                                                            @if(isset($data['patient']->landmark_tu_id) && $data['patient']->landmark_tu_id == $facility['TBUnitCode'])
                                                              selected
                                                            @endif
                                                          >
                                                          {{$facility['TBUnitName']}}
                                                          </option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col" id="Pincode">
                                            <label class="col-md-12" id="caterralert">Pincode <span class="red">*</span> </label>
                                            <div class="col-md-12">
                                               <input type="number"  id="pincode" name="pincode"  onKeyPress="if(this.value.length==6) return false;"  value="{{ old('pincode', $data['patient']->pincode) }}" class="form-control form-control-line" min="100000" max="999999" oninvalid="setCustomValidity('Plz enter valid pincode')"
                                              onchange="try{setCustomValidity('')}catch(e){}" required>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row ">
									     <?php //dd($data['patient']->area); ?>
                                        <div class="col">
                                            <label class="col-md-12">Area <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <select name="area" class="form-control form-control-line">
                                                 <option value="">Select</option>
                                                   <?php foreach ($masters['areas'] as $key => $value) { ?>
                                                     <option value="<?php echo $value->id; ?>"



<?php if(!empty($data['patient']->area)){if($value->id == $data['patient']->area){echo "selected";}}else{if($value->id == 5){echo "selected";}}?>



                                                      ><?php echo $value->area_name; ?></option>
                                                   <?php } ?>
                                                   </select>
                                           </div>
                                        </div>
										<div class="col"></div>
									</div>
									
                                    <div class="row ">									
                                         <div class="col ">
                                            <label class="col-sm-12">HIV Status </label>
                                                <div class="col-sm-12">
                                                    <select name="hiv_test"  class="form-control form-control-line" >
                                                         <option value="">--Select--</option>

                                                         <?php foreach ($masters['hiv_status'] as $key => $val) { ?>
                                                           <option value="<?php echo $val->hiv_id; ?>"<?php if(!empty($data['patient']->hiv_test)){if($val->hiv_id == $data['patient']->hiv_test){echo "selected";}}else{if($val->hiv_id == 3){echo "selected";}}?>><?php echo $val->hiv_status;?>
                                                           </option><?php } ?>

                                                    </select>
                                                </div>
                                        </div> 
                                        <div class="col ">
                                            <label class="col-sm-12">Maritial Status  <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="marital_state" id="marital_state" value="{{ old('marital_state', $data['patient']->marital_state) }}" class="form-control form-control-line" required>
                                                         <option value="">Select</option>
                                                        <option value="1"
                                                         @if($data['patient']->marital_state=="1")
                                                            selected="selected"
                                                             @endif
                                                        >Married</option>
                                                        <option value="0"
                                                        @if($data['patient']->marital_state=="0")
                                                            selected="selected"
                                                             @endif
                                                        >Single</option>
                                                        <option value="2"
                                                        @if($data['patient']->marital_state=="2" || empty($data['patient']->marital_state))
                                                            selected="selected"
                                                             @endif
                                                        >Unknown</option>

                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col hide" id="maritalstatus_other">
                                            <label class="col-md-6">Maritial Status Other </label>
                                            <div class="col-md-6">
                                               <input type="text"  value="{{ old('maritalstatus_other', $data['patient']->maritalstatus_other) }}" class="form-control form-control-line" name="maritalstatus_other">
                                           </div>
                                        </div>										
                                    </div>
									
                                    <div class="row">
									
                                        <div class="col ">
                                            <label class="col-sm-12">Occupation <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="occupation"  class="form-control form-control-line" required>
                                                         <option value="">Select</option>
                                                        @foreach ($data['occupation'] as $key=> $occupation)

                                                                <option value="{{$occupation['id']}}"


<?php if(!empty($data['patient']->occupation)){if($occupation['id'] == $data['patient']->occupation){echo "selected";}}else{if($occupation['id'] == 31){echo "selected";}}?>


                                                                >{{$occupation['name']}}</option>

                                                        @endforeach


                                                    </select>
                                                </div>
                                        </div> 
                                        <div class="col ">
                                            <label class="col-sm-12">Socioeconomic Status <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="socioeconomy_status" value="{{ old('socioeconomy_status', $data['patient']->socioeconomy_status) }}" class="form-control form-control-line" required>
                                                         <option value="">Select</option>


                                                         <?php foreach ($masters['socioeconomic'] as $key => $val1) { ?>
                                                           <option value="<?php echo $val1->socio_id; ?>"


<?php if(!empty($data['patient']->socioeconomy_status)){if($val1->socio_id == $data['patient']->socioeconomy_status){echo "selected";}}else{if($val1->socio_id == 1){echo "selected";}}?>



                                                   ><?php echo $val1->socioeconomic; ?></option>
                                                         <?php } ?>




                                                    </select>
                                                </div>
                                        </div>										
                                    </div>
                                    <div class="row">
									    
                                        <div class="col">
                                            <label class="col-md-12">Emergency Contact Person Name </label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_name" value="{{ old('cp_name', $data['patient']->cp_name) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Emergency Contact Person Phone </label>
                                            <div class="col-md-12">
                                               <input type="text" maxlength="10" id="cp_phn_no" name="cp_phn_no" value="{{ old('cp_phn_no', $data['patient']->cp_phn_no) }}" class="form-control form-control-line" min="1000000000" max="9999999999" onkeypress="return isNumberKey(event)"  oninvalid="setCustomValidity('Secondary Phone 2 can not start with zero')" onchange="try{setCustomValidity('')}catch(e){}" >
											   <!---<div style="color:red;" id="err-cp-no"></div>--->
                                           </div>
										   <p style="color:red;" id="error_cp_phn_no"></p>
                                        </div>
										
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Emergency Contact Person Address </label>
                                            <div class="col-md-12">
                                               <input type="text" name="cp_address" value="{{ old('cp_address', $data['patient']->cp_address) }}" class="form-control form-control-line" >
                                           </div>
                                        </div>
                                        <div class="col ">
                                            <label class="col-sm-12">Key Population<span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="key_population" id="key_population" value="{{ old('key_population', $data['patient']->key_population) }}" class="form-control form-control-line" required>
                                                         <option value="">Select</option>

                                                         <?php foreach ($masters['key_poupluation'] as $key => $val2) { ?>
                                                           <option value="<?php echo $val2->key_id; ?>"


<?php if(!empty($data['patient']->key_population))
{
  if($val2->key_id == $data['patient']->key_population)
  {
    echo "selected";
  }
}else{
  if($val2->key_id == 11){
    echo "selected";
  }
}
?>

                                                     ><?php echo $val2->key_population; ?></option>
                                                         <?php } ?>


                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col hide" id="population_other">
                                            <label class="col-sm-12">Key Population Other <span style="color:red;">*</span></label>
                                            <div class="col-sm-12">
                                               <input type="text"  value="{{ old('population_other', $data['patient']->population_other) }}" class="form-control form-control-line" name="population_other">
                                           </div>
                                        </div>
                                    </div>

                                    <div class="row ">


                                        <div class="col-md-6">
                                            <label >Registered Date <span class="red">*</span></label>
                                            <div>
                                               <input type="date" onload="getDate();" id="date" name="regr_date"  value="<?php if(!empty($data['patient']->regr_date)){ echo  $data['patient']->regr_date; }else{
                                                  echo date("Y-m-d");
                                               }
                                               ?>" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line" required>
                                           </div>
                                       </div>
								<div class="col-md-6">
                                        <div class="row">										 
											 <div class="col-md-6 ">
												  <label>Sample Collection Date <span class="red">*</span></label>
												  <div>
													 <input type="date"  value="{{ old('collection_date', $data['patient']->collection_date) }}" max="<?php echo date("Y-m-d");?>"  placeholder="dd-mm-yy" class="form-control form-control-line" name="collection_date" required>
												 </div>
											</div>
											  <div class="col-md-6 ">										
												 
												  
													 <label>Sample Collection Time( 24 hour time format)</label>
													<div class='input-group date' id="collection_time">
													  <input type='text' name="collection_time" value="<?php echo !empty($data['patient']->collection_time)?$data['patient']->collection_time:'00:00'; ?>" class="form-control" />
													  <span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													  </span>
													</div>
											    
                                        </div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="col-12">

                            <button id="save-btn"class="btn btn-info">Save</button>
                            <!-- <a class="btn btn-warning" href="{{url('/enroll')}}">Cancel</a> -->
                            <a class="btn btn-warning" onclick="window.close();">Cancel</a>
                            <!-- <button class="btn btn-success">Preview</button>
                             <button class="btn ">Print</button> -->
							
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


        <script>
        $(document).ready(function(){        
		  $('#collection_time').datetimepicker({
					format: 'HH:mm'
		  });
		  
        $("#adhar_no").on("keyup",function(){
        console.log(isNaN(this.value))
          if(isNaN(this.value)){
            var confirm=alert("Not a valid Adhar Number");
          $("#save-btn").css("display","none");

          }else{

          $("#save-btn").css("display","inline-block");
          $("#save-btn").css("margin-left", "1%");
          }

        });

        });

         </script>






       <script>

         $(document).ready(function(){
            $('#adhar_no').keypress(function( e ) {
			if(e.which === 32) 
				return false;
		});

       /* $("#cp_phn_no").on("keyup",function(){

            if(this.value.length == '' || this.value.length == null){
              document.getElementById('err-cp-no').innerHTML="";
              document.getElementById("save-btn").disabled=false;


            }else{
              // console.log(isNaN(this.value))
                if(this.value.length < 8 || this.value.length > 10 || isNaN(this.value) == true){
                  document.getElementById('err-cp-no').innerHTML="Please specify a 10 digit numeric value";
                  document.getElementById("save-btn").disabled=true;

                }else{
                  document.getElementById('err-cp-no').innerHTML="";
                  document.getElementById("save-btn").disabled=false;
                }


            }


        });*/

        });


        </script>
      <script>
    $(document).ready(function() {
//pradip
       /* $('#pincode').on('change', function(evt) {
          if($(this).value.length!=6)
               return false;
          }); */
		
		//   $("#save-btn").on("click",function(){
     
		// 	if(this.value.length < 6 || this.value.length > 6 || isNaN(this.value) == true || $(this).val() == null ||  $(this).val() == ''){
		// 		document.getElementById('pincode').css('border','1px solid red');
		// 	document.getElementById("save-btn").setAttribute('type','button');
		// 	}else{
		// 		document.getElementById('pincode').css('border','none');
		// 		document.getElementById("save-btn").setAttribute('type','submit');
		// 	}
		  
		// });
	
	
		
        var _sample = $('#key_population').find(":selected").val();
        if(_sample=='Other'){
          $("#population_other").removeClass("hide");

        }else{
          $("#population_other").addClass("hide");

        }

        $("#key_population").change(function(){
            var _sample = $(this).find(":selected").val();
            if(_sample=='Other'){
              $("#population_other").removeClass("hide");
              document.getElementById("#population_other").setAttribute("required","required");
            }else{
              $("#population_other").addClass("hide");
              document.getElementById("#population_other").removeAttribute("required","required");
            }
        });

        var _sample = $('#bank_name').find(":selected").val();
        if(_sample=='Other'){
          $("#bankname_other").removeClass("hide");
        }else{
          $("#bankname_other").addClass("hide");
        }

        $("#bank_name").change(function(){
            var _sample = $(this).find(":selected").val();
            if(_sample=='Other'){
              $("#bankname_other").removeClass("hide");
              document.getElementById("#bankname_other").setAttribute("required","required");
            }else{
              $("#bankname_other").addClass("hide");
              document.getElementById("#bankname_other").removeAttribute("required","required");
            }
        });

        // var _sample = $('#marital_state').find(":selected").val();
        // if(_sample==2){
        //   $("#maritalstatus_other").removeClass("hide");
        // }else{
        //   $("#maritalstatus_other").addClass("hide");
        // }

        // $("#marital_state").change(function(){
        //     var _sample = $(this).find(":selected").val();
        //     if(_sample==2){
        //       $("#maritalstatus_other").removeClass("hide");
        //       document.getElementById("#maritalstatus_other").setAttribute("required","required");
        //     }else{
        //       $("#maritalstatus_other").addClass("hide");
        //       document.getElementById("#maritalstatus_other").removeAttribute("required","required");
        //     }
        // });


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
		
		//already state has value
		var state=$("#state").val();
		//alert(statee);
		if(state!=''){
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
						//by default login value will select
						var dtocode='<?php echo !empty($data["patient"]->district)?$data["patient"]->district:$data["login_user_phi_rln"]->DTOCode; ?>';
						if(dtocode!=''){
						   //$('[name=district]').val(dtocode);
						   $('[name=district] option').filter(function() { 
								return ($(this).val() == dtocode); //To select Blue
							}).attr("selected","selected");
						}
                    });
                },
                error: function() {
                  console.log("err")
              }
            });
        }

        $("#district").change( function() {
            var district = $(this).val();
            var state = $('#state').val();
            $.ajax({
                url: "{{url('tbunit')}}"+'/'+state+'/'+district,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {

                    //$('#district').html();
                    $("#tb option").remove();
                    $('#tb').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.tbunit, function (i, item) {
                        $('#tb').append($('<option>', {
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
		
		

        $("#tb").change( function() {
            var tbu = $(this).val();
            var state = $('#state').val();
            var district = $('#district').val();
            $.ajax({
                url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {
                    $("#phi option").remove();
                    $('#phi').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.phi, function (i, item) {
                        $('#phi').append($('<option>', {
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

        $("#landmark_state").change( function() {
            var state = $(this).val();

            $.ajax({
                url: "{{url('district')}}"+'/'+state,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {
                    console.log(items);
                    //$('#district').html();
                    $("#landmark_district option").remove();
                    $('#landmark_district').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.district, function (i, item) {
                        $('#landmark_district').append($('<option>', {
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
		//landmark state has value
		var landmark_state=$("#landmark_state").val();
		if(landmark_state!=""){
			 $.ajax({
                url: "{{url('district')}}"+'/'+landmark_state,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {
                    console.log(items);
                    //$('#district').html();
                    $("#landmark_district option").remove();
                    $('#landmark_district').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.district, function (i, item) {
                        $('#landmark_district').append($('<option>', {
                            value: item.DTOCode,
                            text : item.name
                        }));
						//by default login value will select
						var dtocode='<?php echo !empty($data["patient"]->landmark_district)?$data["patient"]->landmark_district:""; ?>';
						if(dtocode!=''){
						   //$('[name=district]').val(dtocode);
						   $('[name=landmark_district] option').filter(function() { 
								return ($(this).val() == dtocode); //To select Blue
							}).attr("selected","selected");
						}
                    });
                },
                error: function() {
                  console.log("err")
              }
            });
		}
		
		
		
		//alert(statee);
		$("#landmark_district").change( function() {
            var district = $(this).val();
            var state = $('#landmark_state').val();
            $.ajax({
                url: "{{url('tbunit')}}"+'/'+state+'/'+district,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {

                    //$('#district').html();
                    $("#landmark_tu_id option").remove();
                    $('#landmark_tu_id').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.tbunit, function (i, item) {
                        $('#landmark_tu_id').append($('<option>', {
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
		
		
		
    });

$(window).bind("load", function() {
//$( document ).ajaxComplete(function() {
	//if district has value
	    if($('#district').val()!=''){
			var district=$('#district').val();
		}else{	
		   var district='<?php echo !empty($data["patient"]->district)?$data["patient"]->district:$data["login_user_phi_rln"]->DTOCode; ?>';
		}   
		
		//alert(district);
		if(district!=''){
            
            var state = $('#state').val();
			//alert(state);
            $.ajax({
                url: "{{url('tbunit')}}"+'/'+state+'/'+district,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {

                    //$('#district').html();
                    $("#tb option").remove();
                    $('#tb').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.tbunit, function (i, item) {
                        $('#tb').append($('<option>', {
                            value: item.TBUnitCode,
                            text : item.TBUnitName
                        }));
                    });
					
					//by default login value will select
						var tbucode='<?php echo !empty($data["patient"]->tb)?$data["patient"]->tb:$data["login_user_phi_rln"]->TBUCode; ?>';
						if(tbucode!=''){
						   //$('[name=tb]').val(tbucode);
						   $('[name=tb] option').filter(function() { 
								return ($(this).val() == tbucode); //To select Blue
							}).attr("selected","selected");
						}
                },
                error: function() {
                  console.log("err")
              }
            });
        }
		
		
		   var tbu='<?php echo !empty($data["patient"]->tb)?$data["patient"]->tb:$data["login_user_phi_rln"]->TBUCode; ?>';
		
		 if(tbu!='') {
			            
            var state = $('#state').val();
            var district = '<?php echo !empty($data["patient"]->district)?$data["patient"]->district:$data["login_user_phi_rln"]->DTOCode; ?>';
			//alert(tbu);
			//alert(state);
			//alert(district);
            $.ajax({
                url: "{{url('phi')}}"+'/'+state+'/'+tbu+'/'+district,
                type:"GET",
                processData: false,
                contentType: false,
                dataType : "json",
                success: function(items) {
                    $("#phi option").remove();
                    $('#phi').append($('<option>', {
                        value: '',
                        text : 'Select'
                    }))
                    $.each(items.phi, function (i, item) {
                        $('#phi').append($('<option>', {
                            value: item.id,
                            text : item.DMC_PHI_Name
                        }));
                    });
					<?php if(!empty($data["patient"]->phi)){ ?>
					var dmcphiname='<?php echo $data["patient"]->phi; ?>';
					<?php }else{ ?>
					var dmcphiname='<?php echo $data["login_user_phi_rln"]->DMC_PHI_Name; ?>';
					<?php } ?>
					//alert(dmcphiname);
						if(dmcphiname!=''){
						   //$('[name=phi]').val(dmcphicode);
						   $('[name=phi] option').filter(function() { //alert($(this).text());
						     <?php if(!empty($data["patient"]->phi)){ ?>
								return ($(this).val() == dmcphiname); //To select Blue
							<?php }else{ ?>
							    return ($(this).text() == dmcphiname); 
							<?php } ?>
							}).attr("selected","selected");
						}
                },
                error: function() {
                  console.log("err")
              }
            });
        }
});
</script>


<script>
$(document).ready(function(){
  $("#createForm").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
$(document).ready(function(){

$(".getnamer").on("change", function(){

var firstname=$('#firstname').val();
var lastname=$('#lastname').val();
var patient_name=firstname+' '+lastname;
var err=0;
if(firstname == '' || firstname == null){
  alert("Firstname cannot be empty");
  $("#patient_name").val(null);
  err=err+1;
}

if(lastname == '' || lastname == null  ){
  alert("Surname cannot be empty");
    $("#patient_name").val(null);
  err=err+1;
}
if(err < 1){
  $("#patient_name").val(patient_name);
}



});

});
</script>
<script>
$(document).ready(function(){
$(".sector_radio").change(function(){
var secvalue = $(this).val();
//alert(secvalue)
$("#sec_heading").html(secvalue.toUpperCase()+' '+'SECTOR');


});

});
</script>
<script>
function getDate(){
    var today = new Date();

document.getElementById("date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);


}
</script>
<script>
$(document).ready(function(){
	$("#secondary_no_1").on("keyup",function(){

	  if(this.value.length == '' || this.value.length == null){
		  document.getElementById('er1').innerHTML="";
		  document.getElementById("save-btn").disabled=false;
	  }else{

		if(this.value.length < 8 || this.value.length > 10 || isNaN(this.value) == true){
		  document.getElementById('er1').innerHTML="Please specify a 10 digit numeric value";
		  document.getElementById("save-btn").disabled=true;

		}else{
		  document.getElementById('er1').innerHTML="";
		  document.getElementById("save-btn").disabled=false;
		}
	  }
	});
});
</script>

<script>
$(document).ready(function(){

$("#secondary_no_2").on("keyup",function(){
// console.log(isNaN(this.value))

if(this.value.length == '' || this.value.length == null){
    document.getElementById('er2').innerHTML="";
    document.getElementById("save-btn").disabled=false;
}else{

  if(this.value.length < 8 || this.value.length > 10 || isNaN(this.value) == true){
    document.getElementById('er2').innerHTML="Please specify a 10 digit numeric value";
    document.getElementById("save-btn").disabled=true;

  }else{
    document.getElementById('er2').innerHTML="";
    document.getElementById("save-btn").disabled=false;
  }


}

});
});
</script>
<script>
$(document).ready(function(){
 
$("#secondary_no_3").on("keyup",function(){

  if(this.value.length == '' || this.value.length == null){
      document.getElementById('er3').innerHTML="";
      document.getElementById("save-btn").disabled=false;
  }else{

    if(this.value.length < 8 || this.value.length > 10 || isNaN(this.value) == true){
      document.getElementById('er3').innerHTML="Please specify a 10 digit numeric value";
      document.getElementById("save-btn").disabled=true;

    }else{
      document.getElementById('er3').innerHTML="";
      document.getElementById("save-btn").disabled=false;
    }


  }
});
});
</script>


<script>
$(document).ready(function(){

	$("#cp_phn_no").on("keyup",function(){
	// console.log(isNaN(this.value))

		if(this.value.length == '' || this.value.length == null){
			document.getElementById('error_cp_phn_no').innerHTML="";
			document.getElementById("save-btn").disabled=false;
		}else{

		  if(this.value.length < 8 || this.value.length > 10 || isNaN(this.value) == true){
			document.getElementById('error_cp_phn_no').innerHTML="Please specify a 10 digit numeric value";
			document.getElementById("save-btn").disabled=true;

		  }else{
			document.getElementById('error_cp_phn_no').innerHTML="";
			document.getElementById("save-btn").disabled=false;
		  }
		}

	});
});
</script>





<script>
$(document).ready(function(){
/*$('#primary_no').change(function() {    
    $(this).val($(this).val().replace(/ /g,""));
});	*/

$("#primary_no").on("keyup paste",function(){ //alert();
  if(this.value.trim().length < 10 || this.value.trim().length > 10 || isNaN(this.value) == true) {
    document.getElementById('er0').innerHTML="Please specify a 10 digit numeric value";

    document.getElementById("save-btn").disabled=true;


  }else{
    document.getElementById('er0').innerHTML="";
    document.getElementById("save-btn").disabled=false;
  }

});
$("#secondary_no_1").on("keyup paste",function(){ //alert(this.value.trim().length);
  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) { //alert("here1");
    document.getElementById('er1').innerHTML="Please specify a 10 digit numeric value";
    document.getElementById("save-btn").disabled=true;	
  }else if(this.value.trim().length==0){ //alert("here2");
    document.getElementById('er1').innerHTML="";
    document.getElementById("save-btn").disabled=false;	
  }else {
    document.getElementById('er1').innerHTML="";
	document.getElementById("save-btn").disabled=false;
  }

});
$("#secondary_no_2").on("keyup paste",function(){ //alert();
  if((this.value.trim().length>0 && this.value.trim().length < 10)|| this.value.trim().length > 10 || isNaN(this.value) == true) {
    document.getElementById('er2').innerHTML="Please specify a 10 digit numeric value"; 
    document.getElementById("save-btn").disabled=true;	
  }else if(this.value.trim().length==0){ 
    document.getElementById('er2').innerHTML="";
    document.getElementById("save-btn").disabled=false;	
  }else {
    document.getElementById('er2').innerHTML="";
	document.getElementById("save-btn").disabled=false;
  }

});
$("#secondary_no_3").on("keyup paste",function(){ //alert();
  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
    document.getElementById('er3').innerHTML="Please specify a 10 digit numeric value";
    document.getElementById("save-btn").disabled=true;	
  }else if(this.value.trim().length==0){
    document.getElementById('er3').innerHTML="";
    document.getElementById("save-btn").disabled=false;	
  }else {
    document.getElementById('er3').innerHTML="";
	document.getElementById("save-btn").disabled=false;
  }

});
$("#cp_phn_no").on("keyup paste",function(){ //alert();
  if((this.value.trim().length>0 && this.value.trim().length < 10) || this.value.trim().length > 10 || isNaN(this.value) == true) {
    document.getElementById('error_cp_phn_no').innerHTML="Please specify a 10 digit numeric value"; 
    document.getElementById("save-btn").disabled=true;	
  }else if(this.value.trim().length==0){
    document.getElementById('error_cp_phn_no').innerHTML="";
    document.getElementById("save-btn").disabled=false;	
  }else {
    document.getElementById('error_cp_phn_no').innerHTML="";
	document.getElementById("save-btn").disabled=false;
  }

});
});
</script>



<script>
$("#adhar_no").keyup(function(){
var adhar=$(this).val();

if(adhar == '' || adhar == null){
  document.getElementById("save-btn").disabled=false;
  document.getElementById('eradh').innerHTML="";
}else{
  if(adhar.length < 12 || adhar.length > 12 || isNaN(adhar) == true){
  document.getElementById("save-btn").disabled=true;
  document.getElementById('eradh').innerHTML="Please specify 12 digit Adhar";
  }else{
    document.getElementById("save-btn").disabled=false;
    document.getElementById('eradh').innerHTML="";
  }


}



});
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
	}else{	
	       //alert( document.getElementById("primary_no").value);
	       //var y = document.createForm.mobile_number.value;
	       if((document.getElementById("primary_no").value.charAt(0)=="0")||(document.getElementById("secondary_no_1").value.charAt(0)=="0")||(document.getElementById("secondary_no_2").value.charAt(0)=="0")||(document.getElementById("secondary_no_3").value.charAt(0)=="0")||(document.getElementById("cp_phn_no").value.charAt(0)=="0"))
           {
                //alert("it should start with 9 ");
                return false
           }else{
              return true;
		   }
		   
	}
}
</script>
@endsection
