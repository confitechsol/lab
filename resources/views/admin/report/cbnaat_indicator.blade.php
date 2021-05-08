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
                              <!-- <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                <div class="card" >
                                    <div class="card-block">
                                      <form method="post" action="{{ url('/cbnaat_indicator') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        From: <input type="date" name="from_date" required> To: <input type="date" name="to_date" required> <button type="submit" class="btn-info">Submit</button>
                                      </form>
                                    </div>
                                  </div>
                                </div> -->

                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                                    <div class="card" >
                                        <div class="card-block">
                                            <h6>CBNAAT report   </h6>
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

                                                          <th style="text-align: center!important; font-weight: 600;"><b>Sample type </b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" colspan="2"><b>Mtb detected, Rif detected</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" colspan="2"><b>Mtb detected ,Rif Not detected</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" colspan="2"><b>Mtb Not detected</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" colspan="2"><b>Invalid</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;" colspan="2"><b>Indeterminate</b></th>
                                                          <th style="text-align: center!important; font-weight: 600;"><b>Denominator</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td></td>
                                                        <td>No</td>
                                                        <td>%</td>
                                                        <td>No</td>
                                                        <td>%</td>
                                                        <td>No</td>
                                                        <td>%</td>
                                                        <td>No</td>
                                                        <td>%</td>
                                                        <td>No</td>
                                                        <td>%</td>
                                                        <td>No of each <br />sample type <br />received </td>

                                                      </tr>
                                                          <tr>
                                                            <td>Sputum</td>
                                                            <td>{{$data['cbn_sputum']->mtb_ref_det?$data['cbn_sputum']->mtb_ref_det:0}}</td>
                                                            <td>{{number_format($data['cbn_sputum']->mtb_ref_det/$data['cbn_sputum']->total*100, 2, '.', ',')}}</td>
                                                            <td>{{$data['cbn_sputum']->mtb_det_ref_ndet?$data['cbn_sputum']->mtb_det_ref_ndet:0}}</td>
                                                            <td>{{number_format($data['cbn_sputum']->mtb_det_ref_ndet/$data['cbn_sputum']->total*100, 2, '.', ',')}}</td>
                                                            <td>{{$data['cbn_sputum']->mtb_ndet?$data['cbn_sputum']->mtb_ndet:0}}</td>
                                                            <td>{{number_format($data['cbn_sputum']->mtb_ndet/$data['cbn_sputum']->total*100, 2, '.', ',')}}</td>
                                                            <td>{{$data['cbn_sputum']->mtb_invalid?$data['cbn_sputum']->mtb_invalid:0}}</td>
                                                            <td>{{number_format($data['cbn_sputum']->mtb_invalid/$data['cbn_sputum']->total*100, 2, '.', ',')}}</td>
                                                            <td>{{$data['cbn_sputum']->rif_indeterminate?$data['cbn_sputum']->rif_indeterminate:0}}</td>
                                                            <td>{{number_format($data['cbn_sputum']->rif_indeterminate/$data['cbn_sputum']->total*100, 2, '.', ',')}}</td>
                                                            <td>No of each <br />sample type <br />received </td>

                                                          </tr>
                                                          <tr>
                                                           <td>CSF</td>
                                                           <td>{{$data['cbn_csf']->mtb_ref_det?$data['cbn_csf']->mtb_ref_det:0}}</td>
                                                           <td>{{$data['cbn_csf']->total?number_format($data['cbn_csf']->mtb_ref_det/$data['cbn_csf']->total*100, 2, '.', ','):0}}</td>
                                                           <td>{{$data['cbn_csf']->mtb_det_ref_ndet?$data['cbn_csf']->mtb_det_ref_ndet:0.00}}</td>
                                                           <td>{{$data['cbn_csf']->total?number_format($data['cbn_csf']->mtb_det_ref_ndet/$data['cbn_csf']->total*100, 2, '.', ','):0.00}}</td>
                                                           <td>{{$data['cbn_csf']->mtb_ndet?$data['cbn_csf']->mtb_ndet:0}}</td>
                                                           <td>{{$data['cbn_csf']->total?number_format($data['cbn_csf']->mtb_ndet/$data['cbn_csf']->total*100, 2, '.', ','):0.00}}</td>
                                                           <td>{{$data['cbn_csf']->mtb_invalid?$data['cbn_csf']->mtb_invalid:0}}</td>
                                                           <td>{{$data['cbn_csf']->total?number_format($data['cbn_csf']->mtb_invalid/$data['cbn_csf']->total*100, 2, '.', ','):0.00}}</td>
                                                           <td>{{$data['cbn_csf']->rif_indeterminate?$data['cbn_csf']->rif_indeterminate:0}}</td>
                                                           <td>{{$data['cbn_csf']->total?number_format($data['cbn_csf']->rif_indeterminate/$data['cbn_csf']->total*100, 2, '.', ','):0.00}}</td>
                                                           <td>No of each <br />sample type <br />received </td>

                                                         </tr>
                                                         <tr>
                                                          <td>GA</td>
                                                          <td>{{$data['cbn_ga']->mtb_ref_det?$data['cbn_ga']->mtb_ref_det:0}}</td>
                                                          <td>{{$data['cbn_ga']->total?number_format($data['cbn_ga']->mtb_ref_det/$data['cbn_ga']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_ga']->mtb_det_ref_ndet?$data['cbn_ga']->mtb_det_ref_ndet:0}}</td>
                                                          <td>{{$data['cbn_ga']->total?number_format($data['cbn_ga']->mtb_det_ref_ndet/$data['cbn_ga']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_ga']->mtb_ndet?$data['cbn_ga']->mtb_ndet:0}}</td>
                                                          <td>{{$data['cbn_ga']->total?number_format($data['cbn_ga']->mtb_ndet/$data['cbn_ga']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_ga']->mtb_invalid?$data['cbn_ga']->mtb_invalid:0}}</td>
                                                          <td>{{$data['cbn_ga']->total?number_format($data['cbn_ga']->mtb_invalid/$data['cbn_ga']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_ga']->rif_indeterminate?$data['cbn_ga']->rif_indeterminate:0}}</td>
                                                          <td>{{$data['cbn_ga']->total?number_format($data['cbn_ga']->rif_indeterminate/$data['cbn_ga']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>No of each <br />sample type <br />received </td>

                                                        </tr>
                                                        <tr>
                                                          <td>PUS</td>
                                                          <td>{{$data['cbn_pus']->mtb_ref_det?$data['cbn_pus']->mtb_ref_det:0}}</td>
                                                          <td>{{$data['cbn_pus']->total?number_format($data['cbn_pus']->mtb_ref_det/$data['cbn_pus']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_pus']->mtb_det_ref_ndet?$data['cbn_pus']->mtb_det_ref_ndet:0}}</td>
                                                          <td>{{$data['cbn_pus']->total?number_format($data['cbn_pus']->mtb_det_ref_ndet/$data['cbn_pus']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_pus']->mtb_ndet?$data['cbn_pus']->mtb_ndet:0}}</td>
                                                          <td>{{$data['cbn_pus']->total?number_format($data['cbn_pus']->mtb_ndet/$data['cbn_pus']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_pus']->mtb_invalid?$data['cbn_pus']->mtb_invalid:0}}</td>
                                                          <td>{{$data['cbn_pus']->total?number_format($data['cbn_pus']->mtb_invalid/$data['cbn_pus']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>{{$data['cbn_pus']->rif_indeterminate?$data['cbn_pus']->rif_indeterminate:0}}</td>
                                                          <td>{{$data['cbn_pus']->total?number_format($data['cbn_pus']->rif_indeterminate/$data['cbn_pus']->total*100, 2, '.', ','):0.00}}</td>
                                                          <td>No of each <br />sample type <br />received </td>

                                                        </tr>
                                                        <tr>
                                                         <td>BAL</td>
                                                         <td>{{$data['cbn_bal']->mtb_ref_det?$data['cbn_bal']->mtb_ref_det:0}}</td>
                                                         <td>{{$data['cbn_bal']->total?number_format($data['cbn_bal']->mtb_ref_det/$data['cbn_bal']->total*100, 2, '.', ','):0.00}}</td>
                                                         <td>{{$data['cbn_bal']->mtb_det_ref_ndet?$data['cbn_bal']->mtb_det_ref_ndet:0}}</td>
                                                         <td>{{$data['cbn_bal']->total?number_format($data['cbn_bal']->mtb_det_ref_ndet/$data['cbn_bal']->total*100, 2, '.', ','):0.00}}</td>
                                                         <td>{{$data['cbn_bal']->mtb_ndet?$data['cbn_bal']->mtb_ndet:0}}</td>
                                                         <td>{{$data['cbn_bal']->total?number_format($data['cbn_bal']->mtb_ndet/$data['cbn_bal']->total*100, 2, '.', ','):0.00}}</td>
                                                         <td>{{$data['cbn_bal']->mtb_invalid?$data['cbn_bal']->mtb_invalid:0}}</td>
                                                         <td>{{$data['cbn_bal']->total?number_format($data['cbn_bal']->mtb_invalid/$data['cbn_bal']->total*100, 2, '.', ','):0.00}}</td>
                                                         <td>{{$data['cbn_bal']->rif_indeterminate?$data['cbn_bal']->rif_indeterminate:0}}</td>
                                                         <td>{{$data['cbn_bal']->total?number_format($data['cbn_bal']->rif_indeterminate/$data['cbn_bal']->total*100, 2, '.', ','):0.00}}</td>
                                                         <td>No of each <br />sample type <br />received </td>

                                                       </tr>
                                                       <tr>
                                                        <td>PF</td>
                                                        <td>{{$data['cbn_pf']->mtb_ref_det?$data['cbn_pf']->mtb_ref_det:0}}</td>
                                                        <td>{{$data['cbn_pf']->total?number_format($data['cbn_pf']->mtb_ref_det/$data['cbn_pf']->total*100, 2, '.', ','):0.00}}</td>
                                                        <td>{{$data['cbn_pf']->mtb_det_ref_ndet?$data['cbn_pf']->mtb_det_ref_ndet:0}}</td>
                                                        <td>{{$data['cbn_pf']->total?number_format($data['cbn_pf']->mtb_det_ref_ndet/$data['cbn_pf']->total*100, 2, '.', ','):0.00}}</td>
                                                        <td>{{$data['cbn_pf']->mtb_ndet?$data['cbn_pf']->mtb_ndet:0}}</td>
                                                        <td>{{$data['cbn_pf']->total?number_format($data['cbn_pf']->mtb_ndet/$data['cbn_pf']->total*100, 2, '.', ','):0.00}}</td>
                                                        <td>{{$data['cbn_pf']->mtb_invalid?$data['cbn_pf']->mtb_invalid:0}}</td>
                                                        <td>{{$data['cbn_pf']->total?number_format($data['cbn_pf']->mtb_invalid/$data['cbn_pf']->total*100, 2, '.', ','):0.00}}</td>
                                                        <td>{{$data['cbn_pf']->rif_indeterminate?$data['cbn_pf']->rif_indeterminate:0}}</td>
                                                        <td>{{$data['cbn_pf']->total?number_format($data['cbn_pf']->rif_indeterminate/$data['cbn_pf']->total*100, 2, '.', ','):0.00}}</td>
                                                        <td>No of each <br />sample type <br />received </td>

                                                      </tr>
                                                      <tr>
                                                       <td>HIV positive (All sample type)</td>
                                                       <td>{{$data['cbn_hiv']->mtb_ref_det?$data['cbn_hiv']->mtb_ref_det:0}}</td>
                                                       <td>{{$data['cbn_hiv']->total?number_format($data['cbn_hiv']->mtb_ref_det/$data['cbn_hiv']->total*100, 2, '.', ','):0.00}}</td>
                                                       <td>{{$data['cbn_hiv']->mtb_det_ref_ndet?$data['cbn_hiv']->mtb_det_ref_ndet:0}}</td>
                                                       <td>{{$data['cbn_hiv']->total?number_format($data['cbn_hiv']->mtb_det_ref_ndet/$data['cbn_hiv']->total*100, 2, '.', ','):0.00}}</td>
                                                       <td>{{$data['cbn_hiv']->mtb_ndet?$data['cbn_hiv']->mtb_ndet:0}}</td>
                                                       <td>{{$data['cbn_hiv']->total?number_format($data['cbn_hiv']->mtb_ndet/$data['cbn_hiv']->total*100, 2, '.', ','):0.00}}</td>
                                                       <td>{{$data['cbn_hiv']->mtb_invalid?$data['cbn_hiv']->mtb_invalid:0}}</td>
                                                       <td>{{$data['cbn_hiv']->total?number_format($data['cbn_hiv']->mtb_invalid/$data['cbn_hiv']->total*100, 2, '.', ','):0.00}}</td>
                                                       <td>{{$data['cbn_hiv']->rif_indeterminate?$data['cbn_hiv']->rif_indeterminate:0}}</td>
                                                       <td>{{$data['cbn_hiv']->total?number_format($data['cbn_hiv']->rif_indeterminate/$data['cbn_hiv']->total*100, 2, '.', ','):0.00}}</td>
                                                       <td>No of each <br />sample type <br />received </td>

                                                     </tr>
                                                     <tr>
                                                      <td>Others</td>
                                                      <td>{{$data['cbn_others']->mtb_ref_det?$data['cbn_others']->mtb_ref_det:0}}</td>
                                                      <td>{{$data['cbn_others']->total?number_format($data['cbn_others']->mtb_ref_det/$data['cbn_others']->total*100, 2, '.', ','):0.00}}</td>
                                                      <td>{{$data['cbn_others']->mtb_det_ref_ndet?$data['cbn_others']->mtb_det_ref_ndet:0}}</td>
                                                      <td>{{$data['cbn_others']->total?number_format($data['cbn_others']->mtb_det_ref_ndet/$data['cbn_others']->total*100, 2, '.', ','):0.00}}</td>
                                                      <td>{{$data['cbn_others']->mtb_ndet?$data['cbn_others']->mtb_ndet:0}}</td>
                                                      <td>{{$data['cbn_others']->total?number_format($data['cbn_others']->mtb_ndet/$data['cbn_others']->total*100, 2, '.', ','):0.00}}</td>
                                                      <td>{{$data['cbn_others']->mtb_invalid?$data['cbn_others']->mtb_invalid:0}}</td>
                                                      <td>{{$data['cbn_others']->total?number_format($data['cbn_others']->mtb_invalid/$data['cbn_others']->total*100, 2, '.', ','):0.00}}</td>
                                                      <td>{{$data['cbn_others']->rif_indeterminate?$data['cbn_others']->rif_indeterminate:0}}</td>
                                                      <td>{{$data['cbn_others']->total?number_format($data['cbn_others']->rif_indeterminate/$data['cbn_others']->total*100, 2, '.', ','):0.00}}</td>
                                                      <td>All others <br />except above <br />sample types</td>

                                                    </tr>
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
                    'excel', 'pdf'
                ]
            });
        } );
        </script>
    @endsection
