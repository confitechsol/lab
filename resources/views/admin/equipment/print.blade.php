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
                      <h3 class="text-themecolor m-b-0 m-t-0" style="text-align: center;margin-top:10px;">Equipments</h3>
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
																						<th>Item Name (Equipment by category)</th>
																						<th>Item Name (Equipment by name)</th>
																						<th>Tool</th>
																						<th>Supplier Name</th>

																						<th>Equipment Make</th>
																						<th>Equipment Model No</th>
																						<th>Equipment Serial No. </th>
																						<th>Organization/Agency funding for equipment along with project name </th>

																						<th>Date of Installation </th>
																						<th>Equipment ID </th>
																						<th>Location of the equipment </th>
																						<th>Warranty Status till applicable date </th>

																						<th>Current warranty status </th>
																						<th>Name of the company maintaining of equipment</th>
																						<th>Name Contact Person in the company for maintainance</th>
																						<th>Contact No.</th>


																						<th>Date of Last maintenance/Calibration </th>
																						<th>Maintenance report </th>
																						<th>Due date of Next maintenance </th>
																						<th>Lab Responsble person</th>

																						<th>Date of Breakdown of the equipment </th>
																						<th>Date of equipment returning back to functional status</th>
																						<th>Date of Decommission the equipment </th>
																						<th>Contact Email</th>


                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
																					<th>{{$samples->name_cat}}</th>
                                          <th>{{$samples->name}}</th>
                                          <th>{{$samples->tool}}</th>
                                          <th>{{$samples->supplier}}</th>

                                          <th>{{$samples->make}}</th>
                                          <th>{{$samples->model_no}}</th>
                                          <th>{{$samples->serial_no}}</th>
                                          <th>{{$samples->org}}</th>

                                          <th>{{$samples->date_installation}}</th>
                                          <th>{{$samples->eqp_id}}</th>
                                          <th>{{$samples->location}}</th>
                                          <th>{{$samples->waranty_status}}</th>

                                          <th>{{$samples->curr_warrenty}}</th>
                                          <th>{{$samples->company_name}}</th>
                                          <th>{{$samples->contact_name}}</th>
                                          <th>{{$samples->contact_no}}</th>

                                          <th>{{$samples->date_last_maintain}}</th>
                                          <th>{{$samples->maintainance_report}}</th>
                                          <th>{{$samples->next_calibration}}</th>
                                          <th>{{$samples->responsible_person}}</th>

                                          <th>{{$samples->breakdown_eqp}}</th>
                                          <th>{{$samples->return_function_status}}</th>
                                          <th>{{$samples->date_decommission}}</th>
                                          <th>{{$samples->contact_email}}</th>

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
