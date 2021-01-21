@extends('admin.layout.app')
@section('content')

    <style>

    </style>

        <div class="page-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" style="margin-top: 15px;">
                        <h3>Test Enrolment</h3>
                        <a class="pull-right btn-go go-button add-button" href="{{ url('/patient/create') }}" style="float:right;">Add New</a>
                    </div>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th>Nikshay_id</th>
                                                <th>Created_on</th>

                                            </tr>
                                        </thead>
                                       <!--  <tbody>

                                          @foreach ($data['patient'] as $key=> $patients)
                                          <td>{{ $patients->id }}</td>
                                          <td>{{ $patients->name }}</td>
                                          <td>{{ $patients->contact_no }}</td>
                                          <td>{{ $patients->nikshay_id }}</td>
                                          <td>{{ $patients->created_on }}</td>
                                          @endforeach

                                      </tbody> -->
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
