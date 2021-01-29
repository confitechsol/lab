@extends('admin.layout.app')
@section('content')
<style>
#pageloader
{
	top: 0;
    bottom: 0;
    left: 0;
    right: 0;
	position: fixed;
    height:100%;
	width:100%;
	background:rgba(0, 0, 0, 0.2);
	opacity:.7;
	z-index:9999;
	display:none;
}
#pageloader .loader
{
  left: 50%;
  margin-left: -32px;
  margin-top: -32px;
  position: absolute;
  top: 50%;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">Microscopy Next Step</h3>

                  </div>
                   <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/review_microscopy/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/microscopyreview/resultpopup')
              @include('admin/microscopy/nextpopup')
              <div class="row">
                <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
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

                                              <th>Test to be performed</th>
                                              <th>Tests in process</th>
                                              <th>Tests for review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                              <td>{{$data['microscopy_test']}}</td>
                                              <td>{{$data['microscopy_tested']}}</td>
                                              <td>{{$data['microscopy_review']}}</td>
                                         </tr>


                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
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
                                              <th><input type="checkbox" id="bulk-select-all"></th>
                                              <th class="hide">ID</th>
                                              <th>Lab Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Visual appearance</th>
                                              <th>Next Step </th>
                                              <th>Microscopy method (ZN OR FM)</th>
											   <th>Test Requested</th>
                                              <th>Reason for test (DX/FU)</th>
                                               <th>Follow up month</th>
                                              <th>Date of Receipt</th>
                                              <th>Microscopy result</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)                                          
                                          <tr>
                                            <td>
                                                   
                                                    <input class="bulk-selected" type="checkbox" value="{{ $samples->log_id}}">
                                                   
                                                </td>
                                            <td class="hide">{{$samples->ID}}</td>
                                            <td>{{$samples->label}}</td>
                                            <td>{{$samples->sample_label}}</td>
                                            <td>{{$samples->sample_quality}}</td>
                                            <td>
                                              @if($samples->status==2)
                                              <button onclick="openNextForm('{{$samples->sample_label}}', {{$samples->log_id}},'{{$samples->service_id}}',{{$samples->enrollID}},{{$samples->sample_id}},'{{$samples->tag}}',{{$samples->rec_flag}})" type="button" class = "btn btn-info btn-sm  nextbtn">Submit</button>
                                              @elseif($samples->status==0)
                                              Done
                                              @else
                                              Storage
                                              @endif

                                            </td>
                                            <td>
                                              {{$samples->service_id == 1? "ZN Microscopy" : "FM Microscopy"}}
                                            </td>
											<td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                            <td>
                                              @if($samples->reason=='Diagnosis')
                                              DX
                                              @elseif($samples->reason=='Follow up')
                                              FU
                                              @else
                                              {{$samples->reason}}
                                              @endif
                                            </td>
                                            <td>{{$samples->fu_month}}</td>
                                            <td><?php echo date('d-m-Y',strtotime($samples->receive)) ?></td>
                                             <td>
                                               @if($samples->status==0)
                                               {{$samples->stage}}
                                               @else
                                               <a href="#" onclick="openResultForm('{{$samples->sample_label}}', {{$samples->log_id}}, '{{$samples->result}}','{{$samples->serviceID}}','{{$samples->service_id}}',{{$samples->enrollID}},{{$samples->sample_id}},'{{$samples->tag}}',{{$samples->rec_flag}} )">{{$samples->stage}}</a>
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


{{-- MODAL FOR BULK REVIEW --}}
    <div class="modal fade" id="modal-bulk-review" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Microscopy Result</h4>
                </div>

                <form method="post"
                      class="form-horizontal form-material"
                      action="{{ route('microscopy_review.send-review.bulk') }}" id="deconbulkform">
                    
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
                    <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sample_ids" value="">                        

                        <div class="row">
                    <div class="col">
                        <label class="col-md-12">Result<span class="red">*</span></label>
                        <div class="col-md-12">
                           <select name="service_id1" class="form-control form-control-line test_reason" id="service_id1" required>
                              <option value="">--Select--</option>
                              <!--<option value="3" id="dna">Decontamination DNA extraction</option>
                              <option value="3" id="lc">Decontamination for AFB Culture Liquid</option>
                              <option value="3" id="lj">Decontamination for AFB Culture Solid</option>
                              <option value="3" id="Sent_for">Decontamination for Culture LC and LJ both</option>-->
                              <option value="3" id="dna">Decontamination</option>
                              <option value="4" id="cbnaat">CBNAAT</option>
                              <option value="8" id="dna1">LPA 1st Line</option>
                              <option value="8" id="dna2">LPA 2nd Line</option>
                              <option value="8" id="dnaboth">LPA 1st and 2nd Line</option>
                              <option value="16" id="solid_culture">Solid Culture</option>
                              <option value="16" id="liquid_culture">Liquid Culture</option>
                              <option value="16" id="both">Solid and Liquid Culture</option>
                              <option value="11" id="storage">Sent for storage</option>
                              <option value="25" id="Sent_for">Sent for microbiologist</option>
                              <!-- <option value="12" id="Sent_for">Sent for microbiologist</option> -->
                     </select>
                       </div>
                    </div>       
                  </div>

                  <div class="row">
                    <div class="col">
                        <label class="col-md-12">Comments</label>
                        <div class="col-md-12">
                          <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                       </div>
                    </div>
                </div>


                    </div>
                    <div class="modal-footer">
                        <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
                        <button class="btn btn-default add-button cancel btn-md"
                                type="button"
                                data-dismiss="modal">Cancel</button>

                        <button class="pull-right btn btn-primary btn-md" type="submit">Ok</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- MODAL FOR BULK REVIEW - ENDS --}}

<script>
$(document).ready(function(){
  $("#nxtpopup").on("submit", function(){
    $("#pageloader").fadeIn();
	var zIndex = 9999;

    if ($('body').hasClass('modal-open')) {
        zIndex = parseInt($('div.modal').css('z-index')) + 1;
    }

    $("#pageloader").css({
        'display': 'block',
        'z-index': zIndex
    });

    setTimeout(function(){$("#pageloader").css("display", "none");}, 5000);
  });//submit
});//document ready

$(function(){


  var confirmDelete = true;
  $(".resultbtn").click(function(){
    $('#resultpopupDiv').modal('toggle');
    $('#sample_id').val($(this).val());
  });
  // $(".nextbtn").click(function(){
  //   $('#nextpopupDiv').modal('toggle');
  //   $('#next_sample_id').val($(this).val());
  // });
});

function openResultForm(sample_label, log_id, result, serviceID,service_id,enroll_id,sample_id,tag,rec_flag){
  $('#sample_id').val(sample_label);
  $('#result_log_id').val(log_id);
  $('#type').val('review');
  $('#result').val(result);
  $('#serviceID').val(serviceID);
  
  $("#rsltenrollId").val(enroll_id);
  $("#rslttagId").val(tag);  
  $("#rsltsampleId").val(sample_id);
  $("#rsltserviceId").val(service_id);	
  $("#rsltrecFlagId").val(rec_flag);

  if(serviceID=='1')
  {
    $('#allresults option').remove();
    $('#allresults').append($('<option>', {
        text : '--Select--',
        value : ''
    }));
    $('#allresults').append($('<option>', {
        text : 'Negative/Not Seen',
        value : 'Negative/Not Seen'
    }));
	
	 $('#allresults').append($('<option>', {
            text : 'Positive',
            value : 'Positive'
		}));
		
	 $('#allresults').append($('<option>', {
            text : '1+positive',
            value : '1+positive'
        }));
      $('#allresults').append($('<option>', {
            text : '2+positive',
            value : '2+positive'
        }));
      $('#allresults').append($('<option>', {
            text : '3+positive',
            value : '3+positive'
      }));
    $('#allresults').append($('<option>', {
          text : 'Sc 1',
          value : 'Sc 1'
      }));

    $('#allresults').append($('<option>', {
          text : 'Sc 2',
          value : 'Sc 2'
      }));
    $('#allresults').append($('<option>', {
          text : 'Sc 3',
          value : 'Sc 3'
      }));
    $('#allresults').append($('<option>', {
          text : 'Sc 4',
          value : 'Sc 4'
    }));
    $('#allresults').append($('<option>', {
          text : 'Sc 5',
          value : 'Sc 5'
      }));

    $('#allresults').append($('<option>', {
          text : 'Sc 6',
          value : 'Sc 6'
      }));
    $('#allresults').append($('<option>', {
          text : 'Sc 7',
          value : 'Sc 7'
      }));
     $('#allresults').append($('<option>', {
          text : 'Sc 8',
          value : 'Sc 8'
      }));
      $('#allresults').append($('<option>', {
            text : 'Sc 9',
            value : 'Sc 9'
        }));

     
      //$('#allresults').append($('<option>', {
      //      text : '4+positive',
     //       value : '4+positive'
     // }));
  }
  else
  {
    $('#allresults option').remove();
    $('#allresults').append($('<option>', {
        text : '--Select--',
        value : ''
    }));
    $('#allresults').append($('<option>', {
        text : 'Negative/Not Seen',
        value : 'Negative/Not Seen'
    }));
	
	 $('#allresults').append($('<option>', {
          text : 'Positive',
          value : 'Positive'
      }));
	  
    $('#allresults').append($('<option>', {
          text : '1+positive',
          value : '1+positive'
      }));
    $('#allresults').append($('<option>', {
          text : '2+positive',
          value : '2+positive'
      }));
     $('#allresults').append($('<option>', {
          text : '3+positive',
          value : '3+positive'
      }));
	  
	     $('#allresults').append($('<option>', {
          text : 'Sc 1',
          value : 'Sc 1'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 2',
          value : 'Sc 2'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 3',
          value : 'Sc 3'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 4',
          value : 'Sc 4'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 5',
          value : 'Sc 5'
      }));
	    $('#allresults').append($('<option>', {
          text : 'Sc 6',
          value : 'Sc 6'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 7',
          value : 'Sc 7'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 8',
          value : 'Sc 8'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 9',
          value : 'Sc 9'
      }));
	  /*  $('#allresults').append($('<option>', {
          text : 'Sc 10',
          value : 'Sc 10'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 11',
          value : 'Sc 11'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 12',
          value : 'Sc 12'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 13',
          value : 'Sc 13'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 14',
          value : 'Sc 14'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 15',
          value : 'Sc 15'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 16',
          value : 'Sc 16'
      }));
		$('#allresults').append($('<option>', {
          text : 'Sc 17',
          value : 'Sc 17'
      }));
	   $('#allresults').append($('<option>', {
          text : 'Sc 18',
          value : 'Sc 18'
      }));
  
     $('#allresults').append($('<option>', {
          text : 'Sc 19',
          value : 'Sc 19'
      }));
	  
	  
	  
      $('#allresults').append($('<option>', {
           text : 'NA',
           value : 'NA'
       })); */
  }

  var _sample = $("#result").val();
  if(_sample==''){
    $("#reason_other").addClass("hide");
  }else{
    $("#reason_other").removeClass("hide");
  }
  $('#resultpopupDiv').modal('toggle');
}

function openNextForm(sample_label,log_id,service_id,enroll_id,sample_id,tag,rec_flag){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
  //alert(enroll_id);
  
  $("#enrollID").val(enroll_id);
  $("#tagID").val(tag);  
  $("#SampleID").val(sample_id);
  $("#ServiceID").val(service_id);	
  $("#recFlagID").val(rec_flag);
  $('#nextpopupDiv').modal('toggle');
}
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
                title: 'LIMS_Review_Microscopy_'+today+''
            },
            {
                text: 'Submit',            
                action: bulk_action_review
            }
        ],
         //"order": [[ 1, "desc" ]]
    });
	
});


// ==================================================
        // =========== SCRIPT FOR BULK REVIEW ===============
        // ==================================================

        var $bulk_checkboxes = $('.bulk-selected');
        var $bulk_select_all_checkbox = $('#bulk-select-all');


        // Automatically Check or Uncheck "all select" checkbox
        // based on the state of checkboxes in the list.
        $bulk_checkboxes.click(function(){
            if( $bulk_checkboxes.length === $bulk_checkboxes.filter(':checked').length ){
                $bulk_select_all_checkbox.prop('checked', true);
            }
        });


        // Check or Uncheck checkboxes based on the state
        // of "all select" checkbox.
        $bulk_select_all_checkbox.click(function(){
            var checked = $(this).prop('checked');
            $('.bulk-selected').prop('checked', checked);
        });

// Open bulk editing modal on clicking "Send Selected to Review" button.
        function bulk_action_review(){
            var $modal = $('#modal-bulk-review');
            var selected = [];
            var $checkboxes = $('.bulk-selected:checked');

            // Display an error message and stop if no checkboxes are selected.
            if( $checkboxes.length === 0 ){
                alert("First select one or more items from the list.");
                return;
            }

            $modal.modal('show');

            $checkboxes.each(function(i, e){
                selected.push( $(e).val() );

                // Last iteration of the loop.
                if( i === $checkboxes.length - 1 ){
                    $modal.find('input[name="sample_ids"]').val( selected.join(',') );
                }
            });
        }

        // ==================================================
        // ========= SCRIPT FOR BULK REVIEW - ENDS ==========
        // ==================================================
</script>



@endsection
