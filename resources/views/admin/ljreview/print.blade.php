<html>
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicon.png')}}">
    	<title>LIMS</title>    
	    <!-- <link href="{{url('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">	     -->
	    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>	    
	</head>
	<body>
		<div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-12 col-12 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">LJ Review</h3>
                  </div>
              </div>

		<div class="row">
                    <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;">
                        <div class="" >
                            <div class="card-block">
                                <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;">
                                    <table border="1" id="example" class="table table-striped table-bordered responsive col-lg-12" cellspacing="0" cellpadding="10" width="100%">
                                       <thead>
                                        <tr>
                                          <th> Sample ID</th>
                                          <th>Enroll ID</th>
                                          <th>DX/FU/EQA</th>
										  <th>FU month</th>
										  <th>Week of Result</th>
										  <th>Samples submitted</th>
                                          <th>Type of sample</th>
                                          <th>LPA Test requested</th>
                                          <th>Culture method S/L/Both</th>
                                          <th>Final result</th>
                                          <th>Date of Solid Culture Result</th>
										  <th>If subjected to LC, LC Result</th>
										  <th>If subjected to LC, date of LC result</th>
										
                                          
                                        </tr>
                                      </thead>
                                      <tbody>
									 	@foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>{{$samples->reason}}</td>
										  <td>{{$samples->fu_month}}</td>
										   <td>
                                            @if($samples->week==null)
                                            1
                                            @else
                                            {{$samples->week+1}}
                                            @endif
                                          </td>
                                          <td>{{$samples->no_of_samples}}</td>
                                          <td>
											 @if($samples->sample_type=="Other" || $samples->sample_type=="Others")
												{{$samples->sample_type}}({{$samples->others_type}})
											@else
												{{$samples->sample_type}}
											@endif
											</td>
                                         <td>{{$samples->lpa_type}}</td>
                                          <td>{{$samples->culture_method}}</td>
                                          <td>{{$samples->final_result}}</td>
                                          <td>{{$samples->lj_result_date}}</td>
										  <td>{{$samples->lc_result}}</td>
                                          <td>{{$samples->lc_result_date}}</td>
                                          
                                        </tr>
                                        @endforeach

                                    </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

	</body>
</html>

<script>
	$(document).ready(function(){
    	window.print();
	});
</script>