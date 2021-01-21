@extends('admin.layout.app')
@section('content')
@include('admin.biowaste.view_sample_popup')
<div class="page-wrapper">
<div class="container-fluid">
<div class="row page-titles">
<div class="col-md-5 col-8 align-self-center">
<h3 class="text-themecolor m-b-0 m-t-0">Biomedical Waste Management System </h3>

</div>
<div class="col-md-7 col-4 align-self-center">
<div align="right">
  <a class="btn btn-info btn-sm" href="{{ url('/bioWaste/create') }}">Add New</a>
  <a class="btn btn-info btn-sm" href="{{ route('bio-waste-sample.index') }}">View Samples</a>
  <form class="d-inline-block" action="{{ url('/bioWaste/print') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-sm btn-primary" >Print</button>
  </form>
{{--<input type="button" id="view_bwm_samples" name="view_bwm_samples" class="btn btn-info btn-sm" value="View Samples" />--}}
</div>
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
<th class="hide">ID</th>
<th>Date of waste generated</th>
<th>Quantity of waste generated(in kg)</th>
<th>Quantity of waste generated(in Packets)</th>
<th>Date of collection for disposal</th>
<th>Edit</th>
<th>Action</th>

</tr>
</thead>
<tbody>
@foreach ($data['sample'] as $key=> $samples)
<tr>
<td class="hide">{{$samples->id}}</td>
<td>{{$samples->generated_date}}</td>
<td>{{$samples->quantity}}</td>
<td>{{$samples->packets}}</td>
<td>
@if($samples->collected_date!=null)
{{$samples->collected_date}}
@else
<button type="button" onclick="openCbnaatForm1({{$samples->id}})"  class="btn btn-info btn-sm resultbtn" >Add Date</button>
@endif
</td>
<td>
@if($samples->status==0)
<button type="button" onclick="openCbnaatForm({{$samples->id}})"  class="btn btn-info btn-sm resultbtn" >Edit</button>
@elseif($samples->status==1)
submitted
@endif

</td>
<td>
@if(($samples->quantity!=null) ||  ($samples->packets!=null))
@if($samples->collected_date!=null  && $samples->status==0)
<a href="{{ url('/bioWaste/'.$samples->id.'/edit') }}">Submit</a>
@elseif($samples->collected_date!=null && $samples->status==1)
submitted
@elseif($samples->collected_date==null  && $samples->status==0)
@endif
@else
Enter the quantity in kg
@endif
</td>
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
<footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
</div>

<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Bio waste Management</h4>
</div>
<form class="form-horizontal form-material" action="{{ url('/bioWaste') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
@if(count($errors))
@foreach ($errors->all() as $error)
<div class="alert alert-danger"><h4>{{ $error }}</h4></div>
@endforeach
@endif
<div class="modal-body">

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="waste_id" id="waste_id" value="">
<div id="qaunt_div">
<label class="col-md-12">Quantity of waste generated (in kg)</label>
<div class="col-md-12">

<input type="number" name="quantity" pattern="[0-9]" class="form-control form-control-line "  id="quantity" >
</div>
</div>


<div id="pckt_div">
<label class="col-md-12">Quantity of waste generated(in Packets)</label>
<div class="col-md-12">

<input type="number" name="packets" pattern="[0-9]" class="form-control form-control-line "  id="packets" >
</div>
</div>

</div>
<div class="modal-footer">
<!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
<button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
<button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
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
<h4 class="modal-title">Bio waste Management</h4>
</div>
<form class="form-horizontal form-material" action="{{ url('/bioWaste') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
@if(count($errors))
@foreach ($errors->all() as $error)
<div class="alert alert-danger"><h4>{{ $error }}</h4></div>
@endforeach
@endif
<div class="modal-body">

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="waste_id_col" id="waste_id_col" value="">

<label class="col-md-12">Date of collection for disposal</label>
<div class="col-md-12">
<input type="text" name="collected_date"  placeholder="dd-mm-yy" class="form-control form-control-line datepicker" required>
</div>





</div>
<div class="modal-footer">
<!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
<button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
<button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
</div>

</form>
</div>
</div>
</div>


<script>
$(function(){






$(".resultbtn").click(function(){
$('#sample_id').val($(this).val());
});

$('#confirmDelete').on('show.bs.modal', function (e) {

// Pass form reference to modal for submission on yes/ok
var form = $(e.relatedTarget).closest('form');
$(this).find('.modal-footer #confirm').data('form', form);
});




});
function openCbnaatForm1(id) {
//console.log("sample_ids", sample_ids.split(','));
$("#waste_id_col").val(id);


$('#myModal1').modal('toggle');
}


function openCbnaatForm(id) {
//console.log("sample_ids", sample_ids.split(','));
$("#waste_id").val(id);


$('#myModal').modal('toggle');
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
title: 'LIMS_'+labname+'_'+labcity+'_BWM_'+today+'',
exportOptions: {
   columns: [  1, 2, 3,4 ]
}
}
]
});
} );
</script>
<script>

$(document).ready(function(){

$("#quantity").keyup(function(){
var quantity=$("#quantity").val();
if(quantity == '' || quantity == null){
$("#pckt_div").show();
}else{

$("#pckt_div").hide();

}
});


$("#packets").keyup(function(){
var pckts=$("#packets").val();
if(pckts == '' || pckts == null){
  $("#qaunt_div").show();
}else{

$("#qaunt_div").hide();

}
});


});
</script>
<script>
$("#view_bwm_samples").click(function(){

  $.ajax({

    url:"{{ url('/viewsamples') }}",
    type:"GET",
    dataType:"JSON",
    success:function(response){
      console.log(response)
      if(response == false){

        alert("Currently No Sample Has Been Sent To Bio-Medical Waste Management System. Please Send Sample To View The Log");
      }else{
        var html='';
        $.each(response,function(index,mainsamples){
            html +="<tr><td>"+mainsamples.enroll_label+"</td><td>"+mainsamples.sample_label+"</td><td>"+mainsamples.patient_name+"</td><td>"+mainsamples.test_req+"</td><td>"+mainsamples.date+"</td></tr>";

        });
        $("#bwm_modal > tbody").html(html);
        $("#viewsamplepopup").modal();

      }
    }
  });
});

</script>
<script type="text/javascript">
$(function(){
    $("#search_bwm_samples").keyup(function(){
      $("#bwm_modal > tbody").html("");
      var search_val=$(this).val();
        // alert("n");
      $.ajax({
        url:"{{ url('/search/bwmsamples') }}",
        type:"POST",
        data:{"search_val":search_val,"_token":"{{ csrf_token() }}" },
        dataType:"JSON",
        success:function(responses){
          var html='';
          if(responses == false){
            html ='<tr><td colspan="8">No Results found</td></tr>';
          //  alert("Currently No Sample Has Been Sent To Bio-Medical Waste Management System. Please Send Sample To View The Log");
          }else{

            $.each(responses,function(index,mainsamples){
                // alert(mainsamples.test_req);
                html +="<tr><td>"+mainsamples.enroll_label+"</td><td>"+mainsamples.sample_label+"</td><td>"+mainsamples.patient_name+"</td><td>"+mainsamples.test_req+"</td><td>"+mainsamples.date+"</td></tr>";

            });
          }
          $("#bwm_modal > tbody").html(html);
        }
      });


    });
});
</script>
@endsection
