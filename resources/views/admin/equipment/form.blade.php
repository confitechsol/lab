@extends('admin.layout.app')
@section('content')
<style>
.ydiv {
border:solid 1px;
width:200px;
//height:150px;
background-color:#D8D8D8;
display:none;
position:absolute;
top:40px;
}

.ybutton {

  border: none;
  width:35px;
height:35px;
  background-color:#D8D8D8;
font-size:100%;
}

.yhr {
background-color:black;
color:black;
height:1px;
}


.ytext {
border:none;
text-align:center;
width:118px;
font-size:100%;
background-color:#D8D8D8;
font-weight:bold;

}
#yeardate{

  width:50%;
}
.btn.btn-primary{
margin-left:3%;

}
</style>
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Equipments</h3>

                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                       <p  class="pull-right "></p>
                   </div>
                </div>
                   @if($data['equipment']->id>0)
                   <form id="createForm" action="{{ url('/equipment/'.$data['equipment']->id) }}" method="post">
                     <input name="_method" type="hidden" value="patch">
                   @else
                   <form id="createForm" action="{{ url('/equipment') }}" method="post" role="alert">
                 @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-block">

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-sm-12">Equipment by Type <span class="red">*</span></label>
                                                <div class="col-sm-12">

                                                    <select name="name_cat" class="form-control form-control-line" id="name_cat" value="{{ old('name_cat', $data['equipment']->name_cat) }}" required>
                                                         <option value="">--Select--</option>
                                                          @foreach ($data['category'] as $key=> $district)
                                                                  @if($data['equipment']->name_cat==$district->name)
                                                                  <option value="{{$district->name}}"  selected="selected">{{$district->name}}</option>
                                                                  @else
                                                                   <option value="{{$district->name}}">{{$district->name}}</option>
                                                                  @endif

                                                          @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-sm-12">Equipment by Name <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <!-- <select name="name" class="form-control form-control-line" id="Item Name (Equiment by Name)" required="required" >
                                                        <option value="Alcohol Thermometer"
                                                        @if($data['equipment']->name=="Alcohol Thermometer")
                                                            selected="selected"
                                                        @endif
                                                        >Alcohol Thermometer</option>
                                                        <option value="Mercury Thermometer"
                                                        @if($data['equipment']->name=="Mercury Thermometer")
                                                            selected="selected"
                                                        @endif
                                                        >Mercury Thermometer</option>
                                                        <option value="Thermometer"
                                                        @if($data['equipment']->name=="Thermometer")
                                                            selected="selected"
                                                        @endif
                                                        >Thermometer</option>
                                                        <option value="Digital Thermometer"
                                                        @if($data['equipment']->name=="Digital Thermometer")
                                                            selected="selected"
                                                        @endif
                                                        >Digital Thermometer</option>
                                                        <option value="PCR-Workstation"
                                                        @if($data['equipment']->name=="PCR-Workstation")
                                                            selected="selected"
                                                        @endif
                                                        >PCR-Workstation</option>
                                                        <option value="UV Light"
                                                        @if($data['equipment']->name=="UV Light")
                                                            selected="selected"
                                                        @endif
                                                        >UV Light</option>
                                                        <option value="Magnetic stirrer with heating plate etc."
                                                        @if($data['equipment']->name=="Magnetic stirrer with heating plate etc.")
                                                            selected="selected"
                                                        @endif
                                                        >Magnetic stirrer with heating plate etc.</option>
                                                    </select> -->
                                                    <input type="text"  name="name" value="{{ old('name', $data['equipment']->name) }}" class="form-control form-control-line" required="required">
                                                </div>
                                        </div>
                                    </div>
									
									<div class="row">
									     <div class="col">
                                            <label class="col-md-12">Name of the Supplier of equipment<span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="supplier" value="{{ old('supplier', $data['equipment']->supplier) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
										 <div class="col">
                                            <label class="col-md-12">Equipment Manufacturer <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="make" value="{{ old('make', $data['equipment']->make) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
									</div>
                                    
									<div class="row">
									    <div class="col">
                                            <label class="col-md-12">Equipment Model No. <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="model_no" value="{{ old('model_no', $data['equipment']->model_no) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
										<div class="col">
                                            <label class="col-md-12">Equipment Serial No. <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="serial_no" id="serial_no" value="{{ old('serial_no', $data['equipment']->serial_no) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
									</div>
									
									<div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Date of Installation <span class="red">*</span></label>
                                            <div id="5" class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                  <input type="date" placeholder="dd-mm-yy"
                                                  max="{{ date('Y-m-d')}}" name="date_installation" value="{{ old('date_installation', $data['equipment']->date_installation) }}" class="form-control" required="required">

                                            </div>
                                        </div>
										<div class="col">
                                            <label class="col-sm-12">Location of the Equiment <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <input type="text"  name="location" value="{{ old('location', $data['equipment']->location) }}" class="form-control form-control-line" required="required">
                                                </div>
                                        </div>
                                    </div>
									
									<div class="row">
									     <div id="curr_warrenty_status" class="col">
                                            <label class="col-sm-12">Current warranty status <span class="red">*</span></label>
                                            <div class="col-sm-12">
                                                <select name="curr_warrenty" class="form-control form-control-line warrenty_status" id="Instrument/Tool" required="required">
                                                    <option value="">--Select--</option>
                                                    <option value="Under Warranty"
                                                            @if($data['equipment']->curr_warrenty=="Under Warranty")
                                                            selected="selected"
                                                            @endif
                                                    >Under Warranty</option>
                                                    <option value="Not Under Warranty"
                                                            @if($data['equipment']->curr_warrenty=="Not Under Warranty")
                                                            selected="selected"
                                                            @endif
                                                    >Not Under Warranty</option>
                                                </select>
                                            </div>
                                        </div>
										<div class='col blank_div_aftr_war_st'><label class='col-md-8'>&nbsp;</label><div class='col-md-12'>&nbsp;</div></div>
										<div class="col warranty_status_date_div">
                                            <label class="col-md-8">Date of Warranty <span class="red">*</span> (applicable till)</label>
                                                <div class="col-md-12">
                                                    <input type="date"   name="waranty_status" value="<?php echo $data['equipment']->waranty_status; ?>" class="form-control dt_war_status" required="required">
                                                </div>
                                        </div>										
									</div>
									
									<div class="row">
									       <div class="col">
                                            <label class="col-sm-12">Equipment under Maintenance<span class="red">*</span></label>
                                                <div class="col-md-12">
                                                    <select name="eqp_maintain" class="form-control form-control-line  equip_under_main_cls" id="Status of the Equiment" required="required">
                                                        <option value="">--Select--</option>
                                                        <option value="Yes"
                                                        @if($data['equipment']->eqp_maintain=="Yes")
                                                            selected="selected"
                                                        @endif
                                                        >Yes</option>
                                                        <option value="No"
                                                        @if($data['equipment']->eqp_maintain=="No")
                                                            selected="selected"
                                                        @endif
                                                        >No</option>
                                                    </select>

                                                </div>
                                        </div>
										
										<div class='col blank_div_aftr_eqp_und_main'><label class='col-md-8'>&nbsp;</label><div class='col-md-12'>&nbsp;</div></div>
										 <div class="col main_con_date_div">
                                            <label class="col-sm-12">Maintenance Contract (till applicable date) <span class="red">*</span></label>
                                                <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                    <!-- <select name="maintainance_report" class="form-control form-control-line" id="Maintainence Report" required="required">
                                                        <option value="Completed"
                                                        @if($data['equipment']->maintainance_report=="Completed")
                                                            selected="selected"
                                                        @endif
                                                        >Completed</option>
                                                        <option value="Incompleted"
                                                        @if($data['equipment']->maintainance_report=="Incompleted")
                                                            selected="selected"
                                                        @endif
                                                        >Incompleted</option>

                                                    </select> -->
                                                      <input type="date" placeholder="dd-mm-yy"
                                                      min="{{ date('Y-m-d')}}" name="maintainance_report" value="{{ old('maintainance_report', $data['equipment']->maintainance_report) }}" class="form-control dt_maintain_cls" required="required">

                                                </div>
                                        </div>
									</div>
									
									<div class="row">
									    <div class="col">
                                          <label class="col-md-12">Maintained by company <span class="red">*</span></label>
                                          <div class="col-md-12">
                                             <input type="text"  name="company_name" value="{{ old('company_name', $data['equipment']->company_name) }}" class="form-control form-control-line" required="required">
                                          </div>
                                        </div>
										
                                        <div class="col">
                                            <label class="col-md-12">Name Contact Person in the company for maintainance <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="contact_name" value="{{ old('contact_name', $data['equipment']->contact_name) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
                                       
                                    </div>
									
									<div class="row">
									      <div class="col">
                                            <label class="col-md-12">Contact No. <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text" id="contact_no"   name="contact_no"  maxlength="10" minlength="10" value="{{ old('contact_no', $data['equipment']->contact_no) }}" class="form-control form-control-line" required="required">
                                               <div id="err-eq-contact"></div>
                                           </div>
                                        </div>
									     <div class="col">
                                          <label class="col-sm-12">Contact Email <span class="red">*</span></label>
                                              <div class="col-sm-12">

                                                   <input type="email"  name="contact_email" value="{{ old('contact_email', $data['equipment']->contact_email) }}" class="form-control form-control-line" required="required">
                                            </div>
                                            <!-- <label class="col-sm-12">Status of the Equiment <span class="red">*</span></label>
                                                <div class="col-sm-12">

                                                     <input type="text"  name="status" value="{{ old('status', $data['equipment']->status) }}" class="form-control form-control-line" required="required">
                                                </div> -->
                                        </div>
										 
									</div>
									
									<div class="row">
									    <div class="col">
                                            <label class="col-md-6">Date of Last Maintenance</label>
                                            <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                              <input type="date"
                                                     class="form-control"
                                                     placeholder="dd-mm-yy"
                                                     max="{{ date('Y-m-d')}}"
                                                     name="date_last_maintain"
                                                     value="{{ old('date_last_maintain', $data['equipment']->date_last_maintain) }}">
                                            </div>
                                        </div>
									       <?php  $originalDate = $data['equipment']->due_date;
											 if(!empty($originalDate)){

												$newDate = date("Y-m-d", strtotime($originalDate));
											 } ?>

                                        <div class="col">
                                            <label class="col-md-12">Due Date of Next Maintenance<span class="red">*</span></label>
                                            <div id=due_date class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                              <input type="date" name="due_date" value="<?php if(!empty($newDate)){  echo $newDate;  } ?>" class="form-control" required="required">
                                            </div>
                                        </div>
										
									</div>
									
									<div class="row">
									      <?php  $originalDate1 = $data['equipment']->next_calibration;
                                               if(!empty($originalDate1)){
                                                $newDate1 = date("Y-m-d", strtotime($originalDate1)); 
												} 
											?>
									    <div class="col">
                                            <label class="col-sm-12">Date of Last Calibration </label>
                                                <div class="col-sm-12">
                                                    <input type="date"  placeholder="dd-mm-yy"
                                                    max="{{ date('Y-m-d')}}" name="date_last_caliberation" value="{{ old('date_last_caliberation', $data['equipment']->date_last_caliberation) }}" class="form-control" >
                                                </div>
                                        </div>
										<div class="col">
										   
                                            <label class="col-sm-12">Due date of Next Calibration <span class="red">*</span></label>
                                                <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                      <input type="date" name="next_calibration" min="{{ date('Y-m-d')}}" value="<?php if (!empty($newDate1)){
                                                        echo $newDate1; } ?>" class="form-control" required="required">

                                                </div>
                                        </div>
									</div>
									
									<div class="row">  
                                        <?php $data['equipment']->provider;  ?>
                                        <div class="col">
                                            <label class="col-sm-12">Type of provider <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select id="provider" name="provider" class="form-control form-control-line" id="Name of the Provider" required="required">
                                                        <option value="">--Select--</option>
                                                        <option value="Central"
                                                        <?php if($data['equipment']->provider  =="Central"){ echo "selected"; } ?>

                                                        >Central</option>
                                                        <option value="State"
                                                        <?php if($data['equipment']->provider  =="State"){ echo "selected"; } ?>
                                                        >State</option>
                                                        <option value="Donor"
                                                        <?php if($data['equipment']->provider  =="Donor"){ echo "selected"; } ?>

                                                        >Donor</option>
                                                        <option value="Hospital"
                                                        <?php if($data['equipment']->provider  =="Hospital"){ echo "selected"; } ?>
                                                        >Hospital</option>
                                                    </select>
                                                </div>

                                                <div id="donor_name" class="col" <?php if(!empty($data['equipment']->donor_name)){ ?> style="display:block;" <?php }else{ ?>style="display:none;" <?php } ?>>
                                                  <label class="col-sm-12">Donor Name<span id="red_asterix" style="color:red;"></span></label>
                                                  <input type="text" class="form-control" placeholder="Donor Name" value="{{$data['equipment']->donor_name}}" id="donorname" name="donorname" maxlength="13"/>
                                                </div>
                                        </div>
										 <div class="col">
                                            <label class="col-md-12">Name of the Provider <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="org" value="{{ old('org', $data['equipment']->org) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
                                    </div>
									
									<input type="hidden" name="tool" value="Instrument">
									<input type="hidden" name="eqp_id" id="eqp_id" value="">
									<!----
                                    <div class="row">
                                        <div class="col">
                                            <label class="col-sm-12">Instrument/Tool <span class="red">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="tool" class="form-control form-control-line" id="Instrument/Tool" required="required">
                                                        <option value="">--Select--</option>
                                                        <option value="Tool"
                                                        @if($data['equipment']->tool=="Tool")
                                                            selected="selected"
                                                        @endif
                                                        >Tool</option>
                                                        <option value="Instrument"
                                                        @if($data['equipment']->tool=="Instrument")
                                                            selected="selected"
                                                        @endif
                                                        >Instrument</option>
                                                    </select>
                                                </div>
                                        </div>                                        
                                   
                                        <div class="col">
                                             <label class="col-md-12">Date of Decommissioning the equipment  </label>
                                            <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                              <input type="date" placeholder="dd-mm-yy"
                                              max="{{ date('Y-m-d')}}" name="date_decommission" value="{{ old('date_decommission', $data['equipment']->date_decommission) }}" class="form-control" >

                                            </div>
                                        </div>
										
                                    </div>


                                   
                                    

                                    
                                    

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Lab Responsible Person<span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="responsible_person" value="{{ old('responsible_person', $data['equipment']->responsible_person) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
                                        
                                   
                                    <?php  $originalDate1 = $data['equipment']->next_calibration;
                                    if(!empty($originalDate1)){
                                    $newDate1 = date("Y-m-d", strtotime($originalDate1));  } ?>

                                    
                                        
                                        <div class="col">
                                            <label class="col-md-12">Date of Breakdown of the equipment </label>
                                            <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                              <input type="date" placeholder="dd-mm-yy"
                                              max="<?php echo date('Y-m-d') ?>"
                                               name="breakdown_eqp" value="{{ old('breakdown_eqp', $data['equipment']->breakdown_eqp) }}" class="form-control" >


                                           </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-sm-12">Date of equipment returning back to functional status </label>
                                                <div id=5 class="date_class col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                      <input type="date" placeholder="dd-mm-yy" name="return_function_status"
                                                      max="{{ date('Y-m-d')}}"
                                                       value="{{ old('return_function_status', $data['equipment']->return_function_status) }}" class="form-control" >

                                                </div>
                                        </div>
                                        <div class="col">
                                            <label class="col-md-12">Records of instrument kept in <span class="red">*</span></label>
                                             <div class="col-md-12">
                                               <input type="text"  name="record_instrument" value="{{ old('record_instrument', $data['equipment']->record_instrument) }}" class="form-control form-control-line" required="required">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label class="col-md-12">Equipment ID <span class="red">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text"  name="eqp_id" value="{{ old('eqp_id', $data['equipment']->eqp_id) }}" class="form-control form-control-line" required="required">
                                           </div>
                                        </div>
                                       
                                    </div>--->

                                </div>
                            </div>
                        </div>





                        <div class="col-12">

                            <button id="save-btn" class="btn btn-info">Save</button>
                            <a class="btn btn-warning" href="{{url('/equipment')}}">Cancel</a>
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
            <footer class="footer">  </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
</div>

<script type="text/javascript">
$(document).ready(function(){
	if($(".warrenty_status").val()=='Under Warranty'){
		$('.blank_div_aftr_war_st').hide();
	    $(".warranty_status_date_div").show();
        $(".dt_war_status").attr('required','true');		
	}else{
		$('.blank_div_aftr_war_st').show();
		$(".warranty_status_date_div").hide();
        $('.dt_war_status').removeAttr('required');		
	}	
	
	$(".warrenty_status").change(function(){
		if($(".warrenty_status").val()=='Under Warranty'){
			$('.blank_div_aftr_war_st').hide();
			$(".warranty_status_date_div").show();
			$(".dt_war_status").attr('required','true');
		}else{
			$('.blank_div_aftr_war_st').show();
			$(".warranty_status_date_div").hide();
			$('.dt_war_status').removeAttr('required');
		}
	  
	});
	
	if($(".equip_under_main_cls").val()=='Yes'){
	   $('.blank_div_aftr_eqp_und_main').hide();	
	   $(".main_con_date_div").show();
       $(".dt_maintain_cls").attr('required','true');	   
	}else{
		$('.blank_div_aftr_eqp_und_main').show();
		$(".main_con_date_div").hide();
		$('.dt_maintain_cls').removeAttr('required');
	}
	
	$(".equip_under_main_cls").change(function(){
		if($(".equip_under_main_cls").val()=='Yes'){
			$('.blank_div_aftr_eqp_und_main').hide();
			$(".main_con_date_div").show();
			$(".dt_maintain_cls").attr('required','true');
		}else{
			$('.blank_div_aftr_eqp_und_main').show();
			$(".main_con_date_div").hide();
			$('.dt_maintain_cls').removeAttr('required');
		}
	  
	});
	
	$("#serial_no").on("change keyup paste", function(){
    $("#eqp_id").val($("#serial_no").val());
  })
});
  $(function () {
        var today = new Date();
        //alert(new Date());
        // $('#sandbox-container1').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container2').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container3').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container4').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container5').datepicker({
        //             format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container6').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container7').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });
        // $('#sandbox-container8').datepicker({
        //              format: 'dd-mm-yyyy',
        //              startDate: '-0d',
        //              autoclose: true
        // });

        // $("#sandbox-container1").on("dp.change", function (e) {
        //     $('#sandbox-container1').data("DatePicker").minDate(today);
        // });


  });
</script>
<script>
$(function () {
    $('#donorname').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
            e.preventDefault();
        } else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                e.preventDefault();
            }
        }
    });
});
</script>
<script>
$(document).ready(function(){
$("#provider").change(function(){
var val=$(this).val();
if(val !== null && val == 'Donor'){
  // alert("ok");
  $("#donor_name").css("display","block");
  $("#donorname").prop("required","required");
  $("#red_asterix").html("*");
}else{
    $("#donor_name").css("display","none");
    $("#donorname").removeAttr("required");
    // $("#donorname").val(null);
    $("#red_asterix").html("");
}

});

});
</script>
<script>
$(document).ready(function(){

$("#w_p").hide();
 // $("<div id='new_appended_div' class='col'></div>").insertAfter("#curr_warrenty_status");
$(".warrenty_status").change(function(){
var value=$(".warrenty_status").val();
var error=0;
if(value != null && value == 'Under Warranty'){
  $("#w_p").show();
  $("#new_appended_div").remove();
  $("#yeardate").prop("required","required");
}else{
error++;
$("div").find("#new_appended_div").remove();
 // $("<div id='new_appended_div' class='col'></div>").insertAfter("#curr_warrenty_status");
  $("#w_p").hide();
$("#yeardate").removeAttr("required");
}

});

});
</script>

<script>
$(document).ready(function(){

$("#contact_no").on("keyup",function(){
console.log(isNaN(this.value))
  if(isNaN(this.value)){
    document.getElementById('err-eq-contact').innerHTML="Please specify a numeric value";
    document.getElementById("save-btn").disabled=true;
  }else{
    document.getElementById('err-eq-contact').innerHTML="";
    document.getElementById("save-btn").disabled=false;
  }

});
});
</script>

@endsection
