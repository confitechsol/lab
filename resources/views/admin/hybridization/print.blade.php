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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">Hybridization</h3>
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
                                            <th>Sample ID</th>
                                            <th>No of samples submitted</th>
                                            <th>Date of Decontamination</th>
                                            <th>Microscopy result</th>
                                            <th>Date of Extraction</th>
                                            <th>LPA test type</th>
                                            <th>PCR completed</th>
                                           
                                          </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td style="display:none;">{{$samples->ID}}</td>
                                            <td>{{$samples->samples}}</td>
                                            <td>{{$samples->no_of_samples}}</td>
                                            <td><?php echo date('d/m/Y', strtotime($samples->decontamination_date)); ?></td>
                                            <td>{{$samples->result}}</td>
                                            <td><?php echo date('d/m/Y', strtotime($samples->date_of_extraction)); ?></td>
                                            <td>{{$samples->tag}}</td>
                                            <td>
                                              @if($samples->pcr_completed==1)
                                              yes
                                              @else
                                              no
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