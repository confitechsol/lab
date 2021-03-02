@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">User Management Module</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/adduser/create') }}"  >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Add New</a>
                    </form>
                 </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >

                                  <div class="table-scroll">
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th class="hide">ID</th>
                                            <th>Name</th>
                                            <th>User ID</th>
                                            <th>Edit Permissions</th>
                                            @if(Auth::user()->name=="Admin")
                                              <th>Reset Password</th>
                                            @endif


                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td class="hide">{{$samples->id}}</td>
                                          <td>{{$samples->name}}</td>
                                          <td>{{$samples->email}}</td>
                                          <td>
                                            <a class="btn btn-default btn-sm" href="{{ url('/adduser/'.$samples->id.'/edit') }}">Edit </a>
                                          </td>
                                          @if(Auth::user()->name=="Admin")
                                            <td>
                                              @if($samples->reset_flag==1)
                                              <!-- <a class="btn btn-default btn-sm" href="{{ url('/passwordReset/'.$samples->id.'/edit') }}">Requested </a> -->
                                              password changed
                                              @else
                                              password not changed
                                              @endif
                                            </td>
                                          @endif


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
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
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
        stateSave: true,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_user_management_module_'+today+'',
                  exportOptions: {
                    columns: [  1, 2]
                }
            }
        ]
    });
} );
</script>






@endsection
