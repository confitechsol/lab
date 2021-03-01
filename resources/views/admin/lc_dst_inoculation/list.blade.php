@extends('admin.layout.app')
@section('content')
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">LC DST Inoculation</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/lcdstinoculation/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/lc_dst_inoculation/cipopup')
              @include('admin/lc_dst_inoculation/resultpopup')
                <div class="row">

                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                        <div class="card" style="border: none;">
                            <div class="card-block">
                                <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" style="width: auto;overflow-y: scroll;">

                                  <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>Sample ID</th>
                                         <!--  <th>TUBE sequence ID</th> -->
                                          <th>Positive MGIT sequence ID</th>
                                          <th>DST carrier set ID  1</th>
                                          <th>DST carrier set ID 2</th>
                                          <th>DST carrier set ID 3</th>
                                          <th>Drugs for DST request</th>
                                          <th>Date of DST inoculation </th>
                                          <th>Results</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                        @foreach ($data['sample'] as $key=> $samples)
                                        <tr>
                                          <td>{{$samples->samples}}</td>
                                          <!-- <td>
                                            @if($samples->tube_id_lj)
                                            {{$samples->tube_id_lj}}
                                            @else
                                            {{$samples->tube_id_lc}}
                                            @endif
                                          </td> -->
                                          <td>{{$samples->mgit_id}}</td>
                                          <td>{{$samples->dst_c_id1}}</td>
                                          <td>{{$samples->dst_c_id2}}</td>
                                          <td>{{$samples->dst_c_id3}}</td>
                                          <td>{{$samples->druglist}}</td>
                                          <td>{{ !empty($samples->inoculation_date) ? date('d-m-Y',strtotime($samples->inoculation_date)) :  date('d-m-Y',strtotime($samples->inc_date)) }}</td>
                                          <td>
                                            @if($samples->status==1)
                                            <button onclick="openForm('{{$samples->samples}}', {{$samples->log_id}}, '{{$samples->lpa_type}}','{{$samples->mgit_id}}',{{$samples->enrollID}},{{$samples->sampleID}},{{$samples->service_id}},'{{$samples->tag}}',{{$samples->rec_flag}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Submit</button>
                                            @elseif($samples->status==0)
                                            Done
                                            @else
                                            <button onclick="resultForm('{{$samples->samples}}', {{$samples->log_id}}, {{$samples->lc_dst_tr_id}},'{{$samples->druglist}}','{{$samples->drug_ids}}',{{$samples->enrollID}},{{$samples->sampleID}},{{$samples->service_id}},'{{$samples->tag}}',{{$samples->rec_flag}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Add Result</button>
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

                </div>

            </div>
            <footer class="footer"> © Copyright Reserved 2017-2018, LIMS </footer>
        </div>

<script>
function openForm(sample_label, log_id, lpa_type,mgit_id=null,enroll_id=null,sample_id=null,service_id=null,tag=null,rec_flag=null){
  $('#sample_id').val(sample_label);
  $('#log_id').val(log_id);
  $('#mgit_seq_id').val(mgit_id);
  
  $("#enrollId").val(enroll_id);
  //$("#tagId").val(lpa_type); 
  $("#tagId").val(tag);  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  
  $('#extractionpopupDiv').modal('toggle');
  $(".datep").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
}
function resultForm(sample_label, log_id, lc_dst_tr_id, druglist, drugid,enroll_id=null,sample_id=null,service_id=null,tag=null,rec_flag=null){

  console.log(druglist);
  drugs=druglist.split(',');
  drugs_id=drugid.split(',');
  var text="";
   for(i=0;i<drugs.length;i++){
  //     text=text+"<div class='col-md-6 dil_2'><label class='col-md-12'>"+drugs[i]+"</label>"+
  //                 "<input type='hidden' id='dil_2_drugName' name='dil_2_drugName[]' value='"+drugs[i]+"'' />"+
  //                 "<div class='col-md-12'>"+
  //                   "<select name='dil_2_drugVal[]'' id='dil_2_drugVal' class='dil_2_drugVal form-control' required >"+
  //                     "<option value=''>---</option>"+
  //                     "<option value='Sensitive'>Sensitive</option>"+
  //                     "<option value='Resistance'>Resistance</option>"+
  //                     "<option value='Contaminated'>Contaminated</option>"+
  //                     "<option value='Not done'>Not done</option>"+
  //                   "</select>"+
  //                "</div>"+
  //              "</div>";
        text=text+" <div ><div class='col'>"+
            "<label class='col-md-12'>"+drugs[i]+"<span class='red'>*</span></label>"+
            "<div class='col-md-12'>"+
               "<select name='"+drugs[i]+"' id='"+drugs[i]+"' class='form-control form-control-line drugnm' required>"+
                 "<option value=''>--Select Result--</option>"+
                 "@foreach ($data['dp_result'] as $key => $result)"+
                  "<option value='{{$result}}'>{{$result}}</option>"+
                 "@endforeach"+
               "</select>"+
           "</div>"+
        "</div><p style='color:red;' class='error_drugnm'></p>"+
/*"<div class='col'>"+
            "<label class='col-md-12'>Repeat "+drugs[i]+"</label>"+
            "<div class='col-md-12'>"+
               "<input type='checkbox' class='form-control-line' name='repeat[]' value='"+drugs_id[i]+"'>"+
           "</div>"+
        "</div>"+*/
		"</div>";
   }

  document.getElementById("drug_names").innerHTML=text;
  $('#next_sample_id').val(sample_label);
  // $('#druglist').val(druglist);
  $('#next_log_id').val(log_id);
  $('#lc_dst_tr_id').val(lc_dst_tr_id);
  
  $("#rslt_enrollId").val(enroll_id);
  //$("#tagId").val(lpa_type); 
  $("#rslt_tagId").val(tag);  
  $("#rslt_sampleID").val(sample_id);
  $("#rslt_serviceId").val(service_id);	
  $("#rslt_recFlagId").val(rec_flag);
  
  $('#resultpopupDiv').modal('toggle');
  $(".datepi").datepicker({
      dateFormat: "dd/mm/yyyy"
  }).datepicker("setDate", "0");
  $("#nxtpopup").attr("action","{{ url('/lc_dst_inoculation') }}/"+log_id);
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
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_lc_dst_inoculation_'+today+''
            }
        ],
        "order": [[ 1, "desc" ]]
    });
	
	
} );
</script>
@endsection
