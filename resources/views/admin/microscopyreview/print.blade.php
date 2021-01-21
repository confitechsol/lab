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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">Microscopy Next Step</h3>
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
                                              <th style="display:none;">ID</th>
                                              <th>Lab Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Visual appearance</th>
                                              <th>Reason for test (ZN OR FM)</th>
                                              <th>Microscopy result</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td style="display:none;">{{$samples->ID}}</td>
                                            <td>{{$samples->label}}</td>
                                            <td>{{$samples->sample_label}}</td>
                                            <td>{{$samples->sample_quality}}</td>

                                            <td>
                                              {{$samples->service_id == 1? "ZN Microscopy" : "FM Microscopy"}}
                                            </td>
                                             <td>{{$samples->result}}</td>

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
