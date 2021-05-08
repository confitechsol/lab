@extends('admin.layout.app')
@section('content')
<link href="{{ url('https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ url('https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js') }}"></script>
        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                <div class="card" >
                                    <div class="card-block">
                                      <form method="post" action="{{ url('/report/lqcIndicator_tat') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            From:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="from_date" value="{{$data['from_date']}}"  id="from_date" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-1">
                                            To:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="to_date" id="to_date" value="{{ $data['to_date'] }}" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-12">
                                            <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Submit</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Lab QC indicator Turn Around Time    </h6>
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
                                                    <table style="width:100%; text-align: center!important;" id="example1">
														<thead>
															<tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">

															  <th style="text-align: center!important; font-weight: 600;"><b></b></th>
															  <th style="text-align: center!important; font-weight: 600;"><b>TAT in guidelines (In days)</b></th>
															  <th style="text-align: center!important; font-weight: 600;"><b>Total No of Test</b></th>
															  <th style="text-align: center!important; font-weight: 600;"><b>Total No of Test in TAT</b></th>
															  <th style="text-align: center!important; font-weight: 600;"><b>With in TAT(%)</b></th>

															</tr>
														</thead>
														<tbody>
															@foreach($data['qc_indicator_tat_data'] as $key=> $ind_indi_data)
															<tr>
																<td>{{ $ind_indi_data->tindicator_text }}</td>
																<td>{{ $ind_indi_data->tat_in_days }}</td>
																<td>{{ $ind_indi_data->total_test }}</td>
																<td>{{ $ind_indi_data->total_test_in_tat }}</td>
																<td>{{ $ind_indi_data->total_test_in_tat_perc }}</td>
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

                </div>


            </div>

            <footer class="footer">  </footer>

        </div>
        <script>
        $(document).ready(function() {
            $('#example1').DataTable({
              searching: false,
              paging: false,
              ordering: false,
              dom: 'Bfrtip',
              buttons: [
                 {
                     extend: 'excelHtml5',
                     title: 'Lab QC indicator Turn Around Time',
                     messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

                 },
                 {
                     extend: 'pdfHtml5',
                     title: 'Lab QC indicator Turn Around Time',
                      messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

                 }
            ],
            });
        } );
        </script>
    @endsection
