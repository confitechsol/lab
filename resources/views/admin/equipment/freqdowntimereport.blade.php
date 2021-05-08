@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Equipment down time more than one time</h3>

                  </div>
              </div>
                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                      <div class="card" >
                          <div class="card-block">
                            <form method="post" action="{{ url('/equipment/freqdowntimeAnalysis') }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="row">
                                <div class="col-sm-1">
                                  From:
                                </div>
                                <div class="col-sm-11">
                                  <input type="text" name="from_date"  class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                </div>

                                <div class="col-sm-1">
                                  To:
                                </div>
                                <div class="col-sm-11">
                                  <input type="text" name="to_date" class="datepicker" max="<?php echo date("Y-m-d");?>" required>
                                </div>
                                <div class="col-sm-12">
                                  <button type="submit" style="padding: 5px 15px; border-radius: 4px; background: #009efb; color: #ffffff; margin-right: 3px;">Submit</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12 " >

                                  <div class="table-scroll">
                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12 " cellspacing="0" >
                                      <thead>
                                          <tr>
                                            <th>Item Name (Equipment by category)</th>
                                            <th>Item Name (Equipment by name)</th>
                                            <th>Number of Breakdowns</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data['sample'] as $key => $samples)
                                        <tr>
                                          @if( $samples->count )
                                          <th>{{ $samples->name_cat }}</th>
                                          <th>{{ $samples->name }}</th>
                                          <th>{{ $samples->count }}</th>
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
                <div class="col-12">

                    <a class="btn btn-warning" href="{{url('/equipment')}}">Back</a>

                </div>
            </div>
            <footer class="footer">  </footer>
</div>



<script>

$(function(){


});
</script>






@endsection
