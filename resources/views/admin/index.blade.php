@extends('admin.layout.app')
@section('content')
<div class="page-wrapper">

<div class="container-fluid">

<div class="row">
<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
<div class="card" style="border: none;">
<div class="card-block">

<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
<div class="card" style="overflow-x: scroll;">
@role('equipment')

@if(Session::has('due_dates'))
@if(Session::get('due_dates'))
<div class="alert alert-danger" style="overflow-x: scroll;" id="alertdiv">Equipment Alert:<br>
<table style="width:100%">
  <thead>
      <tr>
        <th>Equipment Name</th>
        <th>Due date of Next Maintenance </th>
        <th>Due date of Next Calibration </th>
      </tr>
  </thead>
  <tbody>
    <?php //dd(Session::get('due_dates')); ?>

   <?php foreach(Session::get('due_dates') as $due_date): ?>

   <?php if($due_date->date_last_maintain <= Date('Y-m-d') && Date('Y-m-d') <= $due_date->due_date ||
    $due_date->date_last_caliberation < Date('Y-m-d') && Date('Y-m-d') <= $due_date->next_calibration) { ?>

    <tr style="background-color:#fbf498">
      <td><?php echo $due_date->name; ?></td>
      <td>{{date('d-m-Y', strtotime($due_date->due_date))}}</td>
      <td>{{date('d-m-Y', strtotime($due_date->next_calibration))}}</td>
   </tr>
 <?php }elseif(($due_date->date_last_maintain==Date('d-m-Y')) || ($due_date->date_last_caliberation==Date('d-m-Y'))){ ?>

   <tr style="background-color:#b2ff9a">
     <td><?php echo $due_date->name; ?></td>
     <td>{{date('d-m-Y', strtotime($due_date->due_date))}}</td>
     <td>{{date('d-m-Y', strtotime($due_date->next_calibration))}}</td>
  </tr>
<?php }elseif(($due_date->due_date<Date('Y-m-d')) || ($due_date->next_calibration<Date('Y-m-d'))){ ?>

   <tr style="background-color:#ffa4a4">
     <td> <?php echo $due_date->name; ?></td>
     <td>{{date('d-m-Y', strtotime($due_date->due_date))}}</td>
     <td>{{date('d-m-Y', strtotime($due_date->next_calibration))}}</td>
  </tr>
<?php } ?>
<?php endforeach; ?>
</tbody>
</table><br>
<button type="button" class="btn btn-danger btn-sm" onclick="removealert()">OK</button>
</div>
@endif
@endif
@endrole
<div class="card-block">
<h6>Current Year Statistics ({{$data['today']}})</h6>
<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


    <style>
    table, th, td {
        border: 1px solid black;
    }
    .card-block {
          width: inherit;
          overflow-x: auto;
      }
    </style>
    <table  style="width:100%; text-align: center!important;">
      <thead>
          <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">


            <th style="text-align: center!important; font-weight: 600;">Patients sample enrolled</th>
            {{--<th style="text-align: center!important; font-weight: 600;">Patients enrolled samples rejected</th>--}}
            <th style="text-align: center!important; font-weight: 600; ">Tests in processes</th>
            <th style="text-align: center!important; font-weight: 600;">Patient Samples for which results released</th>




          </tr>
      </thead>
      <tbody>
          <td>{{$data['total_samples']}}</td>
          {{--<td>{{$data['rejected']}}</td>--}}
          <td>{{$data['non_tested_samples']}}</td>
          <td>{{$data['tested_samples']}}</td>


    </tbody>
      </table>

</div>
</div>
</div>
</div>
<br>

<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12"  >
<div class="card" style="overflow-x: scroll;">
<div class="card-block">
<h6>Current Workload Section (Cumulative from {{$data['today']}})</h6>
<div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


    <style>
    table, th, td {
        border: 1px solid black;
    }
    </style>
    <table style="width:100%; text-align: center!important;">
      <thead>
          <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">

            <th style="text-align: center!important; font-weight: 600;"><b>Type of Test / Process</b></th>
            <!-- <th style="text-align: center!important; font-weight: 600;"><b>Tests performed</b></th> -->
            <th style="text-align: center!important; font-weight: 600;"><b>Tests pending</b></th>
            <!-- <th style="text-align: center!important; font-weight: 600;"><b>Tests submitted for review</b></th> -->
            <th style="text-align: center!important; font-weight: 600;"><b>Tests completed</b></th>

          </tr>
      </thead>
      <tbody>
        <?php  if(count($data['ret'])>0){ ?>
          @foreach ($data['ret'] as $key => $values)
		 
            <tr>

             <td>{{$values['sample']->name}}</td>
             <!-- <td>{{$values['sample']->cnt}}</td> -->
             <td>
              @if($values['test'])
                {{$values['test']->cnt}}
              @else
                0
              @endif

             </td>

             <!-- <td>
               @if($values['review'])
                  {{$values['review']->cnt}}
               @else
                 0
               @endif
             </td> -->
              <td>
               @if($values['result'])
                  {{$values['result']->cnt}}
               @else
                 0
               @endif
             </td>

           </tr>
		   
          @endforeach
		<?php  }else{ ?>
		 <tr><td colspan="3">No record found</td></tr>
		<?php } ?>
    </tbody>
      </table>

</div>

</div>
</div>
</div>



</div>
</div>
</div>

</div>


</div>

<footer class="footer">   </footer>

</div>
<script>
function removealert(){
$("#alertdiv").addClass("hide");
}

</script>
@endsection
