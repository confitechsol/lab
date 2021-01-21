@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Configuration and Laboratory Details</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <h5>


		                <a class="pull-right btn-go go-button add-button" href="{{ url('/laboratory/create') }}">Add New/Edit</a>

		            </h5>
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
                                            <th class="hide">ID</th>
                                            <th>Lab Code</th>
                                            <th>Lab Name</th>
                                            <th>Lab Address</th>

                                            <th>View</th>


                                          </tr>
                                      </thead>
                                          @foreach ($data['config'] as $key=> $labs)
                                        <tr>
                                          <td class="hide">{{$labs->id}}</td>
                                          <td>{{$labs->lab_code}}</td>
                                          <td>{{$labs->lab_name}}</td>
                                          <td>{{$labs->address}}</td>

                                          <td>
                                            <a class="btn btn-default btn-sm" href="{{ url('/laboratory/'.$labs->id.'/edit') }}">View </a>
                                          </td>

                                        </tr>
                                        @endforeach
                                      <tbody>

                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
</div>



<script>
$(function(){



});

</script>






@endsection
