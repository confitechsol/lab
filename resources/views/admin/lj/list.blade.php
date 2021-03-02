@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LJ Reporting</h3>

                  </div>
                   <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lj/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/lc_flagged_mgit/cipopup')
			   @if(count($errors))
                        @foreach ($errors->all() as $error)
                           <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                       @endforeach
                @endif
                <div class="row">
                  <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                      <div class="card" style="border: none;">
                          <div class="card-block">
                            <form action="{{ url('/dashboardlj') }}" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <div class="col-lg-6 col-xlg-6 col-md-6 col-sm-6 col-sm-6">
                                <label>Choose Week<span style="color:red;">*</span></label>
                                <select name="week" class="form-control form-control-line test_reason" required>
                                  @foreach ($data['weeks'] as $key => $week)
                                   <option value="{{$key}}"
                                   @if($data['week'] == $key)
                                   selected
                                   @endif
                                   >{{$week}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-lg-6 col-xlg-6 col-md-6 col-sm-6 col-sm-6">
                                <label>Result<span style="color:red;">*</span></label>
                                <select name="result" class="form-control form-control-line" >
                                  <option value="">--Select--</option>
                                  @foreach ($data['result_data'] as $key => $result_data)
                                  <option value="{{$key}}"
                                  @if($data['result_data'] == $key)
                                  selected
                                  @endif
                                  >{{$result_data}}</option>
                                 @endforeach                                                                    
                                </select>
                                <input type="hidden" name="log_ids" value="" id="log_ids" class="form-control form-control-line" />
                              </div>
                              <div class="col-lg-6 col-xlg-6 col-md-6 col-sm-6 col-sm-6 pull-right">
                                <input type="submit" value="Submit" class="btn btn-info btn-sm" />
                              </div>
                            </form>
                          </div>
                      </div>
                  </div>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                          <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                              <div class="scroll-table " >
                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th><input type="checkbox" id="bulk-select-all"></th>
                                          <th>Sample ID</th>
                                          <th>Enroll ID</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>
                                            @if($samples->status==-1 || $samples->status==0)                                                                                        
                                            @elseif($samples->status>=1)
                                            <input class="bulk-selected" type="checkbox" name="smpl_log[]" id="smpl_log_{{ $samples->log_id }}" value="{{ $samples->log_id }}">
                                            @endif
                                          </td>
                                          <td>{{$samples->samples}}</td>
                                          <td>{{$samples->enroll_label}}</td>
                                          <td>
                                            @if($samples->status==-1 || $samples->status==0)
                                            Done
                                            @elseif($samples->status>=1)
                                            <a href="{{ url('/dashboardlj/'.$samples->log_id) }}" class="btn btn-info btn-sm">Detail</a>
                                            @endif
                                          </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                      </table>

                                </div>
                            </div>
                        </div>
                    </div>
                  </form>
                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>

<script>
function openForm(sample_label, log_id, lpa_type){
  $('#sample_id').val(sample_label);
  $('#log_id').val(log_id);
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  if(lpa_type == 'LJ'){
    $("#tube_id_lc").attr("disabled", true);
  }
  if(lpa_type == 'LC'){
    $("#tube_id_lj").attr("disabled", true);
  }
}
function openNextForm(sample_label, log_id, enroll_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  $('#enroll_id').val(enroll_id);
  $('#nextpopupDiv').modal('toggle');
}
</script>
<script>

$(document).ready(function() {
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
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_lj_reporting_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });

    var $bulk_checkboxes = $('.bulk-selected');
    var $bulk_select_all_checkbox = $('#bulk-select-all');
    


        // Automatically Check or Uncheck "all select" checkbox
        // based on the state of checkboxes in the list.
        $bulk_checkboxes.click(function(){
          
            if( $bulk_checkboxes.length === $bulk_checkboxes.filter(':checked').length ){
                $bulk_select_all_checkbox.prop('checked', true);                

            }

            var selected = [];
                var $checkboxes = $('.bulk-selected:checked');           
                $("#log_ids").val("");

                      $checkboxes.each(function(i, e){
                      selected.push( $(e).val() );
                      // Last iteration of the loop.
                      if( i === $checkboxes.length - 1 ){
                          $("#log_ids").val( selected.join(',') );
                      }
                  });
        });


        // Check or Uncheck checkboxes based on the state
        // of "all select" checkbox.
        $bulk_select_all_checkbox.click(function(){
            var checked = $(this).prop('checked');
            $('.bulk-selected').prop('checked', checked);

            var selected = [];
            var $checkboxes = $('.bulk-selected:checked');           
            $("#log_ids").val("");

                  $checkboxes.each(function(i, e){
                  selected.push( $(e).val() );
                  // Last iteration of the loop.
                  if( i === $checkboxes.length - 1 ){
                      $("#log_ids").val( selected.join(',') );
                  }
              });
        });
        
} );
</script>

@endsection
