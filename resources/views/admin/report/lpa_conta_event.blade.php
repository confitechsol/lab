@extends('admin.layout.app')
@section('content')
<style type="text/css">
.frm{
  padding: 20px;
  margin: 60px;
}
.tab{
  padding: 10px;
  margin-top: 10px;
}
.table-bordered{
  border: cover;
border-width: 2px;
border-color: #ccccff;
}
.btn{ 
	margin-left:700px;	
    border-radius: 4px;
    background: #009efb;
    color: #ffffff;
}

</style>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
<div class="row page-titles">
                    <div class="align-self-center">
                        <h2 class="text-themecolor m-b-0 m-t-0" Style="margin-left:400px;">LPA Contamination Event Report</h2>

                    </div>

                </div>
                 <div class="flash-message">
       @foreach (['danger', 'warning', 'success', 'info'] as $msg)
         @if(Session::has('alert-' . $msg))

           <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
           </p>
         @endif
      @endforeach
  </div> 
  <div width="100%">
<form action="{{ url('/report/lpa_conta_event_submit') }}" method="post">
  {{csrf_field()}}
  <div class="form-group col-sm-12">
    
    <label class="col-sm-4"><b>Date of event</b></label>
    <input type="text" max="{{ date('Y-m-d')}}" name="date" class="form-control col-sm-6 datepicker"  placeholder="dd-mm-yy" required="required">
  </div>
 <div class="form-group col-sm-12">
    
    <label class="col-sm-4"><b>No. of samples in batch</b></label>
    <input type="number" name="batch" class="form-control col-md-6" placeholder=" Enter No. of samples in batch" required="required" max="100">
  </div>   
    
    <div class="form-group col-sm-12">
  <label for="LPA" class="col-sm-4"><b>Whether FLLPA/SLLPA/Both</b></label>
  <select class="form-control col-md-6" name="type" required="required">
    <option value="">Select Option</option>
    <option name="type" value="FLLPA">FLLPA</option>
    <option name="type" value="SLLPA">SLLPA</option>
    <option name="type" value="both">Both</option>
  </select>
</div>
    
   <div class="form-group col-sm-12">
    
    <label class="col-sm-4" width="200px"><b>Reasons for Contamination</b></label>
    <input type="text" name="reason" class="form-control col-md-6" placeholder=" Please Enter Reasons for Contamination" required="required">
  </div>
   <div class="form-group col-sm-12">
    
    <label class="col-sm-4"><b>Corrective action taken</b></label>
    <input type="text" maxlength="140" name="action" class="form-control col-md-6" placeholder=" Enter your action taken" required="required" max="140">
  </div>
   <div class="form-group col-sm-12">
    
    <label class="col-sm-4"><b>Restart date of LPA after event</b></label>
     <input type="text" name="date_after" max="{{ date('Y-m-d')}}" class="form-control col-sm-6 datepicker"  placeholder="dd-mm-yy" required="required">
  </div>
 
 <input type="submit" name="submit" value="Submit" class="btn">
</form>

</div>
</div>
	<div class="align-self-center">
	<h2 class="text-themecolor m-b-0 m-t-0" Style="margin-left:400px; margin-top:10px;">LPA Contamination Event Report</h2>
	</div>
<div class="container-fluid tab">
<div class="table-responsive">
    <table class="table table-bordered"  style="border:1px solid black;">
      <thead>
        <tr>
          
          <th style="border:1px solid black;text-align:center;"><b>Date of event</b></th>
          <th style="border:1px solid black;text-align:center;"><b>No. of samples in batch</b></th>
          <th style="border:1px solid black;text-align:center;"><b>Whether FLLPA/SLLPA/Both</b></th>
          <th style="border:1px solid black;text-align:center;"><b>Reasons for Contamination</b></th>
          <th style="border:1px solid black;text-align:center;"><b>Corrective action taken</b></th>
          <th style="border:1px solid black;text-align:center;"><b>Date of restart of LPA after event</b></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $value)
        <tr>  
          <td style="border:1px solid black;text-align:center;">{{$value->date_of_event}}</td>
          <td style="border:1px solid black;text-align:center;">{{$value->no_samples}}</td>
          <td style="border:1px solid black;text-align:center;">{{$value->type}}</td>
          <td style="border:1px solid black;text-align:center;">{{$value->contam_reason}}</td>
          <td style="border:1px solid black;text-align:center;">{{$value->action_taken}}</td>
          <td style="border:1px solid black;text-align:center;">{{$value->restart_date}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  </div>
</div>
@endsection