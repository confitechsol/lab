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
                                            <h6>CBNAAT Monthly Report   </h6>
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

                                                  <table class="tg" id="result">
                                                    <tr>
                                                      <th class="tg-031e">Sr.No</th>
                                                      <th class="tg-031e" colspan="2">Indicator</th>
                                                      <th class="tg-031e">Jan</th>
                                                      <th class="tg-031e">Feb</th>
                                                      <th class="tg-031e">March</th>
                                                      <th class="tg-031e">1Q17</th>
                                                      <th class="tg-031e">April</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">May</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">June</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">2Q17</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">July</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">Aug</th>
                                                      <th class="tg-031e">Remarks</th>
                                                      <th class="tg-031e">Sep</th>
                                                      <th>Remarks</th>
                                                      <th>3Q117</th>
                                                      <th>Oct</th>
                                                      <th>Remarks</th>
                                                      <th>Nov</th>
                                                      <th>Remarks</th>
                                                      <th>Dec</th>
                                                      <th>Remarks</th>
                                                      <th>4Q17</th>
                                                      <th>Total</th>
                                                    </tr>
                                                    <tr>
                                                      <td class="tg-031e" rowspan="3">1</td>
                                                      <td class="tg-031e" colspan="2">Total number of tests performed using CBNAAT (RNTCP and referalls from private sector)</td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_01?$data['cbnaat_total']->cbnaat_total_01:0}}</td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_02?$data['cbnaat_total']->cbnaat_total_02:0}}</td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_03?$data['cbnaat_total']->cbnaat_total_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_04?$data['cbnaat_total']->cbnaat_total_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_05?$data['cbnaat_total']->cbnaat_total_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_06?$data['cbnaat_total']->cbnaat_total_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_07?$data['cbnaat_total']->cbnaat_total_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_08?$data['cbnaat_total']->cbnaat_total_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['cbnaat_total']->cbnaat_total_09?$data['cbnaat_total']->cbnaat_total_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['cbnaat_total']->cbnaat_total_10?$data['cbnaat_total']->cbnaat_total_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['cbnaat_total']->cbnaat_total_11?$data['cbnaat_total']->cbnaat_total_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['cbnaat_total']->cbnaat_total_12?$data['cbnaat_total']->cbnaat_total_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="tg-031e" colspan="2">HIV +ve out of '1'</td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_01?$data['hiv_pos']->hiv_pos_01:0}}</td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_02?$data['hiv_pos']->hiv_pos_02:0}}</td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_03?$data['hiv_pos']->hiv_pos_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_04?$data['hiv_pos']->hiv_pos_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_05?$data['hiv_pos']->hiv_pos_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_06?$data['hiv_pos']->hiv_pos_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_07?$data['hiv_pos']->hiv_pos_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_08?$data['hiv_pos']->hiv_pos_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['hiv_pos']->hiv_pos_09?$data['hiv_pos']->hiv_pos_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['hiv_pos']->hiv_pos_10?$data['hiv_pos']->hiv_pos_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['hiv_pos']->hiv_pos_11?$data['hiv_pos']->hiv_pos_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['hiv_pos']->hiv_pos_12?$data['hiv_pos']->hiv_pos_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="tg-031e" colspan="2">Paediatric out of '1'</td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_01?$data['paediatric']->paediatric_01:0}}</td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_02?$data['paediatric']->paediatric_02:0}}</td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_03?$data['paediatric']->paediatric_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_04?$data['paediatric']->paediatric_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_05?$data['paediatric']->paediatric_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_06?$data['paediatric']->paediatric_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_07?$data['paediatric']->paediatric_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_08?$data['paediatric']->paediatric_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['paediatric']->paediatric_09?$data['paediatric']->paediatric_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['paediatric']->paediatric_10?$data['paediatric']->paediatric_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['paediatric']->paediatric_11?$data['paediatric']->paediatric_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['paediatric']->paediatric_12?$data['paediatric']->paediatric_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>2</td>
                                                      <td colspan="2">Total number of MTB not detected (MTB-)</td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_01?$data['mtb_not_detected']->mtb_not_detected_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_02?$data['mtb_not_detected']->mtb_not_detected_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_03?$data['mtb_not_detected']->mtb_not_detected_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_04?$data['mtb_not_detected']->mtb_not_detected_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_05?$data['mtb_not_detected']->mtb_not_detected_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_06?$data['mtb_not_detected']->mtb_not_detected_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_07?$data['mtb_not_detected']->mtb_not_detected_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_08?$data['mtb_not_detected']->mtb_not_detected_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_not_detected']->mtb_not_detected_09?$data['mtb_not_detected']->mtb_not_detected_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_not_detected']->mtb_not_detected_10?$data['mtb_not_detected']->mtb_not_detected_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_not_detected']->mtb_not_detected_11?$data['mtb_not_detected']->mtb_not_detected_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_not_detected']->mtb_not_detected_12?$data['mtb_not_detected']->mtb_not_detected_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td rowspan="3">3</td>
                                                      <td colspan="2">Total number of MTB detected and RIF sensitive (MTB+/Rif-)</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_01?$data['mtb_detected_rif_not']->mtb_detected_rif_not_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_02?$data['mtb_detected_rif_not']->mtb_detected_rif_not_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_03?$data['mtb_detected_rif_not']->mtb_detected_rif_not_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_04?$data['mtb_detected_rif_not']->mtb_detected_rif_not_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_05?$data['mtb_detected_rif_not']->mtb_detected_rif_not_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_06?$data['mtb_detected_rif_not']->mtb_detected_rif_not_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_07?$data['mtb_detected_rif_not']->mtb_detected_rif_not_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_08?$data['mtb_detected_rif_not']->mtb_detected_rif_not_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_09?$data['mtb_detected_rif_not']->mtb_detected_rif_not_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_10?$data['mtb_detected_rif_not']->mtb_detected_rif_not_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_11?$data['mtb_detected_rif_not']->mtb_detected_rif_not_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not']->mtb_detected_rif_not_12?$data['mtb_detected_rif_not']->mtb_detected_rif_not_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2">HIV +ve out of '3'</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_01?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_02?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_03?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_04?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_05?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_06?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_07?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_08?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_09?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_10?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_11?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_12?$data['mtb_detected_rif_not_hiv']->mtb_detected_rif_not_hiv_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2">Paediatric out of '3'</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_01?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_02?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_03?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_04?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_05?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_06?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_07?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_08?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_09?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_10?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_11?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_12?$data['mtb_detected_rif_not_paediatric']->mtb_detected_rif_not_paediatric_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td rowspan="3">4</td>
                                                      <td colspan="2">Total number of MTB detected and RIF resistant (MTB+/Rif+)</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_01?$data['mtb_rif_detected']->mtb_rif_detected_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_02?$data['mtb_rif_detected']->mtb_rif_detected_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_03?$data['mtb_rif_detected']->mtb_rif_detected_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_04?$data['mtb_rif_detected']->mtb_rif_detected_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_05?$data['mtb_rif_detected']->mtb_rif_detected_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_06?$data['mtb_rif_detected']->mtb_rif_detected_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_07?$data['mtb_rif_detected']->mtb_rif_detected_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_08?$data['mtb_rif_detected']->mtb_rif_detected_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected']->mtb_rif_detected_09?$data['mtb_rif_detected']->mtb_rif_detected_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected']->mtb_rif_detected_10?$data['mtb_rif_detected']->mtb_rif_detected_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected']->mtb_rif_detected_11?$data['mtb_rif_detected']->mtb_rif_detected_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected']->mtb_rif_detected_12?$data['mtb_rif_detected']->mtb_rif_detected_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2">HIV +ve out of '4'</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_01?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_02?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_03?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_04?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_05?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_06?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_07?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_08?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_09?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_10?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_11?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_12?$data['mtb_rif_detected_hiv']->mtb_rif_detected_hiv_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="2">Paediatric out of '4'</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_01?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_02?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_03?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_04?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_05?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_06?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_07?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_08?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_09?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_10?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_11?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_12?$data['mtb_rif_detected_paediatric']->mtb_rif_detected_paediatric_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>5</td>
                                                      <td colspan="2">Number of MTB Detected Rif Indeterminate (MTB+/Rif Indeterminate)</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_01?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_02?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_03?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_04?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_05?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_06?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_07?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_08?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_09?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_10?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_11?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_12?$data['mtb_rif_indeterminate']->mtb_rif_indeterminate_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>6</td>
                                                      <td colspan="2">Out of '5' number retested</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>7</td>
                                                      <td colspan="2">Number of MTB detected and RIF sensitive (MTB+/Rif-) from '5'</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_01?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_02?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_03?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_04?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_05?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_06?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_07?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_08?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_09?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_10?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_11?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_12?$data['mtb_rif_indeterminate_sens']->mtb_rif_indeterminate_sens_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>8</td>
                                                      <td colspan="2">Number of MTB detected and RIF resistant (MTB+/Rif+) from '5'</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_01?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_02?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_03?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_04?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_05?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_06?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_07?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_08?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_09?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_10?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_11?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_12?$data['mtb_rif_indeterminate_res']->mtb_rif_indeterminate_res_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>9</td>
                                                      <td colspan="2">Total number of errors</td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_01?$data['mtb_error']->mtb_error_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_02?$data['mtb_error']->mtb_error_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_03?$data['mtb_error']->mtb_error_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_04?$data['mtb_error']->mtb_error_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_05?$data['mtb_error']->mtb_error_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_06?$data['mtb_error']->mtb_error_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_07?$data['mtb_error']->mtb_error_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_08?$data['mtb_error']->mtb_error_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error']->mtb_error_09?$data['mtb_error']->mtb_error_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error']->mtb_error_10?$data['mtb_error']->mtb_error_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error']->mtb_error_11?$data['mtb_error']->mtb_error_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error']->mtb_error_12?$data['mtb_error']->mtb_error_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td rowspan="4">10</td>
                                                      <td rowspan="4">Out of '9' what is the number of "type of error codes"</td>
                                                      <td>2008 (sample too viscous)</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_01?$data['mtb_error_code_2008']->mtb_error_code_2008_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_02?$data['mtb_error_code_2008']->mtb_error_code_2008_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_03?$data['mtb_error_code_2008']->mtb_error_code_2008_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_04?$data['mtb_error_code_2008']->mtb_error_code_2008_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_05?$data['mtb_error_code_2008']->mtb_error_code_2008_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_06?$data['mtb_error_code_2008']->mtb_error_code_2008_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_07?$data['mtb_error_code_2008']->mtb_error_code_2008_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_08?$data['mtb_error_code_2008']->mtb_error_code_2008_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_2008']->mtb_error_code_2008_09?$data['mtb_error_code_2008']->mtb_error_code_2008_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_2008']->mtb_error_code_2008_10?$data['mtb_error_code_2008']->mtb_error_code_2008_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_2008']->mtb_error_code_2008_11?$data['mtb_error_code_2008']->mtb_error_code_2008_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_2008']->mtb_error_code_2008_12?$data['mtb_error_code_2008']->mtb_error_code_2008_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>5006, 5007, 5008 (probe check failure, incorrect volume of sample, viscous sample)</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_01?$data['mtb_error_code_5']->mtb_error_code_5_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_02?$data['mtb_error_code_5']->mtb_error_code_5_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_03?$data['mtb_error_code_5']->mtb_error_code_5_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_04?$data['mtb_error_code_5']->mtb_error_code_5_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_05?$data['mtb_error_code_5']->mtb_error_code_5_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_06?$data['mtb_error_code_5']->mtb_error_code_5_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_07?$data['mtb_error_code_5']->mtb_error_code_5_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_08?$data['mtb_error_code_5']->mtb_error_code_5_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_5']->mtb_error_code_5_09?$data['mtb_error_code_5']->mtb_error_code_5_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_5']->mtb_error_code_5_10?$data['mtb_error_code_5']->mtb_error_code_5_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_5']->mtb_error_code_5_11?$data['mtb_error_code_5']->mtb_error_code_5_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_5']->mtb_error_code_5_12?$data['mtb_error_code_5']->mtb_error_code_5_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>3074, 3075 (heater failure)</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_01?$data['mtb_error_code_3']->mtb_error_code_3_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_02?$data['mtb_error_code_3']->mtb_error_code_3_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_03?$data['mtb_error_code_3']->mtb_error_code_3_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_04?$data['mtb_error_code_3']->mtb_error_code_3_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_05?$data['mtb_error_code_3']->mtb_error_code_3_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_06?$data['mtb_error_code_3']->mtb_error_code_3_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_07?$data['mtb_error_code_3']->mtb_error_code_3_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_08?$data['mtb_error_code_3']->mtb_error_code_3_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_3']->mtb_error_code_3_09?$data['mtb_error_code_3']->mtb_error_code_3_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_3']->mtb_error_code_3_10?$data['mtb_error_code_3']->mtb_error_code_3_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_3']->mtb_error_code_3_11?$data['mtb_error_code_3']->mtb_error_code_3_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_3']->mtb_error_code_3_12?$data['mtb_error_code_3']->mtb_error_code_3_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>Other error codes</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_01?$data['mtb_error_code_others']->mtb_error_code_others_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_02?$data['mtb_error_code_others']->mtb_error_code_others_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_03?$data['mtb_error_code_others']->mtb_error_code_others_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_04?$data['mtb_error_code_others']->mtb_error_code_others_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_05?$data['mtb_error_code_others']->mtb_error_code_others_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_06?$data['mtb_error_code_others']->mtb_error_code_others_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_07?$data['mtb_error_code_others']->mtb_error_code_others_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_08?$data['mtb_error_code_others']->mtb_error_code_others_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_error_code_others']->mtb_error_code_others_09?$data['mtb_error_code_others']->mtb_error_code_others_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_others']->mtb_error_code_others_10?$data['mtb_error_code_others']->mtb_error_code_others_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_others']->mtb_error_code_others_11?$data['mtb_error_code_others']->mtb_error_code_others_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_error_code_others']->mtb_error_code_others_12?$data['mtb_error_code_others']->mtb_error_code_others_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>11</td>
                                                      <td colspan="2">Number of "invalid test" (internal control not amplified)</td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_01?$data['mtb_invalid']->mtb_invalid_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_02?$data['mtb_invalid']->mtb_invalid_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_03?$data['mtb_invalid']->mtb_invalid_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_04?$data['mtb_invalid']->mtb_invalid_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_05?$data['mtb_invalid']->mtb_invalid_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_06?$data['mtb_invalid']->mtb_invalid_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_07?$data['mtb_invalid']->mtb_invalid_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_08?$data['mtb_invalid']->mtb_invalid_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_invalid']->mtb_invalid_09?$data['mtb_invalid']->mtb_invalid_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_invalid']->mtb_invalid_10?$data['mtb_invalid']->mtb_invalid_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_invalid']->mtb_invalid_11?$data['mtb_invalid']->mtb_invalid_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_invalid']->mtb_invalid_12?$data['mtb_invalid']->mtb_invalid_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>12</td>
                                                      <td colspan="2">Number of "no results" (test stopped, electrical failure)</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>13</td>
                                                      <td colspan="2">Number retested out of indicator '9', '11' and '12'</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>14</td>
                                                      <td colspan="2">Number of MTB detected and RIF sensitive (MTB+/Rif-) from '13'</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>15</td>
                                                      <td colspan="2">Number of MTB detected and RIF resistant (MTB+/Rif+) from '13'</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>16</td>
                                                      <td colspan="2">New cases out of '4' sent for re-confirmation to RNTCP certified laboratory</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>17</td>
                                                      <td colspan="2">Out of '16',number of results received</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>18</td>
                                                      <td colspan="2">Total number of Smear +ve, CBNAAT MTB -ve</td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_01?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_02?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_03?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_04?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_05?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_06?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_07?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_08?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_09?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_10?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_11?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_12?$data['mtb_neg_microscopy_pos']->mtb_neg_microscopy_pos_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>19</td>
                                                      <td colspan="2">Total number of samples sent to RNTCP certified laboratory from '18'</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>20</td>
                                                      <td colspan="2">Out of '19' number of results received</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>21</td>
                                                      <td colspan="2">Total number of Smear-ve, CBNAAT MTB +ve</td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_01?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_01:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_02?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_02:0}}</td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_03?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_04?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_05?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_06?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_07?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_08?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_09?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_10?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_11?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_12?$data['mtb_pos_microscopy_neg']->mtb_pos_microscopy_neg_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>22</td>
                                                      <td colspan="2">New cases out of '21' sent for re-confirmation to RNTCP certified laboratory</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>23</td>
                                                      <td colspan="2">Out of '22' number of results received</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>24</td>
                                                      <td colspan="2">Out of '3' number put on First Line Treatment</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>25</td>
                                                      <td colspan="2">Out of '4' number put on Second Line Treatment</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>26</td>
                                                      <td colspan="2">Number of referrals from private sector</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_01?$data['referrals_ptivate_sec']->referrals_ptivate_sec_01:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_02?$data['referrals_ptivate_sec']->referrals_ptivate_sec_02:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_03?$data['referrals_ptivate_sec']->referrals_ptivate_sec_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_04?$data['referrals_ptivate_sec']->referrals_ptivate_sec_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_05?$data['referrals_ptivate_sec']->referrals_ptivate_sec_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_06?$data['referrals_ptivate_sec']->referrals_ptivate_sec_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_07?$data['referrals_ptivate_sec']->referrals_ptivate_sec_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_08?$data['referrals_ptivate_sec']->referrals_ptivate_sec_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_09?$data['referrals_ptivate_sec']->referrals_ptivate_sec_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_10?$data['referrals_ptivate_sec']->referrals_ptivate_sec_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_11?$data['referrals_ptivate_sec']->referrals_ptivate_sec_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec']->referrals_ptivate_sec_12?$data['referrals_ptivate_sec']->referrals_ptivate_sec_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>27</td>
                                                      <td colspan="2">Number of MTB detected and RIF sensitive (MTB+/Rif-) from '26'</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_01?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_01:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_02?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_02:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_03?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_04?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_05?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_06?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_07?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_08?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_09?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_10?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_11?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_12?$data['referrals_ptivate_sec_mtb_rif_not']->referrals_ptivate_sec_mtb_rif_not_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>28</td>
                                                      <td colspan="2">Number of MTB detected and RIF resistant (MTB+/Rif+) from '26'</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_01?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_01:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_02?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_02:0}}</td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_03?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_04?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_05?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_06?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_07?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_08?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_09?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_10?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_11?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_12?$data['referrals_ptivate_sec_mtb_rif_pos']->referrals_ptivate_sec_mtb_rif_pos_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>29</td>
                                                      <td colspan="2">New cases out of '28' sent for re-confirmation to RNTCP accredited laboratory</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>30</td>
                                                      <td colspan="2">Out of '29' number of results received</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>31</td>
                                                      <td>Number of EP-TB sample processed</td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_01?$data['ep_tb']->ep_tb_01:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_02?$data['ep_tb']->ep_tb_02:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_03?$data['ep_tb']->ep_tb_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_04?$data['ep_tb']->ep_tb_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_05?$data['ep_tb']->ep_tb_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_06?$data['ep_tb']->ep_tb_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_07?$data['ep_tb']->ep_tb_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_08?$data['ep_tb']->ep_tb_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb']->ep_tb_09?$data['ep_tb']->ep_tb_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb']->ep_tb_10?$data['ep_tb']->ep_tb_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb']->ep_tb_11?$data['ep_tb']->ep_tb_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb']->ep_tb_12?$data['ep_tb']->ep_tb_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>32</td>
                                                      <td colspan="2">Number of MTB detected and RIF sensitive (MTB+/Rif-) from '31'</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_01?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_01:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_02?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_02:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_03?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_04?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_05?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_06?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_07?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_08?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_09?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_10?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_11?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_12?$data['ep_tb_mtb_rif_neg']->ep_tb_mtb_rif_neg_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>33</td>
                                                      <td colspan="2">Number of MTB detected and RIF resistant (MTB+/Rif+) from '31'</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_01?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_01:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_02?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_02:0}}</td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_03?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_03:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_04?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_04:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_05?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_05:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_06?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_06:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_07?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_07:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_08?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_08:0}}</td>
                                                      <td class="tg-031e"></td>
                                                      <td class="tg-031e">{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_09?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_09:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_10?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_10:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_11?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_11:0}}</td>
                                                      <td></td>
                                                      <td>{{$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_12?$data['ep_tb_mtb_rif_pos']->ep_tb_mtb_rif_pos_12:0}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                    </tr>
                                                    <tr>
                                                      <td>34</td>
                                                      <td colspan="2">Total number of cartridges received in the facility</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
                                                    <tr>
                                                      <td>35</td>
                                                      <td colspan="2">Total number of cartridges in stock at month end</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                      <td>--</td>
                                                    </tr>
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
                    'excel', 'pdf'
                ]
            });
        } );
        </script>
    @endsection
