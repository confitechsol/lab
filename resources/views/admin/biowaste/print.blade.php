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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">Bio Waste Management</h3>
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
                                            <!-- <th class="hide">ID</th> -->
                                            <th>Date of waste generated</th>
                                            <th>Unit of Measurement</th>
                                            <th>Yellow</th>
                                            <th>Red</th>
                                            <th>White</th>
                                            <th>Blue</th>
                                            <th>Date of collection for disposal</th>
                                            
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['waste'] as $key=> $samples)
                                        <tr>
                                          <!-- td class="hide">{{$samples->id}}</td> -->
                                          <td>{{$samples->generated_date}}</td>
                                          @if($samples->quantity!=null)
                                            <td>KG</td>
                                          @elseif($samples->packets==2)
                                            <td>PACKETS</td>
                                          @else
                                            <td>None</td>
                                          @endif
                                          <td>{{$samples->yellow}}</td>
                                          <td>{{$samples->red}}</td>
                                          <td>{{$samples->white}}</td>
                                          <td>{{$samples->blue}}</td>
                                          <td>{{$samples->collected_date}}</td>
                                          
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