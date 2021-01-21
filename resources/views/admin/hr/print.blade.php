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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">HR</h3>
                  </div>
              </div>

		<div class="row">
                    <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;">
                        <div class="" >
                            <div class="card-block">
                                <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;">
                                    <table border="1" id="example" class="table table-striped table-bordered responsive col-lg-12" cellspacing="0" cellpadding="1" width="10%">
                                       <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Qualifiaction</th>
                                            <th>Mode</th>
                                            <th>Date of Joining</th>
                                            <th>Annual Health Checkup</th>
                                            <th>Vaccination</th>
                                            <th>Orientation Training</th>

                                            <th>Microscopy</th>
                                            <th>LC</th>
                                            <th>DST</th>
                                            <th>LPA</th>
                                            <th>GeneXpert</th>
                                            <th>QMS Training</th>
                                            <th>Bio safety training</th>
                                            <th>Fire safety training</th>
                                            <th>Bio waste management training</th>
                                            <th>Date of releving from current post</th>
																						<th>Adhaar</th>


                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <th>{{$samples->name}}</th>
                                          <th>{{$samples->designation}}</th>
                                          <th>{{$samples->qualification}}</th>
                                          <th>{{$samples->mode}}</th>
                                          <th>{{$samples->date_joining}}</th>
                                          <th>{{$samples->health_check}}</th>
                                          <th>{{$samples->vaccination}}</th>
                                          <th>{{$samples->orientation_training}}</th>

                                          <th>{{$samples->microscopy}}</th>
                                          <th>{{$samples->lc}}</th>
                                          <th>{{$samples->dst}}</th>
                                          <th>{{$samples->lpa}}</th>
                                          <th>{{$samples->geneXpert}}</th>
                                          <th>{{$samples->qms}}</th>
                                          <th>{{$samples->bio_safe_t}}</th>
                                          <th>{{$samples->fire_safe_t}}</th>
                                          <th>{{$samples->bio_waste_man}}</th>
                                          <th>{{$samples->date_reliving_curr}}</th>
																					<th>{{$samples->adhaar}}</th>

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
