<?php
$from_date = app('request')->input('from_date') ?? date("d-m-Y");
$to_date = app('request')->input('to_date') ?? date("d-m-Y");
?>

@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Equipment Down time analysis</h3>

                  </div>


              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                      <div class="card" >
                          <div class="card-block">
                            <form method="post" action="{{ url('/equipment/downtimeAnalysis') }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="row">
                                <div class="col-sm-1">
                                  From:
                                </div>
                                <div class="col-sm-11">
                                  <input type="date" name="from_date" value="{{ app('request')->input('from_date') }}" id="from_date" max="{{ date("Y-m-d") }}" required>
                                </div>

                                <div class="col-sm-1">
                                  To:
                                </div>
                                <div class="col-sm-11">
                                  <input type="date" name="to_date" value="{{ app('request')->input('to_date') }}" id="to_date" max="{{ date("Y-m-d") }}" required>
                                </div>
                                <div class="col-sm-12">
                                  <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Submit</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >

                                  <div class="table-scroll">
                                    <table id="example1" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th>Item Name (Equipment by category)</th>
                                            <th>Item Name (Equipment by name)</th>
                                            <th>1-7 Days</th>
                                            <th>8-14 Days</th>
                                            <th>15-30 Days</th>
                                            <th>> 30 Days</th>
                                            <th>Remarks </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($equipments as $equipment)
                                            <tr>
                                              <th>{{$equipment->name_cat}}</th>
                                              <th>{{$equipment->name}}</th>
                                              <th>
                                                @if($equipment->days>=1 && $equipment->days<=7)
                                                {{$equipment->days}}
                                                @endif
                                              </th>
                                              <th>
                                                @if($equipment->days>=8 && $equipment->days<=14)
                                                {{$equipment->days}}
                                                @endif
                                              </th>
                                              <th>
                                                @if($equipment->days>=15 && $equipment->days<=30)
                                                {{$equipment->days}}
                                                @endif
                                              </th>
                                              <th>
                                                @if($equipment->days>30)
                                                {{$equipment->days}}
                                                @endif
                                              </th>
                                              <th></th>
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
                <div class="col-12">

                    <a class="btn btn-warning" href="{{url('/equipment')}}">Back</a>

                </div>
            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
</div>



<script>

$(function(){

});
$(document).ready(function() {
    $('#example1').DataTable({
      searching: false,
      paging: false,
      ordering: false,
      dom: 'Bfrtip',
      buttons: [
         {
             extend: 'excelHtml5',
             title: 'Downtime Analysis',
             messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

         },
    ],
    });
} );
</script>






@endsection
