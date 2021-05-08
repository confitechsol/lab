@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Equipments</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">

                    <form action="{{ url('/equipment/print') }}" method="post" >

                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="btn-group pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ url('/equipment/create') }}">Add New</a>
                        <a class="btn btn-sm btn-warning" href="{{ url('/calendar') }}">Calendar</a>
                        <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
                      </div>
                    </form>
                    <form action="{{ url('/equipment/downtimeAnalysis') }}" method="post" >

                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="btn-group pull-right">

                        <button type="submit" class="pull-right btn-sm btn-info" >Downtime Report</button>
                      </div>
                    </form>
                    <form action="{{ url('/equipment/freqdowntimeAnalysis') }}" method="post" >

                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="btn-group pull-right">

                        <button type="submit" class="pull-right btn-sm btn-info" >Frequent Breakdown Report</button>
                      </div>
                    </form>
                 </div>

              </div>

			  
                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >

                                  <div class="table-scroll">
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th>Item Type (Equipment by Type)</th>
                                            <th>Item Name (Equipment by name)</th>
                                           <!-- <th>Instrument/Tool</th>-->
                                            <th>Equipment Make</th>
                                            <th>Equipment Model No</th>
                                            <th>Equipment Serial No. </th>
                                            <th>Name of the Provider </th>
                                            <th>Name of the Supplier of equipment</th>
                                            <th>Date of Installation </th>
                                           <!-- <th>Equipment ID </th>-->
                                            <th>Location of the equipment </th>
                                           <!-- <th>Warranty Status till applicable date </th>-->
                                            <th>Current warranty status </th>
                                            <th>Equipment under maintainance contract</th>
                                            <th>Maintainance contract (till applicable date)</th>
                                            <th>Maintained by company</th>
                                            <th>Name Contact Person in the company for maintainance</th>
                                            <th>Contact Person No.</th>
                                            <th>Contact Person Email</th>
                                            <th>Date of Last Maintenance </th>
                                            <th>Date of Last Calibration </th>
                                            <th>Due date of Next Maintenance </th>
                                            <th>Due date of Next Calibration </th>
                                            <!--<th>Lab Responsble person</th>
                                            <th>Date of Breakdown of the equipment </th>
                                            <th>Date of equipment returning back to functional status</th>
                                            <th>Date of Decommission the equipment </th>
                                            <th>Records of Instrument kept in</th>-->
                                            <th>Add Breakdown Date</th>
											<th>Add returning Back to Functional Date</th>
                                            <th>Action</th>
                                            <!--<th>Delete</th>-->

                                          </tr>
                                      </thead>
                                      <tbody>
									  <?php //echo "<pre>"; print_r($data['sample']); die; ?>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->name_cat}}</td>
                                          <td>{{$samples->name}}</td>
                                          <!--<td>{{$samples->tool}}</td>-->
                                          <td>{{$samples->make}}</td>
                                          <td>{{$samples->model_no}}</td>
                                          <td>{{$samples->serial_no}}</td>
                                          <td>{{$samples->org}}</td>
                                          <td>{{$samples->supplier}}</td>
                                          <td>@if(!empty($samples->date_installation))  {{ date('d-m-Y', strtotime($samples->date_installation)) }} @endif</td>
                                         <!-- <td>{{$samples->eqp_id}}</td>-->
                                          <td>{{$samples->location}}</td>
                                         <!-- <th>@if(!empty($samples->waranty_status))  {{ date('d-m-Y', strtotime($samples->waranty_status)) }} @endif</td>-->
                                          <td>{{$samples->curr_warrenty}}</td>
                                          <td>{{ $samples->eqp_maintain }}</td>
                                          <td>@if(!empty($samples->maintainance_report)) {{ date('d-m-Y', strtotime($samples->maintainance_report)) }} @endif</td>
                                          <td>{{$samples->company_name}}</td>
                                          <td>{{$samples->contact_name}}</td>
                                          <td>{{$samples->contact_no}}</td>
                                          <td>{{$samples->contact_email}}</td>
                                          <td>@if(!empty($samples->date_last_maintain)) {{ date('d-m-Y', strtotime($samples->date_last_maintain)) }} @endif</td>
                                          <td>@if(!empty($samples->date_last_caliberation)) {{ date('d-m-Y', strtotime($samples->date_last_caliberation)) }} @endif</td>
                                        <td>  <?php $originalDate = "$samples->due_date";
                                          if(!empty($originalDate)){
                                            $newdueDate = date("d-m-Y", strtotime($originalDate));
                                            echo $newdueDate;
                                          } ?></td>
                                          <td><?php $oldcalliberationriginalDate = "$samples->next_calibration";
                                          if(!empty($oldcalliberationriginalDate)){
                                            $newcallbirationDate = date("d-m-Y", strtotime($oldcalliberationriginalDate));
                                            echo $newcallbirationDate;
                                          }?></td>
                                          <!---<td>{{$samples->responsible_person}}</td>
                                          <td>@if(!empty($samples->breakdown_eqp)) {{ date('d-m-Y', strtotime($samples->breakdown_eqp)) }} @endif</td>
                                          <td>@if(!empty($samples->return_function_status)) {{ date('d-m-Y', strtotime($samples->return_function_status )) }} @endif</td>
                                          <td>@if(!empty($samples->date_decommission)) {{ date('d-m-Y', strtotime($samples->date_decommission)) }} @endif</td>
                                          <td>{{$samples->records_inst}}</td>--->
                                          <td>
										    <input type="hidden" name="hidRecDate" class="hidRecDate" id="hidRecDate{{$samples->id}}" value="<?php echo !empty($samples->recovery_date)?$samples->recovery_date:"";?>">
                                            <button type="button" onclick='openCbnaatForm({{$samples->id}})'  class="btn btn-info btn-sm resultbtn" <?php if((!empty($samples->breakdown_date)&& empty($samples->recovery_date))){?> disabled <?php } ?>>Add</button>
                                            <!-- <form action="{{ url('/equipment/addbreakdown/'.$samples->id) }}" method="post" >
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              Breakdown date: <input type="text" placeholder="dd-mm-yy" name="break_date"  class="form-control datepicker" required="required">
                                              Recovery Date: <input type="text" placeholder="dd-mm-yy" name="recovery_date"  class="form-control datepicker" required="required">
                                              <button type="submit" class="pull-right btn-sm btn-info" >Add</button>
                                            </form> -->
                                          </td>
                                          <td>
										    
											  <input type="hidden" name="hidBkDnDate" class="hidBkDnDate" id="hidBkDnDate{{$samples->m_equip_breakdown_date_id}}" value="<?php echo !empty($samples->breakdown_date)?$samples->breakdown_date:"";?>">
                                            <button type="button" onclick="openRtnBkStatusForm({{$samples->m_equip_breakdown_date_id}})"  class="btn btn-info btn-sm resultbtn" <?php if((empty($samples->breakdown_date)&& empty($samples->recovery_date))||(!empty($samples->breakdown_date)&& !empty($samples->recovery_date))){?> disabled <?php } ?>>Add</button>                                           
                                          </td>
                                          <td><a href="{{ url('/equipment/'.$samples->id.'/edit') }}">Edit</a></td>
                                          <!--<td><a href="{{ url('/equipment/'.$samples->id.'/delete_equipment') }}">Delete</a></td> -->
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
</div>

<div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add breakdown Date</h4>
        </div>
         <form class="form-horizontal form-material" action="#" method="post" enctype='multipart/form-data' id="cbnaat_result">
                
                       <div class="alert alert-danger"><h4></h4></div>
                  
		        <div class="modal-body">

		           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		           	<input type="hidden" name="equipId" id="equipId" value="">
					<input type="hidden" name="hid_rec_date" id="hid_rec_date" value="">

		        <label class="col-md-12">Date of Breakdown of the equipment <span class="red">*</span></label>
                <div class="col-md-12">
                   <input type="date" placeholder="Y-m-d" name="break_date" id="break_date"  class="form-control" required="required">
                </div>
               <br>
			   <label class="col-md-12">Remarks</label>
                <div class="col-md-12">
                   <input type="text" placeholder="reason for breakdown" name="break_reason" id="break_reason"  class="form-control" required="required">
                </div>
               <br>
			   <!---
               <label class="col-md-12">Date of equipment returning back to functional status</label>
               <div class="col-md-12">
                  <input type="date" placeholder="Y-m-d" name="recovery_date"  class="form-control" required="required">
              </div>--->

		        </div>
		        <div class="modal-footer">
		          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
		          <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
        		  <button type="button" class="pull-right btn btn-primary btn-md" id="confirmOK">Ok</button>
		        </div>

		  </form>
      </div>
    </div>
 </div>
<div class="modal fade" id="addRtnBkModal" role="dialog" >
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Date of equipment returning back to functional status</h4>
        </div>
         <form class="form-horizontal form-material" action="#" method="post" enctype='multipart/form-data' id="updFrmId">
                  
                       <div class="alert alert-danger"><h4></h4></div>
                  
		        <div class="modal-body">

		           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		           	<input type="hidden" name="m_equip_breakdown_date_id" id="m_equip_breakdown_date_id" value="">
                  
		            <label class="col-md-12">Previous Breakdown Date</label>
                <div class="col-md-12">
                   <input type="text"  name="disp_break_date" id="disp_break_date" value="" class="form-control" readonly>
               </div>
               <br>
               <label class="col-md-12">Date of equipment returning back to functional status</label>
               <div class="col-md-12">
                  <input type="date" placeholder="Y-m-d" name="recovery_date"  id="recovery_date" class="form-control" required="required">
              </div>

		        </div>
		        <div class="modal-footer">
		          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
		          <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
        		  <button type="button" class="pull-right btn btn-primary btn-md" id="rtnBkOk">Ok</button>
		        </div>

		  </form>
      </div>
    </div>
 </div>
<script>

$( document ).ready(function() {
  $('.alert').hide();
  $("#confirmOK").click(function(e){
    e.preventDefault();
    var rec_date= $('#hid_rec_date').val(); //get user recovery date;
   //alert(rec_date);
   if($('#break_date').val().length === 0) {//null checking
   //alert("1");
      $('#break_date').addClass("error");  
    }/*else if( $('#hid_rec_date').val().length === 0) {  //alert("2");
	  $('.alert').show().text("Breakdown Date is already defined.Please enter the returning back to functional date before entering the new breakdown date");
	}*/else{ //alert("else");
	//var startDate = new Date($('#break_date').val());
   // var endDate = new Date($('#hid_rec_date').val());
	 if(Date.parse($('#break_date').val())<=Date.parse($('#hid_rec_date').val())) {  //alert("3");
	  $('.alert').show().text("Current breakdown date should be greater than  the last date of returning back to functional.");
	 }else{  //alert("3 else");
	   $('#break_date').removeClass("error");
	   $('.alert').hide();
		//make ajax call
		$.ajax({
			type: "POST",
			url:"{{ url('/equipment/addbreakdown') }}",
			data: {"equipId":$('#equipId').val(),"break_date":$('#break_date').val(),"break_reason":$('#break_reason').val(),"_token":"{{ csrf_token() }}" },
			success: function(msg){
				$("#message").html(msg)
				$("#myModal").modal('hide'); 
				 location.reload();
			},
			error: function(){
				alert("failure");
			}
		});
	}
    }
});
$("#rtnBkOk").click(function(e){
    e.preventDefault();
    var rec_date= $('#hid_rec_date').val(); //get user recovery date;
   //alert(rec_date);
   if($('#recovery_date').val().length === 0) {//null checking
   //alert("1");
      $('#recovery_date').addClass("error");  
    }else{ 
	var disp_break_date=$("#disp_break_date" ).val();
	var new_disp_break_date = disp_break_date.split("-").reverse().join("-");
	//alert($("#disp_break_date" ).val());
	//alert($('#recovery_date').val());
	//alert(new_disp_break_date);
	
	 if(Date.parse($('#recovery_date').val())<Date.parse(new_disp_break_date)) {  //alert("3");
	  $('.alert').show().text("Date of equipment returning back to functional status should be greater than equal to the current breakdown date.");
	 }else{  //alert("3 else");
	   $('#recovery_date').removeClass("error");
	   $('.alert').hide();
		//make ajax call
		$.ajax({
			type: "POST",
			url:"{{ url('/equipment/updatebreakdown') }}",
			data: {"m_equip_breakdown_date_id":$('#m_equip_breakdown_date_id').val(),"recovery_date":$('#recovery_date').val(),"_token":"{{ csrf_token() }}" },
			success: function(msg){
				$("#message").html(msg)
				$("#addRtnBkModal").modal('hide'); 
				 location.reload();
			},
			error: function(){
				alert("failure");
			}
		});
	}
    }
});

});
function openCbnaatForm(id){
var recovery_date=$('#hidRecDate'+id).val();	
  //alert(recovery_date);
 $("#equipId").val(id);
 $("#hid_rec_date").val(recovery_date);
 $('#myModal').modal('toggle');
}
function openRtnBkStatusForm(id){
	
var brkdwn_date=convertLinuxDate($('#hidBkDnDate'+id).val());
//alert(brkdwn_date);

 $("#m_equip_breakdown_date_id").val(id);
 $("#disp_break_date").val(brkdwn_date);
 $('#addRtnBkModal').modal('toggle');
}
function convertLinuxDate(linux_date) {
    //linux_date = "2001-01-02"
    var arrDate = linux_date.split("-");
    return arrDate[2] + "-" +arrDate[1] + "-" + arrDate[0];
}
</script>



<script>

$(document).ready(function() {
      var labname="<?php echo $data['labname']; ?>";
  var labcity="<?php echo $data['labcity']; ?>";
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
    $('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_equipment_'+today+'',
                   exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27 ]
                }
            }
        ]
    });
} );
</script>

<style>
.error {
    border-color: solid 1px #FF0000;  
}
</style>
@endsection
