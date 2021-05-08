@extends('admin.layout.app')
@section('content')

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">HR Type Of Employment-Year Filtered Data</h3>

                  </div>


              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >
                                  <div class="table-scroll">
                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
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

                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['hr'] as $key=> $samples)
                                        <tr>
                                          <th>{{$samples->name}}</th>
                                          <th>{{$samples->adhaar}}</th>
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
                                          <th>{{$samples->date_reliving_curr}}</th>
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
                <div class="col-12">

                    <a class="btn btn-warning" href="{{url('/hr')}}">Back</a>

                </div>
            </div>
            <footer class="footer">  </footer>
</div>


<script>

$(function(){

});
</script>






@endsection
