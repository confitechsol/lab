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
                                      <form method="post" action="{{ url('/report/performance_indicator') }}">
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
                                            <h6>Performance Indicator   </h6>
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
                                                  <table class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id ="example1" >
                                                    <thead>
                                                    <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">
                                                      <th class="tg-031e" rowspan="4">S.NO</th>
                                                      <th class="tg-yw4l" rowspan="4">Name of the Labs</th>                                                     
                                                      <th class="tg-yw4l" colspan="9" style="text-align: center!important;">LPA AND MDRTB DETECTED</th>
                                                      <th class="tg-yw4l" colspan="10" style="text-align: center!important;">SL-LPA AND XDRTB DETECTED</th>
                                                      <th class="tg-yw4l" colspan="17" style="text-align: center!important;">SL-LPA AND LCDST</th>
													  <th class="tg-yw4l" colspan="8" style="text-align: center!important;">SL  LIQUID DST </th>
                                                    </tr>
                                                    <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">
                                                      <td class="tg-yw4l" colspan="8">LPA(S or R)</td>
													  <td class="tg-yw4l" rowspan="3">MDRTB cases detected</td>
                                                      <td class="tg-yw4l" colspan="10">SL LPA (FQ &amp; / SLID)</td>
                                                      <td class="tg-yw4l" rowspan="3">Number of SL-LC DSTs conducted FOR (PRE/XDR BY SLLPA)</td>
													  <td class="tg-yw4l" colspan="2">FQ CLASS (RESISTANT/SENSITIVE BY SLLPA)</td>
													  <td class="tg-yw4l" colspan="2">MOX.(2) (LC DST)</td>
													  <td class="tg-yw4l" colspan="2">KAN (RESISTANT/SENSITIVE BY SLLPA)</td>
													  <td class="tg-yw4l" colspan="2">KAN ( LC DST)</td>													  
													  <td class="tg-yw4l" colspan="2">CAPREO (RESISTANT/SENSITIVEBY SL-LPA)</td>
													  <td class="tg-yw4l" colspan="2">CAPREO(LC DST)</td>
												      <td class="tg-yw4l" colspan="2">LZD (LC DST)</td>
													  <td class="tg-yw4l" colspan="2">Number of discordance between SLDST &  SL-LPA</td>
													  <td class="tg-yw4l" rowspan="3">Number of SL DSTs conducted</td>
													  <td class="tg-yw4l" rowspan="3">Total Susceptible to FQ &amp; SLID</td>
													  <td class="tg-yw4l" rowspan="3">Number of MDR + FQ  reistance detected</td>
													  <td class="tg-yw4l" rowspan="3">Number of MDR + SLI  resistance detected</td>
													  <td class="tg-yw4l" rowspan="3">Number of XDR detected</td>
													  <td class="tg-yw4l" rowspan="3">Number of MDR +   Mox (2) resistance dettected</td>
													  <td class="tg-yw4l" rowspan="3">DST Contaminated</td>
													  <td class="tg-yw4l" rowspan="3">Results awaited/ Ongoing</td>
                                                    </tr>
													 <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">
                                                      <td class="tg-yw4l" rowspan="2">Total subjected to LPA</td>
													  <td class="tg-yw4l" rowspan="2">Total susceptible</td>
                                                      <td class="tg-yw4l" colspan="3">Resistant</td>
                                                      <td class="tg-yw4l" rowspan="2">Invalid</td>
                                                      <td class="tg-yw4l" rowspan="2">MTBC Not Detected</td>
                                                      <td class="tg-yw4l" rowspan="2">Final results not available</td>
													  <td class="tg-yw4l" rowspan="2">Total subjected to SLPA</td>
                                                      <td class="tg-yw4l" rowspan="2">Total susceptible</td>
                                                      <td class="tg-yw4l" colspan="4">Resistant</td>
													  <td class="tg-yw4l" rowspan="2">Invalid</td>
                                                      <td class="tg-yw4l" rowspan="2">MTBC Not Detected</td>
                                                      <td class="tg-yw4l" rowspan="2">Final results not available</td>
													  <td class="tg-yw4l" rowspan="2">Total H resistant subjected to SL-LPA</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">R</td>
													  <td class="tg-yw4l" rowspan="2">S</td>
													  <td class="tg-yw4l" rowspan="2">FQ</td>
													  <td class="tg-yw4l" rowspan="2">SLID</td>
                                                    </tr>
                                                    <tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">
                                                      <!--<td class="tg-yw4l">Diagnostic Sputum SPECIMENS inoculated</td>
                                                      <td class="tg-yw4l">Follow-Up SPECIMENS inoculated</td>-->
                                                      <td class="tg-yw4l">HR</td>
                                                      <td class="tg-yw4l">R</td>
                                                      <td class="tg-yw4l">H</td>
                                                      
													  <td class="tg-yw4l">FQ+SLID</td>
                                                      <td class="tg-yw4l">FQ</td>
													  <td class="tg-yw4l">SLID</td>
                                                      <td class="tg-yw4l">Mono low level KAN</td>
                                                     
                                                    </tr>
                                                  </thead>

                                                  <tbody>
												    @foreach ($data['performance_data'] as $key=> $per_data)
                                                    <tr>
                                                      <td class="tg-031e">{{ $per_data->v_slno }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_lab_name }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_colc }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_cold }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_cole }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_colf }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_colg }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_colh }}</td>
                                                      <td class="tg-yw4l">{{ $per_data->v_coli }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colj }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colk }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_coll }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colm }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_coln }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colo }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colp }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colq }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colr }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_cols }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colt }}</td>
                                                      <td class="tg-031e">{{ $per_data->v_colu }}</td>													  
													  <td class="tg-031e">{{ $per_data->v_colv }}</td>
													  <td class="tg-031e">{{ $per_data->v_colw }}</td>
													  <td class="tg-031e">{{ $per_data->v_colx }}</td>
													  <td class="tg-031e">{{ $per_data->v_coly }}</td>
													  <td class="tg-031e">{{ $per_data->v_colz }}</td>
													  <td class="tg-031e">{{ $per_data->v_colaa }}</td>
													  <td class="tg-031e">{{ $per_data->v_colab }}</td>
													  <td class="tg-031e">{{ $per_data->v_colac }}</td>
													  <td class="tg-031e">{{ $per_data->v_colad }}</td>
													  <td class="tg-031e">{{ $per_data->v_colae }}</td>
													  <td class="tg-031e">{{ $per_data->v_colaf }}</td>
													  <td class="tg-031e">{{ $per_data->v_colag }}</td>
													  <td class="tg-031e">{{ $per_data->v_colah }}</td>
													  <td class="tg-031e">{{ $per_data->v_colai }}</td>
													  <td class="tg-031e">{{ $per_data->v_colaj }}</td>
													  <td class="tg-031e">{{ $per_data->v_colak }}</td>
													  <td class="tg-031e">{{ $per_data->v_colal }}</td>
													  <td class="tg-031e">{{ $per_data->v_colam }}</td>
													  <td class="tg-031e">{{ $per_data->v_colan }}</td>
													  <td class="tg-031e">{{ $per_data->v_colao }}</td>
													  <td class="tg-031e">{{ $per_data->v_colap }}</td>
													  <td class="tg-031e">{{ $per_data->v_colaq }}</td>
													  <td class="tg-031e">{{ $per_data->v_colar }}</td>
													  <td class="tg-031e">{{ $per_data->v_colas }}</td>
													  <td class="tg-031e">{{ $per_data->v_colat }}</td>
													  
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
                     title: 'Performance Indicator',
                     messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

                 }/*,
                 {
                     extend: 'pdfHtml5',
                     title: 'Performance Indicator',
                      messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

                 }*/
            ],
            });
        } );
        </script>
    @endsection
