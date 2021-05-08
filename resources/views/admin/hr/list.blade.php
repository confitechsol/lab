@extends('admin.layout.app')
@section('content')

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-4 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">HR</h3>

                  </div>
                  <div class="col-md-4 col-4 align-self-center">
                    <a class="pull-right btn-go go-button add-button  btn-sm btn-info" href="{{ url('/hr/create') }}">Add New</a>
                 </div>	
				 
                 <div class="col-md-4 col-4 align-self-center">
                    <form action="{{ url('/hr/print') }}" method="post" >
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
                    </form>
                 </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >
                                  <!----<form action="{{ url('/hr/yearDesignationFilter') }}" method="post">
                                  <div class="row">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <div class="col-sm-2">Designation:                                       
                                        <select name="desig" class="form-control form-control-line">
                                            <option value="">Select</option>
                                            @foreach ($data['designation'] as $key => $designation)
                                                    <option value="{{$designation->designation}}"
                                                    >{{$designation->designation}}</option>

                                            @endforeach
                                        </select>
                                      </div>
                                      <div class="col-sm-2">Year: <input type="number" name="year" class="form-control form-control-line "></div>
                                      <div class="col-sm-2">&nbsp;<input type="submit" class="btn btn-primary btn-sm form-control form-control-line text-white" value="Filter"></div>
                                  </div>
                                </form>
                                <form action="{{ url('/hr/yearOrganizationFilter') }}" method="post">
                                  <div class="row">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <div class="col-sm-2">Organization:
                                        <select name="org" class="form-control form-control-line" >
                                            <option value="">--Select--</option>
                                            <option value="Central Govt."
                                            >Central Govt.</option>
                                            <option value="State Govt."
                                            >State Govt.</option>
                                            <option value="Institutional"
                                            >Institutional</option>
                                            <option value="Contractual"
                                            >Contractual</option>
                                            <option value="RNTCP"
                                            >RNTCP</option>
                                            <option value="Private"
                                            >Private</option>
                                            <option value="Project"
                                            >Project</option>
                                            <option value="Others"
                                            >Others</option>
                                        </select>
                                      </div>
                                      <div class="col-sm-2">Year: <input type="number" name="year_org" class="form-control form-control-line "></div>
                                      <div class="col-sm-2">&nbsp;<input type="submit" class="btn btn-primary btn-sm form-control form-control-line text-white" value="Filter"></div>
                                  </div>
                                </form>
                                <form action="{{ url('/hr/yearTypeFilter') }}" method="post">
                                  <div class="row">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <div class="col-sm-2">Type of Employment:
                                        <select name="type" class="form-control form-control-line" required="required">
                                            <option value="">--Select--</option>
                                            <option value="Partime"
                                            >Partime</option>
                                            <option value="Fulltime"
                                            >Fulltime</option>
                                        </select>
                                      </div>
                                      <div class="col-sm-2">Year: <input type="number" name="year_type" class="form-control form-control-line "></div>
                                      <div class="col-sm-2">&nbsp;<input type="submit" class="btn btn-primary btn-sm form-control form-control-line text-white" value="Filter"></div>
                                  </div>
                                </form>
                                  <hr/>---->
                                  <div class="table-scroll">
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Adhaar ID</th>
                                            <th>Designation</th>
                                            <th>Qualifiaction</th>
                                            <th>Part time/Full time</th>
                                            <th>Organization/Source of funding for position</th>
                                            <th>Date of Joining</th>
                                            <th>Annual Health Checkup</th>
                                            <th>Vaccination</th>
                                            <th>Orientation Training</th>
                                            <th>Microscopy</th>
                                            <th>Liquid Culture Training (MGIT 960)</th>
                                            <th>Solid Culture (LJ) training</th>
                                            <th>DST (LC) First Line</th>
                                            <th>DST (LC) Second Line</th>
                                            <th>DST (LJ) First Line</th>
                                            <th>DST (LJ) Second Line</th>
                                            <th>LPA 1st Line</th>
                                            <th>LPA 2nd Line</th>
                                            <th>GeneXpert</th>
                                            <th>QMS Training</th>
                                            <th>Bio safety training</th>
                                            <th>Fire safety training</th>
                                            <th>Bio waste management training</th>
                                            <th>Others</th>
                                            <th>Date of releving from current post</th>
                                            <th>Name of Refresher Training</th>
                                            <th>Date for Refresher Training</th>
                                            <th>Action</th>
                                            <!--<th>Delete</th>-->

                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <th>{{$samples->name}}</th>
                                          <th>
                                              @if(!empty($samples->adhaar))

                                            <?php echo '********'.substr($samples->adhaar,-4); ?>
                                              
                                              @else
                                              @endif
                                            </th>
                                          <th>{{$samples->designation}}</th>
                                          <th>{{$samples->qualification}}</th>
                                          <th>{{$samples->type_qualification}}</th>
                                          <th>{{$samples->org_source}}</th>
                                          <th>{{$samples->date_joining}}</th>
                                          <th>{{$samples->health_check}}</th>
                                          <th>{{$samples->vaccination}}</th>
                                          <th>{{$samples->orientation_training}}</th>
                                          <th>{{$samples->microscopy}}</th>
                                          <th>{{$samples->lc}}</th>
                                          <th>{{$samples->lj}}</th>
                                          <th>{{$samples->dst}}</th>
                                          <th>{{$samples->dst_lc_2}}</th>
                                          <th>{{$samples->dst_lj_1}}</th>
                                          <th>{{$samples->dst_lj_2}}</th>
                                          <th>{{$samples->lpa}}</th>
                                          <th>{{$samples->lpa_2}}</th>
                                          <th>{{$samples->geneXpert}}</th>
                                          <th>{{$samples->qms}}</th>
                                          <th>{{$samples->bio_safe_t}}</th>
                                          <th>{{$samples->fire_safe_t}}</th>
                                          <th>{{$samples->bio_waste_man}}</th>
                                          <th>{{$samples->name_other}}</th>
                                         
                                          <th>
                                              @if(!empty($samples->date_reliving_curr))
                                            {{ date('d-m-Y', strtotime($samples->date_reliving_curr)) }}
                                          @else @endif</th>



										  <th>{{$samples->refresher_training_name}}</th>
                      
                         <th> @if($samples->refresher_training_date != "0000-00-00")
                          {{ date('d-m-Y', strtotime($samples->refresher_training_date)) }} @else @endif</th>
                      
                                          
                                          <th><a href="{{ url('/hr/'.$samples->id.'/edit') }}">Edit</a></th>
                                         <!-- <th><a href="{{ url('/hr/'.$samples->id.'/delete_hr') }}">Delete</a></th>-->
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer">  </footer>
</div>

<script>

$(document).ready(function() {
    var labname="<?php echo $data['labname']; ?>";
  var labcity="<?php echo $data['labcity']; ?>";
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
    $('#exampl').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_hr_'+today+'',
                   exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25 ]
                }
            }
        ]
    });
} );
</script>






@endsection
