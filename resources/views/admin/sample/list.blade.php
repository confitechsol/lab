@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Sample Opening</h3>

                  </div>
             <!---<div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/enroll') }}" method="post">
                      <input type ="hidden" name="enroll" value = "1">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Add New
                      </a>
                    </form>
                  </div>--->
				  <div class="col-md-7 col-4 align-self-center">
					  <a class="btn pull-right btn-sm btn-info" href="{{url('sample/create')}}">Add New </a>                  
                  </div>
              </div>


                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th class="hide">ID</th>
                                              <th>Created By</th>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Date of Receipt</th>
                                              <th>Sample type</th>
                                              <th>Other Sample type</th>
                                              <th>Sample quality</th>
                                              <th>Sample Acceptance</th>
                                              <th>Reason for Test</th>
                                              <th>Follow Up Month</th>
                                              <th>samples submitted</th>
                                              <th>Sample sent to</th>
                                              <th>View</th>
                                              <!-- <th>Print</th> -->
                                              <!--<th>Result</th> -->

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($data['sample'] as $key=> $samples)
                                          <?php $dt= explode("," , $samples->receive);

                                          $counter= count($dt);
                                          ?>
                                          <tr>
                                            <td class="hide">{{$samples->enroll_id}}</td>
                                            <td>{{$samples->name}}</td>
                                            <td>{{$samples->label}}</td>

                                            <td>{{$samples->samples}}</td>
											

                                            <td>  @foreach( $dt as $recvdates) <?php echo $custdt= date('d-m-Y h:i:s', strtotime($recvdates));   ?>  @endforeach</td>

                                            <td>{!! str_replace(',','<br/>', $samples->sample_type) !!}</td>
                                            <td>
                                              @if($samples->sample_type=="Other" || $samples->sample_type=="Others")
                                              {{$samples->others_type}}
                                              @endif
                                            </td>
                                            <td>{!! str_replace(',','<br/>', $samples->sample_quality) !!}</td>
                                            <td>{!! str_replace(',','<br/>', $samples->is_accepted) !!}</td>
                                            <td>{!! str_replace(',','<br/>', $samples->reason) !!}</td>
                                            <td>{!! str_replace(',','<br/>', $samples->fu_month) !!}</td>
                                            <td>{{ $samples->no_of_samples }}</td>
                                            <td>{!! str_replace(',','<br/>', $samples->sname) !!}</td>
                                            <td>
                                              <a class="btn btn-default btn-sm" target="_blank"
                                              href="{{url('samplePreview/'.$samples->enroll_id)}}">View Details </a>
                                              <a  href="{{url('sample/editnew/'.$samples->enroll_id)}}" class="btn btn btn-sm">Edit</a>
                                            </td>
                                            <!-- <td>
                                              <button type="button" class="btn btn-info btn-sm" onclick="openPrintModal($(this))"  data-sample="{{$samples->samples}}">Print</button>
                                              <a target="_blank" href="{{url('sample/print/'.$samples->samples)}}" class="btn btn btn-sm">PDF</a>
                                            </td> -->



                                             <td>
                                                <!-- <a target="_blank" href="{{url('sample/editnew/'.$samples->enroll_id)}}" class="btn btn btn-sm">Edit</a> -->
                                                <!-- <a target="_blank" href="{{url('interimview/'.$samples->id)}}" class="btn btn btn-sm">Result</a> -->
                                              </td>
<!--
                                              <td>
                                                <a target="_blank" href="{{ url('pdfview/'.$samples->id,['download'=>'pdf']) }}" class="btn btn btn-sm">Open PDF Mode</a>
                                              </td> -->

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
  // alert(labcity);
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
                title: 'LIMS_'+labname+'_'+labcity+'_SampleOpening_'+today+'',
                 exportOptions: {
                    columns: [  1, 2, 3,4,5,6,7,8,9,10,11,12 ]
                }
            }



        ],
        "order": [[ 2, "desc" ]]
    });
} );
</script>

@endsection
