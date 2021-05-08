@extends('admin.layout.app')
@section('content')
<style>
.setradio{
    position: static !important;
    left: 0 !important;
    opacity: 1 !important;

}
</style>
        <div class="page-wrapper">
            <div class="container-fluid">

              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Barcodes</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <!--form action="{{ url('/barcodes') }}" method="post" >
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="text" name="_next" value="0"-->
                      <span id="genDetails"><?php echo Session::get('barcode_gerator_status'); ?></span>
                      <button type="submit" id="doPollSubmit" onclick="doPoll(0);" class="pull-right btn-sm btn-info" >Generate For Next Year</a>
                    <!--/form-->
                 </div>
              </div>

                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" >
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">

                                    <table id="example" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Action </th>
                                                <!-- <th>Action </th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($years as $key=> $year)
                                            <tr>
                                              <td>{{ $year->year }}</td>
                                              <td>
                                                  <button type="button" class="btn btn-info btn-sm" onclick="openPrintModal({{ $year->year }},'50')"  >Print</button>

                                              </td>
                                              <td>

                                                  <!-- <button type="button" class="btn btn-info btn-sm" onclick="openPrintModal({{ $year->year }},'25')"  >Print 25mm*25mm</button> -->
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
            <footer class="footer">  </footer>
        </div>

        <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->

    <form action="{{ url('/barcodes/print') }}" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Barcodes</h4>
      </div>
      <div class="modal-body" id="printCode">
        <input type="hidden" value="" name="print_type" id="print_type" />
        <input type="hidden" value="" name="year" id="year" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <p>Year: <span id="yeartpl"></span> </p>
        <p>From: <input type="text" name="seqFrm" id="seqFrm"> </p>
        <p>To: &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="seqTo" id="seqTo"> </p>       
              <input type="radio" class="setradio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked="checked" > One set of A and one set of B        
           
              <br><input type="radio" class="setradio" name="inlineRadioOptions" id="inlineRadio2" value="2"> Two sets of A   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-default btn-info" >Submit</button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </form>

  </div>
</div>

<script>
 var totalCount = 0;
function doPoll(nxt){
  $("#doPollSubmit").attr("disabled", "disabled");
  var post = {
    _token: "{{ csrf_token() }}",
      _next:nxt
  };
    $.post("{{ url('/barcodes') }}",post, function(data) {
        console.log(data);
        //alert(data);  // process results here
        $("#genDetails").html("created ("+data.count+" / 99999) records for year:"+data.year);
        if(totalCount <= 99979){ //99979
          totalCount = data.count;
          //setInterval(function() { },5000);
          doPoll(1);
        }else{
          totalCount = 0;
          HoldOn.close();
          location.reload();
        }
      });
    }

    $("#doPollSubmit").click(function(){

      var options = {
          theme:"sk-cube-grid",
        content:'<img style="width:80px;" src="https://www.google.de/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" class="center-block">',
          message:'It might take some hours to finish.<br>Just hold tight and sit back for some time untill the process gets over.Please do not cancel or refresh it in any chance.',
          backgroundColor:"#000000",
          textColor:"#0099FF"
     };
     HoldOn.open(options);

     history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
    window.onbeforeunload = function() {
    return "Data will be lost if you leave the page, are you sure?";
  };
    });

function openPrintModal(year,print_type){
  //console.log(obj.attr('data-sample'));
    $("#year").val(year);
    $("#print_type").val(print_type);
    $("#yeartpl").html(year);
    // $("#year").val()
    $('#myModal').modal('toggle');

}
</script>
   @endsection
