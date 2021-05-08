@extends('admin.layout.app')
@section('content')
        <div class="page-wrapper"> 
            <div class="container-fluid">                 
                                                                                    
                <div class="row">
                    
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">
                                      
                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Lab Code</th>
                                                <th>Location</th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['lab'] as $key=> $labs)
                                          <td>{{ $labs->id }}</td>
                                          <td>{{ $labs->name }}</td>
                                          <td>{{ $labs->lab_code }}</td>
                                          <td>{{ $labs->location }}</td>
                                          
                                          @endforeach

                                      </tbody>
                                        </table>


                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                    
            </div>
            <footer class="footer">  </footer>
        </div>
   @endsection