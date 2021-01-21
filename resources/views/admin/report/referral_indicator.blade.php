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
                                      <form method="post" action="{{ url('/report/referral_indicator') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            From:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="from_date" value="{{$from_date}}" id="from_date" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-1">
                                            To:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="to_date" id="to_date" value="{{ $to_date }}" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
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
                                            <h6>Referral site wise report   </h6>
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
                                                        <th style="text-align: center!important; font-weight: 600;"><b>District </b></th>
                                                        <th style="text-align: center!important; font-weight: 600;"><b>TB unit </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Referral name </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" ><b>No. of samples received </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" ><b>No. of samples pending result</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>No. of samples declared result</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach($data as $value)
                                                      <tr>
                                                      <td>{{$value->name?$value->name:0}}</td>
                                                        <td>{{$value->TBUnitName?$value->TBUnitName:0}}</td>
                                                        <td>{{$value->DMC_PHI_Name?$value->DMC_PHI_Name:0}}</td>
                                                        <td>{{$value->received?$value->received:0}}</td>
                                                        <td>{{($value->received?$value->received:0)-($value->declared?$value->declared:0)}}</td>
                                                        <td>{{$value->declared?$value->declared:0}}</td>
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
                   title: 'Referral site wise report',
                   messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               },
               {
                   extend: 'pdfHtml5',
                   title: 'Referral site wise report',
                   messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               }
          ],
          });
        } );
        </script>
    @endsection