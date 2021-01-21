<?php //dd($val['created_at']); ?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
<style type="text/css">

   input[type=checkbox]{
	  transform:scale(0.7);
	  margin: 0;
	  vertical-align: middle;
   }

   label{
	   font-size:8px;
	   vertical-align: middle;
	   margin-top: 0 !important;
   }


   @media print {

   	* {
    color: #000;
    background-color: #fff;
    font-size: 10px;


     }
     @page {
      size: A4; /* DIN A4 standard, Europe */
      margin:0;
    }
    body
			{
			  margin:0mm 0mm 0mm 0mm;
			  font-size:10px;
			  line-height: 1.1;


			}
		 .my_container{ }
		  #pdfhide{ display:none;}

	}
  ul{ margin: 0px; padding: 0px;}
  ul li{ float: left; list-style-type:none; float: left;}


  #pdfhide{ color:#6cb5d9;}
</style>

<style>
table {
    border-collapse: collapse;
}

td, th {
    border: 1px solid black;
	line-height: 1.1;
	padding: 0 0.085rem;

}
table{ border-left: 0px;}
body
{
  margin:0mm 5mm 5mm 5mm;
  font-size:10px;

}

.t-no-border{
}

@page { margin-top: 120px; margin-bottom: 120px}
header { position: fixed; left: 0px; top: -90px; right: 0px; height: 150px; text-align: center; }
.my_container{
	margin-top:50px !important;
}
@page:first-child {
.headcls{display:none;}
}
[type="checkbox"]
{
    vertical-align:middle;
}
</style>
</head>
<body>
<!------Amrita  on  18/05/20202 start------->
{{-- Here's the magic. This MUST be inside body tag. Page count / total, centered at bottom of page --}}
<script type="text/php">
    if (isset($pdf)) {		
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
		//$page_num = $pdf->get_page_number();	
        $size = 8;
        $font = $fontMetrics->getFont("Arial");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
		
		
        //header
		
		  $pdf->page_text(50,90,'Name of the patient: <?php echo $data['personal']->userName;?> (Nikshay ID: <?php echo $data['personal']->pnikshay_id; ?>)',$font,$size);
		
	   //footer
		$pdf->page_text($x, $y, $text, $font, $size);
		
    }
</script>
<!------Amrita  on  18/05/20202 start------->
<header style="width: 100%; margin-top: 0px; ">	 
	 <table width="100%" style="border:none;">
		<tr>
			<td colspan="4" style="border:none;">
			</td>
			<td style="border:none;">
			  <p style="margin-top: -1%;" align="right">Annexure 15 A...
				  @if( request('d') ) <br>
				  Duplicate &nbsp; &nbsp;
				  @endif
			  </p>
			</td>
		</tr>	
	</table>
    <table width="100%" style="border:none;">	
		<tr>
			<td style="width:18%; border:none;">		 
			@if(!empty($data['config']->logo))
			 <img style="border-radius:15px;" src="{{ public_path('uploads/lab_logo/'.$data['config']->logo)}}" height="60px" width="60px"/>
			@endif
		   </td>
			<td style="width:64%; border:none;">
				<h2 align="center" style="color: #6cb5d9; margin-bottom: 0px;padding: 0px; margin-top:0px; font-size:14px; margin-top:-14px;">NTEP Request Form for examination of biological specimen for TB</h2>
				<p align="center" style="margin:0px;">(Required for Diagnosis of TB, Drug Sensitivity Testing and follow up)</p>	
			</td>
			<td style="width:20%; border:none;">
			   @if(!empty($data['config']->nabl_logo))
				<img "style="border-radius:15px;" src="{{ public_path('uploads/nabl_logo/'.$data['config']->nabl_logo)}}" height="60px" width="60px" align="right"/>
				@endif
			</td>
		</tr>
	</table>
	<table width="100%" style="border:none;">	
		<tr>
			<td style="border:none;">
				@if(empty($data['checkflag']))
					<a id="pdfhide" href="{{ url('pdfview/'.$data['personal']->smp_id,['download'=>'pdf']) }}">Download PDF</a>
				@endif
			</td>
			<td colspan="3" style="border:none;">
			</td>
			<td style="border:none;">
				@if(!empty($data['config']->nabl_no))
				   <p align="right" style="font-size:8px">   {{ $data['config']->nabl_no }} &nbsp;&nbsp;&nbsp; </p>
				@endif
			</td>
		
		</tr>  
	</table>
	<!---
	<table width="100%" style="border:none;">	
		<tr>
			<td style="border:none;">				
			</td>
			<td colspan="3" style="text-align:center;border:none;" class="headcls">
			Name and Enrollment No: <?php //echo $data['personal']->userName. ' - '.$data['personal']->label; ?>
			</td>
			<td style="border:none;">
				
			</td>
		
		</tr>  
	</table>---->
</header>
<!------Amrita  on  18/05/20202 end------->
<div class="my_container"">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none; ">
         <tr>

               <td colspan="2" style="border:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border:2px solid #000; border:none; margin-top:-30px;">
              <tr valign="top">
                <th colspan="4" style="text-align:center; padding:3px;">Patient Information</th>
              </tr>
                <tr>
                  <td width="50%" colspan="2" valign="top">
                      <table width="100%" border="0" cellspacing="5" cellpadding="5" style="margin-left:-1px; border:none;" >
        <tr>
          <td colspan="2" style="border-top:0px; padding:5px;" width="45%" >Patient name</td>
          <td colspan="2" style="border-top:0px; border-right:0px;padding:5px;">{{$data['personal']->userName}}</td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px; border-right:0px;padding:5px;">Patient mobile no. or<br />
            other contact no.</td>
          <td colspan="2" style="border-top:0px; border-right:0px; padding:5px;">{{$data['personal']->mobile_number}}</td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px; border-right:0px;padding:5px;">Aadhaar no.(If available )</td>
          <td colspan="2" style="border-top:0px; border-right:0px;padding:5px;">{{$data['personal']->adhar_no}}</td>
        </tr>
        <tr>
          <td colspan="2" style="border-top:0px; border-right:0px;padding:5px;">Patient address with<br />
            landmark</td>
          <td colspan="2" style="border-top:0px; border-right:0px; padding:3px; height:96px;">  House No: {{$data['personal']->house_no}}, Street: {{$data['personal']->street}}, Ward: {{$data['personal']->ward}}</br>
            City: {{$data['personal']->city}}, Taluka: {{$data['personal']->taluka}}</br>
            Landmark: {{$data['personal']->landmark}}, Pincode: {{$data['personal']->pincode}}</td>
        </tr>
      </table>
                  </td>
                  <td valign="top" colspan="2">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="border:none;" colspan="2" width="49%"><b>Age (in yrs):</b>{{$data['personal']->age?$data['personal']->age:"________"}}</td>
          <td style="border-top:0px; border-right:0px;" colspan="2"> <b style="margin-top:-2px; display:inline-block;">Gender:</b> <input type="checkbox" name="" value="" @if($data['personal']->gender == "male")checked @endif >
            <label style="margin-top:-2px; display:inline-block">M</label>
            <input type="checkbox" name="" value="" @if($data['personal']->gender == "female")checked @endif >
            <label style="margin-top:-2px; display:inline-block">F</label>
            <input type="checkbox" name="" value="" @if($data['personal']->gender == "transgender")checked @endif>
            <label style="margin-top:-2px; display:inline-block">TG</label>
             </td>
          </td>
        </tr>
        <tr>
          <td style="border-left:0px;border-bottom:0px;" colspan="2"><b>Specimen</b><br /> <b>Date of collection: </b>{{$data['personal']->collection_dates?date('d-m-Y',strtotime($data['personal']->collection_dates)):"____________"}}<br />
		  <b>Time of collection: </b>{{ $data['personal']->collection_time}}</td>

          <td style="border-left:0px;border-bottom:0px; border-right:0px;" colspan="2"> <input type="checkbox" name="" value=""  @if($data['personal']->sample_type == "Sputum")checked @endif><label style="margin-top:-2px; display:inline-block"><b>Sputum</b></label>
            <div style="clear:both;"></div>



                      <input type="checkbox" name="" value="" @if($data['personal']->sample_type != "Sputum")checked @endif>

                      <b style="margin-top:-3px; display:inline-block;">Other</b><?php if(!empty($data['personal']->sample_type) && $data['personal']->sample_type == "Others" ){
                         echo " <label style='margin-top:-2px; display:inline-block'>(";
						echo $data['personal']->others_type;
						 echo ")</label>"; 
                      } else{
						   if($data['personal']->sample_type!="Sputum"){
                        echo " <label style='margin-top:-2px; display:inline-block'>(";
                          echo  $data['personal']->sample_type;
						   echo ")</label>"; 
						   }
                      }?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="1" style="margin-left:-1px;">
        <tr>
          <td colspan="2" valign="top" style="border-right:0px;">
              <b style="margin-top:-2px; display:inline-block;">HIV Status:</b> <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 1)checked @endif ><font style="margin-top:-2px; display:inline-block;">Reactive</font>
               <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 2)checked @endif><font style="margin-top:-2px; display:inline-block;">Non-reactive</font>
               <input type="checkbox" name="" value="" @if($data['personal']->hiv_test == 3)checked @endif><font style="margin-top:-2px; display:inline-block;">Unknown</font>
             </td>
        </tr>
        <tr>
            <td colspan="2" style="border-right:0px; border-bottom:0px;">
            <b style="margin-bottom:0px; display:inline-block; margin-top:0px; margin-top:3px;">  Key populations:
             </b>
             <div style="clear:both;"></div>
            <input type="checkbox"  name="" value="" @if($data['personal']->key_population == 1)checked @endif>
			<label style="margin-top:-5px; display:inline-block;">Contact of Known TB Patients</label>

              <input type="checkbox" name="" value="" @if($data['personal']->key_population == 2)checked @endif>
              <label style="margin-top:-5px; display:inline-block;">Diabetes</label>
              <input type="checkbox" name="" value="" @if($data['personal']->key_population == 3)checked @endif>
              <label style="margin-top:-5px; display:inline-block">Tobacco</label>

              <input type="checkbox" name="" value="" @if($data['personal']->key_population == 4)checked @endif>
              <label style="margin-top:-5px; display:inline-block">Prison</label>
			  <br>
			  <!--<div style="clear:both;"></div>-->
              <input type="checkbox" style="margin-top:-4px;"  name=""  value="" @if($data['personal']->key_population == 5)checked @endif>
              <label style="margin-top:-5px; display:inline-block; vertical-align:top;" >Miner</label>
              <input type="checkbox" style="margin-top:-4px;" name=""  value="" @if($data['personal']->key_population == 6)checked @endif>
			  <label style="margin-top:-5px; display:inline-block;  vertical-align:top;">Migrant</label>
              <input type="checkbox" style="margin-top:-4px;" name="" value="" @if($data['personal']->key_population == 7)checked @endif>
			  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Refugee</label>
              <input type="checkbox" style="margin-top:-4px;" name="" value="" @if($data['personal']->key_population == 8)checked @endif>
			  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Urban Slum</label>
			  <!--<div style="clear:both;"></div>-->
			  <br>
              <input type="checkbox" style="margin-top:-4px;" name="" value="" @if($data['personal']->key_population == 9)checked @endif>
			  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Health-care worker</label>
              <input type="checkbox" style="margin-top:-4px;" name="" value="" @if($data['personal']->key_population == 11)checked @endif >
			  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Not Applicable</label>

              <input type="checkbox" style="margin-top:-4px;" name="" value="" @if($data['personal']->key_population == 10)checked @endif >
			  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Other (Specify):

              @if($data['personal']->key_population=='Other')
              {{$data['personal']->population_other}}
              @endif
            </td>
          </tr>

      </table>
                  </td>
                </tr>
    </table>
  </td>
</tr>
   <tr>
    <td colspan="2" style="border:0;"><table width="100%" cellspacing="2" cellpadding="2"
     style="margin-top:3px; border:2px solid #000;">
        <tr>
          <td width="80%"><b>Name referring facility (PHI/DMC/DR-TB Centre/Laboratory/other):</b>
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
            </br>
              <b>Health Establishment ID (NIKSHAY): </b><?php if(!empty($data['personal']->health_establish_id)){ echo $data['personal']->health_establish_id; }else{
                echo "_ _ _ _";
              } ?></td>




          <td>NIKSHAY ID: <?php if(!empty($data['personal']->pnikshay_id)){ echo $data['personal']->pnikshay_id; }else{ echo "_________________"; } ?></td>
        </tr>
        <tr>
          <td colspan="2"><b>State:</b> @if(!empty($data['personal']->state_name)) {{ $data['personal']->state_name }} @else ____________ @endif  <b>District:</b > @if(!empty($data['personal']->district_name)) {{ $data['personal']->district_name }} @else ____________ @endif  <b>Tuberculosis Unit (TU):</b> @if(!empty($data['personal']->mtb)) {{ $data['personal']->mtb }} @else ____________ @endif</td>
        </tr>
      </table></td>
</tr>

 <tr>
    <td colspan="2" style="border:0px;">
    <h1 style="margin-bottom:2px;margin-top:2px; font-size:9px; margin-left:10px;">Reason for Testing</h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px; border:2px solid #000;">
        <tr valign="top">
          <th colspan="2" style="text-align:center; padding:3px;">Diagnosis and follow up of TB</th>
        </tr>
        <tr>
          <td width="50%" valign="top" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:-1px;">
              <tr>
                <td style="padding:4px;border-right:0px;">Diagnosis</td>
              </tr>
              <tr>
                <td style="padding:2px;border-right:0px;"><font style="margin-top:-2px; display:inline-block;">H/O anti TB Rx for>1 month:</font> <input type="checkbox" name="" value=""<?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'yes'){ echo "checked"; }} ?> />
				<label style="margin-top:-2px; display:inline-block">Yes</label>
				<input type="checkbox" name="" value="" <?php if(!empty($data['req_test']->ho_anti_tb)){ if($data['req_test']->ho_anti_tb == 'no'){ echo "checked"; }} ?>>
				<label style="margin-top:-2px; display:inline-block">No</label>

                        </td>
              </tr>

              <?php

              if(!empty($data['test_requests']->diagnosis)){
               $explode_diagonosis=explode(',',$data['test_requests']->diagnosis);
               // dd($explode_diagonosis);
              }
                ?>
              <tr>
                <td style="border-right:0px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="border:none;"><table width="100%" border="0" cellspacing="1" cellpadding="1">

                        <tr>
                          <td  style="border:none;"><input type="checkbox"  name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 1) checked @endif @endforeach  @endif>
						  <label style="margin-top:-2px; display:inline-block">Presumtive TB</label>
                          </td>
                        </tr>

                        <tr>
                          <td  style="border:none;"><input type="checkbox" style="margin-top:-4px;" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 3) checked @endif @endforeach  @endif>
						  <label style="margin-top:-2px;  vertical-align:top; display:inline-block">Private referral</label>
                          </td>
                        </tr>

                        <tr>
                          <td  style="border:none;"><input type="checkbox" style="margin-top:-4px;" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 4) checked @endif @endforeach  @endif>
						  <label style="margin-top:-2px;  vertical-align:top; display:inline-block">Presumtive NTM</label>
                          </td>
                        </tr>

                        <tr>
                          <td  style="border:none;"><input type="checkbox" style="margin-top:-4px;" name=""@if(!empty($explode_diagonosis)) @foreach($explode_diagonosis as $explode_diagonosiss) @if($explode_diagonosiss == 5) checked @endif @endforeach  @endif>
						  <label style="margin-top:-2px;  vertical-align:top; display:inline-block">TB Repeat Exam</label>
                          </td>
                        </tr>



                        </table></td>
                      <td style="border-top:0px; border-bottom:0px;border-right:0px;padding:5px;">Predominant symptom: <u>{{$data['personal']->ps_name?$data['personal']->ps_name:"_____________"}}</u> <br>
                        Duration:<u>{{$data['personal']->duration?$data['personal']->duration:"_____________"}}</u> days </td>
                    </tr>
                  </table></td>
              </tr>



            </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="border-left:0px;border-right:0px; padding:4px;">Follow up (Smear and culture)</td>
              </tr>
              <tr>
                <td style="border:none;"><table width="100%" border="0" cellspacing="2" cellpadding="2">

                  <?php if(!empty($data['test_requests'])){ ?>
                   <tr>
                      <td style="border:none;"><font style="margin-top:5px; display:inline-block;">NTEP TB Reg no:</font></td>
                      <td style="border:none;"> <u><?php if(!empty($data['test_requests']->rntcp_reg_no)){ echo $data['test_requests']->rntcp_reg_no; } ?></u></td>
                    </tr>

                    <tr>
                      <td style="border:none;">Regimen:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['test_requests']->regimen == "New" && $data['personal']->req_test_type == 2)checked @endif  >
                      <label style="margin-top:-5px; display:inline-block;">New</label>
                      </td>
                      <td colspan="3" style="border:none;"><input type="checkbox" @if($data['test_requests']->regimen == "Previously Treated" && $data['personal']->req_test_type == 2)checked @endif >
                      <label style="margin-top:-5px; display:inline-block;">Previously Treated</label>
                     </td>
                    </tr>
                    <tr>
                      <td style="border:none;">Reason:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->test_reason == "End IP")checked @endif >
                        <label style="margin-top:-5px; display:inline-block;">End IP</label>
                      </td>
                      <td colspan="3" style="border:none;"><input type="checkbox" @if($data['personal']->test_reason == "End CP")checked @endif >
                      <label style="margin-top:-5px; display:inline-block;">End CP</label>
                      </td>
                    </tr>
                    <tr>
                      <td style="border:none;">Post treatment:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['test_requests']->post_treatment == "6 M")checked @endif ><label style="margin-top:-5px; display:inline-block;">6m</label></td>
                      <td style="border:none;"><input type="checkbox" @if($data['test_requests']->post_treatment == "12 M")checked @endif ><label style="margin-top:-5px; display:inline-block;">12m</label></td>
                      <td style="border:none;"><input type="checkbox" @if($data['test_requests']->post_treatment == "18 M")checked @endif ><label style="margin-top:-5px; display:inline-block;">18m</label></td>
                      <td style="border:none;"><input type="checkbox" @if($data['test_requests']->post_treatment == "24 M")checked @endif ><label style="margin-top:-5px; display:inline-block;">24m</label></td>
                    </tr>
                    <?php }else{ ?>

                    <tr>
                      <td style="border:none;">NTEP TB Reg no:</td>
                      <td style="border:none;"> <u>{{$data['personal']->rntcp_reg_no?$data['personal']->rntcp_reg_no:"____________"}}</u></td>

                    </tr>

                    <tr>
                      <td style="border:none;">Regimen:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->regimen == "New" && $data['personal']->req_test_type == 2)checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">New</label></td>
                      <td colspan="0" style="border:none;"><input type="checkbox" @if($data['personal']->regimen == "Previously Treated" && $data['personal']->req_test_type == 2)checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">Previously Treated</label></td>
                    </tr>
                    <tr>
                      <td style="border:none;">Reason:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->test_reason == "End IP")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">End IP</label></td>
                      <td colspan="0" style="border:none;"><input type="checkbox" @if($data['personal']->test_reason == "End CP")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">End CP</label></td>
                    </tr>
                    <tr>
                      <td style="border:none;">Post treatment:</td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->post_treatment == "6 M")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">6m</label></td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->post_treatment == "12 M")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">12m</label></td>
                      <td style="border:none;"><input type="checkbox" @if($data['personal']->post_treatment == "18 M")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">18m</label></td>
                      <td style="border:none;"> <input type="checkbox" @if($data['personal']->post_treatment == "24 M")checked @endif >
					  <label style="margin-top:-2px; display:inline-block;">24m</label></td>
                    </tr>
                <?php } ?>

                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>

  <tr>
    <td colspan="2" style="border:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; border:2px solid #000;">
        <tr valign="top">
          <th colspan="6" style="text-align:center; padding:3px;">Diagnosis and follow up Drug-resistant TB</th>
        </tr>

          <td valign="top">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:-1px;">
              <tr>
                <td colspan="2" style="border:none;padding:3px;">Drug Susceptibility Testing (DST)</td>
              </tr>
              <?php // dd($data['test_requests']->req_test_type); ?>
              <tr>
                <td>&nbsp;Presumptive MDR TB</td>
                <td style="border-right:0px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 0px; border-collapse:collapse; border-spacing:0px;">
                    <tr>
                  <?php if(!empty($data['test_requests']->regimen)){ ?>

<?php $regis_explode=explode(',',$data['test_requests']->regimen);

 ?>
                        <td>

              <input type="checkbox" <?php foreach( $regis_explode as $regis ):  ?> @if($regis == "New" && $data['personal']->req_test_type == 3)checked @endif <?php endforeach; ?> >
			  <label style="margin-top:-5px; display:inline-block;">New</label>
              <input type="checkbox"  <?php foreach( $regis_explode  as $regis ): ?>  @if($regis == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif <?php endforeach; ?>> 
			  <label style="margin-top:-5px; display:inline-block;">Previously treated</label>
            </td>
          <?php }else{ ?>

                <td style="border:none;">
              <input type="checkbox" @if($data['personal']->regimen == "New" && $data['personal']->req_test_type == 3)checked @endif >
			  <label style="margin-top:-5px; display:inline-block;">New</label>
              <input type="checkbox" @if($data['personal']->regimen == "Previously Treated" && $data['personal']->req_test_type == 3)checked @endif > <label style="margin-top:-2px; display:inline-block;">Previously treated</label>
            </td>
          <?php } ?>

                    </tr>

                           <?php
  if(!empty($data['test_requests']) && !empty($data['type_of_prsmptv_drtb']) ){

   $explode= $data['type_of_prsmptv_drtb'];?>

                    <tr>
                      <td style="border:none; " colspan="2"><input type="checkbox" name="" <?php foreach ($explode as $key => $value) {

               if($value == "At Diagnosis"){ echo "checked"; } } ?> >
			   <label style="display:inline-block;">At diagnosis</label> </td>
                    </tr >
                    <tr>
                      <td style="border:none; "><input type="checkbox" style="margin-top:-4px;"  name="" <?php foreach ($explode as $key => $value) {

               if($value == "Contact of MDR/RR TB"){ echo "checked"; } } ?> >
			   <label style="display:inline-block; vertical-align:top;">Contact of MDR/RR TB </label></td>
                    </tr>

                    <tr>
                      <td style="border:none;"><input type="checkbox"  style="margin-top:-4px;" name="" <?php foreach ($explode as $key => $value) {

               if($value == "Follow-up SM + VE at END IP"){ echo "checked"; } } ?> >
			   <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Follow up Sm +ve</label>
			   </td>
                    </tr>
                    <tr>
                      <td style="border:none;"><input type="checkbox"  style="margin-top:-4px;" name="" <?php foreach ($explode as $key => $value) { if($value == "Private Referral"){ echo "checked"; } } ?> >
					  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Private referral</label> </td>
                    </tr>

<?php  }else{ ?>


<tr>
                      <td style="border:none;"><input type="checkbox"  name="" @if($data['personal']->type_of_prsmptv_drtb == "At diagnosis")checked @endif>
					  <label style="margin-top:-5px; display:inline-block;">At diagnosis</label>  </td>
                    </tr>
                    <tr>
                      <td style="border:none;"><input type="checkbox"   style="margin-top:-4px;" name="" @if($data['personal']->type_of_prsmptv_drtb == "Contact of MDR/RR TB")checked @endif>
					  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Contact of MDR/RR TB</label>  </td>
                    </tr>

                    <tr>
                      <td style="border:none;"><input type="checkbox"  style="margin-top:-4px;" name="" @if($data['personal']->type_of_prsmptv_drtb == "Follow-up SM + VE at END IP")checked @endif>
					  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Follow-up SM + VE at END IP</label>  </td>
                    </tr>
                    <tr>
                      <td style="border:none;"><input type="checkbox"  style="margin-top:-4px;" name="" @if($data['personal']->type_of_prsmptv_drtb == "Private Referral")checked @endif>
					  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Private referral</label> </td>
                    </tr>


 <?php } ?>
                  </table>
				  </td>
              </tr>
              <tr>
                <td colspan="2" style="margin-bottom:0px; border-right:0px;"><input style="margin-top:2px;" type="checkbox" name=""@if(!empty($data['test_requests']->presumptive_h)) @if($data['test_requests']->presumptive_h)checked @endif @endif/>
				<label style="margin-top:-5px; display:inline-block; font-size:10px;">Presumptive H Mono/Poly</label></td>
				
              </tr>
      <?php //dd($data['test_requests']); ?>
              <?php
    if(!empty($data['test_requests'])){
 // dd("hi");
               $explode1= explode(',',$data['test_requests']->prsmptv_xdrtv);

}
               ?>

              <tr>
                <td style="border-bottom:0px;border-right:0px;" colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td style="border-top:0px;border-bottom:0px; border-left:0px;">&nbsp;Presumptive XDR TB</td>
                      <td style="border-right:0px;border-left:0px;border-top:0px;border-bottom:0px;" valign="bottom">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
                          <tr>
                            <td style="border:none;">	<input type="checkbox"  style="margin-top:-4px;"  name="" <?php
                              if(!empty($data['test_requests'])){  foreach ($explode1 as $key => $value1) { if($value1 =="MDR/RR TB at Diagnosis"){ echo "checked"; } } }  ?> >
							  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">MDR/RR TB at Diagnosis</label>	</td>
                          </tr>
                          <tr>
                            <td style="border:none;">	<input type="checkbox" style="margin-top:-4px;"  name="" <?php
                              if(!empty($data['test_requests'])){  foreach ($explode1 as $key => $value1) { if($value1 ==">=4 Months Culture Positive"){ echo "checked"; } }  } ?> >
							  <label style="margin-top:-5px; display:inline-block; vertical-align:top;">>=4 months culture positive</label> </td>
                          </tr>
                          <tr>
                            <td style="border:none;">	<input type="checkbox" style="margin-top:-4px;"  name="" <?php   if(!empty($data['test_requests'])){ foreach ($explode1 as $key => $value1) { if($value1 =="3 Monthly for Persistent Culture Positives"){ echo "checked"; } } } ?> >
							<label style="margin-top:3px; display:inline-block; vertical-align:top;">3 monthly for persistent culture <br />
                              positives (treatment month _____)</label></td>
                          </tr>
                         
                          <tr>
                            <td style="border:none;"> <input type="checkbox"  style="margin-top:-4px;"  name="" <?php   if(!empty($data['test_requests'])){ foreach ($explode1 as $key => $value1) { if($value1 =="Culture Reversion"){ echo "checked"; } } } ?> >
                            <label style="margin-top:-5px; display:inline-block; vertical-align:top;">Culture Reversion</label></td>
                          </tr>
                          <tr>

                            <td style="border:none;">	<input type="checkbox" style="margin-top:-4px;"  name="" <?php   if(!empty($data['test_requests'])){ foreach ($explode1 as $key => $value1) { if($value1 =="Failure of MDR/RR-TB Regimen"){ echo "checked"; } } } ?> >
							<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Failure of MDR/RR-TB regimen</label></td>
                          </tr>
                           
                          <tr>
                            <td style="border:none;padding-bottom: 58px;">	<input type="checkbox" style="margin-top:-4px;"  name="" <?php   if(!empty($data['test_requests'])){ foreach ($explode1 as $key => $value1) { if($value1 =="Recurrent Case of Second Line Treatment"){ echo "checked"; } } } ?> >
							<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Recurrent case of second line treatment</label></td>
                          </tr>



                        </table></td>


                    </tr>
                  </table></td>
              </tr>

<?php //dd($data['req_test']); ?>
<tr>
			
            </table></td>
          <td valign="top" colspan="5">
             <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td colspan="1" style="border-left:0px;border-right:0px;border-top:0px;padding:3px;">Follow up (Culture/Microscopy)</td>
              </tr>
              <tr>
                <td style="border:0px;"><font style="margin-top:5px; display:inline-block;">PMDT TB No.<?php $cond= !empty($data['personal']->pmdt_tb_no)?$data['personal']->pmdt_tb_no:"___________________"; echo $cond;?> </font></td>
              </tr>
              <tr>
                <td style="border:0px;">Regimen:</td>
              </tr>
              <tr>
                <td style="border:0px;">	<input type="checkbox"  name=""
                  @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen for INH Mono/Poly Resistant TB")checked @endif @endif>
				  <label style="margin-top:-5px; display:inline-block;">Regimen for INH Mono/Poly Resistant TB</label></td>
              </tr>
              <tr>
                <td style="border:0px;">	<input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen for MDR/RR TB")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block;  vertical-align:top;">Regimen for MDR/RR TB</label>
				</td>
              </tr>

              <tr>
                <td style="border:0px;"><input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen for XDR TB")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen for XDR TB</label>
				</td>
              </tr>
              <tr>
                <td style="border:0px;">	<input type="checkbox"  style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen with New Drug for Failures of Regimen for MDR-TB")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen with New Drug for Failures of Regimen for MDR-TB</label>
				</td>
              </tr>
              <tr>
                <td style="border:0px;"><input type="checkbox"  style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen with New Drug for Failures of Regimen for XDR-TB")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen with New Drug for Failures of Regimen for XDR-TB</label>
				</td>
              </tr>
              <tr>
                <td style="border:0px;"><input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen with New Drug for MDR-TB Regimen + FQ/SLI Resistance</label>
				</td>
              </tr>


              <tr>
                <td style="border:0px;"><input type="checkbox"  style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen with New Drug for Mixed Pattern Resistance")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen with New Drug for Mixed Pattern Resistance</label></td>
              </tr>

              <tr>
                <td style="border:0px;"><input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Regimen with New Drug for XDR-TB")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Regimen with New Drug for XDR-TB</label></td>
              </tr>
              <tr>
                <td style="border:0px;"><input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Shorter MDR TB Regimen")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Shorter MDR TB Regimen</label></td>
              </tr>
              <tr>
                <td style="border:0px;"><input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Modified REegimen for Mixed Pattern Resistance")checked @endif  @endif>
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Modified Regimen for Mixed Pattern Resistance</label></td>
              </tr>
              <tr>
                <td style="border:0px;">	<input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) @if($data['req_test']->regimen_fu == "Modified (DST Guided) Regimen for MDR/RR-TB + DQ/SLI Resistance")checked @endif   @endif>
				<label style="margin-top:-5px; display:inline-block;vertical-align:top;">Modified (DST Guided) Regimen for MDR/RR-TB + DQ/SLI Resistance</label></td>
              </tr>
              <tr>
                <td style="border:0px;">	<input type="checkbox" style="margin-top:-4px;" name="" @if(isset($data['req_test'])) <?php if($data['req_test']->regimen_fu == 'Other'){ echo "checked"; }?> @endif >
				<label style="margin-top:-5px; display:inline-block; vertical-align:top;">Other</label>
                  @if(isset($data['req_test']))
    							@if($data['req_test']->regimen_fu == "Other")
    								&emsp; Other Regimen : {{$data['pesronal']->fudrtb_regimen_other}}</br>
    							@endif @endif</td>
              </tr>
              <tr>
                <td style="border:0px;">
  							<font style=" margin-top:-5px; display:inline-block;">Treatment:</font>
							<input type="checkbox" name="" @if($data['personal']->month_week == "Month")checked @endif>
							<label style="margin-top:-5px; display:inline-block;">Month</label>
							<input type="checkbox" name="" @if($data['personal']->month_week == "Week")checked @endif>
							<label style="margin-top:-5px; display:inline-block;">Week</label>
							
							
							<label style="margin-top:-5px; display:inline-block;">No.: {{$data['personal']->treatment?$data['personal']->treatment :"__________________"}}
							</label></td> 
              </tr>
            </table>
          </td>
      </table>
    </td>
  </tr>




  <tr>

    <td colspan="2" style="border:0px;">
    <h1 style="margin-bottom:0px;margin-top:20px; font-size:9px; margin-left:10px; text-align:center;">Test Requested</h1>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2px; border:2px solid #000;">
        <tr>
          <td style="margin-top:-10px;"><table width="100%" style="margin-bottom:2px; border:0px solid #000;" cellspacing="5" cellpadding="5">
              <tr>
                <td style="border:0px;"><input type="checkbox" @if(in_array(1,$data['test_requested']))checked @endif >
                  <label style="margin-top:-5px; display:inline-block">Microscopy</label>
                  <input type="checkbox">
                  <label style="margin-top:-5px; display:inline-block">TST</label>
                  <input type="checkbox" name="" value="" @if(in_array(10,$data['test_requested']))checked @endif>
                  <label style="margin-top:-5px; display:inline-block">IGRA</label>
                  <input type="checkbox" name="" value="" @if(in_array(11,$data['test_requested']))checked @endif>
                  <label style="margin-top:-5px; display:inline-block">Chest X-ray</label>
                  <input type="checkbox" name="" value="" @if(in_array(12,$data['test_requested']))checked @endif>
                  <label style="margin-top:-5px; display:inline-block">Cytopathology</label>
                  <input type="checkbox" name="" value="" @if(in_array(13,$data['test_requested']))checked @endif>
                  <label style="margin-top:-5px; display:inline-block">Histopathology</label>
                  <input type="checkbox" @if(in_array(2,$data['test_requested']))checked @endif >
                  <label style="margin-top:-5px; display:inline-block">CBNAAT</label>
                  <input type="checkbox" @if(in_array(3,$data['test_requested'])||in_array(24,$data['test_requested'])||in_array(25,$data['test_requested']))checked @endif >
                  <label style="margin-top:-5px; display:inline-block">Culture</label>
                  <input type="checkbox" @if(in_array(21,$data['test_requested']) || in_array(22,$data['test_requested']) || in_array(23,$data['test_requested']))checked @endif >
                  <label style="margin-top:-5px; display:inline-block">DST</label>
                  <div style="clear:both;"></div>

                  <input type="checkbox" @if(in_array(4,$data['test_requested']) || in_array(5,$data['test_requested']) || in_array(6,$data['test_requested']))checked @endif >
                  <label style="margin-top:-5px; display:inline-block">Line Probe Assay</label>

                  <input type="checkbox" name="" value="">
                  <label style="margin-top:-5px; display:inline-block">Gene Sequencing</label>
                  <input type="checkbox" name="" value="">
                  <label style="margin-top:-5px; display:inline-block">Other(Please Specify):</label>
                  <div style="clear:both;"></div>
                  Requestor Name: {{$data['personal']->requestor_name}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
				  Designation: {{$data['personal']->designation}}  &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
				  &nbsp; &nbsp;	 &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
				  Signature:_________________________
                  <div style="clear:both;"></div>
                  Contact Number:@if(!empty($data['personal']->requestor_cno)) {{$data['personal']->requestor_cno}}
                  @else
                  _________________________
                  @endif
                   &nbsp;&nbsp;&nbsp;&nbsp;
                  Email Id:@if(!empty($data['personal']->requestor_email)) {{$data['personal']->requestor_email}}
                  @else
                  _________________________
                  @endif </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
</tr>
<tr>
 <td width="20%" style="border:0px;"><b style="margin-top:5px; margin-bottom:0px; display:inline-block;">Results:</b></td>
 <td style="border:0px;"><b style="margin-top:0px; margin-bottom:5px;">NIKSHAY ID</b> Generated:<?php if(!empty($data['personal']->pnikshay_id)){ echo $data['personal']->pnikshay_id; }else{ echo "_________________"; } ?></td>
</tr>

<?php if(is_null($data['lpa1']) && is_null($data['lpa2']) && is_null($data['lpaf'])  && is_null($data['culturelj'])  && is_null($data['culturelc']) && $data['cbnaat']->isEmpty() ){ ?>

  @if(!empty($data['microscopyA']->result) || !empty($data['microscopyB']->result))
<tr>
   <td colspan="2" style="border:0px;">
     <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; border:2px solid #000;">
       <tr>
         <th colspan="2" style="padding-left:1px; margin-top:-10px;">Microscopy(
           <input type="checkbox" style="margin-top:5px;" name="zn" value="" @if($data['microscopy'] == 1)checked @endif >
           ZN
           <input type="checkbox" style="margin-top:5px;" name="florscent" value="" @if($data['microscopy'] == 2)checked @endif>
           Florescent)</th>
       </tr>
       <tr>
         <td width="40%" valign="top">
         <table width="100%" border="0" cellspacing="5" cellpadding="6" style="margin-left: -1px;">
             <tr>
               <td>&nbsp;</td>
               <td style="padding:8px;">Lab Sr. No</td>
               <td style="border-right:0px;">Visual appearance</td>
             </tr>
             <tr>
               <td style="padding:3px;">Sample-ID A</td>
               <td >{{$data['microscopyA']->sample_label}}</td>
                <td style="border-right:0px;">&nbsp;</td>

             </tr>
             @if(!empty($data['microscopyB']->sample_label))
             <tr>
               <td>Sample-ID B</td>
               <td> {{$data['microscopyB']->sample_label}}</td>
               <td style="border-right:0px;">&nbsp;</td>
             </tr>
              @endif
           </table></td>
         <td valign="top" style="border-bottom:0px;">
         <table width="100.5%" border="0" cellspacing="0" cellpadding="0" style="margin-left:-1px;">
             <tr>
               <td colspan="3" style="text-align:center; padding:3px;">Result</td>
             </tr>
             <tr>
               <td style="border:none;" colspan="5">
                 <table class="t-no-border" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:-1px;">
                   <tr>
                     <td style="text-align:center; padding:1px;">Negative</td>
                     <td style="text-align:center; padding:1px;">Scanty</td>
                     <td style="text-align:center; padding:1px;">1+</td>
                     <td style="text-align:center; padding:1px;">2+</td>
                     <td style="text-align:center; padding:1px; border-right:0px;">3+</td>

                   </tr>
					@if($data['microscopyA'])
                   <tr>
                     <td style="text-align:center; padding:1px;">@if($data['microscopyA']->result=='Negative/Not Seen'){{ $data['microscopyA']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:1px;">@if($data['microscopyA']->result=='Scanty'|| $data['microscopyA']->result=='Sc 1' || $data['microscopyA']->result=='Sc 2'|| $data['microscopyA']->result=='Sc 3'|| $data['microscopyA']->result=='Sc 4'|| $data['microscopyA']->result=='Sc 5'|| $data['microscopyA']->result=='Sc 6'|| $data['microscopyA']->result=='Sc 7'|| $data['microscopyA']->result=='Sc 8'|| $data['microscopyA']->result=='Sc 9' || $data['microscopyA']->result=='Sc 10'||
					$data['microscopyA']->result=='Sc 11'|| $data['microscopyA']->result=='Sc 12' || $data['microscopyA']->result=='Sc 13'||
					$data['microscopyA']->result=='Sc 14'|| $data['microscopyA']->result=='Sc 15' || $data['microscopyA']->result=='Sc 16'||
					$data['microscopyA']->result=='Sc 17'|| $data['microscopyA']->result=='Sc 18' || $data['microscopyA']->result=='Sc 19'){{ $data['microscopyA']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:1px;">@if($data['microscopyA']->result=='1+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:1px;">@if($data['microscopyA']->result=='2+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:1px; border-right:0px;">@if($data['microscopyA']->result=='3+positive'){{ $data['microscopyA']->result }} @else  @endif</td>
                   </tr>
                   				@endif
                   		<?php if(!empty($data['microscopyB'])){ ?>
                   <tr>
                     <td style="text-align:center; padding:3px;">@if($data['microscopyB']->result=='Negative/Not Seen'){{ $data['microscopyB']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:3px;">@if($data['microscopyB']->result=='Scanty' || $data['microscopyB']->result=='Sc 1' || $data['microscopyB']->result=='Sc 2'|| $data['microscopyB']->result=='Sc 3'|| $data['microscopyB']->result=='Sc 4'|| $data['microscopyB']->result=='Sc 5'|| $data['microscopyB']->result=='Sc 6'|| $data['microscopyB']->result=='Sc 7'|| $data['microscopyB']->result=='Sc 8'|| $data['microscopyB']->result=='Sc 9' || $data['microscopyB']->result=='Sc 10'|| $data['microscopyB']->result=='Sc 11'|| $data['microscopyB']->result=='Sc 12' || $data['microscopyB']->result=='Sc 13'|| $data['microscopyB']->result=='Sc 14'|| $data['microscopyB']->result=='Sc 15' || $data['microscopyB']->result=='Sc 16'|| $data['microscopyB']->result=='Sc 17'|| $data['microscopyB']->result=='Sc 18' || $data['microscopyB']->result=='Sc 19'){{ $data['microscopyB']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:3px;">@if($data['microscopyB']->result=='1+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:3px;">@if($data['microscopyB']->result=='2+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
                     <td style="text-align:center; padding:3px; border-right:0px;">@if($data['microscopyB']->result=='3+positive'){{ $data['microscopyB']->result }} @else  @endif</td>
                   </tr>
                 <?php } ?>
                 </table></td>
             </tr>
           </table></td>
       </tr>
       <tr>
         <td colspan="2" style="border:0px;">
            <table width="100%" border="0" cellspacing="3" cellpadding="3" style="margin-top:3px;">

           <tr>

            <!-- <td style="padding:3px; border:0px;">Date tested for microscopy Sample: {{ date('d-m-Y',strtotime($data['date_receipt']->receive_date)) }} </td>
             <td style="padding:3px; border:0px;">Date Reported:{{ $data['today']}} </td> -->
			 <td style="padding:3px; border:0px;">Date tested for microscopy Sample-ID: {{ date('d-m-Y',strtotime($data['date_receipt']->created_at)) }} </td>
             <td style="padding:3px; border:0px;">Date Reported:{{ date('d-m-Y H:i:s', time())}} </td>
             <td style="padding:3px;border:0px;">Reported by:{{ $data['microbio_name']}}</td>
           </tr>
             <tr>
               <td colspan="2" style="padding:3px;border:0px;">Laboratory Name: {{ $data ['labrotory_name'] }}</td>
               <!--<td style="padding:3px;border:0px;">(Name and Signature)</td>-->
             </tr>
           </table></td>
       </tr>
     </table>
	 </td>
 </tr>


@endif

<?php } ?>



	<?php if(!empty($data['cbnaat'])){

		if(count($data['cbnaat']) > 0){
	//	dd($data['cbnaat']);
		 ?>


<tr>
  <td colspan="2" style="border:0px;"><table width="100%" border="0" cellspacing="5" cellpadding="5" style="margin-top:5px; border:2px solid #000;">
      <tr>
        <th colspan="5" style="padding:3px; text-align:center;">Cartridge Based Nucleic Acid Amplification Test</th>
      </tr>
      <tr>
          @if($data['cbnaat'])
						<td WIDTH="30%">Sample ID: {{ $data['cbnaat'][0]->sample_label }}</td>
						@else
						<td WIDTH="30%">Sample ID:</td><td></td>
						@endif
	
        <td style="border-right:0px;"><input type="checkbox" name="sample_a_cbnaat" @if(!empty($data['cbnaat'][0]->sample_label))checked @endif/><label>Sample A</label></td>
        <td style="border-right:0px;"><input type="checkbox" name="sample_b_cbnaat" /><label>Sample B</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>M. tuberculosis</td>
        <td>	<input type="checkbox" @if(isset($data['cbnaat'][0])) @if($data['cbnaat'][0]->result_MTB == 'MTB Detected')checked @endif @endif><label>Detected</label></td>
        <td>	<input type="checkbox" @if(isset($data['cbnaat'][0])) @if($data['cbnaat'][0]->result_MTB == 'MTB Not Detected')checked @endif @endif><label>Not Detected</label></td>
        <td><input type="checkbox" @if(isset($data['cbnaat'][0])) @if($data['cbnaat'][0]->result_MTB == 'Invalid' || $data['cbnaat'][0]->result_MTB == 'Error')checked @endif @endif><label>N/A</label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Rif Resistance</td>
        <td>	<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Detected')checked @endif><label>Detected</label></td>
        <td>	<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Not Detected')checked @endif><label>Not Detected</label></td>
        <td>	<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'RIF Indeterminate')checked @endif><label>Indeterminate</label></td>
        <td>	<input type="checkbox" @if($data['cbnaat'][0]->result_RIF == 'NA')checked @endif><label>N/A</label></td>
      </tr>
      <tr>
        <td>Test</td>

        <td><input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'No Result')checked @endif><label>No Result </label></td>
		<td><input type="checkbox" @if($data['cbnaat'][0]->result_MTB == 'Invalid')checked @endif><label>Invalid </label></td>
		<td><input type="checkbox"@if($data['cbnaat'][0]->error != '')checked @endif><label>Error </label></td>
        <td>Error Code : {{$data['cbnaat'][0]->error}}</td>
        
      </tr>





      <tr>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
			 <!-- Changed By Pradip on 18/05/2020 Start Process --->
             <!--<td style="padding:3px; border:0px;">Date tested: {{date('d-m-Y', strtotime($data['cbnaat'][0]->test_date))}}</td>
               <td style="padding:3px; border:0px;">Date Reported:{{date('d-m-Y H:i:s', time())}}</td> 
              <td style="padding:3px; border:0px;">Reported by:{{ $data['microbio_name']}}</td>-->
			 
			  <td style="padding:3px; border:0px;">Date Result: {{date('d-m-Y', strtotime($data['cbnaat'][0]->test_date))}}</td>
              <td style="padding:3px; border:0px;">Date Reported:{{date('d-m-Y H:i:s', strtotime($data['cbnaat'][0]->sent_to_nikshay_date))}}</td> 
              <td style="padding:3px; border:0px;">Reported by:{{ $data['cbnaat'][0]->name}}</td>
			  
            </tr>
            <tr>
			<!--<br></br><br></br>-->
              <td colspan="2" style="padding:3px; border:0px;">Laboratory Name: {{ $data ['labrotory_name'] }}</td>
             <!-- <td style="padding:3px; border:0px;">(Name and Signature)</td><br /> -->
			  <!----- Changed By Pradip on 18/05/2020 End Process ------------->
            </tr>
			
          </table></td>
      </tr>
    </table></td>
</tr>
    <?php }}?>




		@if($data['culturelj'] || $data['culturelc'])
<tr style="border:0px;">
   <td colspan="2" style="border:0px;">
     <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:0px; margin-bottom:0px; border:2px solid #000;">
     <tr>
       <th colspan="2">
        <label center style="margin-top:-2px;text-align:center !important;">Culture (</label>
           <input align="center" type="checkbox"@if(!empty($data['culture-llj'])) @if($data['culture-llj'] == 1)checked @endif @endif >
		<label center style="margin-top:-2px; text-align:center !important;">LJ</label>
            <input align="center" type="checkbox" @if(!empty($data['culture'])) @if($data['culture'] == 2)checked @endif @endif >
        <label style="margin-top:-2px; text-align:center !important;">LC )</label>
	 
      </th>
     </tr>
     <tr>
       <td colspan="2">
	    <!--<td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">-->
         <table width="100%" border="0" cellspacing="5" cellpadding="5" style="margin-left:-1px;">
               <tr>
                  <td style="padding:3px; text-align:center;">Sample ID</td>

                 <td style="padding:3px; text-align:center;">Negative</td>
                 <td style="padding:3px; text-align:center;">Positive</td>
                 <td style="padding:3px; text-align:center;">NTM (write species)</td>
                 <td style="padding:3px; text-align:center;">Contamination</td>
				 <td style="padding:3px;border-right:0px; text-align:center;">Others</td>
               </tr>

               <tr>
                 @if(!empty($data['culturelj']))

                 <td style="padding:3px; text-align:center;">{{ $data['culturelj']->sample_label	 }}-LJ REPORT</td>
                 <?php //echo $data['culturelj']->final_result; ?>
                 <td style="padding:3px; text-align:center;">@if($data['culturelj']->final_result=='Negative'){{ $data['culturelj']->final_result }} @else  @endif</td>
                 <td style="padding:3px; text-align:center;">@if($data['culturelj']->final_result=='1+' || $data['culturelj']->final_result=='2+' || $data['culturelj']->final_result=='3+'){{ $data['culturelj']->final_result }} @else  @endif</td>
                 <td style="padding:3px; text-align:center;">@if($data['culturelj']->final_result=='NTM') @if(!empty($data['culturelj']->species)) {{ $data['culturelj']->species }} @else {{ $data['culturelj']->final_result }}  @endif  @endif</td>
                 <td style="padding:3px;border-right:0px; text-align:center;">@if($data['culturelj']->final_result=='Contaminated'){{ $data['culturelj']->final_result }} @else  @endif</td>
				  <td style="padding:3px;"></td>
                 @else
                 <td style="padding:3px;"></td>
                 <td style="padding:3px;"></td>
                 <td style="padding:3px;"></td>
                 <td style="padding:3px;"></td>
                 <td style="padding:3px;"></td>
				  <td style="padding:3px;"></td>
                 @endif
               </tr>

               <tr>
     						@if(!empty($data['culturelc']))
     						<td style="padding:3px; text-align:center;">{{ $data['culturelc']->sample_label	 }}-LC REPORT</td>
     						<td style="padding:3px; text-align:center;">@if($data['culturelc']->result=='Negative'){{ $data['culturelc']->result }} @else  @endif</td>
     						<td style="padding:3px; text-align:center;">@if($data['culturelc']->result=='Positive'){{ $data['culturelc']->result }} @else  @endif</td>
     						<td style="padding:3px; text-align:center;">@if($data['culturelc']->result=='NTM')@if(!empty($data['culturelc']->species)){{ $data['culturelc']->species }} @else {{ $data['culturelc']->result }} @endif @endif</td>
     						<td style="padding:3px; text-align:center;">@if($data['culturelc']->result=='Contaminated'){{ $data['culturelc']->result }} @else  @endif</td>
     						<td style="padding:3px;border-right:0px; text-align:center;">@if($data['culturelc']->result=='Other Result'){{ $data['culturelc']->other_result }} @else  @endif</td>
							@else
     						<td style="padding:3px;"></td>
     						<td style="padding:3px;"></td>
     						<td style="padding:3px;"></td>
     						<td style="padding:3px;"></td>
     						<td style="padding:3px;"></td>
     						@endif
     					</tr>





              <tr>

              </tr>

             </table>

       </td>
     </tr>
     <tr>
       <td colspan="2">
       <table width="100%" border="0" cellspacing="5" cellpadding="5">
           
			 <!----- Changed by Pradip on 18/05/2020  Start Process ------>
             <!--<td style="padding:3px; border:0px;">Date result:          
					@if($data['culturelj'])
                        {{ date ('d-m-Y', strtotime($data['culturelj']->lj_result_date)) }} 
					@elseif($data['culturelc'])
                        {{ date ('d-m-Y', strtotime($data['culturelc']->result_date)) }} 
						 
                    @endif</td>
             <td style="padding:3px; border:0px;">Date Reported:    
					@if($data['culturelj'])
						{{ date('d-m-Y H:i:s', time()) }} 
					@elseif($data['culturelc'])
						{{ date('d-m-Y H:i:s', time()) }} 
					
					@endif</td>
					<td style="padding:3px; border:0px;">Reported by:{{ $data['microbio_name']}}</td> -->
				
				
					@if(!empty($data['culturelj']))
						<tr>
						<td style="padding:3px; border:0px;">LJ - Date Result: {{ date ('d-m-Y', strtotime($data['culturelj']->lj_result_date)) }} </td>
						<td style="padding:3px; border:0px;">Date Reported: {{date('d-m-Y H:i:s', strtotime($data['culturelj']->sent_to_nikshay_date))}} </td>
						<td style="padding:3px; border:0px;">Reported by: {{ $data['culturelj']->name}} </td>
						</tr>
						
					@endif
				
					@if(!empty($data['culturelc']))
						<tr>
						<td style="padding:3px; border:0px;">LC - Date Result: {{ date ('d-m-Y', strtotime($data['culturelc']->result_date)) }} </td>
						<td style="padding:3px; border:0px;">Date Reported: {{date('d-m-Y H:i:s', strtotime($data['culturelc']->sent_to_nikshay_date))}}  </td>
						<td style="padding:3px; border:0px;">Reported by: {{ $data['culturelc']->name}} </td>
						</tr>
						
					@endif
					
					<!----- Changed by Pradip on 18/05/2020  End Process ------>
				
          
           <tr>
			<!-- <br></br><br></br><br></br> -->
			 <td colspan="2" style="padding:3px; border:0px;">Laboratory Name: {{ $data ['labrotory_name'] }}</td>
            <!-- <td style="padding:3px; border:0px;">(Name and Signature)</td>
			 <br />-->
           </tr>
         </table>
       </td>
     </tr>


</table>

   </td>
</tr>
@endif







    @if($data['lpa1'] || $data['lpa2'] || $data['lpaf'])
		<tr>
		 <td colspan="2" style="border:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; border:2px solid #000;">
			<tr>
   						<th colspan="4" style="padding:3px;border-right:0px; text-align:center">Line Probe Assay(LPA)</th>
					</tr>
					<tr>
						@if($data['lpaf'])
							<th colspan="4" style="border-right:0px;"><input type="checkbox" name="" value="" <?php if(!empty($data['lpaf'		][0]['type_direct'])): echo "checked";   endif; ?> >
									<label style="margin-top:-2px; display:inline-block">Direct</label>
										<input type="checkbox"<?php if(!empty($data['lpaf'][0]['type_indirect'])): echo "checked"; endif; ?> ><label style="margin-top:-2px; display:inline-block">Indirect   Lab serial :
										<?php if(!empty($data['lab_serial'])){ echo $data['lab_serial']->type; } ?>
									</label>
							</th>
   						@else
							<th colspan="4"><input type="checkbox" name="" value="">
								<label style="margin-top:-2px; display:inline-block">Direct</label>
										<input type="checkbox">
										<label style="margin-top:-2px; display:inline-block">Indirect   Lab serial______________
								</label>
							</th>

   						@endif
					</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td colspan="2" style="border:0px;">
			 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; border:2px solid #000;">	
			 	@if($data['lpa1'])
					  		
       					<tr>
       						<th colspan="4" style="padding:3px;border-right:0px;">First line LPA (Sample ID: {{$data['lpa1']->sample_label}} )</th>
       					</tr>
       					<tr>
       						<td colspan="4" style="padding:3px;border-right:0px;">
								<ul>
								   <li>RpoB :- Locus Control :</li>
								   <li> @if($data['lpa1']->RpoB == 1) Present @elseif($data['lpa1']->RpoB == 0)Absent @endif</li>
								 </ul>

								<div style="clear:both;"></div>
									 <ul>
										<li>	WT1:</li>
										<li>@if($data['lpa1']->wt1 == 1) Present @else Absent @endif</li>
									 </ul>
									 <ul>
										<li>	WT2:</li>
										<li>@if($data['lpa1']->wt2 == 1) Present @else Absent  @endif</li>
									 </ul>
									 <ul>
										<li>	WT3:</li>
										<li>@if($data['lpa1']->wt3 == 1) Present @else Absent  @endif</li>
									 </ul>
									 <ul>
										<li>WT4:</li>
										<li>@if($data['lpa1']->wt4 == 1) Present @else Absent  @endif</li>
									 </ul>
								<div style="clear:both;"></div>
									 <ul>
										<li>WT5:</li>
										<li>@if($data['lpa1']->wt5 == 1) Present @else Absent  @endif</li>
									 </ul>
									 <ul>
										<li>WT6:</li>
										<li>@if($data['lpa1']->wt6 == 1) Present @else Absent  @endif</li>
									 </ul>
									 <ul>
										<li>WT7:</li>
										<li>@if($data['lpa1']->wt7 == 1) Present @else Absent  @endif</li>
									 </ul>
									 <ul>
										<li>WT8:</li>
										<li>@if($data['lpa1']->wt8 == 1) Present @else Absent  @endif</li>
									 </ul>
								<div style="clear:both;"></div>

										MUT1(D516V) :	@if($data['lpa1']->mut1DS16V == 1) Present @else Absent @endif
										MUT2A(H526Y) :	@if($data['lpa1']->mut2aH526Y == 1) Present @else Absent  @endif
										MUT2B(H526D) :	@if($data['lpa1']->mut2bH526D == 1) Present @else Absent @endif
										MUT3(S531L) : @if($data['lpa1']->mut3S531L == 1) Present @else Absent @endif

       						</td>
       					</tr>
       					<tr>
       						<td colspan="2" style="padding:3px;border-right:0px;" >
										KatG :- Locus Control : @if($data['lpa1']->katg == 1) Present @else Absent  @endif<div style="clear:both; height:10px;"></div>
										WT1(315) :	@if($data['lpa1']->wt1315 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT1(S315T1) : @if($data['lpa1']->mut1S315T1 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT2(S315T2) : @if($data['lpa1']->mut2S315T2 == 1) Present @else Absent  @endif
										<br /> <br /> <br />
       						</td>
       						<td colspan="2" style="padding:3px;border-right:0px;">
										InhA :- Locus Control : @if($data['lpa1']->inha == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										WT1(-15,-16) :	@if($data['lpa1']->wt1516 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										WT2(-8) :	@if($data['lpa1']->wt28 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT1(C15T) :	@if($data['lpa1']->mut1C15T == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT2(A16G) : @if($data['lpa1']->mut2A16G == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT3A(T8C) :	@if($data['lpa1']->mut3aT8C == 1) Present @else Absent  @endif<div style="clear:both;"></div>
										MUT3B(T8A) : @if($data['lpa1']->mut3bT8A == 1) Present @else Absent  @endif
       						</td>
       					</tr>
						<tr>
							<td colspan="4">
									<table width="100%" cellspacing="5" cellpadding="5" style="margin-left:-1px;">
									
											<tr>
												<td style="padding:3px; border-right:0px;">
													<!--<strong>Final LPA Interpretation:-</strong></br></br>-->
													<strong>Interpretation:-</strong></br></br>
													<?php  //echo "<pre>"; print_r($data['lpaf']); die;?>
													@if(isset($data['lpaf']) && !empty($data['lpaf']))
																@foreach($data['lpaf'] as $lpaf)
																    @if($lpaf['tag']=='1st line LPA')
																		
																	    @if(!empty($lpaf['mtb_result']))
																				MTB Result:{{ $lpaf['mtb_result'] }} 	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;						 
																		@endif 
										
																		@if(!empty($lpaf['rif']))
																				RIF Resi:{{$lpaf['rif']}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
																		@endif
								 
								 
																		@if(!empty($lpaf['inh']))
																				H Resi:{{$lpaf['inh']}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
																		@endif
																		
																		@if(!empty($lpaf['nikshey_final_interpretation']))
																			<br>
																			<strong>Final LPA Interpretation:-</strong> {{$lpaf['nikshey_final_interpretation']}} 
																		@endif
																	
																	@endif
																@endforeach
													@endif
												</td>
											</tr>
											<tr>
													<!-- Changed By Pradip on 18/05/2020  Start Process -->
													<!-- <td style="padding:3px; border-right:0px;">
													
														@if($data['lpaf'])
															    
																Date Result:{{date('d-m-Y', strtotime($data['lpaf'][0]['created_at']))}} | Date Reported:{{ date('d-m-Y H:i:s',time()) }} | Reported by(Name and Signature):{{ $data['microbio_name']}} 
														
														
														@else
																Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
														@endif
														-->
													<td style="padding:3px; border-right:0px;">
													@if(isset($data['lpaf']) && !empty($data['lpaf']))
														@foreach($data['lpaf'] as $lpaf)
															@if($lpaf['tag']=='1st line LPA')
														
																Date Result:{{date('d-m-Y', strtotime($lpaf['test_date']))}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; 
																Date Reported:{{date('d-m-Y H:i:s', strtotime($lpaf['sent_to_nikshay_date']))}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	
																Reported by:{{ $lpaf['name']}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	
															@endif
														@endforeach
													@else
														Date Result:_____________ Date Reported:_____________ Reported by:__________________
													@endif
													
												
											
													<br /><br />
													 Laboratory Name: {{ $data ['labrotory_name'] }} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	
													 &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp; &nbsp;	&nbsp;		
													 <!--(Name and Signature)
													 <br /><br /><br />-->
													 </td>
													 <!------------- Changed By Pradip on 18/05/2020  End Process -->
										   </tr>

									</table>
							</td>
						</tr>
					@endif
					</table>
					</td>
					</tr>
					<tr>
					<td colspan="2" style="border:0px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:15px; border:2px solid #000;">
       				@if($data['lpa2'])
       					<tr>
       						<th colspan="4" style="padding:3px;border-right:0px;">Second Line LPA (Sample ID: {{$data['lpa2']->sample_label}} )</th>
       					</tr>
       					<tr>
       						<td style="border-right:0px;">
       							&nbsp;gyrA :-</br> Locus Control : 	@if($data['lpa2']->gyra == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT1(85-90) :@if($data['lpa2']->wt18590 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT2(89-93) :@if($data['lpa2']->wt28993 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT3(92-97) :@if($data['lpa2']->wt39297 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT1(A90V) :@if($data['lpa2']->mut1A90V == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT2(S91P) :@if($data['lpa2']->mut2S91P == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT3A(D94A) :@if($data['lpa2']->mut3aD94A == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT3B(D94N/Y) :@if($data['lpa2']->mut3bD94N == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT3C(D94G) :@if($data['lpa2']->mut3cD94G == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT3D(D94H) :@if($data['lpa2']->mut3dD94H == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       						</td>


       						<td valign="top">
       							&nbsp;gyrB :- Locus Control : @if($data['lpa2']->gyrb == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT1(536-541) :@if($data['lpa2']->wt1536541 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT1(N538D) :@if($data['lpa2']->mut1N538D == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT2(E540V) :@if($data['lpa2']->mut2E540V == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       						</td>
       						<td valign="top">
       							&nbsp;rrs :- Locus Control :@if($data['lpa2']->rrs == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       				 			&nbsp;WT1(1401-02) :@if($data['lpa2']->wt1140102 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT2(1484) :@if($data['lpa2']->wt21484 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT1(A1401G) :@if($data['lpa2']->mut1A1401G == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT2(G1484T) :@if($data['lpa2']->mut2G1484T == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       						</td>
       						<td valign="top" style="border-right:0px;">
       							&nbsp;eis :- Locus Control : 	@if($data['lpa2']->eis == 1) Present @else Absent  @endif</br><div style="clear:both;"></div>
       							&nbsp;WT1(37) :@if($data['lpa2']->wt137 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT2(14,12,10) :@if($data['lpa2']->wt2141210 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;WT3(2) :@if($data['lpa2']->wt32 == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       							&nbsp;MUT1(C-14T) :@if($data['lpa2']->mut1c14t == 1) Present @else Absent  @endif<div style="clear:both;"></div>
       						</td>
       					</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="5" cellpadding="5" style="margin-left:-1px;">
									<tr>
										<td style="padding:3px; border-right:0px;">
												<!--<strong>Final LPA Interpretation:-</strong></br></br>-->
												<strong>Interpretation:-</strong></br></br>
												<?php  //echo "<pre>"; print_r($data['lpaf']); die;?>
												@if(isset($data['lpaf']) && !empty($data['lpaf']))
													@foreach($data['lpaf'] as $lpaf)
												        @if($lpaf['tag']=='2nd line LPA')
														    @if(!empty($lpaf['mtb_result']))
																 MTB Result:{{ $lpaf['mtb_result'] }} 	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	
															@endif 
												
															@if(!empty($lpaf['quinolone']))
																FQ Resi: {{$lpaf['quinolone']}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;
															@endif
											
															@if(!empty($lpaf['slid']))
																SLID Resi: {{$lpaf['slid']}} &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	
															@endif
															
															@if(!empty($lpaf['nikshey_final_interpretation']))
																	<br>
																	<strong>Final LPA Interpretation:-</strong> {{$lpaf['nikshey_final_interpretation']}}
															@endif
														@endif
													@endforeach
												@endif
										</td>
									</tr>
									<tr>
										<td style="padding:3px; border-right:0px;">
												<!-- Changed By Pradip on 18/05/2020 Start Process
												@if($data['lpaf'])
												
													Date Result:{{date('d-m-Y', strtotime($data['lpaf'][0]['created_at']))}}  &emsp; Date Reported:{{date('d-m-Y H:i:s', strtotime($data['lpaf'][0]['sent_to_nikshay_date']))}} &emsp; Reported by(Name and Signature):{{ $data['lpaf'][0]['name']}} 
										
												@else
														Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
												@endif
												--->
												@if(isset($data['lpaf']) && !empty($data['lpaf']))
														@foreach($data['lpaf'] as $lpaf)
															@if($lpaf['tag']=='2nd line LPA')
														
																Date Result:{{date('d-m-Y', strtotime($lpaf['test_date']))}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; 
																Date Reported:{{date('d-m-Y H:i:s', strtotime($lpaf['sent_to_nikshay_date']))}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp; &nbsp;	&nbsp;	&nbsp;	
																Reported by:{{ $lpaf['name']}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	
															@endif
														@endforeach
													@else
														Date Result:_____________ Date Reported:_____________ Reported by:__________________
													@endif
													
													<br /><br />
													 Laboratory Name: {{ $data ['labrotory_name'] }} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	
													 &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp; &nbsp;	&nbsp;		
													<!-- (Name and Signature) 
													 <br /><br /><br /> -->
													 
										</td>
										<!------------- Changed By Pradip on 18/05/2020  End Process -->
									</tr>

								</table>
							</td>
						</tr>
       					@endif
						
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
							@if($hybridization_data->tag=='2nd line LPA')
								
								<th colspan="4">Line Probe Assay(LPA) - Second Line LPA - Hybridization: The result is invalid of Sample  {{$hybridization_data->sample_label}} </th>
								
							@endif
						
							<!--<tr>
								<th colspan="4">Line Probe Assay(LPA)- {{$hybridization_data->tag}}<br/>The result is invalid of Sample  {{$hybridization_data->sample_label}}</th>
							</tr>-->
						</table>
					</td>
				</tr>			
				@endif
			@endforeach		
        @endif




	@if(count($data['lc_dst'])>0 || count((array)$data['lj_dst'])>0)
        <tr>
                <td colspan="2" style="border:0px;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px; border:2px solid #000;">


                                    <tr>
                            			<td colspan="2">
                            				
                            				<table width="100.5%" style="margin-left:-1px;">
                            					<tr>
                            						<th colspan="19" style="padding:3px; text-align:center; border-right:0px;">Drug Suspectibility Test (DST) results</th>
                            					</tr>
                            					<tr>
                            						<td rowspan="2" style="padding:3px; text-align:center">Sample ID</td>
                            						<td colspan="6" style="padding:4px; text-align:center">1st Line drugs</td>
                            						<td colspan="3" style="padding:4px; text-align:center">SLI</td>
                            						<td colspan="3" style="padding:4px; text-align:center">FQ</td>
                            						<td colspan="6" style="padding:3px; text-align:center">Others</td>
                            					</tr>
                            					<tr>
                            						<td style="padding:3px; text-align:center" width="20">S</td>
                            						<td style="padding:3px; text-align:center" width="20">H (0.1)</td>
                            						<!--<td style="padding:3px; text-align:center" width="45">H(0.4)</td>-->
                            						<td style="padding:3px; text-align:center" width="20">R</td>
                            						<td style="padding:3px; text-align:center" width="20">E</td>
                            						<td style="padding:3px; text-align:center" width="20">Z</td>
                            						<td style="padding:3px; text-align:center" width="20">Km</td>
                            						<td style="padding:3px; text-align:center" width="20">Cm</td>
                            						<td style="padding:3px; text-align:center" width="20">Am</td>
                            						<td style="padding:3px; text-align:center" width="20">Lfx</td>
                            						<td style="padding:3px; text-align:center" width="15">Mfx (0.25)</td>
                            						<td style="padding:3px; text-align:center" width="20">Mfx (1)</td>
                            						<td style="padding:3px; text-align:center" width="20">PAS</td>
                            						<td style="padding:3px; text-align:center" width="20">Lzd</td>
                            						<td style="padding:3px; text-align:center" width="20">Cfz</td>
                            						<td style="padding:3px; text-align:center" width="20">Eto</td>
                            						<td style="padding:3px; text-align:center" width="20">Clr</td>
                            						<td style="padding:3px; text-align:center" width="20">Azi</td>
													<td style="padding:3px; text-align:center" width="20">BDQ</td>

                            					</tr>
												@if(isset($data['lj_dst_fld'])&& !empty($data['lj_dst_fld']))
													@if(!empty($data['lj_dst_fld']['s']) || !empty($data['lj_dst_fld']['H(inh A)']) || !empty($data['lj_dst_fld']['H(Kat G)']) || !empty($data['lj_dst_fld']['r']) || !empty($data['lj_dst_fld']['e']) || !empty($data['lj_dst_fld']['z']) || !empty($data['lj_dst_fld']['km']) || !empty($data['lj_dst_fld']['cm']) || !empty($data['lj_dst_fld']['am']) || !empty($data['lj_dst_fld']['lfx']) || !empty($data['lj_dst_fld']['mfx1']) || !empty($data['lj_dst_fld']['mfx2']) || !empty($data['lj_dst_fld']['pas']) || !empty($data['lj_dst_fld']['lzd']) || !empty($data['lj_dst_fld']['cfz']) || !empty($data['lj_dst_fld']['eto']) || !empty($data['lj_dst_fld']['clr']) || !empty($data['lj_dst_fld']['azi']))						
													<tr>
														<td style="padding:3px; text-align:center;font-size=6;">LJ DST-{{ !empty($data['culturelj']->sample_label)?$data['culturelj']->sample_label:"" }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['s'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['s'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['H(inh A)'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['H(inh A)'],0,1) }}</td>
														<!--<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['H(Kat G)'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['H(Kat G)'],0,1) }}</td>-->
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['r'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['r'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['e'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['e'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['z'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['z'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['km'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['km'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['cm'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['cm'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['am'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['am'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['lfx'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['lfx'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['mfx1'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['mfx1'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['mfx2'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['mfx2'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['pas'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['pas'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['lzd'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['lzd'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['cfz'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['cfz'],0,1)  }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['eto'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['eto'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['clr'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['clr'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['azi'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['azi'],0,1) }}</td>
														<td style="padding:3px; text-align:center">{{ mb_substr($data['lj_dst_fld']['BDQ'],0,1)=="N"?"--":mb_substr($data['lj_dst_fld']['BDQ'],0,1) }}</td>
													</tr>
													@endif
												@endif
											    @if(isset($data['lc_dst_fld'])&& !empty($data['lc_dst_fld']))
													@if(!empty($data['lc_dst_fld']['s']) || !empty($data['lc_dst_fld']['H(inh A)']) || !empty($data['lc_dst_fld']['H(Kat G)']) || !empty($data['lc_dst_fld']['r']) || !empty($data['lc_dst_fld']['e']) || !empty($data['lc_dst_fld']['z']) || !empty($data['lc_dst_fld']['km']) || !empty($data['lc_dst_fld']['cm']) || !empty($data['lc_dst_fld']['am']) || !empty($data['lc_dst_fld']['lfx']) || !empty($data['lc_dst_fld']['mfx1']) || !empty($data['lc_dst_fld']['mfx2']) || !empty($data['lc_dst_fld']['pas']) || !empty($data['lc_dst_fld']['lzd']) || !empty($data['lc_dst_fld']['cfz']) || !empty($data['lc_dst_fld']['eto']) || !empty($data['lc_dst_fld']['clr']) || !empty($data['lc_dst_fld']['azi']))						
													<tr>
													   <?php //echo '<pre>'; echo $data['lc_dst_fld']['am']; die();?>
														<!--<td>LC DST-{{ !empty($data['culturelc']->sample_label)?$data['culturelc']->sample_label:"" }}</td>-->
														<td style="padding:3px; text-align:center;font-size=6;">LC DST-{{ !empty($data['culturelc']->sample_label)?$data['culturelc']->sample_label:"" }}</td>
														
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['s'])&&!empty($data['lc_dst_fld']['s'])? mb_substr($data['lc_dst_fld']['s'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['s'],0,1):""; ?></td>	
															
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['H(inh A)'])&&!empty($data['lc_dst_fld']['H(inh A)'])?mb_substr($data['lc_dst_fld']['H(inh A)'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['H(inh A)'],0,1):""; ?></td>
														<!--<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['H(Kat G)'])&&!empty($data['lc_dst_fld']['H(Kat G)'])?mb_substr($data['lc_dst_fld']['H(Kat G)'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['H(Kat G)'],0,1):""; ?></td>-->
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['r'])&&!empty($data['lc_dst_fld']['r'])?mb_substr($data['lc_dst_fld']['r'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['r'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['e'])&&!empty($data['lc_dst_fld']['e'])?mb_substr($data['lc_dst_fld']['e'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['e'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['z'])&&!empty($data['lc_dst_fld']['z'])?mb_substr($data['lc_dst_fld']['z'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['z'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['km'])&&!empty($data['lc_dst_fld']['km'])?mb_substr($data['lc_dst_fld']['km'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['km'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['cm'])&&!empty($data['lc_dst_fld']['cm'])?mb_substr($data['lc_dst_fld']['cm'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['cm'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['am'])&&!empty($data['lc_dst_fld']['am'])?mb_substr($data['lc_dst_fld']['am'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['am'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['lfx'])&&!empty($data['lc_dst_fld']['lfx'])?mb_substr($data['lc_dst_fld']['lfx'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['lfx'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['mfx1'])&&!empty($data['lc_dst_fld']['mfx1'])?mb_substr($data['lc_dst_fld']['mfx1'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['mfx1'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['mfx2'])&&!empty($data['lc_dst_fld']['mfx2'])?mb_substr($data['lc_dst_fld']['mfx2'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['mfx2'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['pas'])&&!empty($data['lc_dst_fld']['pas'])?mb_substr($data['lc_dst_fld']['pas'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['pas'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['lzd'])&&!empty($data['lc_dst_fld']['lzd'])?mb_substr($data['lc_dst_fld']['lzd'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['lzd'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['cfz'])&&!empty($data['lc_dst_fld']['cfz'])?mb_substr($data['lc_dst_fld']['cfz'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['cfz'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['eto'])&&!empty($data['lc_dst_fld']['eto'])?mb_substr($data['lc_dst_fld']['eto'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['eto'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['clr'])&&!empty($data['lc_dst_fld']['clr'])?mb_substr($data['lc_dst_fld']['clr'],0,1)=="N"?"--":mb_substr($data['lc_dst_fld']['clr'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['azi'])&&!empty($data['lc_dst_fld']['azi'])?mb_substr($data['lc_dst_fld']['azi'],0,1):""; ?></td>
														<td style="padding:3px; text-align:center"><?php echo isset($data['lc_dst_fld']['BDQ'])&&!empty($data['lc_dst_fld']['BDQ'])?mb_substr($data['lc_dst_fld']['BDQ'],0,1):""; ?></td>
														
														
													</tr>
													@endif
												@endif	
                            				</table>



                                    <tr>
                                      <td colspan="2">
                                      <table width="100%" border="0" cellspacing="5" cellpadding="5">

										 <!--Changed by Pradip on 18/05/2020 Start Process 
                                          <tr>
                                            
                                             <td style="padding:3px; border:0px;">Date result:          @if($data['culturelj'])
                                              {{ date ('d-m-Y', strtotime($data['culturelj']->lj_result_date)) }} 
										   
                                             @elseif($data['culturelc'])
                                              {{ date ('d-m-Y', strtotime($data['culturelc']->result_date)) }}
											   
                                             @endif</td>
                                            <td style="border:none;">Date Reported:{{ date('d-m-Y H:i:s', time()) }}</td>
                                            <td style="border:none;">Reported by:{{ $data['microbio_name']}}</td>
                                          </tr>

                                          Date Result:_____________ Date Reported:_____________ Reported by(Name and Signature):__________________
										  -->
										  <tr>
												<td style="padding:3px; border:0px;">
													@if(!empty($data['lj_dst']))
														LJDST - Date Result: {{ date ('d-m-Y', strtotime($data['lj_dst']->created_at)) }} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;
														Date Reported: {{date('d-m-Y H:i:s', strtotime($data['lj_dst']->sent_to_nikshay_date))}}  &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;
														Reported by: {{ $data['lj_dst']->name}}  &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;
														<br /><br />
													@endif
												
													@if($data['lc_dst']->count() > 0)
														LCDST - Date Result: {{ date ('d-m-Y', strtotime($data['lc_dst'][0]->result_date)) }} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; 
														Date Reported: {{date('d-m-Y H:i:s', strtotime($data['lc_dst'][0]->sent_to_nikshay_date))}}  &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;
														Reported by: {{ $data['lc_dst'][0]->uname}} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;
														<br /><br />
													@endif
												
													 Laboratory Name: {{ $data ['labrotory_name'] }} &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	
													 &nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp; &nbsp;
													 &nbsp;	&nbsp; &nbsp;	&nbsp;	&nbsp;	&nbsp; &nbsp;	&nbsp;		
													 <!--(Name and Signature)
													 <br /><br /><br /><br /><br />-->
											</td>		 
                                          </tr>
                                        </table>
										<tr><td colspan="2">
										@if(count($data['lc_dst'])>0 || count((array)$data['lj_dst'])>0)
											<p style="padding:0px; margin:0px 0px 10px 5px; font-weight:bold; text-align:center">R: Resistant; S: Susceptible; C: Contaminated; -- Not done</p>
                                        @endif
									    </td></tr>
                                    </tr>
                            			
                            			</td>
                            		</tr>

                                </table>

                </td>
             </tr>
        @endif


        <?php if(!empty($data['final_remark_list'])){ ?>
        <tr>
		
            <td colspan="2" style="border:0px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:15px; border:2px solid #000;" align="center">
                    <tbody>
                    @php( $final_remark_list = array_pop( $data['final_remark_list'] ) )
                    <tr align="left">
                        <th width="120">Remarks</th>
                        <td>{{ $final_remark_list->remark }}</td>
                    </tr>
					@if(!empty($final_remark_list->detail))
                    <tr align="left">
                        <th width="120">Details</th>
                        <td>{{ $final_remark_list->detail }}</td>
                    </tr>
					@endif
                    </tbody>
                </table>
            </td>
        </tr>
        <?php } ?>

</table>
    @if( request('remarks') )
       <!-- <strong>Remarks: {{ request('remarks') }}</strong> -->
    @endif <br /> <br /> <br />
	<h3 style="margin-top:-4px;color:#2E9AFE;" align="center"><?php echo 'This is a computer generated test report no signature required.'; ?></h3>
	<br /> <br />
	
	<!--<h3 style="margin-top:-4px;" align="center">(<?php echo $data['report_type']; ?>)</h3>-->
	<h3 style="margin-top:-4px;" align="center">(<?php echo 'End of Report'; ?>)</h3>
</div>
</body>
</html>
