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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">LJ DST 1st Line</h3>
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
                                          <th>Sample ID</th>
                                          <th>Enroll ID</th>
                                          <th>Inoculation Date</th>
                                          <th>Primary Culture Date</th>
                                          <th>Drug List</th>
                                          <th>4th Week Reading</th>
                                          <th>6th Week Reading</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>
                                            @if($samples->inoculation_date)
                                              {{$samples->inoculation_date}}
                                            @else
                                            <a href="#" onclick="openDateForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}')" class="btn btn-info btn-sm">Add Date</a>
                                            @endif
                                          </td>
                                          <td>{{$samples->lj_result_date}}</td>
                                          <td>{{$samples->druglist}}</td>
                                          <td>
                                            @if($samples->w4id)
                                              <a href="#" class="btn  btn-sm" onclick="openReading({{$samples->w4id}})">View Details</a>
                                            @else
                                            <a href="#" class="btn btn-info btn-sm" onclick="openReadingForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}',4)">Add Reading</a>
                                            @endif

                                          </td>
                                          <td>
                                            @if($samples->w6id)
                                              <a href="#" class="btn  btn-sm" onclick="openReading({{$samples->w6id}})">View Details</a>
                                            @else
                                            <a href="#" class="btn btn-info btn-sm" onclick="openReadingForm('{{$samples->enroll_id}}','{{$samples->sample_id}}','{{$samples->service_log_id}}',6)">Add Reading</a>
                                            @endif

                                          </td>
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