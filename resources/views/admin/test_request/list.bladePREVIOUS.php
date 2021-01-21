@extends('admin.layout.app')
@section('content')


<style>
  .bg-selected {
    background: #ffbdbd !important;
  }
</style>

 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Test Request</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/test_request/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="table-scroll">

                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Created By</th>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Receive Date</th>
                                              <th>Reason for Test</th>
                                              <th>Follow up month</th>
                                              <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td class="hide">{{$samples->enroll_id}}</td>
                                            <td>{{$samples->name}}</td>
                                            <td>{{$samples->label}}</td>
											<td>{{$samples->samples}}</td>
                                            <!--<td><?php
                                            if (strpos($samples->samples, 'R') !== false) {
                                             $string = substr($samples->samples, 0, strpos($samples->samples, 'R'));
                                            echo $string;}else{ echo $samples->samples;} ?></td>-->

                                            <td><?php echo date('d-m-Y h:i:s',strtotime($samples->receive)) ?></td>
                                            <td>{!! str_replace(',','<br/>', $samples->reason) !!}</td>
                                            <td>{!! str_replace(',','<br/>', $samples->fu_month) !!}</td>

                                            <td>

                                              <button class="btn btn-default btn-sm"
                                                onclick="
                                                  window.open('{{ $samples->tr_id > 0 ? url('/test_request/'.$samples->tr_id.'/edit') : url('/test_request/create/'.$samples->enroll_id) }}');
                                                  $('#exampl tr.bg-selected').removeClass('bg-selected');
                                                  $(this).parents('tr').addClass('bg-selected')
                                                ">{{ $samples->tr_id > 0 ? 'Request' : 'Create' }}
                                              </button>

                                              {{--
                                              @if ($samples->tr_id > 0)
                                                <!--a class="btn btn-default btn-sm" href="{{ url('/test_request/'.$samples->tr_id) }}">View </a-->
                                                <a class="btn btn-default btn-sm" href="{{ url('/test_request/'.$samples->tr_id.'/edit') }}">Request</a>
                                              @else
                                                <a class="btn btn-default btn-sm" href="{{ url('/test_request/create/'.$samples->enroll_id) }}">Create</a>
                                              @endif
                                              --}}

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

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>





<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Barcodes</h4>
      </div>
      <div class="modal-body" id="printCode">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$(function(){

});
function openPrintModal(obj){
  //console.log(obj.attr('data-sample'));
  var samples = obj.attr('data-sample');
  $.ajax({
    method: "GET",
    url: "{{url('sample/print/')}}"+'/'+samples,
    data: { samples: samples }
  }).done(function( msg ) {
    $("#printCode").html(msg)
    $('#myModal').modal('toggle');
  });

}
</script>

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
    $('#exampl').DataTable( {
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_'+labname+'_'+labcity+'_TestRequest_'+today+'',
                    exportOptions: {
                    columns: [  1, 2, 3,4,5,6 ]
                }
            }
        ],
        "order": [[ 2, "desc" ]]
    });
} );
</script>
@endsection
