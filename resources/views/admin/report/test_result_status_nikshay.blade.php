@extends('admin.layout.app')
@section('content')
        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                <div class="card" >
                                    <div class="card-block">
                                     <form method="post" action="{{ url('/report/test_result_status_nikshay') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            From:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="from_date"  value="{{$data['from_date']}}" id="from_date" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
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
                                            <h6>Test Result Status - Nikshay   </h6>
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
                                                  {{-- Change done by Deepak and Vidhi --}}
                                                  <table style="width:100%; text-align: center!important;"  id="example1">
                                                    <thead>
                                                        <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Nikshay Id </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Test Date </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Patient </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Enrollment No</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Test</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Test Result</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach($data['status_data'] as $key=> $stat_data)
                                                      <tr>
                                                        <td>{{ $stat_data->nikshay_id }}</td>
                                                        <td>{{ $stat_data->test_date }}</td>
                                                        <td>{{ $stat_data->patient }}</td>
                                                        <td>{{ $stat_data->enrollment_no }}</td>
                                                        <td>{{ $stat_data->test }}</td>
                                                        <td>{{ $stat_data->test_result }}</td>
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

            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>

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
                   title: 'Test Result Status - Nikshay',
                   messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               },
               {
                   extend: 'pdfHtml5',
                   title: 'Test Result Status - Nikshay',
                   messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               }
          ],
          });
        } );
        </script>
    @endsection