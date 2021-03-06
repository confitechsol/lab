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
    <th rowspan="2" class="hide">ID</th>
    <th rowspan="2">Date of waste generated</th>
    <th rowspan="2">Unit of Measurement</th>
    <th colspan="4" style="text-align: center;">Quantity of Waste Generated</th>
    <th rowspan="2">Date of collection of disposal</th>
    <th rowspan="2">Edit</th>    
  </tr>
  <tr>
    <th class="yellow" style="background-color: #ffff00; color:#000;">Yellow</th>
    <th class="red1" style="background-color: #fb0001; color:#fff;">Red</th>
    <th class="white" style="background-color: #fff; color:#000;">White</th>
    <th class="blue" style="background-color: #01b0f1; color:#fff;">Blue</th>
  </tr>

{{-- <tr>
<th class="hide">ID</th>
<th>Date of waste generated</th>
<th>Unit of Measurement</th>
<!-- <th>Quantity of Waste Generated<div class="d-flex flex-nowrap text-center"><div class="yellow col-3 p-0">Yellow</div><div class="red1 col-3 p-0">Red</div><div class="white col-3 p-0">White</div><div class="blue col-3 p-0">Blue</div></div></th> -->
<th class="yellow" style="background-color: #ffff00; color:#000;">Yellow</th>
<th class="red1" style="background-color: #fb0001; color:#fff;">Red</th>
<th class="white" style="background-color: #fff; color:#000;">White</th>
<th class="blue" style="background-color: #01b0f1; color:#fff;">Blue</th>
<th>Date of collection of disposal</th>
<th>Edit</th>
<th>Action</th>

</tr> --}}
</thead>
<tbody>
  {{-- {{ dd($data['sample']) }}  --}}

 @foreach ($data['sample'] as $key=> $samples)
<tr>
<td class="hide">{{$samples->id}}</td>
<td class="hide">{{$samples->status}}</td>
<td>{{date('d-m-Y', strtotime($samples->generated_date))}}</td>
@if($samples->quantity!=null)
<td>KG</td>
@elseif($samples->packets==2)
<td>PACKETS</td>
@else
<td>None</td>
@endif
<!-- <td> 

  <div class="d-flex flex-nowrap text-center"><div class="col-3 p-0" style="width: 56px;">{{$samples->yellow}}</div><div class="col-3 p-0" style="width: 56px;">{{$samples->red}}</div><div class="col-3 p-0" style="width: 56px;">{{$samples->white}}</div><div class="col-3 p-0" style="width: 56px;">{{$samples->blue}}</div>
</td> -->
<td style="text-align:center;" >{{$samples->yellow}}</td>
<td style="text-align:center;" >{{$samples->red}}</td>
<td style="text-align:center;" > {{$samples->white}}</td>
<td style="text-align:center;">{{$samples->blue}}</td>
<td>
@if($samples->collected_date!=null)
{{$samples->collected_date}}
@else
<button style="display:none;" type="button" onclick="openCbnaatForm1({{$samples->id}})"  class="btn btn-info btn-sm resultbtn" >Add Date</button>
@endif
</td>
<td>
  <?php 
  if($samples->packets == 0){
     $packets = 0;
  }else{
    $packets = $samples->packets;
  }

  if(!isset($samples->quantity)){ 
    $quantity = 0;
   } else{ 
   $quantity = $samples->quantity; 
  }
// $c_date = strtotime($samples->collected_date);
  if(isset($samples->collected_date)){
    $c_date = date('d-m-Y', strtotime($samples->collected_date));
    $c_date = strtotime($c_date);
  }else{
    $c_date = 0;
  }
  
 ?>

@if($samples->status==0)
<button type="button" onclick="openCbnaatForm({{$samples->id}},{{ $quantity }},{{$packets}} ,{{$samples->yellow}},{{$samples->red}},{{$samples->white}},{{$samples->blue}},{{$c_date}})"  class="btn btn-info btn-sm resultbtn" >Edit</button>
@else
submitted
@endif

</td>
{{-- <td>
@if(($samples->quantity!=null) ||  ($samples->packets!=null) )
  @if($samples->collected_date!=null  && $samples->status==0)
  <a href="{{ url('/bioWaste/'.$samples->id.'/edit') }}">Submit</a>
  @elseif($samples->collected_date!=null && $samples->status==1)
  submitted
  @elseif($samples->collected_date==null  && $samples->status==0)
  @endif
@else  
@endif 
</td> --}}
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
<div class="d-flex align-items-baseline">
  <label>Select Mode<span style="color:red;">*</span></label>
  <div class="d-flex form-options ml-3">
    <div class="form-check">
      <input class="form-check-input option_mode" type="radio" name="option_value" id="quantity_mode" value="quantity_option" checked>
      <label class="form-check-label" for="quantity_mode">
        in kg
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input option_mode" type="radio" name="option_value" id="packets_mode" value="packets_option" >
      <label class="form-check-label" for="packets_mode">
        in Packets
      </label>
    </div>
  </div>
</div>

<!-- <div id="qaunt_div">
  <div class="row align-items-center">
    <label class="col-md-8 my-3"><strong>Quantity of waste generated (in kg)</strong></label>
    <div class="col-md-4">
      <input type="number" name="quantity" pattern="[0-9]" class="form-control form-control-line "  id="quantity" >
    </div>
  </div>
</div> -->

<div id="pckt_div">  
<label class="d-block my-3"><strong>Quantity of waste generated</strong></label>
<div class="col-md-12">
<!-- <input type="number" name="packets" pattern="[0-9]" class="form-control form-control-line "  id="packets" > -->
  <div class="row text-center">
    <div class="col-3 yellow py-1">
      Yellow
    </div>
    <div class="col-3 red1 py-1">
      Red
    </div>
    <div class="col-3 white py-1">
      White
    </div>
    <div class="col-3 blue py-1">
      Blue
    </div>
  </div>
  <div class="row">
    <div class="col-3">
      <input type="number"  name="yellow" pattern="[0-9]" class="form-control form-control-line "  id="yellow" min="0" oninput="validity.valid||(value='');">
    </div>
    <div class="col-3">
      <input type="number" name="red" pattern="[0-9]" class="form-control form-control-line "  id="red" min="0" oninput="validity.valid||(value='');">
    </div>
    <div class="col-3">
      <input type="number" name="white" pattern="[0-9]" class="form-control form-control-line "  id="white" min="0" oninput="validity.valid||(value='');">
    </div>
    <div class="col-3">
      <input type="number" name="blue" pattern="[0-9]" class="form-control form-control-line "  id="blue" min="0" oninput="validity.valid||(value='');">
    </div>
  </div>
  <div class="row">
    <label class="d-block my-3"><strong>Date of collection for disposal</strong><span style="color:red;">*</span></label>
    <div class="col-md-12">
      <input type="text" id="collected_date" name="collected_date"  placeholder="dd-mm-yy" class="form-control form-control-line datepicker" required>
    </div>
  </div>
</div>
</div>



</div>
<div class="modal-footer">
<!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
<button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
<button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Submit</button>
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

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function openCbnaatForm(id,quantity,packets,yellow,red,white,blue,c_date) {
//console.log("sample_ids", sample_ids.split(','));
$("#waste_id").val(id);


 $('#myModal').modal('toggle');
 $('#yellow').val(yellow).show();
 $('#red').val(red).show();
 $('#white').val(white).show();
 $('#blue').val(blue).show();

 if(c_date > 0 ){
    var jsDate = new Date(c_date*1000);
    var c_date = formatDate(jsDate.toDateString());  
    $("#collected_date").val(c_date);
  }else{
    $("#collected_date").val('');
  }

 
 //$("#collected_date").datepicker("setDate", new Date(collected_date)); 
 if(quantity==0){
  $('#quantity_mode').prop('checked', false);
  $('#packets_mode').prop('checked', true);

 }
 if(quantity==1){
  $('#quantity_mode').prop('checked', true);
  $('#packets_mode').prop('checked', false);

 }
 if(packets==0){
  $('#quantity_mode').prop('checked', true);
  $('#packets_mode').prop('checked', false);

 }

/*if(quantity==0 && yellow==0 && red==0 && white==0 && blue==0){
  $('#quantity_mode').prop('checked', true);
  $('#packets_mode').prop('checked', false);
  $('#pckt_div').hide();
  $('#qaunt_div').show();
}else if(quantity==0){

  $('#quantity_mode').prop('checked', false);
  $('#packets_mode').prop('checked', true);
  $('#quantity').hide();
  $('#qaunt_div').hide();
  $('#pckt_div').show();
  $('#yellow').val(yellow).show();
  $('#red').val(red).show();
  $('#white').val(white).show();
  $('#blue').val(blue).show();
  

}else if(quantity >= 1){
  //alert(quantity);
  $('#pckt_div').hide();
  $('#quantity_mode').prop('checked', true);
  $('#packets_mode').prop('checked', false);
  $('#quantity').val(quantity).show();
  $('#qaunt_div').show();
  
}
*/
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
title: 'LIMS_'+labname+'_'+labcity+'_BWM',
exportOptions: {
   columns: [  1, 2, 3,4,5,6 ]
}
}
],
columnDefs: [
    { orderable: false }
  ],
                    
        "order": [[ 1, "asc" ], [ 2, "desc" ]],
});
} );
</script>
<script>

$(document).ready(function(){
  //$("#pckt_div").hide();
 //$("#quantity").attr("required", "true");
  $(document).on('click','.option_mode', function() {
    
   /* if (this.value == 'quantity_option') {
       // alert("Q");
        console.log(this.value);
        $("#pckt_div").hide();
        $("#qaunt_div").show();
        $("#quantity").show();
        $("#quantity").attr("required", "true");

        $("#yellow").val('');
        $("#red").val('');
        $("#white").val('');
        $("#blue").val('');

        $("#yellow").removeAttr('required');
        $("#red").removeAttr('required');
        $("#white").removeAttr('required');
        $("#blue").removeAttr('required');
    }
    if (this.value == 'packets_option') {
       // alert("P");
        console.log(this.value);
        $("#qaunt_div").hide();
        $("#pckt_div").show();    
        $("#quantity").val(''); 

        $("#yellow").attr("required", "true");        
        $("#red").attr("required", "true");
        $("#white").attr("required", "true");
        $("#blue").attr("required", "true");

        $("#quantity").removeAttr('required');
     }*/
});


/*$("#quantity").keyup(function(){
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
*/

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
<style type="text/css">
  .yellow{background-color: #ffff00; color:#000;}
  .red1{background-color: #fb0001; color:#000;}
  .white{background-color: #fff; color:#000;}
  .blue{background-color: #01b0f1; color:#fff;}
</style>
@endsection
