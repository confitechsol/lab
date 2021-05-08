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
<form method="post" action="{{ url('/report/lqc_indicator') }}" >
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
<h6>LAB QC indicator  </h6>
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
<!-- <tr>
<td>fgdgd</td>
<td></td>
<td>fgdgd</td>
<td></td>
<td>fgdgd</td>
<td></td>
</tr> -->
<thead>
<tr style="text-align: center!important; font-weight: 600;     color: #6495ed;">

<th style="text-align: center!important; font-weight: 600;"><b>Indicator</b></th>
<th style="text-align: center!important; font-weight: 600;"><b>Diagnosis</b></th>
<th style="text-align: center!important; font-weight: 600;"><b>%</b></th>
<th style="text-align: center!important; font-weight: 600;"><b>Followup</b></th>
<th style="text-align: center!important; font-weight: 600;"><b>%</b></th>
{{-- <th style="text-align: center!important; font-weight: 600;"><b>Denominator</b></th> --}}

</tr>
</thead>
<tbody>

<tr>
<td>{{$data['lq_indicator'][0]->indicator}}</td>
<td>{{$data['lq_indicator'][0]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][0]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][0]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][0]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received for perticular<br /> period for Diagnosis and Followup</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][1]->indicator}}</td>
<td>{{$data['lq_indicator'][1]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][1]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][1]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][1]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received for perticular<br /> period for Diagnosis and Followup</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][2]->indicator}}</td>
<td>{{$data['lq_indicator'][2]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][2]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][2]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][2]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][3]->indicator}}</td>
<td>{{$data['lq_indicator'][3]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][3]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][3]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][3]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][4]->indicator}}</td>
<td>{{$data['lq_indicator'][4]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][4]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][4]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][4]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received1 <br /> Invalid/Indeterminate</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][5]->indicator}}</td>
<td>{{$data['lq_indicator'][5]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][5]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][5]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][5]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][6]->indicator}}</td>
<td>{{$data['lq_indicator'][6]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][6]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][6]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][6]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][7]->indicator}}</td>
<td>{{$data['lq_indicator'][7]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][7]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][7]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][7]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br /> Invalid/Indeterminate</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][8]->indicator}}</td>
<td>{{$data['lq_indicator'][8]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][8]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][8]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][8]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][9]->indicator}}</td>
<td>{{$data['lq_indicator'][9]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][9]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][9]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][9]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][10]->indicator}}</td>
<td>{{$data['lq_indicator'][10]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][10]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][10]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][10]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br /> Invalid</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][11]->indicator}}</td>
<td>{{$data['lq_indicator'][11]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][11]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][11]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][11]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][12]->indicator}}</td>
<td>{{$data['lq_indicator'][12]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][12]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][12]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][12]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br />for perticular period</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][13]->indicator}}</td>
<td>{{$data['lq_indicator'][13]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][13]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][13]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][13]->followup_perc, 2, '.', '')}}%</td>
{{-- <td>Total no. of Sample received <br /> Invalid</td> --}}
</tr>

<tr>
<td>{{$data['lq_indicator'][14]->indicator}}</td>
<td>{{$data['lq_indicator'][14]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][14]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][14]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][14]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][15]->indicator}}</td>
<td>{{$data['lq_indicator'][15]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][15]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][15]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][15]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][16]->indicator}}</td>
<td>{{$data['lq_indicator'][16]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][16]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][16]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][16]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][17]->indicator}}</td>
<td>{{$data['lq_indicator'][17]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][17]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][17]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][17]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][18]->indicator}}</td>
<td>{{$data['lq_indicator'][18]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][18]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][18]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][18]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][19]->indicator}}</td>
<td>{{$data['lq_indicator'][19]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][19]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][19]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][19]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][20]->indicator}}</td>
<td>{{$data['lq_indicator'][20]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][20]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][20]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][20]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][21]->indicator}}</td>
<td>{{$data['lq_indicator'][21]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][21]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][21]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][21]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][22]->indicator}}</td>
<td>{{$data['lq_indicator'][22]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][22]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][22]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][22]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][23]->indicator}}</td>
<td>{{$data['lq_indicator'][23]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][23]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][23]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][23]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][24]->indicator}}</td>
<td>{{$data['lq_indicator'][24]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][24]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][24]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][24]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][25]->indicator}}</td>
<td>{{$data['lq_indicator'][25]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][25]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][25]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][25]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][26]->indicator}}</td>
<td>{{$data['lq_indicator'][26]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][26]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][26]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][26]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
<td>{{$data['lq_indicator'][27]->indicator}}</td>
<td>{{$data['lq_indicator'][27]->diagnosis}}</td>
<td>{{number_format((float)$data['lq_indicator'][27]->diagnosis_perc, 2, '.', '')}}%</td>
<td>{{$data['lq_indicator'][27]->followup}}</td>
<td>{{number_format((float)$data['lq_indicator'][27]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][28]->indicator}}</td>
    <td>{{$data['lq_indicator'][28]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][28]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][28]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][28]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][29]->indicator}}</td>
    <td>{{$data['lq_indicator'][29]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][29]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][29]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][29]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][30]->indicator}}</td>
    <td>{{$data['lq_indicator'][30]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][30]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][30]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][30]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][31]->indicator}}</td>
    <td>{{$data['lq_indicator'][31]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][31]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][31]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][31]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][32]->indicator}}</td>
    <td>{{$data['lq_indicator'][32]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][32]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][32]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][32]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][33]->indicator}}</td>
    <td>{{$data['lq_indicator'][33]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][33]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][33]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][33]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][34]->indicator}}</td>
    <td>{{$data['lq_indicator'][34]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][34]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][34]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][34]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][35]->indicator}}</td>
    <td>{{$data['lq_indicator'][35]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][35]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][35]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][35]->followup_perc, 2, '.', '')}}%</td>
</tr>

<tr>
    <td>{{$data['lq_indicator'][36]->indicator}}</td>
    <td>{{$data['lq_indicator'][36]->diagnosis}}</td>
    <td>{{number_format((float)$data['lq_indicator'][36]->diagnosis_perc, 2, '.', '')}}%</td>
    <td>{{$data['lq_indicator'][36]->followup}}</td>
    <td>{{number_format((float)$data['lq_indicator'][36]->followup_perc, 2, '.', '')}}%</td>
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
{
extend: 'excelHtml5',
title: 'LAB QC indicator',
messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

},
{
extend: 'pdfHtml5',
title: 'LAB QC indicator',
messageTop: 'From Date: ' + $("#from_date").val() + '    To Date:' + $("#to_date").val()

}
],

});
} );

var _customizeExcelOptions = function (xlsx) {
var sheet = xlsx.xl.worksheets['sheet1.xml'];
var numrows = 5;
var clR = $('row', sheet);

$('row c ', sheet).each(function () {
var attr = $(this).attr('r');
var pre = attr.substring(0, 1);
var ind = parseInt(attr.substring(1, attr.length));
ind = ind + numrows;
$(this).attr("r", pre + ind);
});

}
</script>
@endsection
