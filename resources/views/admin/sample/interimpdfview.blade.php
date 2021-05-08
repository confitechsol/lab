<?php //dd($data); ?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Core CSS -->
    <link href="{{url('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="{{ url('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<style type="text/css">


   @media print {

   	* {
    color: #000;
    background-color: #fff;
    font-family:"calibri";
     }
     @page {
      size: A4; /* DIN A4 standard, Europe */
      margin:0;
    }
    body
			{
			  margin:0mm 5mm 5mm 5mm;
        font-family: "calibri";
			}
		 .my_container{ width: 100%;}
		  #pdfhide{ display:none;}

	}
  ul{ margin: 0px; padding: 0px;}
  ul li{ float: left; list-style-type:none; float: left;}
  @font-face {
  font-family: "calibri";
  src: url({{ url('/fonts/CALIBRIB.ttf')}});

}
  body {font-family: "calibri"; font-weight: 500;}
  #pdfhide{ color:#6cb5d9;}
</style>

<style>
table {
    border-collapse: collapse;
}

td, th {
    border: 1px solid black;
}
table{ border-left: 0px;}

.header-area{
	padding-top:10px;
}
.headding-area h2{
	font-size: 25px;
    padding-top: 20px !important;
}
.enbial h2 {
    font-size: 18px;
}
.dw-enable{
	padding-top:20px;
}

</style>

</head>

<!--
	<br/>
	<?php // echo "<pre>"; print_r($data); ?>

@if(empty($data['checkflag']))
	<a id="pdfhide" href="{{ url('interimview/'.$data['personal']->smp_id,['download'=>'pdf']) }}">Download PDF</a>
@endif
  <h4 style="margin-top: -1%;" align="right">Draft Report</h4>

	<h2 align="center" style="color: #6cb5d9; margin-bottom: 0px;padding: 0px;">RNTCP Request Form for examination of biological specimen for TB</h2>
	<p align="center" style="margin:0px;">(Required for Diagnosis of TB, Drug Sensitivity Testing and follow up)</p>-->

<body>
<!------Amrita  on  18/05/20202 start------->
<div class="header-area">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<div class="logo-area">
				@if(!empty($data['config']->logo))
					 <img style="border-radius:15px;" src="{{url('uploads/lab_logo/'.$data['config']->logo)}}" height="100px" width="100px"/>
					@endif
				</div>
			</div>
			<div class="col-md-8">
				<div class="headding-area">
					<h2 align="center" style="color: #6cb5d9; margin-bottom: 0px;padding: 0px;">NTEP Request Form for examination of biological specimen for TB</h2>
					<p align="center" style="margin:0px;">(Required for Diagnosis of TB, Drug Sensitivity Testing and follow up)</p>
				</div>
			</div>
			<div class="col-md-2">
				<div class="logo-area">
				@if(!empty($data['config']->nabl_logo))
					<img style="border-radius:15px;" src="{{url('uploads/nabl_logo/'.$data['config']->nabl_logo)}}" height="100px" width="100px" align="right"/>
					@endif
				</div>
			</div>
		</div>
		
		<div class="dw-enable">
			<div class="row">
				<div class="col-md-2">
					@if(empty($data['checkflag']))
						<!--
						<a id="pdfhide" href="{{ url('pdfview/'.$data['personal']->smp_id, ['download'=>'pdf']) }}?d={{ request('d') }}&remarks={{ request('remarks') }}">Download PDF</a>
						-->
					@endif
				</div>
				
				<div class="col-md-8">			
				</div>
				
				<div class="col-md-2">
					<div class="enbial">
						@if(!empty($data['config']->nabl_no))
						  <h6 align="right"> {{ $data['config']->nabl_no }} </h6>
						@endif
					</div>
				</div>
			</div>
	    </div>
	
	
		<div class="dw-enable">
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">			
				</div>
				
				<div class="col-md-2">
					<div class="enbial">
						 <h6 style="margin-top: -12%;" align="right">Draft Result
							 
						  </h6>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>
<!------Amrita  on  18/05/20202 end------->

<div class="my_container">
<table cellpadding="0" cellspacing="0" width="100%" border="0">
	<tr>
	 <td colspan="2">
	  
       	<table cellspacing="5" cellpadding="5">
					<tr>
						<th colspan="4" style="text-align:center;">Patient Information</th>
					</tr>

					<tr>
						<td width="20%"><b>Patient Name</b></td>
						<td width="30%">{{$data['personal']->userName}}</td>
						<td><b>Age (in yrs):</b><u>{{$data['personal']->age?$data['personal']->age:"________"}}</u></td>
						<td>
							<b>Gender:</b> <input type="checkbox" name="" value="" @if($data['personal']->gender == "male")checked @endif >M
							<input type="checkbox" name="" value="" @if($data['personal']->gender == "female")checked @endif >F
							<input type="checkbox" name="" value="" @if($data['personal']->gender == "transgender")checked @endif>TG</td>
					</tr>
				
<?php //dd($data['personal']); ?>
					<tr>
						<td><b>Patient mobile no. or other contact no.</b></td>
						<td>{{$data['personal']->mobile_number}}</td>
						<td><b>Specimen</b><br /> <b>Date of collection: </b>{{$data['personal']->collection_dates?date('d-m-Y',strtotime($data['personal']->collection_dates)):"____________"}}<br />
						<b>Time of collection: </b>{{($data['personal']->collection_time)}}
						</td>


						<td>
							<input type="checkbox" name="" value=""  @if($data['personal']->sample_type == "Sputum")checked @endif><b>Sputum</b></br>



							<input type="checkbox" name="" value="" @if($data['personal']->sample_type != "Sputum")checked @endif>

							<b>Other</b> <?php if(!empty($data['personal']->sample_type) && $data['personal']->sample_type == "Others" ){
								echo "(".$data['personal']->others_type.")" ;
							} 
							else{
								if($data['personal']->sample_type!="Sputum"){
									echo "(".$data['personal']->sample_type.")";
								}	
							} ?>



						</td>


					</tr>
           <tr>
             <td>Aadhaar No(if available):</td>
             <td>{{$data['personal']->adhar_no}}</td>
                                              
           </tr>
					<tr>
						<td rowspan="2"><b>Patient address with landmark</b></td>
						<td rowspan="2">
							House No: {{$data['personal']->house_no}}, Street: {{$data['personal']->street}}, Ward: {{$data['personal']->ward}}</br>
							City: {{$data['personal']->city}}, Taluka: {{$data['personal']->taluka}}</br>
							Landmark: {{$data['personal']->landmark}}, Pincode: {{$data['personal']->pincode}}</td>
						<td colspan="2">
							<b>HIV Status:</b> <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 1)checked @endif >Reactive
							 <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 2)checked @endif>Non-reactive
							 <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 3)checked @endif>Unknown
						 </td>
					</tr>
					<tr>
						<td colspan="2">
						<b>	Key populations: </b><input type="checkbox" name="" value="" @if($data['personal']->key_population == 1)checked @endif>Contact of Known TB Patients
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 2)checked @endif>Diabetes
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 3)checked @endif>Tobacco
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 4)checked @endif>Prison
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 5)checked @endif>Miner
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 6)checked @endif>Migrant
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 7)checked @endif>Refugee
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 8)checked @endif>Urban Slum
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 9)checked @endif>Health-care worker
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 11)checked @endif >Not Applicable
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == 10)checked @endif >Other (Specify):
							@if($data['personal']->key_population=='Other')
							{{$data['personal']->population_other}}
							@endif
						</td>
					</tr>
				</table>
     </td>
   </tr>
   <tr>
      <td colspan="2">
        <table width="100%" style="border:2px solid #000;margin-top:11px;">
					<tr>
						<td width="50%"><b>Name referring facility (PHI/DMC/DR-TB Centre/Laboratory/other):</b>
							@if($data['personal']->f_name!='Others')
							{{$data['personal']->f_name}}
							@else
							{{$data['personal']->facility_type_other}}
							@endif
							  @if(!empty($data['personal']->DMC_PHI_Name))
							  - {{ $data['personal']->DMC_PHI_Name }}
							  @endif
							  @if(!empty($data['personal']->TBUnitName))
							  , {{ $data['personal']->TBUnitName }}
							  @endif
							  @if(!empty($data['personal']->facility_district))
							  , {{ $data['personal']->facility_district }}
							  @endif
							  @if(!empty($data['personal']->facility_state))
							  , {{ $data['personal']->facility_state }}
							  @endif
						<br/><br/></n>
							<b>Health Establishment ID (NIKSHAY): </b><?php if(!empty($data['personal']->health_establish_id)){ echo $data['personal']->health_establish_id; }else{
								echo "_ _ _ _";
							} ?>

							<b>NTEP TB Reg No. _________________   </b> </br>
							<input type="checkbox" name="" value="">Not Applicable
						</td>
              <td>NIKSHAY ID : <?php if(!empty($data['personal']->pnikshay_id)){ echo $data['personal']->pnikshay_id; }else{ echo ""; } ?></td>
					</tr>

					<tr>
						<td>
							<b>State:</b> {{$data['personal']->state_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <b>District:</b> <?php echo $data['personal']->district_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Tuberculosis Unit(TU): {{$data['personal']->mtb}}&nbsp;</td>
					</tr>
				</table>
      </td>
   </tr>
   <tr>
      <td style="border:none;">
          <h1 style="margin-bottom:10px;margin-top:9px; font-size:18px; text-align:center;">Reason for testing</h1>
         	<table width="100%" style="border:2px solid #000;">
					<tr>
						<td colspan="4">Diagnosis and follow up of TB</td>
					</tr>
					<tr>


						<td>Diagnosis</td>
						<td>Follow up (Smear and culture)</td>
					</tr>
					<?php //dd($data['personal']); ?>
					<tr>
						<td>H/O anti TB Rx for>1 month: <input type="checkbox" name="" value=""<?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'yes'){ echo "checked"; }} ?> />Yes <input type="checkbox" name="" value="" <?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'no'){ echo "checked"; }} ?>>No
                        </td>
						<?php if(!empty($data['test_requests'])){ ?>
						<td colspan="2">
<?php //dd($data['personal']->nikshay_id); ?>
							NTEP TB Reg no:   <u><?php if(!empty($data['test_requests']->rntcp_reg_no)){ echo $data['test_requests']->rntcp_reg_no; } ?></u></br>
							<!-- NIKSHAY ID:	<u><?php // $data['personal']->nikshay_id?$data['personal']->nikshay_id:"_____________" ?></u></br> -->
							Regimen: <input type="checkbox" @if($data['test_requests']->regimen == "New" && $data['personal']->req_test_type == 2)checked @endif >New
											 <input type="checkbox" @if($data['test_requests']->regimen == "Previously Treated" && $data['personal']->req_test_type == 2)checked @endif >Previously Treated</br>
							Reason:	<input type="checkbox" @if($data['personal']->test_reason == "End IP")checked @endif >End IP
											<input type="checkbox" @if($data['personal']->test_reason == "End CP")checked @endif >End CP</br>
							Post treatment:<input type="checkbox" @if($data['test_requests']->post_treatment == "6 M")checked @endif >6m
														 <input type="checkbox" @if($data['test_requests']->post_treatment == "12 M")checked @endif >12m
														 <input type="checkbox" @if($data['test_requests']->post_treatment == "18 M")checked @endif >18m
														 <input type="checkbox" @if($data['test_requests']->post_treatment == "24 M")checked @endif >24m
						</td>
					<?php }else{ ?>
						<td colspan="2">
							NTEP TB Reg no:   <u>{{$data['personal']->rntcp_reg_no?$data['personal']->rntcp_reg_no:"____________"}}</u></br>
							NIKSHAY ID:	<u>{{$data['personal']->nikshay_id?"_____________":"_____________"}}</u></br>
							Regimen: <input type="checkbox" @if($data['personal']->regimen == "New" && $data['personal']->req_test_type == 2)checked @endif >New
											 <input type="checkbox" @if($data['personal']->regimen == "Previously Treated" && $data['personal']->req_test_type == 2)checked @endif >Previously Treated</br>
							Reason:	<input type="checkbox" @if($data['personal']->test_reason == "End IP")checked @endif >End IP
											<input type="checkbox" @if($data['personal']->test_reason == "End CP")checked @endif >End CP</br>
							Post treatment:<input type="checkbox" @if($data['personal']->post_treatment == "6 M")checked @endif >6m
														 <input type="checkbox" @if($data['personal']->post_treatment == "12 M")checked @endif >12m
														 <input type="checkbox" @if($data['personal']->post_treatment == "18 M")checked @endif >18m
														 <input type="checkbox" @if($data['personal']->post_treatment == "24 M")checked @endif >24m
						</td>
					<?php } ?>
					</tr>
          <?php

          if(!empty($data['test_requests']->diagnosis)){
           $explode_diagonosis=explode(',',$data['test_requests']->diagnosis);
           // dd($explode_diagonosis);
          }
            ?>
					<tr>
            <td colspan="3">
            <table border="0" style="width:100%">
              <tr>
						<td width="25%">
							<input type="checkbox" name="" @if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 1)checked @endif @endforeach @endif value="">Presumtive TB
            </td>
            <td width="25%">Predominant symptom: <u>{{$data['personal']->ps_name?$data['personal']->ps_name:"_____________"}}</u></td>
              </tr>
              <tr>
            <td><input type="checkbox" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 3) checked @endif @endforeach  @endif>Private referral  </td>
            <td>Duration:<u>{{$data['personal']->duration?$data['personal']->duration:"_____________"}}</u> days</td>
          </tr>
            <tr>
            <td><input type="checkbox" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 4) checked @endif @endforeach  @endif>Presumtive NTM</td>
            <td></td>
          </tr>
          <tr>
          <td><input type="checkbox" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 5) checked @endif @endforeach  @endif>TB Repeat Exam</td>
          <td></td>
        </tr>
          </table>

            </td>
					</tr>

				</table>
      </td>
   </tr>
   <?php //dd($data['type_of_prsmptv_drtb']); ?>
   <tr>
      <td colspan="2" style="border:0px">
         <table width="100%" border="0" cellspacing="5" cellpadding="5" style="margin-bottom:12px;">
              <tr>
                <th colspan="3">Diagnosis and follow up Drug-resistant TB</th>
              </tr>
              <tr>
						<td colspan="2" WIDTH=60%>Drug Susceptibility Testing (DST)</td>
						<td>Follow up (Culture/Microscopy)</td>
					</tr>
                    <tr>
                      <td width="20%" rowspan="2"><input type="checkbox" name="" @if($data['type_of_prsmptv_drtb'])checked @endif value="">Presumptive MDR TB</td>
						<?php if(!empty($data['test_requests']->regimen)){ ?>
                        <td>
							<input type="checkbox" @if($data['test_requests']->regimen == "New" && $data['personal']->req_test_type == 3)checked @endif >New
							<input type="checkbox" @if($data['test_requests']->regimen == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif > Previously treated
						</td>
					<?php }else{ ?>
                    <td width="30%">
							<input type="checkbox" @if($data['personal']->regimen == "New" && $data['personal']->req_test_type == 3)checked @endif >New
							<input type="checkbox" @if($data['personal']->regimen == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif > Previously treated
						</td>
					<?php } ?>
					<?php if(!empty($data['req_test'])){//dd($data['personal']);
						?>
                        <td rowspan="5">
							PMDT TB No.<?php $cond= !empty($data['personal']->pmdt_tb_no)?$data['personal']->pmdt_tb_no:"___________________"; echo $cond;?>	</br>
						</br></br>
							Regimen:</br>

							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for INH Mono/Poly Resistant TB")checked @endif>Regimen for INH Mono/Poly Resistant TB</br>
						<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for MDR/RR TB")checked @endif>Regimen for MDR/RR TB</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for XDR TB")checked @endif>Regimen for XDR TB</br>


							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with New Drug for Failures of Regimen for MDR-TB")checked @endif>Regimen with New Drug for Failures of Regimen for MDR-TB</br>


							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with New Drug for Failures of Regimen for XDR-TB")checked @endif>Regimen with New Drug for Failures of Regimen for XDR-TB</br>


							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance")checked @endif>Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance</br>

							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with New Drug for Mixed Pattern Resistance")checked @endif>Regimen with New Drug for Mixed Pattern Resistance</br>

							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with New Drug for XDR-TB")checked @endif>Regimen with New Drug for XDR-TB</br>


		<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Shorter MDR TB Regimen")checked @endif>Shorter MDR TB Regimen</br>


							<input type="checkbox" name="" <?php if($data['req_test']->regimen_fu == 'Other'){ echo "checked"; }?> >Other</br>

							@if($data['req_test']->regimen_fu == "Other")
								&emsp; Other Regimen : {{$data['pesronal']->fudrtb_regimen_other}}</br>
							@endif
							Treatment <input type="checkbox" name="" @if($data['personal']->month_week == "Month")checked @endif>Month <input type="checkbox" name="" @if($data['personal']->month_week == "Week")checked @endif>Week  &emsp; No.: {{$data['personal']->treatment?$data['personal']->treatment :"__________________"}}
						</td>
                        <?php }else{ ?>
                        <td rowspan="5">
							PMDT TB No.{{$data['personal']->regimen?$data['personal']->pmdt_tb_no:"___________________"}}	</br>
							DR TB NIKSHAY ID:__________________	</br></br>
							Regimen:</br>

              <input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for INH Mono/Poly Resistant TB")checked @endif>Regimen for INH Mono/Poly Resistant TB</br>
						<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for MDR/RR TB")checked @endif>Regimen for MDR/RR TB</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for XDR TB")checked @endif>Regimen for XDR TB</br>


							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with New Drug for Failures of Regimen for MDR-TB")checked @endif>Regimen with New Drug for Failures of Regimen for MDR-TB</br>


							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with New Drug for Failures of Regimen for XDR-TB")checked @endif>Regimen with New Drug for Failures of Regimen for XDR-TB</br>


							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance")checked @endif>Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance</br>

							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with New Drug for Mixed Pattern Resistance")checked @endif>Regimen with New Drug for Mixed Pattern Resistance</br>

							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with New Drug for XDR-TB")checked @endif>Regimen with New Drug for XDR-TB</br>


		<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Shorter MDR TB Regimen")checked @endif>Shorter MDR TB Regimen</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Other")checked @endif>Other{{$data['personal']->regimen_fu}}</br>





							@if($data['personal']->regimen_fu == "Other")
								&emsp; Other Regimen : {{$data['pesronal']->fudrtb_regimen_other}}</br>
							@endif




							Treatment <input type="checkbox" name="" @if($data['personal']->month_week == "Month")checked @endif>Month <input type="checkbox" name="" @if($data['personal']->month_week == "Week")checked @endif>Week  &emsp; No.: {{$data['personal']->treatment?$data['personal']->treatment :"__________________"}}
						</td>

                        <?php 	} ?>

                    </tr>
                    <?php
	if(!empty($data['test_requests']) && !empty($data['type_of_prsmptv_drtb']) ){

	 $explode= $data['type_of_prsmptv_drtb'];?>
					<tr>
						<td>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) {

							 if($value == "At Diagnosis"){ echo "checked"; } } ?> >At diagnosis	</br>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) {

							 if($value == "Contact of MDR/RR TB"){ echo "checked"; } } ?> >Contact of MDR/RR TB </br>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) {

							 if($value == "Follow-up SM + VE at END IP"){ echo "checked"; } } ?> >Follow up Sm +ve	</br>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) { if($value == "Private Referral"){ echo "checked"; } } ?> >Private referral	</br>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) { if($value == "Presumptive H Mono/Poly"){ echo "checked"; } } ?> >Presumptive H Mono/Poly
						</td>
					</tr>
                    <tr>
						<td colspan="2" rowspan="2"><input type="checkbox" name="" @if($data['test_requests']->presumptive_h)checked @endif>Presumptive H: {{$data['test_requests']->presumptive_h}}</td>
					</tr>

<?php  }else{ ?>

<tr>
							<td>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "At diagnosis")checked @endif>At diagnosis	</br>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Contact of MDR/RR TB")checked @endif>Contact of MDR/RR TB </br>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Follow-up SM + VE at END IP")checked @endif>Follow-up SM + VE at END IP	</br>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Private Referral")checked @endif>Private referral	</br>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Discordance resolution")checked @endif>Discordance resolution
							</td>
						</tr>
                        <tr>
							<td colspan="2" rowspan="2"><input type="checkbox" name="" @if($data['personal']->presumptive_h)checked @endif>Presumptive H: {{$data['personal']->presumptive_h}}</td>
						</tr>


	<?php } ?>
    <tr></tr>
					<?php
if(!empty($data['test_requests'])){

					 $explode1= explode(',',$data['test_requests']->prsmptv_xdrtv); ?>
					 <tr>
 						<td><input type="checkbox" name="" value="" @if($data['test_requests']->prsmptv_xdrtv)checked @endif>Presumptive XDR TB</td>
 						<td>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="MDR/RR TB at Diagnosis"){ echo "checked"; } } ?> >MDR/RR TB at Diagnosis	</br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 ==">=4 Months Culture Positive"){ echo "checked"; } } ?> >>=4 months culture positive </br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="3 Monthly for Persistent Culture Positives"){ echo "checked"; } } ?> >3 monthly for persistent culture positive(treatment month_____	)</br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="Culture Reversion"){ echo "checked"; } } ?> >Culture reversion</br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="Failure of MDR/RR-TB Regimen"){ echo "checked"; } } ?> >Failure of MDR/RR-TB regimen</br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="Recurrent Case of Second Line Treatment"){ echo "checked"; } } ?> >Recurrent case of second line treatment</br>
 							<input type="checkbox" name="" <?php foreach ($explode1 as $key => $value1) { if($value1 =="Discordance resolution"){ echo "checked"; } } ?> >Discordance resolution
 						</td>
 					</tr>

<?php }else{
	?>
	<tr>
		<td><input type="checkbox" name="" value="" @if($data['personal']->prsmptv_xdrtv)checked @endif>Presumptive XDR TB</td>
		<td>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="MDR/RR TB at Diagnosis")checked @endif>MDR/RR TB at Diagnosis	</br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv==">=4 Months Culture Positive")checked @endif>>=4 months culture positive </br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="3 Monthly for Persistent Culture Positives")checked @endif>3 monthly for persistent culture positive(treatment month_____	)</br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="Culture reversion")checked @endif>Culture reversion</br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="Failure of MDR/RR-TB Regimen")checked @endif>Failure of MDR/RR-TB regimen</br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="Recurrant case of Second Line Treatment")checked @endif>Recurrent case of second line treatment</br>
			<input type="checkbox" name="" @if($data['personal']->prsmptv_xdrtv=="Presumptive H Mono/Poly")checked @endif>Presumptive H Mono/Poly
		</td>
	</tr>
    	<?php
} ?>
          </table>

      </td>
   </tr>
   <tr style="margin-top:20px;">
			<td colspan="2" style="border:0px">
        <h1 style="margin-bottom:10px;margin-top:0px; font-size:18px; text-align:center;">Test Requested</h1>
				<table width="100%" style="margin-bottom:10px; border:2px solid #000;" cellspacing="5" cellpadding="5">

					<tr>
						<td>
							<input type="checkbox" @if(in_array(1,$data['test_requested']))checked @endif >Microscopy
							<input type="checkbox">TST
							<input type="checkbox" name="" value="" @if(in_array(10,$data['test_requested']))checked @endif>IGRA
							<input type="checkbox" name="" value="" @if(in_array(11,$data['test_requested']))checked @endif>Chest X-ray
							<input type="checkbox" name="" value="" @if(in_array(12,$data['test_requested']))checked @endif>Cytopathology
							<input type="checkbox" name="" value="" @if(in_array(13,$data['test_requested']))checked @endif>Histopathology
							<input type="checkbox" @if(in_array(2,$data['test_requested']))checked @endif >CBNAAT
							<input type="checkbox" @if(in_array(3,$data['test_requested'])||in_array(24,$data['test_requested'])||in_array(25,$data['test_requested']))checked @endif >Culture
							<input type="checkbox" @if(in_array(21,$data['test_requested']) || in_array(22,$data['test_requested']) || in_array(23,$data['test_requested']))checked @endif >DST
							<input type="checkbox" @if(in_array(4,$data['test_requested']) || in_array(5,$data['test_requested']) || in_array(6,$data['test_requested']))checked @endif >Line Probe Assay
							<input type="checkbox" name="" value="">Gene Sequencing
							<input type="checkbox" name="" value="">Other(Please Specify):
							</br>
							Requestor Name: {{$data['personal']->requestor_name}}  &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	
							Designation: {{$data['personal']->designation}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
							&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
							Signature:_________________________ 	</br>
							Contact Number: {{$data['personal']->requestor_cno}} </br>
							Email Id: {{$data['personal']->requestor_email}}
						</td>
					</tr>
				</table>
			</td>
		</tr>
        <tr>
			<td colspan="2" border="0">
				<table width="100%" cellspacing="5" cellpadding="5" border="0">
					<tr>
						<th border="0" width="50%" align="left">Results:</th>
						<td border="0">NIKSHAY ID Generated: {{$data['personal']->pnikshay_id}}</td>
						<td border="0">Date of Receipt: {{ date('d-m-Y',strtotime($data['date_receipt']->receive_date))}}</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php
//dd($data['lpa1']);
  //    if(is_null($data['lpa1'])) {
  // echo "hi";
  //    }
  // die;?>
  

@if( $data['serviceId'] == '1' ||  $data['serviceId'] == '2' )
<?php if(is_null($data['lpa1']) && is_null($data['lpa2']) && is_null($data['lpaf'])  && is_null($data['culturelj'])  && is_null($data['culturelc']) && $data['cbnaat']->isEmpty()){ ?>
<?php //dd($data); ?>
@if(!empty($data['microscopyA']->result) || !empty($data['microscopyB']->result))

        <tr>
			<td colspan="2">
				<table WIDTH=100%>

					<tr>
						<th colspan="8">Microscopy(<input type="checkbox" name="zn" value="" @if($data['microscopy'] == 1)checked @endif >ZN <input type="checkbox" name="florscent" value="" @if($data['microscopy2'] == 2)checked @endif>Florescent)</th>
					</tr>
					<tr>

						<td rowspan="2">Sample</td>
						<td rowspan="2"></td>
						<td rowspan="2">Visual appearance</td>
						<td colspan="5" WIDTH=60% align="center">Result</td>
					</tr>
					<tr>
						<td style="text-align:center;">Negative</td>
						<td style="text-align:center;">Scanty</td>
						<td style="text-align:center;">1+</td>
						<td style="text-align:center;">2+</td>
						<td style="text-align:center;">3+</td>
					</tr>

          @if(!empty($data['microscopyA']->result))
					<tr>
						<td>Sample A</td>
						@if($data['microscopyA'])
						<td style="text-align:center;">{{$data['microscopyA']->sample_label}}</td>
						<td style="text-align:center;">@if($data['microscopyA']->result=='NA'){{ $data['microscopyA']->result }} @else  @endif</td>

						<td style="text-align:center;">@if($data['microscopyA']->result=='Negative/Not Seen'){{ $data['microscopyA']->result }} @else  @endif</td>
						<td style="text-align:center;">@if($data['microscopyA']->result=='Scanty'|| $data['microscopyA']->result=='Sc 1' || $data['microscopyA']->result=='Sc 2'|| $data['microscopyA']->result=='Sc 3'|| $data['microscopyA']->result=='Sc 4'|| $data['microscopyA']->result=='Sc 5'|| $data['microscopyA']->result=='Sc 6'|| $data['microscopyA']->result=='Sc 7'|| $data['microscopyA']->result=='Sc 8'|| $data['microscopyA']->result=='Sc 9' || $data['microscopyA']->result=='Sc 10'||
						$data['microscopyA']->result=='Sc 11'|| $data['microscopyA']->result=='Sc 12' || $data['microscopyA']->result=='Sc 13'||
						$data['microscopyA']->result=='Sc 14'|| $data['microscopyA']->result=='Sc 15' || $data['microscopyA']->result=='Sc 16'||
						$data['microscopyA']->result=='Sc 17'|| $data['microscopyA']->result=='Sc 18' || $data['microscopyA']->result=='Sc 19'){{ $data['microscopyA']->result }} @else  @endif</td>

            <td style="text-align:center;">@if($data['microscopyA']->result=='1+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
            <td style="text-align:center;">@if($data['microscopyA']->result=='2+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
						<td style="text-align:center;">@if($data['microscopyA']->result=='3+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
						<td style="text-align:center;">Date Result:{{ date('d-m-Y',strtotime($data['date_receipt']->receive_date)) }}  &emsp; Date Reported:{{ date('d-m-Y H:i:s', time())}} &emsp; Reported by(Name and Signature):{{Auth::user()->name}}</td>
						<!--<td style="text-align:center;">Date Result:{{ date('d-m-Y',strtotime($data['date_receipt']->created_at)) }}  &emsp; Date Reported:{{date('d-m-Y H:i:s', time())}} &emsp; Reported by(Name and Signature):{{ $data['microbio_name'] }}</td>-->
						@else
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________</td>
						@endif
					</tr>
          @endif
		<?php if(!empty($data['microscopyB'])){ ?>

          <tr>
            <td>Sample B</td>
            @if($data['microscopyB'])
            <td style="text-align:center;">{{$data['microscopyB']->sample_label}}</td>
            <td style="text-align:center;">@if($data['microscopyB']->result=='NA'){{ $data['microscopyB']->result }} @else  @endif</td>

            <td style="text-align:center;">@if($data['microscopyB']->result=='Negative/Not Seen'){{ $data['microscopyB']->result }} @else  @endif</td>
            <td style="text-align:center;">@if($data['microscopyB']->result=='Scanty'|| $data['microscopyB']->result=='Sc 1' || $data['microscopyB']->result=='Sc 2'|| $data['microscopyB']->result=='Sc 3'|| $data['microscopyB']->result=='Sc 4'|| $data['microscopyB']->result=='Sc 5'|| $data['microscopyB']->result=='Sc 6'|| $data['microscopyB']->result=='Sc 7'|| $data['microscopyB']->result=='Sc 8'|| $data['microscopyB']->result=='Sc 9' || $data['microscopyB']->result=='Sc 10'||
			$data['microscopyB']->result=='Sc 11'|| $data['microscopyB']->result=='Sc 12' || $data['microscopyB']->result=='Sc 13'||
			$data['microscopyB']->result=='Sc 14'|| $data['microscopyB']->result=='Sc 15' || $data['microscopyB']->result=='Sc 16'||
			$data['microscopyB']->result=='Sc 17'|| $data['microscopyB']->result=='Sc 18' || $data['microscopyB']->result=='Sc 19'){{ $data['microscopyB']->result }} @else  @endif</td>

            <td style="text-align:center;">@if($data['microscopyB']->result=='1+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
            <td style="text-align:center;">@if($data['microscopyB']->result=='2+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
            <td style="text-align:center;">@if($data['microscopyB']->result=='3+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
            <td style="text-align:center;">Date Result:{{ date('d-m-Y',strtotime($data['date_receipt']->created_at)) }}  &emsp; Date Reported:{{ date('d-m-Y H:i:s', time())}} &emsp; Reported by(Name and Signature):{{Auth::user()->name}}</td>
			<!--<td style="text-align:center;">Date Result:{{ date('d-m-Y',strtotime($data['date_receipt']->receive_date)) }}  &emsp; Date Reported:{{ $data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}</td>-->
			<!--<td style="text-align:center;">Date Result:{{ date('d-m-Y',strtotime($data['date_receipt']->created_at)) }}  &emsp; Date Reported:{{ date('d-m-Y H:i:s', time())}} &emsp; Reported by(Name and Signature):{{ $data['microbio_name'] }}</td>-->
            @else
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________</td>
            @endif
          </tr>
				<?php } ?>

					@if(count($data['microbio'])>0)
						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']==1 || $val['service_id']==2)
							@if(!empty($val['remark']))	
							<!--<tr>
								<td>Remark:</td>
								<td colspan="7">{{$val['remark']}}</td>
							</tr>-->
							@endif
							@if(!empty($val['detail']))	
							<!--<tr>
								<td>Detail: </td>
								<td colspan="7">{{$val['detail']}}</td>
							</tr>--->
                            @endif
						@endif
						@endforeach
					@endif
				</table>
			</td>
		</tr>
  @endif
<?php } ?>
@endif


@if( $data['serviceId'] == '4')
	<?php if(!empty($data['cbnaat'])){
		// dd($data['cbnaat']);
		if(count($data['cbnaat']) > 0){
		 ?>
<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="2" style="text-align:center;">Cartridge Based Nucleic Acid Amplification Test</th>
					</tr>
					<tr>
						@if($data['cbnaat'])
						{{-- <td WIDTH="30%">Sample ID </td><td>{{ $data['cbnaat'][0]->sample_label }}</td> --}}
						<td WIDTH="30%">Sample ID </td><td>{{ $data['sampleLable'] }}</td>
						@else
						<td WIDTH="30%">Sample ID </td><td></td>
						@endif
					</tr>
					<tr>
						<td>M. tuberculosis</td>
						<td>
							@if($data['cbnaat'])
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'MTB Detected')checked @endif>Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'MTB Not Detected')checked @endif>Not Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'Invalid' || $data['cbnaat'][0]->result_MTB == 'NA' || $data['cbnaat'][0]->result_MTB == 'No Result' || $data['cbnaat'][0]->result_MTB == 'Error')checked @endif>N/A
							@else
							<input type="checkbox" >Detected
							<input type="checkbox" >Not Detected
							<input type="checkbox" >N/A
							@endif
						</td>
					</tr>
              <?php //dd($data['cbnaat'][0]->result_RIF); ?>
					<tr><td>Rif Resistance</td>
						<td>
							@if($data['cbnaat'])
							<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Detected')checked @endif>Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Not Detected')checked @endif>Not Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Indeterminate')checked @endif>Indeterminate
							<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'NA')checked @endif>N/A
							@else
							<input type="checkbox" >Detected
							<input type="checkbox" >Not Detected
							<input type="checkbox" >Indeterminate
							<input type="checkbox" >N/A
							@endif
						</td>
					</tr>
          <tr>
            <td>Test</td><td><input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'No Result')checked @endif>No Result &nbsp; <input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'Invalid')checked @endif>Invalid &nbsp; <input type="checkbox" @if($data['cbnaat'][0]->error != '')checked @endif>Error (Please arrange for fresh sample) : @if($data['cbnaat'][0]->error == 0)
              @else
              {{ $data['cbnaat'][0]->error}}
              @endif
            </td>
          </tr>
			<tr>
				<td colspan="2">
					@if($data['cbnaat'])
					<!-- Date Result:{{ date('d-m-Y',strtotime($data['cbnaat'][0]->created_at)) }}  &emsp; Date Reported:{{ date('d-m-Y H:i:s', time())}} &emsp;--> 
					Date Result:{{date('d-m-Y', strtotime($data['cbnaat'][0]->test_date))}}  &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					Date Reported:{{date('d-m-Y H:i:s', time())}} &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					Reported by:{{Auth::user()->name}}
						
					@else
					Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
					@endif 
				</td>
			</tr>

					@if(count($data['microbio'])>0)
						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']==4)
						<?php if(!empty($val['remark'])){ ?>
						<!--<tr>
							<td>Remark: </td>
							<td>{{$val['remark']}}</td>
						</tr>--->
					<?php } ?>

					<?php if(!empty($val['detail'])){ ?>
						<!--<tr>
							<td>Detail: </td>
							<td>{{$val['detail']}}</td>
						</tr>--->
							<?php } ?>
						@endif
						@endforeach
					@endif

				</table>
			</td>
		</tr>
        <?php }}?>
	@endif

		@if($data['serviceId'] == '17')
			@if($data['culturelc'])
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr>
							<th colspan="6" style="text-align:center;">Culture (<input type="checkbox" @if(!empty($data['culture'])) @if($data['culture'] == 2)checked @endif @endif >LC)</th>
						</tr>
						<tr>							
							<td rowspan="2"; style="text-align:center">Sample ID</td>
							<td colspan="5"; style="text-align:center">Results</td>
						</tr>
						<tr>
							<td style="text-align:center;">Negative</td>
							<td  style="text-align:center;">Positive</td>
							<td  style="text-align:center;">NTM(write species)</td>
							<td  style="text-align:center;">Contamination</td>
							<td  style="text-align:center;">Others</td>
						</tr>
						<tr>
							@if(!empty($data['culturelc']))
							{{-- <td  style="text-align:center;">{{ $data['culturelc']->sample_label	 }}-LC REPORT</td> --}}
							<td  style="text-align:center;">{{ $data['sampleLable']	 }}-LC REPORT</td>
							<td  style="text-align:center;">@if($data['culturelc']->result=='Negative'){{ $data['culturelc']->result }} @else  @endif</td>
							<td  style="text-align:center;">@if($data['culturelc']->result=='Positive'){{ $data['culturelc']->result }} @else  @endif</td>
							<td  style="text-align:center;">@if($data['culturelc']->result=='NTM') @if(!empty($data['culturelc']->species)){{ $data['culturelc']->species }} @else {{ $data['culturelc']->result }} @endif @endif</td>
							<td  style="text-align:center;">@if($data['culturelc']->result=='Contaminated'){{ $data['culturelc']->result }} @else  @endif</td>
							<td  style="text-align:center;">@if($data['culturelc']->result=='Other Result'){{ $data['culturelc']->other_result }} @else  @endif</td>							
							@endif
						</tr>
						<tr>							
							<td colspan="6">			
								@if(!empty($data['culturelc']))
									LC - Date Result: {{ date ('d-m-Y', strtotime($data['culturelc']->result_date)) }} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Date Reported:{{date('d-m-Y H:i:s', time())}}  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Reported by: {{Auth::user()->name}}
									<br />
								@endif
							</td>
						</tr>
					</table>
				</td>
			</tr>
			@endif
		@endif

		@if($data['serviceId'] == '20')
			@if($data['culturelj'])
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr>
							<th colspan="6" style="text-align:center;">Culture (<input type="checkbox"@if(!empty($data['culture-llj'])) @if($data['culture-llj'] == 1)checked @endif @endif >LJ )</th>
						</tr>
						<tr>
							<!--<td rowspan="2">Sample : <?php //echo $data['lab_sr']->sample_label; ?></td>-->
							<td rowspan="2"; style="text-align:center">Sample ID</td>
							<td colspan="5"; style="text-align:center">Results</td>
						</tr>
						<tr>
							<td style="text-align:center;">Negative</td>
							<td  style="text-align:center;">Positive</td>
							<td  style="text-align:center;">NTM(write species)</td>
							<td  style="text-align:center;">Contamination</td>
							<td  style="text-align:center;">Others</td>
						</tr>
						<tr>
							@if(!empty($data['culturelj']))
								{{-- <td  style="text-align:center;">{{ $data['culturelj']->sample_label	 }}-LJ REPORT</td> --}}
								<td  style="text-align:center;">{{ $data['sampleLable']	 }}-LJ REPORT</td>					
								<td  style="text-align:center;">@if($data['culturelj']->final_result=='Negative'){{ $data['culturelj']->final_result }} @else  @endif</td  style="text-align:center;">
								<td  style="text-align:center;">@if($data['culturelj']->final_result=='1+' || $data['culturelj']->final_result=='2+' || $data['culturelj']->final_result=='3+'){{ $data['culturelj']->final_result }} @else  @endif</td>
								<td  style="text-align:center;">@if($data['culturelj']->final_result=='NTM') @if(!empty($data['culturelj']->species)) {{ $data['culturelj']->species }} @else {{ $data['culturelj']->final_result }}  @endif @endif</td>
								<td  style="text-align:center;">@if($data['culturelj']->final_result=='Contaminated'){{ $data['culturelj']->final_result }} @else  @endif</td>					
							@endif
						</tr>
						<tr>							
							<td colspan="6">
								@if(!empty($data['culturelj']))
									LJ - Date Result: {{ date ('d-m-Y', strtotime($data['culturelj']->lj_result_date)) }} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Date Reported:{{date('d-m-Y H:i:s', time())}}  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Reported by: {{Auth::user()->name}}
									<br />
								@endif					
							</td>
						</tr>
					</table>
				</td>
			</tr>
			@endif
		@endif		
		
		@if($data['serviceId'] == '15' && $data['tag'] == '1st')
			
			@if($data['lpa1'])
			<tr>
				<td colspan="2">
					<table width="100%" cellspacing="5" cellpadding="5">
						<tr>
							<th colspan="4" style="text-align:center;">Line Probe Assay(LPA)</th>
						</tr>
						<tr>
							@if($data['lpa1']->type != "")
							<th colspan="4"><input type="checkbox" name="" value="" <?php if($data['lpa1']->type == 'Direct'): echo "checked"; endif; ?> >Direct <input type="checkbox"<?php if($data['lpa1']->type == 'Indirect'): echo "checked"; endif; ?> >Indirect Lab serial :<?php if(!empty($data['lab_serial'])){ echo $data['lab_serial']->type; } ?> </th>
							@else
							<th colspan="4"><input type="checkbox" name="" value="">Direct <input type="checkbox">Indirect   Lab serial______________</th>
							@endif
						</tr>

						<tr>
							{{-- <th colspan="4">First line LPA (Sample ID: {{$data['lpa1']->sample_label}} )</th>  --}}

							<th colspan="4">First line LPA (Sample ID: {{ $data['sampleLable'] }} )</th> 
						</tr>
					<tr>
						<td colspan="4">
			
							<ul>
								<li>RpoB :- Locus Control :</li>
								<li> @if($data['lpa1']->RpoB == 1) Present @elseif($data['lpa1']->RpoB == 0)Absent @endif</li>
							</ul>
							</br>
							<ul>
								<li>	WT1: @if($data['lpa1']->wt1 == 1) Present @else Absent @endif&nbsp;
										WT2: @if($data['lpa1']->wt2 == 1) Present @else Absent  @endif &nbsp;
										WT3: @if($data['lpa1']->wt3 == 1) Present @else Absent  @endif &nbsp;
										WT4: @if($data['lpa1']->wt4 == 1) Present @else Absent  @endif &nbsp;
								</li>
								<li>
										WT5: @if($data['lpa1']->wt5 == 1) Present @else Absent  @endif &nbsp;
										WT6: @if($data['lpa1']->wt6 == 1) Present @else Absent  @endif &nbsp;
										WT7: @if($data['lpa1']->wt7 == 1) Present @else Absent  @endif &nbsp;
										WT8: @if($data['lpa1']->wt8 == 1) Present @else Absent  @endif
								</li>
								<li>
										MUT1(D516V) :	@if($data['lpa1']->mut1DS16V == 1) Present @else Absent @endif &nbsp;
										MUT2A(H526Y) :	@if($data['lpa1']->mut2aH526Y == 1) Present @else Absent  @endif &nbsp;
										MUT2B(H526D) :	@if($data['lpa1']->mut2bH526D == 1) Present @else Absent @endif &nbsp;
										MUT3(S531L) : @if($data['lpa1']->mut3S531L == 1) Present @else Absent @endif
								</li>
							</ul>
							
						</td>
					</tr>
					<tr>
						<td colspan="2">
								KatG :- Locus Control : @if($data['lpa1']->katg == 1) Present @else Absent  @endif</br>
								WT1(315) :	@if($data['lpa1']->wt1315 == 1) Present @else Absent  @endif</br>
								MUT1(S315T1) : @if($data['lpa1']->mut1S315T1 == 1) Present @else Absent  @endif
								</br>
								MUT2(S315T2) : @if($data['lpa1']->mut2S315T2 == 1) Present @else Absent  @endif
						</td>
						<td colspan="2">
								InhA :- Locus Control : @if($data['lpa1']->inha == 1) Present @else Absent  @endif</br>
								WT1(-15,-16) :	@if($data['lpa1']->wt1516 == 1) Present @else Absent  @endif
								WT2(-8) :	@if($data['lpa1']->wt28 == 1) Present @else Absent  @endif</br>
								MUT1(C15T) :	@if($data['lpa1']->mut1C15T == 1) Present @else Absent  @endif
								MUT2(A16G) : @if($data['lpa1']->mut2A16G == 1) Present @else Absent  @endif</br>
								MUT3A(T8C) :	@if($data['lpa1']->mut3aT8C == 1) Present @else Absent  @endif
								MUT3B(T8A) : @if($data['lpa1']->mut3bT8A == 1) Present @else Absent  @endif</br>
						</td>
					</tr>

					<tr>
						<td colspan="4">
							<table width="100%" cellspacing="5" cellpadding="5">
								<tr>
									<td>										
										<strong>Interpretation:-</strong>						
												
														@if($data['lpa1']->mtb_result != "")
																MTB Result:{{ $data['lpa1']->mtb_result }}&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;		
														@endif 
									
														@if( $data['lpa1']->rif != "" )
																RIF Resi:{{ $data['lpa1']->rif }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
														@endif

														@if($data['lpa1']->kat_g != "")
																KatG Resi:{{ $data['lpa1']->kat_g }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;
														@endif
							 
							 
														@if( $data['lpa1']->inh != "" )
																H Resi:{{ $data['lpa1']->inh }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;
														@endif														
														
														@if( $data['lpa1']->finalterpretation != "" )
																<br>
																Final LPA Interpretation:- {{ $data['lpa1']->finalterpretation }} 
														@endif	
														
														@if( $data['lpa1']->clinical_interpretation != "" )
																<br>
																Remarks:- {{ $data['lpa1']->clinical_interpretation }} 
														@endif
														
									</td>
								</tr>
								<tr>
									<td>
					
										@if($data['lpa1'])												
												Date Result:{{date('d-m-Y', strtotime($data['lpa1']->created_at))}}  &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
												Date Reported:{{date('d-m-Y H:i:s', time())}}&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
												Reported by:{{ Auth::user()->name }}
										@else
												Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
										@endif
									</td>
								</tr>								
							</table>
						</td>
					</tr>

					</table>
				</td>
			</tr>
			@endif

				@if(isset($data['hybridization_data']))
					@foreach ($data['hybridization_data'] as $key=> $hybridization_data)
						@if($hybridization_data->result=="Invalid")	
						<tr>
							<td colspan="2">
								<table width="100%" cellspacing="5" cellpadding="5">
										
											@if($hybridization_data->tag=='1st line LPA')
												
												<th colspan="4">Line Probe Assay(LPA) - First Line LPA - Hybridization: The result is invalid of Sample  {{$hybridization_data->sample_label}} </th>
													
											@endif											
								</table>
							</td>
						</tr>		
						@endif
					@endforeach		
			@endif
		@endif

		@if( $data['serviceId'] == '15' && $data['tag'] == '2nd' )

			@if( $data['lpa2'] )

			<tr>
				<td colspan="2">
					<table width="100%" cellspacing="5" cellpadding="5">
						<tr>
							<th colspan="4" style="text-align:center;">Line Probe Assay(LPA)</th>
						</tr>
						<tr>
							@if($data['lpa2']->type != "")
							<th colspan="4"><input type="checkbox" name="" value="" <?php if($data['lpa2']->type == 'Direct'): echo "checked"; endif; ?> >Direct <input type="checkbox"<?php if($data['lpa2']->type == 'Indirect'): echo "checked"; endif; ?> >Indirect Lab serial :<?php if(!empty($data['lab_serial'])){ echo $data['lab_serial']->type; } ?> </th>
							@else
							<th colspan="4"><input type="checkbox" name="" value="">Direct <input type="checkbox">Indirect   Lab serial______________</th>
							@endif
						</tr>

						<tr>
							{{-- <th colspan="4">Second line LPA (Sample ID: {{$data['lpa2']->sample_label}} )</th>  --}}

							<th colspan="4">Second line LPA (Sample ID: {{ $data['sampleLable'] }} )</th> 
						</tr>						
						<tr>
							<td>
								gyrA :- Locus Control : @if($data['lpa2']->gyra == 1) Present @else Absent  @endif</br>
								WT1(85-90) :@if($data['lpa2']->wt18590 == 1) Present @else Absent  @endif</br>
								WT2(89-93) :@if($data['lpa2']->wt28993 == 1) Present @else Absent  @endif</br>
								WT3(92-97) :@if($data['lpa2']->wt39297 == 1) Present @else Absent  @endif</br>
								MUT1(A90V) :@if($data['lpa2']->mut1A90V == 1) Present @else Absent  @endif</br>
								MUT2(S91P) :@if($data['lpa2']->mut2S91P == 1) Present @else Absent  @endif</br>
								MUT3A(D94A) :@if($data['lpa2']->mut3aD94A == 1) Present @else Absent  @endif</br>
								MUT3B(D94N/Y) :@if($data['lpa2']->mut3bD94N == 1) Present @else Absent  @endif</br>
								MUT3C(D94G) :@if($data['lpa2']->mut3cD94G == 1) Present @else Absent  @endif</br>
								MUT3D(D94H) :@if($data['lpa2']->mut3dD94H == 1) Present @else Absent  @endif</br>
							</td>


							<td valign="top">
								gyrB :- Locus Control : @if($data['lpa2']->gyrb == 1) Present @else Absent  @endif</br>
								WT1(536-541) :@if($data['lpa2']->wt1536541 == 1) Present @else Absent  @endif</br>
								MUT1(N538D) :@if($data['lpa2']->mut1N538D == 1) Present @else Absent  @endif</br>
								MUT2(E540V) :@if($data['lpa2']->mut2E540V == 1) Present @else Absent  @endif</br>
							</td>
							<td valign="top">
								rrs :- Locus Control :@if($data['lpa2']->rrs == 1) Present @else Absent  @endif</br>
								WT1(1401-02) :@if($data['lpa2']->wt1140102 == 1) Present @else Absent  @endif</br>
								WT2(1484) :@if($data['lpa2']->wt21484 == 1) Present @else Absent  @endif</br>
								MUT1(A1401G) :@if($data['lpa2']->mut1A1401G == 1) Present @else Absent  @endif</br>
								MUT2(G1484T) :@if($data['lpa2']->mut2G1484T == 1) Present @else Absent  @endif</br>
							</td>
							<td valign="top">
								eis :- Locus Control : 	@if($data['lpa2']->eis == 1) Present @else Absent  @endif</br>
								WT1(37) :@if($data['lpa2']->wt137 == 1) Present @else Absent  @endif</br>
								WT2(14,12,10) :@if($data['lpa2']->wt2141210 == 1) Present @else Absent  @endif</br>
								WT3(2) :@if($data['lpa2']->wt32 == 1) Present @else Absent  @endif</br>
								MUT1(C-14T) :@if($data['lpa2']->mut1c14t == 1) Present @else Absent  @endif</br>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="5" cellpadding="5">
									<tr>
										<td>										
											<strong>Interpretation:-</strong>						
													
															@if($data['lpa2']->mtb_result != "")
																	MTB Result:{{ $data['lpa2']->mtb_result }}&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;		
															@endif 
										
															@if( $data['lpa2']->quinolone != "" )
																	FQ Resi:{{ $data['lpa2']->quinolone }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
															@endif
	
															@if($data['lpa2']->slid != "")
																	SLI (rrs):{{ $data['lpa2']->slid }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;
															@endif
								 
								 
															@if( $data['lpa2']->slid_eis != "" )
																	SLI (eis):{{ $data['lpa2']->slid_eis }} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;
															@endif														
															
															@if( $data['lpa2']->finalInterpretation != "" )
																	<br>
																	Final LPA Interpretation:- {{ $data['lpa2']->finalInterpretation }} 
															@endif	
															
															@if( $data['lpa2']->clinical_interpretation != "" )
																	<br>
																	Remarks:- {{ $data['lpa2']->clinical_interpretation }} 
															@endif
															
										</td>
									</tr>
									<tr>
										<td>
						
											@if($data['lpa2'])												
													Date Result:{{date('d-m-Y', strtotime($data['lpa2']->created_at))}}  &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
													Date Reported:{{date('d-m-Y H:i:s', time())}}&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
													Reported by:{{ Auth::user()->name }}
											@else
													Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
											@endif
										</td>
									</tr>								
								</table>
							</td>
						</tr>


					</table>
				</td>
			</tr>
			@endif

				@if(isset($data['hybridization_data']))
					@foreach ($data['hybridization_data'] as $key=> $hybridization_data)
						@if($hybridization_data->result=="Invalid")	
						<tr>
							<td colspan="2">
								<table width="100%" cellspacing="5" cellpadding="5">										
											
											@if($hybridization_data->tag=='2nd line LPA')
												
												<th colspan="4">Line Probe Assay(LPA) - Second Line LPA - Hybridization: The result is invalid of Sample  {{$hybridization_data->sample_label}} </th>
												
											@endif										
								</table>
							</td>
						</tr>		
						@endif
					@endforeach		
				@endif
		@endif		
		
        

		@if( $data['serviceId'] == '21' && $data['tag'] == 'LC' )

			@if(!empty($data['lc_dst_fld']['s'])
			|| !empty($data['lc_dst_fld']['H(inh A)'])
			|| !empty($data['lc_dst_fld']['H(Kat G)']) 
			|| !empty($data['lc_dst_fld']['r'])
			|| !empty($data['lc_dst_fld']['e'])
			|| !empty($data['lc_dst_fld']['z'])
			|| !empty($data['lc_dst_fld']['km'])
			|| !empty($data['lc_dst_fld']['cm'])
			|| !empty($data['lc_dst_fld']['am'])
			|| !empty($data['lc_dst_fld']['lfx'])
			|| !empty($data['lc_dst_fld']['mfx1'])
			|| !empty($data['lc_dst_fld']['mfx2'])
			|| !empty($data['lc_dst_fld']['pas'])
			|| !empty($data['lc_dst_fld']['lzd'])
			|| !empty($data['lc_dst_fld']['cfz'])
			|| !empty($data['lc_dst_fld']['eto'])
			|| !empty($data['lc_dst_fld']['clr'])
			|| !empty($data['lc_dst_fld']['Dim'])
			|| !empty($data['lc_dst_fld']['BDQ'])
			)

				<tr>
					<td colspan="2">
						
						<table WIDTH=100%>
							<tr>
								<th colspan="20" style="text-align:center;">Drug Susceptibility Test (DST) results</th>
							</tr>
							<tr>
								<td rowspan="2"; style="text-align:center;">Sample ID</td>
								<td colspan="6"; style="text-align:center;">1st Line drugs</td>
								<td colspan="3"; style="text-align:center;">SLI</td>
								<td colspan="3"; style="text-align:center;">FQ</td>
								<td colspan="6"; style="text-align:center;">Others</td>
							</tr>
							<tr>
								<td style="text-align:center;" width="45">S</td>
								<td style="text-align:center;"  width="45">H</td>
								<!--<td style="text-align:center;" width="30">H(0.4)</td>-->
								<td style="text-align:center;" width="45">R</td>
								<td style="text-align:center;" width="45">E</td>
								<td style="text-align:center;" width="45">Z</td>
								<td style="text-align:center;" width="45">Km</td>
								<td style="text-align:center;" width="45">Cm</td>
								<td style="text-align:center;" width="45">Am</td>
								<td style="text-align:center;" width="40">Lfx</td>								
								<td style="text-align:center;" width="40">Mfx (1)</td>
								<td style="text-align:center;" width="40">PAS</td>
								<td style="text-align:center;" width="40">Lzd</td>
								<td style="text-align:center;" width="40">Cfz</td>
								<td style="text-align:center;" width="40">Eto</td>
								<td style="text-align:center;" width="40">Clr</td>
								<td style="text-align:center;" width="40">Dim</td>
								<td style="text-align:center;" width="40">BDQ</td>
							</tr>

							@if(isset($data['lc_dst_fld'])&& !empty($data['lc_dst_fld']))
								@if(!empty($data['lc_dst_fld']['s'])
								|| !empty($data['lc_dst_fld']['H'])								
								|| !empty($data['lc_dst_fld']['r'])
								|| !empty($data['lc_dst_fld']['e'])
								|| !empty($data['lc_dst_fld']['z'])
								|| !empty($data['lc_dst_fld']['km'])
								|| !empty($data['lc_dst_fld']['cm'])
								|| !empty($data['lc_dst_fld']['am'])
								|| !empty($data['lc_dst_fld']['lfx'])							
								|| !empty($data['lc_dst_fld']['mfx2'])
								|| !empty($data['lc_dst_fld']['pas'])
								|| !empty($data['lc_dst_fld']['lzd'])
								|| !empty($data['lc_dst_fld']['cfz'])
								|| !empty($data['lc_dst_fld']['eto'])
								|| !empty($data['lc_dst_fld']['clr'])
								|| !empty($data['lc_dst_fld']['Dim'])
								|| !empty($data['lc_dst_fld']['BDQ']))	
									<tr>
									<?php //echo '<pre>'; echo $data['lc_dst_fld']['am']; die();?>
										{{-- <td style="text-align:center;">LC DST-{{ !empty($data['culturelc']->sample_label)?$data['culturelc']->sample_label:"" }}</td> --}}

										<td style="text-align:center;">LC DST-{{ $data['sampleLable'] }}</td>
										
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['s'])&&!empty($data['lc_dst_fld']['s'])? mb_substr($data['lc_dst_fld']['s'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['s'],0,1):""; ?></td>	
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['H(inh A)'])&&!empty($data['lc_dst_fld']['H(inh A)'])?mb_substr($data['lc_dst_fld']['H(inh A)'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['H(inh A)'],0,1):""; ?></td>
										<!-- <td style="text-align:center;"></*?php echo isset($data['lc_dst_fld']['H(Kat G)'])&&!empty($data['lc_dst_fld']['H(Kat G)'])?mb_substr($data['lc_dst_fld']['H(Kat G)'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['H(Kat G)'],0,1):""; ?></td> -->
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['r'])&&!empty($data['lc_dst_fld']['r'])?mb_substr($data['lc_dst_fld']['r'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['r'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['e'])&&!empty($data['lc_dst_fld']['e'])?mb_substr($data['lc_dst_fld']['e'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['e'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['z'])&&!empty($data['lc_dst_fld']['z'])?mb_substr($data['lc_dst_fld']['z'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['z'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['km'])&&!empty($data['lc_dst_fld']['km'])?mb_substr($data['lc_dst_fld']['km'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['km'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['cm'])&&!empty($data['lc_dst_fld']['cm'])?mb_substr($data['lc_dst_fld']['cm'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['cm'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['am'])&&!empty($data['lc_dst_fld']['am'])?mb_substr($data['lc_dst_fld']['am'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['am'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['lfx'])&&!empty($data['lc_dst_fld']['lfx'])?mb_substr($data['lc_dst_fld']['lfx'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['lfx'],0,1):""; ?></td>										
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['mfx2'])&&!empty($data['lc_dst_fld']['mfx2'])?mb_substr($data['lc_dst_fld']['mfx2'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['mfx2'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['pas'])&&!empty($data['lc_dst_fld']['pas'])?mb_substr($data['lc_dst_fld']['pas'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['pas'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['lzd'])&&!empty($data['lc_dst_fld']['lzd'])?mb_substr($data['lc_dst_fld']['lzd'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['lzd'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['cfz'])&&!empty($data['lc_dst_fld']['cfz'])?mb_substr($data['lc_dst_fld']['cfz'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['cfz'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['eto'])&&!empty($data['lc_dst_fld']['eto'])?mb_substr($data['lc_dst_fld']['eto'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['eto'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['clr'])&&!empty($data['lc_dst_fld']['clr'])?mb_substr($data['lc_dst_fld']['clr'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['clr'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['dim'])&&!empty($data['lc_dst_fld']['dim'])?mb_substr($data['lc_dst_fld']['dim'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['dim'],0,1):""; ?></td>
										<td style="text-align:center;"><?php echo isset($data['lc_dst_fld']['BDQ'])&&!empty($data['lc_dst_fld']['BDQ'])?mb_substr($data['lc_dst_fld']['BDQ'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['BDQ'],0,1):""; ?></td>
																				
										</tr>
									@endif	
								@endif
						</table>

						<tr>	
							<td>	
								
								@if($data['lc_dst']->count() > 0)
									LCDST - Date Result: {{ date ('d-m-Y', strtotime($data['lc_dst'][0]->result_date)) }} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Date Reported:{{date('d-m-Y H:i:s', time())}} &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
									Reported by: {{ Auth::user()->name }} 
									<br />
								@endif
							</td>
						</tr>
					</td>
					</tr>
				@endif
				@if(count($data['lc_dst'])>0)
					<th style="text-align:center;">R: Resistant; S: Susceptible; C: Contaminated; -- Not done</th>
        		@endif
			@endif

		
		@if( $data['serviceId'] == '22' && $data['tag'] == 'LJ' )

				@if(!empty($data['lj_dst_fld']['s'])
					|| !empty($data['lj_dst_fld']['H(inh A)'])
					|| !empty($data['lj_dst_fld']['H(Kat G)']) 
					|| !empty($data['lj_dst_fld']['r'])
					|| !empty($data['lj_dst_fld']['e'])
					|| !empty($data['lj_dst_fld']['z'])
					|| !empty($data['lj_dst_fld']['km'])
					|| !empty($data['lj_dst_fld']['cm'])
					|| !empty($data['lj_dst_fld']['am'])
					|| !empty($data['lj_dst_fld']['lfx'])					
					|| !empty($data['lj_dst_fld']['mfx2'])
					|| !empty($data['lj_dst_fld']['pas'])
					|| !empty($data['lj_dst_fld']['lzd'])
					|| !empty($data['lj_dst_fld']['cfz'])
					|| !empty($data['lj_dst_fld']['eto'])
					|| !empty($data['lj_dst_fld']['clr'])
					|| !empty($data['lj_dst_fld']['Dim'])
					|| !empty($data['lj_dst_fld']['BDQ']))

					<tr>
						<td colspan="2">
							
							<table WIDTH=100%>
								<tr>
									<th colspan="20" style="text-align:center;">Drug Susceptibility Test (DST) results</th>
								</tr>
								<tr>
									<td rowspan="2"; style="text-align:center;">Sample ID</td>
									<td colspan="6"; style="text-align:center;">1st Line drugs</td>
									<td colspan="3"; style="text-align:center;">SLI</td>
									<td colspan="3"; style="text-align:center;">FQ</td>
									<td colspan="6"; style="text-align:center;">Others</td>
								</tr>
								<tr>
									<td style="text-align:center;" width="45">S</td>
									<td style="text-align:center;"  width="45">H</td>				
									<td style="text-align:center;" width="45">R</td>
									<td style="text-align:center;" width="45">E</td>
									<td style="text-align:center;" width="45">Z</td>
									<td style="text-align:center;" width="45">Km</td>
									<td style="text-align:center;" width="45">Cm</td>
									<td style="text-align:center;" width="45">Am</td>
									<td style="text-align:center;" width="40">Lfx</td>									
									<td style="text-align:center;" width="40">Mfx (1)</td>
									<td style="text-align:center;" width="40">PAS</td>
									<td style="text-align:center;" width="40">Lzd</td>
									<td style="text-align:center;" width="40">Cfz</td>
									<td style="text-align:center;" width="40">Eto</td>
									<td style="text-align:center;" width="40">Clr</td>
									<td style="text-align:center;" width="40">Dim</td>
									<td style="text-align:center;" width="40">BDQ</td>
								</tr>

								@if(isset($data['lj_dst_fld'])&& !empty($data['lj_dst_fld']))
									@if( !empty($data['lj_dst_fld']['s'])
									|| !empty($data['lj_dst_fld']['H(inh A)'])
									|| !empty($data['lj_dst_fld']['H(Kat G)']) 
									|| !empty($data['lj_dst_fld']['r'])
									|| !empty($data['lj_dst_fld']['e'])
									|| !empty($data['lj_dst_fld']['z'])
									|| !empty($data['lj_dst_fld']['km'])
									|| !empty($data['lj_dst_fld']['cm'])
									|| !empty($data['lj_dst_fld']['am'])
									|| !empty($data['lj_dst_fld']['lfx'])									
									|| !empty($data['lj_dst_fld']['mfx2'])
									|| !empty($data['lj_dst_fld']['pas'])
									|| !empty($data['lj_dst_fld']['lzd'])
									|| !empty($data['lj_dst_fld']['cfz'])
									|| !empty($data['lj_dst_fld']['eto'])
									|| !empty($data['lj_dst_fld']['clr'])
									|| !empty($data['lj_dst_fld']['Dim'])
									|| !empty($data['lj_dst_fld']['BDQ']))							
									<tr>
										{{-- <td style="text-align:center;">LJ DST-{{ !empty($data['culturelj']->sample_label)?$data['culturelj']->sample_label:"" }}</td> --}}

										<td style="text-align:center;">LJ DST-{{ $data['sampleLable'] }}</td>

										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['s'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['s'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['H(inh A)'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['H(inh A)'],0,1) }}</td>
										<!--<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['H(Kat G)'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['H(Kat G)'],0,1) }}</td>-->
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['r'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['r'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['e'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['e'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['z'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['z'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['km'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['km'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['cm'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['cm'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['am'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['am'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['lfx'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['lfx'],0,1) }}</td>										
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['mfx2'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['mfx2'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['pas'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['pas'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['lzd'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['lzd'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['cfz'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['cfz'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['eto'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['eto'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['clr'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['clr'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['Dim'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['Dim'],0,1) }}</td>
										<td style="text-align:center;">{{ mb_substr($data['lj_dst_fld']['BDQ'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['BDQ'],0,1) }}</td>
									</tr>
									@endif
								@endif
							</table>
							<tr>	
								<td>	
									@if(!empty($data['lj_dst']))
										LJDST - Date Result: {{ date ('d-m-Y', strtotime($data['lj_dst'][0]->created_at)) }} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
										Date Reported:{{date('d-m-Y H:i:s', time())}} &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
										Reported by: {{ Auth::user()->name }} 
										<br />
									@endif								
								</td>
							</tr>
						</td>
					</tr>
				@endif

				@if(count((array)$data['lj_dst'])>0)
					<th style="text-align:center;">R: Resistant; S: Susceptible; C: Contaminated; -- Not done</th>
				@endif
			@endif		      
		</table>
		<h6 align="center">(<?php echo $data['report_type']; ?>)</h6>
</div>
</body>
</html>
