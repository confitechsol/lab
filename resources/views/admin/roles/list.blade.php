@extends('admin.layout.app')
@section('content')

<div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Add User Roles</h3>

                  </div>
              </div>
              <form class="form-horizontal form-material" action="{{ url('/user_role') }}" method="post" enctype='multipart/form-data' novalidate>
                  
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-block">
                                  <!-- <div class="row">
                                    <div class="col">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <label class="col-md-12">Users<span class="red">*</span> </label>
                                      <div class="col-md-12">
                                          <select  class="form-control form-control-line" id="user" name="user" required>
                                              <option value="">--Select--</option>
                                              @foreach ($data['users'] as $key => $user)
                                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                    </div>
                                    

                                </div> -->

                                <!-- <div class="row">
                                    <div class="col">
                                      <label class="col-md-12">Roles<span class="red">*</span> </label>
                                      <div class="col-md-12">
                                          <select  class="form-control form-control-line" id="role" name="role" required>
                                              <option value="">--Select--</option>
                                              @foreach ($data['roles'] as $key => $role)
                                                  <option value="{{$role->id}}">{{$role->name}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                    </div>
                                    

                                </div> -->
                            </div>
                            <style>
                                  tbody {
                                      display:block;
                                      height:calc(80vh);
                                      overflow:auto;
                                  }
                                  thead, tbody tr {
                                      display:table;
                                      width:100%;
                                      table-layout:fixed;
                                  }
                                  thead {
                                      width: calc( 100% - 1em )
                                  }
                          </style>
                            <div>
                              <div class="container">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>Admin</td>
                                            <td>Super User</td>
                                            <td>Clerk</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($data['roles'] as $key => $role)
                                          <tr>
                                            <td>{{$role->name}}</td>
                                            <td>
                                                <div class="checkbox">

                                                <input id="checkbox{{$role->id}}1" name="checkbox[]" value="{{$role->id}}.1" type="checkbox">
                                                <label for="checkbox{{$role->id}}1">
                                                </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                <input id="checkbox{{$role->id}}2" name="checkbox[]" value="{{$role->id}}.2" type="checkbox">
                                                <label for="checkbox{{$role->id}}2">
                                                </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                <input id="checkbox{{$role->id}}3" name="checkbox[]" value="{{$role->id}}.3" type="checkbox">
                                                <label for="checkbox{{$role->id}}3">
                                                </label>
                                                </div>

                                            </td>
                                        </tr>
                                      @endforeach
                                       
                                    </tbody>
                                </table>
                            
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info">Save</button>
                            
                        </div>

                    </div>
                </form>
            </div>
           
</div>

@endsection
