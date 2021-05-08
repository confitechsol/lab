@extends('admin.layout.app')
@section('content')
<style>
.col { margin-bottom: 25px; }
</style>
<div class="page-wrapper">
	<div class="container-fluid">

		<div class="container-fluid">
			<div class="row page-titles">
				<div class="col-md-5 col-8 align-self-center">
					<h3 class="text-themecolor m-b-0 m-t-0">New TU</h3>
				</div>				
			</div>

			<div class="row">
				<div class="col-lg-12 col-xlg-12 col-md-12">
					<div class="card">
						<div class="card-block">
							<div class="row col-lg-12">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<form action="{{ url('/tu_request') }}" method="post" id="dxtbform" class="form-horizontal form-material">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="tu_id" id="tu_id" value="" />
										<input type="hidden" name="edit_result" id="edit_result" value="" />
										<div class="col ">
											<label class="col-sm-12">State  <span class="red">*</span> </label>
												<div class="col-sm-12">
												<select class="form-control form-control-line state" name="state" id="state" required>
												<option value="">--Select--</option>
												@foreach ($get_state_data as  $state)
													<option value="{{$state->STOCode}}">
														{{$state->name}}
													</option>								
												@endforeach
												</select>
												</div>
										</div>

										<div class="col">
											<label class="col-sm-12">District  <span class="red">*</span> </label>
												<div class="col-sm-12">
												<select class="form-control form-control-line district" name="district" id="district" required>
													<option value="">--Select--</option>								
													</option>				
												</select>
												</div>
										</div>

										<div class="col">
											<label class="col-sm-12">TU Name  <span class="red">*</span> </label>
												<div class="col-sm-12">
													<input type="text" value="" class="form-control form-control-line" id="tuname" name="tuname" required>
												</div>
										</div>

										<div class="col">
											<div class="col-sm-12">
												<button id="save-btn" class="btn btn-info saveBtn">Save</button>
												<a class="btn btn-warning" href="{{url('/tu-update')}}">Cancel</a>
											</div>
										</div>

									</form>
								</div>							

								<div class="col-lg-6 col-md-6 col-sm-6">
									<table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>                                    
                                              <th>TU Name</th>                                              
                                              <th>Action</th>
                                            </tr>
                                        </thead>                                
                                    </table>
								</div>
							</div>		
						</div>
					</div>
				</div>
			</div>
	</div>
</div>


<script>
	$('.state').on('change', function() {

		var state_code = $(this).val();
		$.ajax({
			url: "{{url('get_district')}}"+'/'+state_code,
			type:"GET",
			processData: false,
			contentType: false,
			dataType : "json",
			success: function(data) {			

				if(data.length > 0)
				{
					//console.log(data);

					$('.district').html("");
					$('.district').append(new Option('--Select--', ''));

					for(var i=0; i < data.length; i++)
					{
						$('.district').append(new Option(data[i].name, data[i].DTOCode)); 
					}
				}
				
				},
				error: function() {
				console.log("err")
			}
			});
	});

	$('.district').on('change', function() {

		var district_code = "0";
		var state_code = "0";

		district_code = $(this).val();
		state_code = $('.state').val();

		loadtable(state_code, district_code);

		//console.log(state_code);

	});

	$('document').ready(function() {

		//loadtable(0, 0);

	});

	function loadtable(state_code, district_code)
	{
		var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

                        if(dd<10) {
                            dd = '0'+dd
                        }

                        if(mm<10) {
                            mm = '0'+mm
                        }

                        today = dd + '-' + mm + '-' + yyyy;

                        var url = '{{ route("ajax_tu_list") }}';                       

                        $('#exampl').DataTable({
                          dom: 'Bfrtip',
                      pageLength:25,
                      bDestroy: true,
                          processing: true,
                          language: {
                              loadingRecords: '&nbsp;',
                              //processing: 'Loading...'
                              processing: '<div class="spinner"></div>'
                          } , 		
                          serverSide: true,
                          serverMethod: 'post',
                        //searching: false, // Remove default Search Control
                      ajax: {
                          url: url,	
                          data: {state_code: state_code, district_code: district_code},	  
                          headers: 
                          {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                        },
                        drawCallback: function (settings) { 
                            // Here the response
                            var response = settings.json;
                        },
                      columns: [                        
                        
                        { data: 'tu_name' },
                        { data: 'action' },                        
                      ],
                          buttons: [
                              {
                                  extend: 'excelHtml5',
                                  title: 'LIMS_tu_current_'+today+'',
                                  exportOptions: {
                                      /*columns: [  1, 2, 3,4,5,6,7]*/
                            columns: "thead th:not(.noExport)"
                                  }
                              },
                              
                          ],
                          order: [[ 0, 'desc' ]],
                      columnDefs: [
                          { targets: [0], orderable: false }
                        ]
                      });
	}

	function updateTUData(tu_id, state_code, dist_code, tu_name)
	{
		$('#tu_id').val(tu_id);
		$('#edit_result').val('edit');
		$('#state').val(state_code);
		$('#district').val(dist_code);
		$('#tuname').val(tu_name);

	}

</script>

@endsection
