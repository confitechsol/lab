@extends('admin.layout.app')
@section('content')
        <div class="page-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" style="margin-top: 15px;">
                        <h3>Sample Quality Test</h3>
                        <!-- <a class="pull-right btn-go go-button add-button" href="{{ url('/req_test/create') }}" style="float:right;">Add New</a> -->

                    </div>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                  <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                          <tr>

                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>

                                              <th>Nikshay ID</th>
                                               <th>Reason for Test</th>
                                               <th>Name</th>
                                               <th>Registration</th>



                                          </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{ str_pad($samples->enroll_id, 10, "0", STR_PAD_LEFT) }}</td>
                                          <td>{{ $samples->sample_id }}</td>

                                          <td>{{ $samples->nikshay_id }}</td>
                                          <td>{{ $samples->test_reason }}</td>
                                          <th>{{ $samples->name }}</th>
                                          <td><a class="btn btn-default" href="{{ url('/req_test/'.$samples->enroll_id.'/edit') }}">Test History </a></td>
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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>
  @endsection
