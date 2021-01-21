
@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Microbiologistsss</h3>

                  </div>

              </div>

              <!-- <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                  @if($data['summary'])
                  <div class="row">
                    <div class="col">
                      No. Of Tests Submitted For Review
                    </div>
                    <div class="col">
                      No. Of Tests Reviewed
                    </div>
                  </div>

                    <div class="row">
                      <div class="col">
                        @foreach ($data['summary']['todo'] as $key=> $values)
                        <div class="row">
                          <div class="col">
                          {{$values->name}}: {{$values->cnt}}
                          </div>
                        </div>
                        @endforeach
                      </div>
                      <div class="col">
                        @foreach ($data['summary']['done'] as $key=> $values)
                        <div class="row">
                          <div class="col">
                          {{$values->name}}: {{$values->cnt}}
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>



                  @endif

                </div>
             </div> -->

              <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >


                                      <style>
                                      table, th, td {
                                          border: 1px solid black;
                                      }
                                      </style>
                                      <table style="width:100%">
                                        <thead>
                                            <tr>

                                              <th>Test Name</th>
                                              <th>Number of tests to be reviewed</th>

                                            </tr>

                                        </thead>
                                        <tbody>
                                          @foreach ($data['summary']['todo'] as $key=> $values)
                                          <tr>
                                           <td>{{$values->name}}</td>
                                           <td>{{$values->cnt}}</td>
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

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >

                                    <!-- <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%"> -->
                                      <style>
                                      table, th, td {
                                          border: 1px solid black;
                                      }
                                      </style>
                                      <table style="width:100%">
                                        <thead>
                                            <tr>

                                              <th>Test Name</th>
                                              <th>Number of tests reviewed</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['summary']['done'] as $key=> $values)
                                          <tr>
                                           <td>{{$values->name}}</td>
                                           <td>{{$values->cnt}}</td>
                                         </tr>
                                         @endforeach


                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


               <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">


                                    <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-expanded="true">CURRENT</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">HISTORY</a>
                                    </li>


                              </ul>
                          </div>
              </div>

                <div class="row tab-content">
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 tab-pane active" id="tab1" role="tabpanel" aria-expanded="true">
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="scroll-table" >

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Patient Name </th>
                                              <th>Referal Facility</th>
                                              <th>Date of Receipt</th>
                                              <th>Sample type</th>
                                              <th>Test To  Review</th>
                                              <th>Detail</th>
                                              <th>Remark</th>
                                              <th>Result</th>
                                              <th>Next Step</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)
                                                  <tr>

                                                    <td>{{$samples->enroll_l}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    <td>{{$samples->p_name}}</td>
                                                    <td></td>
                                                    <td><?php echo date('d/m/Y', strtotime($samples->date)); ?></td>
                                                    <td>{{$samples->sample_type}}</td>
                                                    <!-- <td><a href={{$samples->url}}>{{$samples->service_name}}</a></td> -->
                                                    <td>{{$samples->service_name}}</td>
                                                    <td>{{$samples->detail}}</td>
                                                    <td>{{$samples->remark}}</td>
                                                    <td>

                                                    <button type="button" onclick="openCbnaatForm1({{$samples->enroll}},'{{$samples->sample}}','{{$samples->service}}','{{$samples->samples}}')" class="btn btn-info btn-sm resultbtn" >View</button>

                                                    </td>
                                                    <td>

                                                    <button type="button" onclick="openCbnaatForm({{$samples->enroll}},'{{$samples->samples}}','{{$samples->service}}')" class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                    </td>


                                                </tr>

                                          @endforeach
                                        @endif
                                      </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 tab-pane" id="tab2" role="tabpanel" aria-expanded="true">
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="scroll-table" >

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Patient Name </th>
                                              <th>Referal Facility</th>
                                              <th>Date of Receipt</th>
                                              <th>Sample type</th>
                                              <!-- <th>Test To  Review</th> -->
                                              <th>Detail</th>
                                              <th>Remark</th>
                                              <th>Next Step</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if($data['done'])
                                            @foreach ($data['done'] as $key=> $samples)
                                                  <tr>

                                                    <td>{{$samples->enroll_l}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    <td>{{$samples->p_name}}</td>
                                                    <td></td>
                                                    <td><?php echo date('d/m/Y', strtotime($samples->date)); ?></td>
                                                    <td>{{$samples->sample_type}}</td>
                                                    <!-- <td><a href={{$samples->url}}>{{$samples->service_name}}</a></td> -->
                                                    <td>{{$samples->detail}}</td>
                                                    <td>{{$samples->remark}}</td>
                                                    <td>{{$samples->next}}</td>




                                                </tr>

                                          @endforeach
                                        @endif
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
<div class="modal fade" id="myModal1" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title">Result</h4> -->
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result1">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollId" value="">
                <input type="hidden" name="service" id="service" value="">
                <input type="hidden" name="type" id="type" value="1">


                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid" value="">

                       </select>
                   </div>
                <br>




                <label class="col-md-12"></label>
                    <div class="col-md-12">
                       <div id="resultData"></div>
                   </div>
                <br>




            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <!-- <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button> -->
              <button type="button" class="pull-right btn btn-primary btn-md hide" id="confirm1" data-dismiss="modal">Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Next Step</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/microbiologist') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollId" id="enrollId" value="">
                <input type="hidden" name="service" id="service" value="">


                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid" value="">

                       </select>
                   </div>
                <br>
                <!-- <label class="col-md-12"><h5>Service ID:</h5></label>
                    <div class="col-md-12">
                       <input type="number" class="form-control form-control-line sampleId" name="service" id="service" disabled>

                       </input>
                   </div>
                <br> -->

                <label class="col-md-12"><h5>Next Step:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="nextStep" value="" id="nextStep">
                        <option>select</option>
                        <!-- <option value="Push to  Nikshay">Push to  Nikshay</option> -->
                        <!-- <option value="Print Result">See Result</option> -->
                        <option value="Print 15A form">Print 15A form</option>
                        <option value="Request for Retest">Request for Retest</option>

                       </select>
                   </div>
                <br>
                <label class="col-md-12"><h5>Detail:</h5></label>
                    <div class="col-md-12">
                       <input type="text" class="form-control form-control-line sampleId" name="detail" id="detail">

                       </input>
                   </div>
                <br>
                <label class="col-md-12"><h5>Remark:</h5></label>
                    <div class="col-md-12">
                       <input type="text" class="form-control form-control-line sampleId" name="remark" id="remark">

                       </input>
                   </div>





            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirm" data-dismiss="modal">Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<script>
$(function(){





  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
  });

  /* Form confirm (yes/ok) handler, submits form*/
  $('#confirm1').click( function(){

    var form = $(document).find('form#cbnaat_result1');
      form.submit();
    // console.log( $('#cbnaat_result').serialize() );
    // var data = $('#cbnaat_result').serialize();
    // $.post(window.location.replace("{{ url('/PCR') }}"), data);
    //form.submit();
  });
  $('#confirm').click( function(){
    //var form = $(document).find('form#resultpopup');
    var form = $(document).find('form#cbnaat_result');
      form.submit();
    // console.log( $('#cbnaat_result').serialize() );
    // var data = $('#cbnaat_result').serialize();
    // $.post(window.location.replace("{{ url('/PCR') }}"), data);
    //form.submit();
  });
});


 function openCbnaatForm1(enroll_id, sample_id, service, sample_ids){
    //console.log("sample_ids", sample_ids.split(','));
    $("#enrollId").val(enroll_id);
    $("#service").val(service);

    var sampleArray = sample_ids.split(',');
    $('#sampleid option').remove();
    $.each(sampleArray, function (i, item) {
        $('#sampleid').append($('<option>', {
            text : item
        }));
    });


    //load data
    var details = service + '/' + sample_id + '/' + enroll_id;

    $.ajax({
          url: "{{url('result')}}"+'/'+details,
          type:"GET",
          processData: false,
          contentType: false,
          dataType : "html",
          success: function(data) {

              //console.log('data',data);
              $("#resultData").html(data);
          },
          error: function() {
            console.log("err")
        }
      });


    $('#myModal1').modal('toggle');
 }


 function openCbnaatForm(enroll_id, sample_ids, service){
  //console.log("sample_ids", sample_ids.split(','));
  $("#enrollId").val(enroll_id);
  $("#service").val(service);

  var sampleArray = sample_ids.split(',');
  $('#sampleid option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleid').append($('<option>', {
          text : item
      }));
  });



  $('#myModal').modal('toggle');
 }

</script>


@endsection
