@extends('admin.layout.app')
@section('content')

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">HR Designation-Year Filtered Data</h3>

                  </div>


              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >
<?php //dd($data['ret'] ); ?>
                                  <hr/>
                                  <div class="table-scroll">
                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Qualifiaction</th>
                                            <th>Trainings Undertaken in {{$data['year']}}</th>
                                            <th>Trainings not Undertaken in {{$data['year']}}</th>


                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['ret'] as $samples)
                                        <tr>
                                          <th>{{$samples['name']}}</th>
                                          <th>{{$samples['designation']}}</th>
                                          <th>{{$samples['qualification']}}</th>
                                          <th>{{$samples['training']}}</th>
                                          <?php if(empty($samples['training'])): ?>
                                          <th>Training not attended</th>
                                        <?php else: ?>
                                          <th>{{$samples['other']}}</th>
                                        <?php endif; ?>
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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
</div>


<script>

$(function(){

});
</script>






@endsection
