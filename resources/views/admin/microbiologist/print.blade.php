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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">Microbiologist</h3>
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
                                              <th>Enrollment ID</th>
                                              <th>Sample ID</th>
                                              <th>Patient Name </th>
                                              <th>Referal Facility</th>
                                              <th>Date of Receipt</th>
                                              <th>Sample type</th>
                                              <th>Test To  Review</th>
                                              <th>Detail</th>
                                              <th>Remark</th>
                                              
                                            

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)
                                                  <tr>

                                                    <td>{{$samples->enroll_l}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    <td>{{$samples->p_name}}</td>
                                                    <td></td>
                                                    <td><?php echo date('d/m/Y', strtotime($samples->date)); ?></td>
                                                    <td>{{$samples->sample_type}}</td>
                                                    <!-- <td><a href={{$samples->url}}>{{$samples->service_name}}</a></td> -->
                                                    <td>{{$samples->service_name}}</td>
                                                    <td>{{$samples->detail}}</td>
                                                    <td>{{$samples->remark}}</td>
                                                    


                                                </tr>

                                          @endforeach
                                        @endif
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