@extends('admin.layout.app')
@section('content')
<!-- <link href="{{ url('https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ url('https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js') }}"></script> -->
        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                <div class="card" >
                                    <div class="card-block">
                                      <form method="post" action="{{ url('/report/quality_indicator') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                          <div class="col-sm-1">
                                            From:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="from_date" id="from_date" value="{{$data['from_date']}}" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-1">
                                            To:
                                          </div>
                                          <div class="col-sm-11">
                                            <input type="text" name="to_date" id="to_date" value="{{$data['to_date']}}" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                          </div>
                                          <div class="col-sm-12">
                                            <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Submit</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                 <!----Quality Indicator test wise Liquid Culture Start---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Quality Indicator test wise Liquid Culture</h6>
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
                                                    <table class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;"  id="lc_culture">
														<thead>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">
															  <th class="tg-yw4l"><b></b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="6"><b>Liquid Culture Result</b></th>
															</tr>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">
																<td class="tg-yw4l"></td>
																<td class="tg-yw4l" style="text-align: center!important;">Positive</td>
																<td class="tg-yw4l" style="text-align: center!important;">Negative</td>
																<td class="tg-yw4l" style="text-align: center!important;">Contaminated</td>
																<td class="tg-yw4l" style="text-align: center!important;">NTM</td>
																<td class="tg-yw4l" style="text-align: center!important;">Others</td>
																<td class="tg-yw4l" style="text-align: center!important;">Total</td>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lc_result'] as $key=> $lc_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lc_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->Positive}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->Negative}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->Contaminated}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->NTM}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->Others}}</td>
															   <td class="tg-yw4l">{{ $lc_rslt->Total}}</td>
															 </tr>
															 @endforeach
														</tbody>
                                                    </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								<!----Quality Indicator test wise Liquid Culture End---->
								
								<!----Quality Indicator test wise Solid Start---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
										    <h6>Quality Indicator test wise Solid Culture</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id="solid_culture">
                                                   <thead>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">
															  <th class="tg-yw4l"><b></b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="6"><b>Solid Culture Result</b></th>
															</tr>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">
																<td class="tg-yw4l"></td>
																<td class="tg-yw4l" style="text-align: center!important;">Positive</td>
																<td class="tg-yw4l" style="text-align: center!important;">Negative</td>
																<td class="tg-yw4l" style="text-align: center!important;">Contaminated</td>
																<td class="tg-yw4l" style="text-align: center!important;">NTM</td>
																<td class="tg-yw4l" style="text-align: center!important;">Others</td>
																<td class="tg-yw4l" style="text-align: center!important;">Total</td>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lj_result'] as $key=> $lj_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lj_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->Positive}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->Negative}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->Contaminated}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->NTM}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->Others}}</td>
															   <td class="tg-yw4l">{{ $lj_rslt->Total}}</td>
															 </tr>
															 @endforeach
														</tbody>
                                                    </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!----Quality Indicator test wise Solid Culture End---->
								
								
								<!----Quality Indicator test wise LPA FLD START---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Quality Indicator test wise LPA FLD</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id="lpa_fld" >
                                                        <thead>															
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">																
																<th class="tg-yw4l" style="text-align: center!important;">Total LPA FLD Done</th>
																<th class="tg-yw4l" style="text-align: center!important;">Total</th>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lpafld_result'] as $key=> $lpa_fld_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lpa_fld_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lpa_fld_rslt->Count}}</td>															 
															  </tr>
															 @endforeach
														</tbody>
                                                    </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								<!----Quality Indicator test wise LPA FLD END---->
								
								
								<!----Quality Indicator test wise LPA SLD START---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Quality Indicator test wise LPA SLD</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id="lpa_sld">
                                                        <thead>															
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">																
																<th class="tg-yw4l" style="text-align: center!important;">Total LPA SLD Done</th>
																<th class="tg-yw4l" style="text-align: center!important;">Total</th>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lpasld_result'] as $key=> $lpa_sld_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lpa_sld_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lpa_sld_rslt->Count}}</td>															 
															  </tr>
															 @endforeach
														</tbody>
                                                    </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								<!----Quality Indicator test wise LPA SLD END---->
								
								
								<!----Quality Indicator test wise LC DST START---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                             <h6>Quality Indicator test wise LC DST</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table  class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id="lcdstfld">
                                                        <thead>															
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">																
																<th class="tg-yw4l" style="text-align: center!important;">Workload</th>
																<th class="tg-yw4l" style="text-align: center!important;">Count</th>
																<th class="tg-yw4l" style="text-align: center!important;">%</th>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lcdst_result'] as $key=> $lcdst_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lcdst_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lcdst_rslt->Count}}</td>
                                                               <td class="tg-yw4l">{{ is_null($lcdst_rslt->Percentage)?'0.00':$lcdst_rslt->Percentage}}</td>															   
															  </tr>
															 @endforeach
														</tbody>
                                                  </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								<!----Quality Indicator test wise LC DST END---->
								
								
								<!----Quality Indicator test wise LJ DST START---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Quality Indicator test wise LJ DST</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table  class="tg"  style="width:100%; text-align: center!important; overflow-x:auto;" id="lj_dst_fld">
                                                        <thead>															
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">																
																<th class="tg-yw4l" style="text-align: center!important;">Workload</th>
																<th class="tg-yw4l" style="text-align: center!important;">Count</th>
																<th class="tg-yw4l" style="text-align: center!important;">Count</th>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['lcdst_result'] as $key=> $lcdst_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $lcdst_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $lcdst_rslt->Count}}</td>
                                                               <td class="tg-yw4l">{{ is_null($lcdst_rslt->Percentage)?'0.00':$lcdst_rslt->Percentage }}</td>															   
															  </tr>
															 @endforeach
														</tbody>
                                                  </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								<!----Quality Indicator test wise LJ DST END---->
								
							
								
								<!----Quality Indicator test wise CBNAAT INDICATOR START---->
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>Quality Indicator test wise CBNAAT Indicator</h6>
                                            <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                                  <style>
                                                  table, th, td {
                                                      border: 1px solid black;
                                                  }
                                                  </style>
                                                  <table style="width:100%; text-align: center!important;" id="cbnaat_indicator">
                                                       <thead>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">															  
															  <th class="tg-yw4l" style="text-align: center!important;"><b>Sample type</b></th>
															  <th class="tg-yw4l"><b></b></th>
															  <th class="tg-yw4l"><b></b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="2"><b>Mtb detected, Rif detected</b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="2"><b>Mtb detected, Rif Not detected</b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="2"><b>Mtb Not detected</b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="2"><b>Invalid</b></th>
															  <th class="tg-yw4l" style="text-align: center!important;" colspan="2"><b>Indeterminate</b></th>
															</tr>
															<tr style="text-align: center!important; font-weight: 600;color: #6495ed;">
																<td class="tg-yw4l"></td>
																<td class="tg-yw4l" style="text-align: center!important;">total no of sample received</td>
																<td class="tg-yw4l" style="text-align: center!important;">total no of sample processed </td>
																<td class="tg-yw4l" style="text-align: center!important;">No</td>
																<td class="tg-yw4l" style="text-align: center!important;">%</td>
																<td class="tg-yw4l" style="text-align: center!important;">No</td>
																<td class="tg-yw4l" style="text-align: center!important;">%</td>
																<td class="tg-yw4l" style="text-align: center!important;">No</td>
																<td class="tg-yw4l" style="text-align: center!important;">%</td>
																<td class="tg-yw4l" style="text-align: center!important;">No</td>
																<td class="tg-yw4l" style="text-align: center!important;">%</td>
																<td class="tg-yw4l" style="text-align: center!important;">No</td>
																<td class="tg-yw4l" style="text-align: center!important;">%</td>
															</tr>
														</thead>
														<tbody>															 
															 @foreach ($data['cbnaat_indicator_result'] as $key=> $cbnaat_rslt)
															  <tr>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->Head}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->total_sample_received}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->total_sample_processed}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->mtbyes_rifyes_count}}</td>
															   <td class="tg-yw4l">{{ is_null($cbnaat_rslt->mtbyes_rifyes_percentage)?'0.00':$cbnaat_rslt->mtbyes_rifyes_percentage}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->mtbyes_rifno_count}}</td>
															   <td class="tg-yw4l">{{ is_null($cbnaat_rslt->mtbyes_rifno_percentage)?'0.00':$cbnaat_rslt->mtbyes_rifno_percentage}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->mtbno_count}}</td>
															   <td class="tg-yw4l">{{ is_null($cbnaat_rslt->mtbno_percentage)?'0.00':$cbnaat_rslt->mtbno_percentage}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->invalid_count}}</td>
															   <td class="tg-yw4l">{{ is_null($cbnaat_rslt->invalis_percentage)?'0.00':$cbnaat_rslt->invalis_percentage}}</td>
															   <td class="tg-yw4l">{{ $cbnaat_rslt->indeterminate_count}}</td>
															   <td class="tg-yw4l">{{ is_null($cbnaat_rslt->indeterminate_percentage)?'0.00':$cbnaat_rslt->indeterminate_percentage }}</td>															   
															 </tr>
															 @endforeach
														</tbody> 
                                                   </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
								
								<!----Quality Indicator test wise CBNAAT INDICATOR END---->

                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>

        </div>
        <script>
        $(function() {
          $('#lc_culture').DataTable({
            searching: false,
            paging: false,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
               {
                   extend: 'excelHtml5',
                   title: 'Quality Indicator test wise',
                   messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               },
               {
                   extend: 'pdfHtml5',
                   title: 'Quality Indicator test wise',
                    messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

               }
          ],
          });



        } );
        </script>
        <script src="{{ url('/js/solid_culture.js') }}"></script>
        <script src="{{ url('/js/lpa_fld.js') }}"></script>
        <script src="{{ url('/js/lpa_sld.js') }}"></script>
        <script src="{{ url('/js/cbnaat_indicator.js') }}"></script>
        <script src="{{ url('/js/lj_dst_sld.js') }}"></script>
        <script src="{{ url('/js/lj_dst_fld.js') }}"></script>
        <script src="{{ url('/js/lc_dst_sld.js') }}"></script>
        <script src="{{ url('/js/lc_dst_fld.js') }}"></script>

    @endsection
