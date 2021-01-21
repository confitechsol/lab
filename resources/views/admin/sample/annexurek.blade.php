<style type="text/css">
	table td, table th{
		border:1px solid black;
	}
</style>
<div class="container">

	<br/>
	<!-- <a href="{{ url('annexurek/1',['download'=>'pdf']) }}"></a> -->
  <button onclick="myFunction()" style="padding: 5px 15px;
    border-radius: 4px;
    background: #009efb;
    color: #ffffff;
    margin-right: 3px;">Download PDF</button>
	<h2 align="center">TB Laboratory Register</h2>
    <table class="tg">
    <tr>
      <th class="tg-yw4l" rowspan="3"><span style="    writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Lab Serial No.</span></th>
      <th class="tg-yw4l" rowspan="3">Date of colllection of first specimen</th>
      <th class="tg-yw4l" rowspan="3">Name is full</th>
      <th class="tg-yw4l" rowspan="3"><span style="writing-mode:vertical-rl; white-space: nowrap; text-orientation: initial;">Sex M/F/TG</span></th>
      <th class="tg-yw4l" rowspan="3">Age</th>
      <th class="tg-yw4l" rowspan="3">Complete Address</th>
      <th class="tg-yw4l" rowspan="3">Key Population</th>
      <th class="tg-yw4l" rowspan="3">Name of referring health facility</th>
      <th class="tg-yw4l" colspan="7">Reasons for Examination</th>
      <th class="tg-yw4l">Type of specimen</th>
      <th class="tg-yw4l" colspan="2">Visual appearance</th>
    </tr>
    <tr>
      <td class="tg-yw4l"rowspan="2">Presumptive TB / RE / NTM</td>
      <td class="tg-yw4l"rowspan="2">Predominant symptom & its duration</td>
      <td class="tg-yw4l"rowspan="2">History of >1 month ATT (Yes/No)</td>
      <td class="tg-yw4l" colspan="4">Follow-up</td>
      <td class="tg-yw4l"></td>
      <td class="tg-yw4l">a</td>
      <td class="tg-yw4l">b</td>
    </tr>
    <tr>
      <td class="tg-yw4l">Nikshay ID</td>
      <td class="tg-yw4l">Regimen New/ Previously Treated</td>
      <td class="tg-yw4l">Month</td>
      <td class="tg-yw4l">Post Treatment Follow up month</td>
      <td class="tg-yw4l"></td>
      <td class="tg-yw4l"></td>
      <td class="tg-yw4l"></td>
    </tr>
    @foreach ($data['lab'] as $key=> $lab)
    <tr>
      <td class="tg-yw4l">{{$lab->sample_label}}</td>
      <td class="tg-yw4l">{{$lab->receive_date}}</td>
      <td class="tg-yw4l">{{$lab->name}}</td>
      <td class="tg-yw4l">{{$lab->gender}}</td>
      <td class="tg-yw4l">{{$lab->age}}</td>
      <td class="tg-yw4l">{{$lab->house_no}},{{$lab->district}},{{$lab->state}},{{$lab->pincode}}</td>
      <td class="tg-yw4l">{{$lab->key_population}}</td>
      <td class="tg-yw4l">{{$lab->facility_name}}</td>
      <td class="tg-yw4l">{{$lab->prsmptv_xdrtv}}</td>
      <td class="tg-yw4l">{{$lab->predmnnt_symptoms}}</td>
      <td class="tg-yw4l">{{$lab->ho_anti_tb}}</td>
      <td class="tg-yw4l">{{$lab->nikshay_id}}</td>
      <td class="tg-yw4l">{{$lab->regimen}}</td>
      <td class="tg-yw4l">{{$lab->fu_month}}</td>
      <td class="tg-yw4l">{{$lab->fu_month}}</td>
      <td class="tg-yw4l">{{$lab->sample_type}}</td>
      <td class="tg-yw4l" colspan="2">{{$lab->sample_quality}}</td>
    </tr>
    @endforeach

  </table>
  <br /><br />
  <table class="tg">
  <tr>
    <th class="tg-031e" colspan="2">Result</th>
    <th class="tg-yw4l" rowspan="2">Date of Result</th>
    <th class="tg-yw4l" rowspan="2">HIV status(Reactive / Non Reactive / Unknown)</th>
    <th class="tg-yw4l" rowspan="2">Diabetic status (Diabetic / Non Diabetic / Unknown)</th>
    <th class="tg-yw4l" rowspan="2">Sample for DST sent (Y/N) with date</th>
    <th class="tg-yw4l" rowspan="2">DST Result (Write the drugs to which resistance no. is dominated)</th>
    <th class="tg-yw4l" rowspan="2">NIKSHAY ID (notification no.)</th>
    <th class="tg-yw4l" rowspan="2">Treatment initiation details(TB No. &amp; TU details) / Referral for treatment </th>
    <th class="tg-yw4l" rowspan="2">Signature </th>
    <th class="tg-yw4l" rowspan="2">Remarks</th>
  </tr>
  <tr>
    <td class="tg-yw4l">a</td>
    <td class="tg-yw4l">b</td>
  </tr>
  @foreach ($data['result'] as $key=> $result)
  <tr>
    <td class="tg-yw4l" colspan="2">{{$result->sample_label}}</td>
    <!-- <td class="tg-yw4l"></td> -->
    <td class="tg-yw4l">{{$result->ld_date}}</td>
    <td class="tg-yw4l">
			@if($result->hiv_test=="Pos")
			Reactive
			@elseif($result->hiv_test=="Neg")
			Non Reactive
			@elseif($result->hiv_test=="Unknown")
			Unknown
			@else
			@endif
		</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">
      @if($result->ld_id)
      Y
      @else
      N
      @endif
			 {{$result->receive_date?date('Y/m/d', strtotime( $result->receive_date)):""}}
    </td>
    <td class="tg-yw4l">{{$result->ld_date}}</td>
    <td class="tg-yw4l">{{$result->nikshay_id}}</td>
    <td class="tg-yw4l">{{$result->tb}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
  @endforeach
</table>

</div>
<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
}
</style>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>

<script>
function myFunction() {
    window.print();
}
</script>
