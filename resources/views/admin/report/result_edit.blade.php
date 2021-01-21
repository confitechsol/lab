
@extends('admin.layout.app')
@section('content')

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Test Result Edit Report</h3>

                  </div>
              </div>
              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                <div class="card" >
                    <div class="card-block">
                      <form method="get" action="{{ url('/report/result_edit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                          <div class="col-sm-1">
                            From:
                          </div>
                          <div class="col-sm-11">
                            <input type="text" name="from_date" id="from_date" value="{{$data['from_date']}}" class="datepicker" max="<?php echo date("d-m-Y");?>" required>
                          </div>
                          <div class="col-sm-1">
                            To:
                          </div>
                          <div class="col-sm-11">
                            <input type="text" name="to_date" id="to_date" value="{{$data['to_date']}}" class="datepicker" max="<?php echo date("d-m-Y");?>" required>
                          </div>
                          <div class="col-sm-12">
                            <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class="row tab-content" style="display:block;">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 tab-pane active" id="tab1" role="tabpanel" aria-expanded="true">
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="table-scroll scroll-table-micro" >

                                    <table id="example1" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Sample ID</th>
                                              <th>Test Name</th>
                                              <th>Date of Change</th>
                                              <th>Previous Results</th>
                                              <th>Current Result</th>
                                              <th>User Id</th>
                                              <th>Reason for Edit</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)
                                                  <tr>
                                                    <td class="hide">{{$samples->id}}</td>
                                                    <td>{{$samples->sample}}</td>
                                                    <td>{{$samples->service}}</td>
                                                    <td>{{$samples->created}}</td>
                                                    <td>{{$samples->previous_result}}</td>
                                                    <td>{{$samples->updated_result}}</td>
                                                    <td>{{$samples->updatedBy}}</td>
                                                    <td>{{$samples->reason}}</td>
                                                  </tr>

                                          @endforeach
                                        @endif
                                      </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

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
           title: 'Test Result Edit Report',
           messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

       },
       {
           extend: 'pdfHtml5',
           title: 'Test Result Edit Report',
           messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val(),
           orientation: 'landscape',
           pageSize: 'LEGAL'

       }

  ],
  });
} );


</script>


@endsection
