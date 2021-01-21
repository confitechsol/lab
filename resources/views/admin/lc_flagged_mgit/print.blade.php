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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">LC Flagged MGIT Tube</h3>
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
                                          <th>TUBE sequence ID</th>
                                          <th>Date of Inoculation</th>
                                          <th>Initial Smear  result</th>
                                          <th>DX/FU</th>
                                          <th>GU</th>
                                          <th>Date of flagging  by MGIT</th>
                                          
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <td>
                                            @if($samples->tube_id_lj)
                                            {{$samples->tube_id_lj}}
                                            @else
                                            {{$samples->tube_id_lc}}
                                            @endif
                                          </td>
                                          <td>{{$samples->inoculation_date}}</td>
                                          <td>{{$samples->result}}</td>
                                          <td>{{$samples->reason}}</td>
                                          <td>{{$samples->gu}}</td>
                                          <td>{{$samples->flagging_date}}</td>
                                          
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