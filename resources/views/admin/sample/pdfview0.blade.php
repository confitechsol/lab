<?php //dd($data); ?>
<style type="text/css">
	table td, table th{
		border:1px solid black;
	}
	input[type=checkbox] {
    display: inline;
	}
</style>

<div class="container">

	<br/>
	<?php // echo "<pre>"; print_r($data); ?>
@if(empty($data['checkflag']))
	<a id="pdfhide" href="{{ url('pdfview/'.$data['personal']->smp_id,['download'=>'pdf']) }}">Download PDF</a>
@endif


	<h2 align="center">RNTCP Request Form for examination of biological specimen for TB</h2>
	<p align="center">(Required for Diagnosis of TB, Drug Sensitivity Testing and follow up)</p>

	<table align="center">
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="4">Patient Information</th>
					</tr>

					<tr>
						<td width="20%">Patient Name</td>
						<td width="30%">{{$data['personal']->userName}}</td>
						<td width="25%">Age (in yrs):<u>{{$data['personal']->age?$data['personal']->age:"________"}}</u></td>
						<td width="25%">
							Gender: <input type="checkbox" name="" value="" @if($data['personal']->gender == "M")checked @endif >M
							<input type="checkbox" name="" value="" @if($data['personal']->gender == "F")checked @endif >F
							<input type="checkbox" name="" value="" @if($data['personal']->gender == "TG")checked @endif>TG</td>
					</tr>
<?php //dd($data['personal']); ?>
					<tr>
						<td>Patient mobile no. or other contact no.</td>
						<td>{{$data['personal']->mobile_number}}</td>
						<td>Specimen<br /> Date of collection: <u>{{$data['personal']->collection_dates?date('d-m-Y',strtotime($data['personal']->collection_dates)):"____________"}}</u></td>
						<td>
							<input type="checkbox" name="" value=""  @if($data['personal']->sample_type == "Sputum")checked @endif>Sputum</br>
							<?php if(!empty($data['personal']->sample_type) && $data['personal']->sample_type  != "Sputum" ): ?>
							<input type="checkbox" name="" value="" @if($data['personal']->sample_type != "Sputum")checked @endif>
							Other: ( <?php if(!empty($data['personal']->sample_type) && $data['personal']->sample_type == "Others" ){
								echo $data['personal']->others_type;
							}else{
									echo $data['personal']->sample_type;
							} ?>)<?php endif; ?>

						</td>
					</tr>

					<tr>
						<td rowspan="2">Patient address with landmark</td>
						<td rowspan="2">
							House No: {{$data['personal']->house_no}}, Street: {{$data['personal']->street}}, Ward: {{$data['personal']->ward}}</br>
							City: {{$data['personal']->city}}, Taluka: {{$data['personal']->taluka}}</br>
							Landmark: {{$data['personal']->landmark}}, Pincode: {{$data['personal']->pincode}}</td>
						<td colspan="2">
							HIV Status: <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == "Reactive")checked @endif >Reactive
							 <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == "Non-Reactive")checked @endif>Non-reactive
							 <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == "Unknown")checked @endif>Unknown
						 </td>
					</tr>
					<tr>
						<td colspan="2">
							Key populations: <input type="checkbox" name="" value="" @if($data['personal']->key_population == "Contact of known TB Patient")checked @endif>Contact of known TB Patient
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Diabetes")checked @endif>Diabetes
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Tobacco")checked @endif>Tobacco
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Prison")checked @endif>Prison
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Miner")checked @endif>Miner
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Migrant")checked @endif>Migrant
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Refugee")checked @endif>Refugee
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Urban Slum")checked @endif>Urban Slum
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Health Care Worker")checked @endif>Health-care worker
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Not Applicable")checked @endif >Not Applicable
							<input type="checkbox" name="" value="" @if($data['personal']->key_population == "Other")checked @endif >Other (Specify):
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
				<table WIDTH=100%>
					<tr>
						<td WIDTH="50%">Name referring facility (PHI/DMC/DR-TB Centre/Laboratory/other):
							@if($data['personal']->f_name!='Others')
							{{$data['personal']->f_name}}
							@else
							{{$data['personal']->facility_type_other}}
							@endif
						</br>
							Health Establishment ID (NIKSHAY): <?php if(!empty($data['personal']->health_establish_id)){ echo $data['personal']->health_establish_id; }else{
								echo "_ _ _ _";
							} ?>
						</td>
						<!-- <td>CDL NIKSHAY ID: {{$data['personal']->nikshay_id?$data['personal']->nikshay_id:"_ _-_ _ _-_-C-_ _-_ _ _ _ _"}}  </br> -->
							RNTCP TB Reg No. _________________    </br>
							<input type="checkbox" name="" value="">Not Applicable
						</td>
					</tr>

					<tr>
						<td colspan="2">
							State: {{$data['personal']->state_name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  District: <?php echo $data['personal']->district; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Tuberculosis Unit(TU): {{$data['personal']->mtb}}&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="2">Dignosis and follow up of TB</th>
					</tr>
					<tr>


						<td WIDTH="50%">Dignosis(NIKSHAY ID____): <?php if(!empty($data['personal']->nikshay_id)){ echo $data['personal']->nikshay_id; }else{ echo ""; } ?></td>
						<td>Follow up (Smear and culture)</td>
					</tr>
					<?php //dd($data['personal']); ?>
					<tr>
						<td>H/O anti TB Rx for>1 month: <input type="checkbox" name="" value=""<?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'yes'){ echo "checked"; }} ?> />Yes <input type="checkbox" name="" value="" <?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'no'){ echo "checked"; }} ?>>No</td>
						<?php if(!empty($data['test_requests'])){ ?>
						<td rowspan="2">
<?php //dd($data['personal']->nikshay_id); ?>
							RNTCP TB Reg no:   <u><?php if(!empty($data['test_requests']->rntcp_reg_no)){ echo $data['test_requests']->rntcp_reg_no; } ?></u></br>
							NIKSHAY ID:	<u>{{$data['personal']->nikshay_id?$data['personal']->nikshay_id:"_____________"}}</u></br>
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
						<td rowspan="2">
							RNTCP TB Reg no:   <u>{{$data['personal']->rntcp_reg_no?$data['personal']->rntcp_reg_no:"____________"}}</u></br>
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
					<tr>
						<td>
							<input type="checkbox" name="" @if($data['personal']->ps_name)checked @endif value="">Presumtive TB Predominant symptom: <u>{{$data['personal']->ps_name?$data['personal']->ps_name:"_____________"}}</u></br>
							<input type="checkbox" name="" @if($data['personal']->duration)checked @endif >Private referral Duration: <u>{{$data['personal']->duration?$data['personal']->duration:"_____________"}}</u> days	</br>
							<input type="checkbox" name="" @if($data['personal']->diagnosis=="4")checked @endif>Presumtive NTM
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="3">Dignosis and follow up Drug-resistant TB</th>
					</tr>
					<tr>
						<td colspan="2" WIDTH=60%>Drug Susceptibility Testing (DST)</td>
						<td>Follow up (Culture)</td>
					</tr>

					<tr>
						<td WIDTH=30% rowspan="2"><input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb)checked @endif value="">Presumptive MDR TB</td>
						<?php if(!empty($data['test_requests']->regimen)){ ?>
						<td>
							<input type="checkbox" @if($data['test_requests']->regimen == "New" && $data['personal']->req_test_type == 3)checked @endif >New
							<input type="checkbox" @if($data['test_requests']->regimen == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif > Previously treated
						</td>
					<?php }else{ ?>
						<td>
							<input type="checkbox" @if($data['personal']->regimen == "New" && $data['personal']->req_test_type == 3)checked @endif >New
							<input type="checkbox" @if($data['personal']->regimen == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif > Previously treated
						</td>
					<?php } ?>
					<?php if(!empty($data['req_test'])){

//dd($data['personal']);
						?>


						<td rowspan="5">
							PMDT TB No.<?php $cond= !empty($data['personal']->pmdt_tb_no)?$data['personal']->pmdt_tb_no:"___________________"; echo $cond;?>	</br>
							DR TB NIKSHAY ID:<?php if(!empty($data['personal']->pmdt_tb_no)){ echo $data['personal']->nikshay_id; }else{ echo ""; } ?>	</br></br>
							Regimen:</br>

							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for INH mono/poly resistant TB")checked @endif>Regimen for INH</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for MDR/RR TB")checked @endif>Regimen for MDR/RR TB</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Modified Regimen for MDR/RR-TB + FQ/SLI resistance")checked @endif>Regimen for MDR/RR TB + FQ/SLI</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for XDR TB")checked @endif>Regimen for XDR TB</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen for Bedaquiline for MDR-TB Regimen +FQ/SLI resiatnce")checked @endif>Regimen with Bedaquiline </br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen withBedaquiline for failures of regimenfor XDR- TB")checked @endif>Regimen with Bedaquiline for failure</br>
							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen with Bedaquiline for failures of regimenfor MDR- TB")checked @endif>Regimen with Bedaquiline for failure MDR-TB</br>

							<input type="checkbox" name="" @if($data['req_test']->regimen_fu == "Regimen withBedaquiline for failures of regimenfor XDR- TB")checked @endif>Regimen with Bedaquiline for failure XDR-TB</br>



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

							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for INH mono/poly resistant TB")checked @endif>Regimen for INH</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for MDR/RR TB")checked @endif>Regimen for MDR/RR TB</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Modified Regimen for MDR/RR-TB + FQ/SLI resistance")checked @endif>Regimen for MDR/RR TB + FQ/SLI</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for XDR TB")checked @endif>Regimen for XDR TB</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen for Bedaquiline for MDR-TB Regimen +FQ/SLI resiatnce")checked @endif>Regimen with Bedaquiline </br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen withBedaquiline for failures of regimenfor XDR- TB")checked @endif>Regimen with Bedaquiline for failure</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen with Bedaquiline for failures of regimenfor MDR- TB")checked @endif>Regimen with Bedaquiline for failure MDR-TB</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Regimen withBedaquiline for failures of regimenfor XDR- TB")checked @endif>Regimen with Bedaquiline for failure XDR-TB</br>
							<input type="checkbox" name="" @if($data['personal']->regimen_fu == "Other")checked @endif>Other{{$data['personal']->regimen_fu}}</br>





							@if($data['personal']->regimen_fu == "Other")
								&emsp; Other Regimen : {{$data['pesronal']->fudrtb_regimen_other}}</br>
							@endif




							Treatment <input type="checkbox" name="" @if($data['personal']->month_week == "Month")checked @endif>Month <input type="checkbox" name="" @if($data['personal']->month_week == "Week")checked @endif>Week  &emsp; No.: {{$data['personal']->treatment?$data['personal']->treatment :"__________________"}}
						</td>

				<?php 	} ?>

					</tr>

	<?php
	if(!empty($data['test_requests'])){
// dd($data['test_requests']->type_of_prsmptv_drtb);
	 $explode= $data['type_of_prsmptv_drtb']; ?>
					<tr>
						<td>
							<input type="checkbox" name="" <?php foreach ($explode as $key => $value) {

							 if($value == "At diagnosis"){ echo "checked"; } } ?> >At diagnosis	</br>
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
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Follow up Sm+ve")checked @endif>Follow up Sm +ve	</br>
								<input type="checkbox" name="" @if($data['personal']->type_of_prsmptv_drtb == "Private referall")checked @endif>Private referral	</br>
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
// dd($data['test_requests']->prsmptv_xdrtv);
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
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="2">Test Requested</th>
					</tr>
					<tr>
						<td colspan="2">
							<input type="checkbox" @if(in_array(1,$data['test_requested']))checked @endif >Microscopy
							<input type="checkbox">TST
							<input type="checkbox" name="" value="" @if(in_array(10,$data['test_requested']))checked @endif>IGRA
							<input type="checkbox" name="" value="" @if(in_array(11,$data['test_requested']))checked @endif>Chest X-ray
							<input type="checkbox" name="" value="" @if(in_array(12,$data['test_requested']))checked @endif>Cytopathology
							<input type="checkbox" name="" value="" @if(in_array(13,$data['test_requested']))checked @endif>Histopathology
							<input type="checkbox" @if(in_array(2,$data['test_requested']))checked @endif >CBNAAT
							<input type="checkbox" @if(in_array(3,$data['test_requested']))checked @endif >Culture
							<input type="checkbox" @if(in_array(21,$data['test_requested']) || in_array(22,$data['test_requested']) || in_array(23,$data['test_requested']))checked @endif >DST
							<input type="checkbox" @if(in_array(4,$data['test_requested']) || in_array(5,$data['test_requested']) || in_array(6,$data['test_requested']))checked @endif >Line Probe Assay
							<input type="checkbox" name="" value="">Gene Sequencing
							<input type="checkbox" name="" value="">Other(Please Specify):
							</br>
							Requestor Name: {{$data['personal']->requestor_name}} Designation: {{$data['personal']->designation}}  Signature:_________________________ 	</br>
							Contact Number: {{$data['personal']->requestor_cno}} </br>
							Email Id: {{$data['personal']->requestor_email}}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th WIDTH=50% align="left">Results:</th>
						<td>NIKSHAY ID Generated: {{$data['personal']->nikshay_id}}</td>
						<td>Date of Receipt: {{$data['date_receipt']->receive_date}}</td>
					</tr>
				</table>
			</td>
		</tr>
		@if($data['microscopyA']->result)
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="8">Microscopy(<input type="checkbox" name="zn" value="" @if($data['microscopy'] == 1)checked @endif >ZN <input type="checkbox" name="florscent" value="" @if($data['microscopy'] == 2)checked @endif>Florescent)</th>
					</tr>
					<tr>

						<td rowspan="2">Sample</td>
						<td rowspan="2">Sample : {{$data['lab_sr']->sample_label}}</td>
						<td rowspan="2">Visual appearance</td>
						<td colspan="5" WIDTH=60% align="center">Result</td>
					</tr>
					<tr>
						<td>Negative</td>
						<td>Scanty</td>
						<td>1+</td>
						<td>2+</td>
						<td>3+</td>
					</tr>
					<tr>
						<td>Sample A</td>
						@if($data['microscopyA'])
						<td>{{$data['microscopyA']->sample_label}}</td>
						<td>@if($data['microscopyA']->result=='NA')Yes @else No @endif</td>
						<td>@if($data['microscopyA']->result=='Negative')Yes @else No @endif</td>
						<td>@if($data['microscopyA']->result=='Scanty' || $data['microscopyA']->result=='Sc 9')Yes @else No @endif</td>
						<td>@if($data['microscopyA']->result=='1+positive')Yes @else No @endif</td>
						<td>@if($data['microscopyA']->result=='2+positive')Yes @else No @endif</td>
						<td>@if($data['microscopyA']->result=='3+positive')Yes @else No @endif</td>
						<td>Date Result:{{date('d-m-Y', strtotime($data['microscopyA']->updated_at))}}  &emsp; Date Reported:{{$data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}</td>
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

		<?php if(!empty($data['microscopyB']->original)){ ?>
					<tr>
						<td>Sample B</td>
						@if($data['microscopyB'])
						<td>{{$data['microscopyB']->sample_label}}</td>
						<td>@if($data['microscopyA']->result=='NA')Yes @else No @endif</td>
						<td>@if($data['microscopyB']->result=='Negative')Yes @else No @endif</td>
						<td>@if($data['microscopyB']->result=='Scanty' || $data['microscopyA']->result=='Sc 9')Yes @else No @endif</td>
						<td>@if($data['microscopyB']->result=='1+positive')Yes @else No @endif</td>
						<td>@if($data['microscopyB']->result=='2+positive')Yes @else No @endif</td>
						<td>@if($data['microscopyB']->result=='3+positive')Yes @else No @endif</td>
						<td>Date Result:{{date('d-m-Y', strtotime($data['microscopyB']->updated_at))}}  &emsp; Date Reported:{{$data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}</td>
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
							<tr>
								<td>Remark: </td>
								<td colspan="7">{{$val['remark']}}</td>
							</tr>
							<tr>
								<td>Detail: </td>
								<td colspan="7">{{$val['detail']}}</td>
							</tr>

							@endif
						@endforeach
					@endif
				</table>
			</td>
		</tr>
		@endif

	<?php if(!empty($data['cbnaat'])){
		// dd($data['cbnaat']);
		if(count($data['cbnaat']) > 0){
		 ?>

		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="2">Cartridge Based Nucleic Acid Amplification Test</th>
					</tr>
					<tr>
						@if($data['cbnaat'])
						<td WIDTH="30%">Sample</td><td>{{ $data['cbnaat'][0]->sample_label }}</td>
						@else
						<td WIDTH="30%">Sample</td><td></td>
						@endif
					</tr>
					<tr>
						<td>M. Tuberculosis</td>
						<td>
							@if($data['cbnaat'])
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'MTB Detected')checked @endif>Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'MTB Not Detected')checked @endif>Not Detected
							<input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'Invalid' || $data['cbnaat'][0]->result_MTB == 'Error')checked @endif>N/A
							@else
							<input type="checkbox" >Detected
							<input type="checkbox" >Not Detected
							<input type="checkbox" >N/A
							@endif
						</td>
					</tr>
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
						<td colspan="2">
							@if($data['cbnaat'])
							Date Result:{{date('d-m-Y', strtotime($data['cbnaat'][0]->test_date))}}  &emsp; Date Reported:{{$data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}
							@else
							Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
							@endif
						</td>
					</tr>
					<tr>
						<td>Test</td><td><input type="checkbox" @if($data['cbnaat'][0]->error != '')checked @endif>Error (Please arrange for fresh sample) : {{$data['cbnaat'][0]->error}}</td>
					</tr>
					@if(count($data['microbio'])>0)
						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']==4)
						<?php if(!empty($val['remark'])){ ?>
						<tr>
							<td>Remark: </td>
							<td>{{$val['remark']}}</td>
						</tr>
					<?php } ?>

					<?php if(!empty($val['detail'])){ ?>
						<tr>
							<td>Detail: </td>
							<td>{{$val['detail']}}</td>
						</tr>
							<?php } ?>
						@endif
						@endforeach
					@endif

				</table>
			</td>
		</tr>
<?php }}?>

<?PHP //dd($data['culture-llj']); ?>
		@if($data['culturelj'] || $data['culturelc'])
		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="5">Culture (<input type="checkbox"@if(!empty($data['culture-llj'])) @if($data['culture-llj'] == 1)checked @endif @endif >LJ <input type="checkbox" @if(!empty($data['culture'])) @if($data['culture'] == 2)checked @endif @endif >LC)</th>
					</tr>
					<tr>
						<td rowspan="2">Sample : {{$data['lab_sr']->sample_label}}</td>
						<td colspan="4">Results</td>
					</tr>
					<tr>
						<td>Negative</td>
						<td>Positive</td>
						<td>NTM(write species)</td>
						<td>Contamination</td>
					</tr>

					<tr>
						@if(!empty($data['culturelj']))

						<td>{{ $data['culturelj']->sample_label	 }}-LJ REPORT</td>
						<td>@if($data['culturelj']->final_result=='Negative')Yes @else No @endif</td>
						<td>@if($data['culturelj']->final_result=='Positive')Yes @else No @endif</td>
						<td>@if($data['culturelj']->final_result=='NTM')Yes @else No @endif</td>
						<td>@if($data['culturelj']->final_result=='Contamination')Yes @else No @endif</td>
						@else
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						@endif
					</tr>
					<tr>
						@if(!empty($data['culturelc']))
						<td>{{ $data['culturelc']->sample_label	 }}-LC REPORT</td>
						<td>@if($data['culturelc']->result=='Negative')Yes @else No @endif</td>
						<td>@if($data['culturelc']->result=='Positive')Yes @else No @endif</td>
						<td>@if($data['culturelc']->result=='NTM'){{$data['culturelc']->species}} @else No @endif</td>
						<td>@if($data['culturelc']->result=='Contamination')Yes @else No @endif</td>
						@else
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						@endif
					</tr>

					@if(count($data['microbio'])>0)

						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']== 20 || $val['service_id']== 18 || $val['service_id']== 22)
						<tr>
							<td>Remark: </td>
							<td colspan="4">{{$val['remark']}}</td>
						</tr>
						<tr>
							<td>Detail:</td>
							<td colspan="4">{{$val['detail']}}</td>
						</tr>
						@endif
						@endforeach
					@endif

					<tr>

						<td colspan="5">Date Result:
							@if($data['culturelj'])
								{{ $data['culturelj']->lj_result_date }}
							@elseif($data['culturelc'])
								{{ $data['culturelc']->result_date }}
							@endif

							Date Reported:
							@if($data['culturelj'])
								{{ $data['culturelj']->receive_date }}
							@elseif($data['culturelc'])
								{{ $data['culturelc']->receive_date }}
							@endif

						 Reported by(Name and Signature):{{$data['user']}}</td>
					</tr>

@if(!empty($data['culturelc']))
					<tr>
						<td>Final Result: @if($data['culturelc']->result=='NTM'){{$data['culturelc']->species}} @endif </td>
						<td colspan="4">Remark: <input type="text"></td>

					</tr>
			@endif
				</table>

			</td>
		</tr>
		@endif





		@if($data['lpa1'] || $data['lpa2'] || $data['lpaf'])

		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<th colspan="4">Line Probe Assay(LPA)</th>
					</tr>
					<tr>
						@if($data['lpaf'])
						<th colspan="4"><input type="checkbox" name="" value="" <?php if(!empty($data['lpaf']->type_direct)): echo "checked"; endif; ?> >Direct <input type="checkbox"<?php if(!empty($data['lpaf']->type_indirect)): echo "checked"; endif; ?> >Indirect   Lab serial :<?php if(!empty($data['lab_serial'])){ echo $data['lab_serial']->type; } ?> </th>
						@else
						<th colspan="4"><input type="checkbox" name="" value="">Direct <input type="checkbox">Indirect   Lab serial______________</th>
						@endif
					</tr>
					<tr>
						<th colspan="4">First line LPA</th>
					</tr>
					@if($data['lpa1'])
					<tr>
						<td colspan="4">
							RpoB :- Locus Control : @if($data['lpa1']->RpoB == 1) Positive @elseif($data['lpa1']->RpoB == 0)Negative @endif</br>
							WT1: @if($data['lpa1']->wt1 == 1) Present @else Absent @endif
							WT2:	@if($data['lpa1']->wt2 == 1) Present @else Absent  @endif
							WT3:	@if($data['lpa1']->wt3 == 1) Present @else Absent  @endif
							WT4:	@if($data['lpa1']->wt4 == 1) Present @else Absent  @endif</br>
							WT5:	@if($data['lpa1']->wt5 == 1) Present @else Absent  @endif
							WT6:	@if($data['lpa1']->wt6 == 1) Present @else Absent  @endif
							WT7:	@if($data['lpa1']->wt7 == 1) Present @else Absent  @endif
							WT8:	@if($data['lpa1']->wt8 == 1) Present @else Absent  @endif</br>
							MUT1(D516V) :	@if($data['lpa1']->mut1DS16V == 1) Present @else Absent @endif
							MUT2A(H526Y) :	@if($data['lpa1']->mut2aH526Y == 1) Present @else Absent  @endif
							MUT2B(H526D) :	@if($data['lpa1']->mut2bH526D == 1) Present @else Absent @endif
							MUT3(S531L) : @if($data['lpa1']->mut3S531L == 1) Present @else Absent @endif</br>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							KatG :- Locus Control : @if($data['lpa1']->katg == 1) Present @else Absent  @endif</br>
							WT1(315) :	@if($data['lpa1']->wt1315 == 1) Present @else Absent  @endif</br>
							MUT1(S315T1) : @if($data['lpa1']->mut1S315T1 == 1) Present @else Absent  @endif</br>
							MUT2(S315T2) : @if($data['lpa1']->mut2S315T2 == 1) Present @else Absent  @endif
						</td>
						<td colspan="2">
							InhA :- Locus Control : @if($data['lpa1']->inha == 1) Present @else Absent  @endif</br>
							WT1(-15,-16) :	@if($data['lpa1']->wt1516 == 1) Present @else Absent  @endif</br>
							WT2(-8) :	@if($data['lpa1']->wt28 == 1) Present @else Absent  @endif</br>
							MUT1(C15T) :	@if($data['lpa1']->mut1C15T == 1) Present @else Absent  @endif</br>
							MUT2(A16G) : @if($data['lpa1']->mut2A16G == 1) Present @else Absent  @endif</br>
							MUT3A(T8C) :	@if($data['lpa1']->mut3aT8C == 1) Present @else Absent  @endif</br>
							MUT3B(T8A) : @if($data['lpa1']->mut3bT8A == 1) Present @else Absent  @endif
						</td>
					</tr>
					@endif
					<tr>
						<th colspan="4">Second Line LPA</th>
					</tr>
					@if($data['lpa2'])
					<tr>
						<td>
							gyrA :- Locus Control : 	@if($data['lpa2']->gyra == 1) Present @else Absent  @endif</br>
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
						<td>
							gyrB :- Locus Control : @if($data['lpa2']->gyrb == 1) Present @else Absent  @endif</br>
							WT1(536-541) :@if($data['lpa2']->wt1536541 == 1) Present @else Absent  @endif</br>
							MUT1(N538D) :@if($data['lpa2']->mut1N538D == 1) Present @else Absent  @endif</br>
							MUT2(E540V) :@if($data['lpa2']->mut2E540V == 1) Present @else Absent  @endif</br>
						</td>
						<td>
							rss :- Locus Control :@if($data['lpa2']->rrs == 1) Present @else Absent  @endif</br>
							WT1(1401-02) :@if($data['lpa2']->wt1140102 == 1) Present @else Absent  @endif</br>
							WT2(1484) :@if($data['lpa2']->wt21484 == 1) Present @else Absent  @endif</br>
							MUT1(A1401G) :@if($data['lpa2']->mut1A1401G == 1) Present @else Absent  @endif</br>
							MUT2(G1484T) :@if($data['lpa2']->mut2G1484T == 1) Present @else Absent  @endif</br>
						</td>
						<td>
							eis :- Locus Control : 	@if($data['lpa2']->eis == 1) Present @else Absent  @endif</br>
							WT1(37) :@if($data['lpa2']->wt137 == 1) Present @else Absent  @endif</br>
							WT2(14,12,10) :@if($data['lpa2']->wt2141210 == 1) Present @else Absent  @endif</br>
							WT3(2) :@if($data['lpa2']->wt32 == 1) Present @else Absent  @endif</br>
							MUT1(C-14T) :@if($data['lpa2']->mut1c14t == 1) Present @else Absent  @endif</br>
						</td>
					</tr>
					@endif
				</table>
			</td>
		</tr>


		<tr>
			<td colspan="2">
				<table WIDTH=100%>
					<tr>
						<td>
							<strong>Final LPA Interpretation:-</strong></br></br>
							MTB Result:	@if($data['lpaf'])
							{{$data['lpaf']->mtb_result}}
							@endif
						 </br>
						 @if($data['lpaf'])
						 @if(!empty($data['lpaf']->rif))
							RIF Resi:{{$data['lpaf']->rif}}
							</br>
							@endif
							@endif
							@if($data['lpaf'])
						  @if(!empty($data['lpaf']->inh))
							H Resi:{{$data['lpaf']->inh}}
							</br>
							@endif
							@endif
							@if($data['lpaf']->quinolone)
							FQ Resi:
							{{$data['lpaf']->quinolone}}
							@endif
							</br>
							@if($data['lpaf']->slid)
							SLID Resi:
							{{$data['lpaf']->slid}}
							@endif</br>
						</td>
					</tr>
					<tr>
						<td>
						@if($data['lpaf'])
						Date Result:{{date('d-m-Y', strtotime($data['lpaf']->test_date))}}  &emsp; Date Reported:{{$data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}
						@else
						Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
						@endif
						</td>
					</tr>
					@if(count($data['microbio'])>0)
						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']== 15)
						<tr>
							<td>Remark: {{$val['remark']}}</td>
						</tr>
						<tr>
							<td>Detail: {{$val['detail']}}</td>
						</tr>


						@endif
						@endforeach
					@endif
				</table>
			</td>
		</tr>
		@endif


		@if($data['lc_dst'] || $data['lj_dst_fld'])

		<tr>
			<td colspan="2">
				<?php
			if(!empty($data['s']) || !empty($data['h1'])|| !empty($data['h2']) || !empty($data['r']) ||!empty($data['e']) ||!empty($data['z'])|| !empty($data['km']) || !empty($data['cm']) || !empty($data['am']) || !empty($data['lfx']) || !empty($data['mfx1']) || !empty($data['mfx2']) || !empty($data['pas'])  || !empty($data['lzd']) || !empty($data['cfz']) || !empty($data['eto']) || !empty($data['cla']) || !empty($data['azi']) ){
			?>
				<table WIDTH=100%>
					<tr>
						<th colspan="20">Drug Susceptibility Test (DST) results</th>
					</tr>
					<tr>
						<td rowspan="2">Sample : {{$data['lab_sr']->sample_label}}</td>
						<td colspan="6">1st Line drugs</td>
						<td colspan="3">SLI</td>
						<td colspan="3">FQ</td>
						<td colspan="6">Others</td>
					</tr>
					<tr>
						<td>S</td>
						<td>H1</td>
						<td>H2</td>
						<td>R</td>
						<td>E</td>
						<td>Z</td>
						<td>Km</td>
						<td>Cm</td>
						<td>Am</td>
						<td>Lfx</td>
						<td>Mfx(0.5)</td>
						<td>Mfx(2)</td>
						<td>PAS</td>
						<td>Lzd</td>
						<td>Cfz</td>
						<td>Eto</td>
						<td>Cla</td>
						<td>Azi</td>

					</tr>
					<tr>
						<td></td>
						<td>{{mb_substr($data['s'],0,1)}}</td>
						<td>{{mb_substr($data['h1'],0,1)}}</td>
						<td>{{mb_substr($data['h2'],0,1)}}</td>
						<td>{{mb_substr($data['r'],0,1)}}</td>
						<td>{{mb_substr($data['e'],0,1)}}</td>
						<td>{{mb_substr($data['z'],0,1)}}</td>
						<td>{{mb_substr($data['km'],0,1)}}</td>
						<td>{{mb_substr($data['cm'],0,1)}}</td>
						<td>{{mb_substr($data['am'],0,1)}}</td>
						<td>{{mb_substr($data['lfx'],0,1)}}</td>
						<td>{{mb_substr($data['mfx1'],0,1)}}</td>
						<td>{{mb_substr($data['mfx2'],0,1)}}</td>
						<td>{{mb_substr($data['pas'],0,1)}}</td>
						<td>{{mb_substr($data['lzd'],0,1)}}</td>
						<td>{{mb_substr($data['cfz'],0,1)}}</td>
						<td>{{mb_substr($data['eto'],0,1)}}</td>
						<td>{{mb_substr($data['cla'],0,1)}}</td>
						<td>{{mb_substr($data['azi'],0,1)}}</td>
					</tr>

					@if(count($data['microbio'])>0)

						@foreach ($data['microbio'] as $key=> $val)
						@if($val['service_id']== 20)
						<tr>
							<td>Remark: </td>
							<td colspan="18">{{$val['remark']}}</td>
						</tr>

						<tr>
							<td>Detail:</td>
							<td colspan="18">{{$val['detail']}}</td>
						</tr>
						<tr>
							<td>
							@if($val['created_at'])
							Date Result:{{date('d-m-Y', strtotime($val['created_at']))}}  &emsp; Date Reported:{{$data['today']}} &emsp; Reported by(Name and Signature):{{$data['user']}}
							@else
							Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
							@endif
							</td>
						</tr>

						@endif
						@endforeach
						@endif

				</table>


			<?php } ?>
			</td>
		</tr>

		@endif

	</table>
		<h2 align="center">Annexure 15 A (<?php echo $data['report_type']; ?>)</h2>
</div>
<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
}
</style>
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
