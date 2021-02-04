@extends('admin.layout.app')
@section('content')
<style>
  table, th, td {
	  border: 1px solid black;
  }
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
	  /* z-index: 9999;*/
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
                      <h3 class="text-themecolor m-b-0 m-t-0">Microscopy</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/microscopy/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>
              </div>
              @include('admin/microscopy/resultpopup')
              @include('admin/microscopy/nextpopup')
              <div class="row">
                  <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                  <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" style="margin-top: 16px;">
                      <div class="card" style="border: none;">
                          <div class="card-block">
                              <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12" >

                                   
                                      <table style="width:100%">
                                      <thead>
                                          <tr>
                                            <th>Tests to be performed </th>
                                            <th>Tests pending</th>
                                            <th>Tests submitted for review</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                        <tr>
                                          <td>{{$data['summaryTotal']}}</td>
                                          <td>{{$data['summaryDone']}}</td>
                                          <td>{{$data['summarySent']}}</td>
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
                                              <th>Microscopy method (ZN OR FM)</th>
											   <th>Test Requested</th>
                                              <th>Reason for test DX/FU</th>
                                              <th>Follow up month</th>
                                              <th>Result</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          @foreach ($data['sample'] as $key=> $samples)
                                          <tr>
                                            <td>
                                                    @if($samples->status && $samples->status==1)
                                                    <input class="bulk-selected" type="checkbox" value="{{ $samples->log_id }}">
                                                    @endif
                                                </td>

                                            <td class="hide">{{$samples->ID}}</td>
                                            <td>{{$samples->label}}</td>
                                            <td>{{$samples->sample_label}}</td>
                                            <td>{{$samples->sample_quality}}</td>
                                            <td>
                                              {{$samples->service_id == 1? "ZN Microscopy" : "FM Microscopy"}}
                                            </td>
											<td  <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                            <td>{{$samples->reason}}</td>
                                            <td>{{$samples->fu_month}}</td>
                                            <td>
                                              @if($samples->stage!='' && $samples->status!=1)
                                                {{$samples->stage}}
                                              @else
                                              <button onclick="openResultForm('{{$samples->sample_label}}', {{$samples->log_id}}, '{{$samples->result}}','{{$samples->serviceID}}','{{$samples->service_id}}',{{$samples->enrollID}},{{$samples->sample_id}},'{{$samples->tag}}',{{$samples->rec_flag}})",  value="" type="button" class = "btn btn-default btn-sm resultbtn">Add Result</button>
                                              @endif
                                            </td>

                                            <!-- <td>
                                              @if($samples->result)
                                              <button onclick="openNextForm('{{$samples->sample_label}}', {{$samples->log_id}})" type="button" class = "btn btn-default btn-sm  nextbtn">Next</button>
                                              @endif

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
                      action="{{ route('microscopy.send-review.bulk') }}" id="deconbulkform">
                    
                    @if(count($errors))
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                        @endforeach
                    @endif
                    <div class="alert alert-danger hide"><h4></h4></div>
                    <div class="modal-body">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sample_ids" value="">

                        <br>
                        <label class="col-md-12">
                            <h5>Microscopy<span class="red">*</span></h5>
                        </label>
                        <div class="col-md-12">
                            <input type="date"
                                   name="test_date"
                                   class="form-control form-control-line sampleId"
                                   value="<?php echo date("Y-m-d");?>"
                                   max="<?php echo date("Y-m-d");?>"
                                   required>
                        </div>

                        <div class="row">
                    <div class="col">
                        <label class="col-md-12">Result<span class="red">*</span></label>
                        <div class="col-md-12">
                           <!-- <input type="text" name="sample_quality[]" class="form-control form-control-line" required> -->
                           <select name="result" id="allresults" class="form-control form-control-line" required="">
                             <!-- <option value="">--Select--</option>
                             <option value="Negative">Negative</option>
                             <option value="Scanty">Scanty</option>
                             <option value="1+positive">1+positive</option>
                             <option value="2+positive">2+positive</option>
                             <option value="3+positive">3+positive</option> -->
                           <option value="">--Select--</option><option value="Negative/Not Seen">Negative/Not Seen</option><option value="Positive">Positive</option><option value="1+positive">1+positive</option><option value="2+positive">2+positive</option><option value="3+positive">3+positive</option><option value="Sc 1">Sc 1</option><option value="Sc 2">Sc 2</option><option value="Sc 3">Sc 3</option><option value="Sc 4">Sc 4</option><option value="Sc 5">Sc 5</option><option value="Sc 6">Sc 6</option><option value="Sc 7">Sc 7</option><option value="Sc 8">Sc 8</option><option value="Sc 9">Sc 9</option></select>
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
  $("#resultpopup").on("submit", function(){
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
  // $(".resultbtn").click(function(){
  //   $('#resultpopupDiv').modal('toggle');
  //   $('#sample_id').val($(this).val());
  // });
  // $(".nextbtn").click(function(){
  //   $('#nextpopupDiv').modal('toggle');
  //   $('#next_sample_id').val($(this).val());
  // });
});
function openResultForm(sample_label, log_id, result, serviceID,service_id,enroll_id,sample_id,tag,rec_flag){
  $('#sample_id').val(sample_label);
  $('#result_log_id').val(log_id);
  $('#result').val(result);
  $('#serviceID').val(serviceID);
  
  $("#rsltenrollId").val(enroll_id);
  $("#rslttagId").val(tag);  
  $("#rsltsampleId").val(sample_id);
  $("#rsltserviceId").val(service_id);	
  $("#rsltrecFlagId").val(rec_flag);
  
  if($('#type').val()!='review'){
      $("#reason_other").addClass("hide");
  }
  // alert(serviceID)
  if(serviceID=='1' || service_id == 1)
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

     
	   
     // $('#allresults').append($('<option>', {
    //        text : 'NA',
    //        value : 'NA'
   //   }));
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
	  /* $('#allresults').append($('<option>', {
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
      })); */
      $('#allresults').append($('<option>', {
           text : 'NA',
           value : 'NA'
       }));
  }

  $('#resultpopupDiv').modal('toggle');
}
function openNextForm(sample_label, log_id){
  $('#next_sample_id').val(sample_label);
  $('#next_log_id').val(log_id);
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
                title: 'LIMS_Microscopy_'+today+''
            },
            ,
            {
                text: 'Send Selected to Review',            
                action: bulk_action_review
            }
        ]
         //"order": [[ 1, "desc" ]]
    });
	
	
} );


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
