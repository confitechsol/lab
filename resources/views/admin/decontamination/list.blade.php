
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
.container{
        /* overflow: hidden; */
    -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
    filter: blur(13px);
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
                      <h3 class="text-themecolor m-b-0 m-t-0">Decontamination Next Step</h3>

                  </div>
                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/Decontamination/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>
			  
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

                                              <th>Test to be performed</th>
                                              <th>Tests in process</th>
                                              <th>Tests for review</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>



                                              <td>{{$data['decontamination_test']}}</td>
                                              <td>{{$data['decontamination_tested']}}</td>
                                              <td>{{$data['decontamination_review']}}</td>
                                         </tr>


                                      </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				
				
				<!----------loader------------>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12 " >
                        <div class="card" >
                          <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                              <div class="table-scroll" >
                                    <!--<p>Filter by DX/FU/EQA : <input type="text" id="filter_by" name="filter_by">
                                      <button id="filter_button">Apply</button>
                                    </p> -->
                                    <br>
                                    <table id="table_decontamin" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th><input type="checkbox" id="bulk-select-all"></th>
                                              <th class="hide">ID</th>
                                              <th>Enrolment ID</th>
                                              <th>Sample ID</th>
                                              <th>Date of Decontamination</th>
                                              <th>Action</th>
                                              <th>Sample Type</th>
											                        <th>Test Requested</th>
                                              <th>DX/FU</th>
                                              <th>Follow up month</th>
                                              <th>Microscopy Result</th>
                                              <th>Next Step</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>

                                     @if($data['sample'])
                                       @foreach ($data['sample'] as $key=> $samples)
                                            <tr>
                                              <td>
                                                @if($samples->sent_for_service=='' && $samples->status!=0)
                                                  <input class="bulk-selected" type="checkbox" id="smpl_id_{{ $samples->sample_id }}" value="{{ $samples->sample_id }}">
                                                  <input type="hidden" name="enroll_id_{{$samples->sample_id}}" id="enroll_id_{{$samples->sample_id}}" value="{{ $samples->enroll_id }}" />
                                                  <input type="hidden" name="samples_{{$samples->sample_id}}" id="samples_{{$samples->sample_id}}" value="{{ $samples->samples }}" />
                                                  <input type="hidden" name="sent_for_{{$samples->sample_id}}" id="sent_for_{{$samples->sample_id}}" value="{{ $samples->sent_for }}" />
                                                  <input type="hidden" name="tag_{{$samples->sample_id}}" id="tag_{{$samples->sample_id}}" value="{{ $samples->tag }}" />
                                                  <input type="hidden" name="date_{{$samples->sample_id}}" id="date_{{$samples->sample_id}}" value="{{ $samples->date }}" />
                                                  <input type="hidden" name="no_sample_{{$samples->sample_id}}" id="no_sample_{{$samples->sample_id}}" value="{{ $samples->no_sample }}" />
                                                  <input type="hidden" name="service_id_{{$samples->sample_id}}" id="service_id_{{$samples->sample_id}}" value="{{ $samples->service_id }}" />
                                                  <input type="hidden" name="rec_flag_{{$samples->sample_id}}" id="rec_flag_{{$samples->sample_id}}" value="{{ $samples->rec_flag }}" />
                                                  <input type="hidden" name="Deconta_sent_for_{{$samples->sample_id}}" id="Deconta_sent_for_{{$samples->sample_id}}" value="{{ $samples->Deconta_sent_for }}" />
                                                
                                                  @elseif($samples->status==0)
                                                  Done
                                                @else
                                                  reviewed
                                                @endif
                                              </td>
                                              <td class="hide">{{$samples->ID}}</td>
                                              <td>{{$samples->enroll_label}}</td>
                                              <td>{{$samples->samples}}</td>
                                              <td>{{$samples->date}}</td>
                                              <td>                                                
                                                @if($samples->sent_for_service=='' && $samples->status!=0)
                                                <button type="button" onclick="openCbnaatForm({{$samples->sample_id}})"  class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                @elseif($samples->status==0)
                                                Done
                                                @else
                                                reviewed

                                                @endif
                                              </td>
                                              <td>
                                                {{ $samples->sample_type == 'Others'? $samples->others_type : $samples->sample_type }}
                                              </td>
                                              <td <?php echo $data['services_col_color['.$samples->enroll_id.']']=='Y'?'bgcolor="#ccffcc"':""; ?>><?php echo $data['test_requested['.$samples->enroll_id.']'];?></td>
                                              
                                              <td>{{$samples->test_reason}}</td>
                                              <td>{{$samples->fu_month}}</td>
                                              <td>{{$samples->result}}</td>
                                              <td>{{$samples->sent_for_service}}</td>                                           


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
            <footer class="footer"> Â© Copyright Reserved 2017-2018, LIMS </footer>
        </div>
 @if($data['sample'])
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Decontamination Next Step</h4>
        </div>
         <form class="form-horizontal form-material" action="{{ url('/decontamination') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
				 <div class="alert alert-danger hide"><h4></h4></div>
            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-12" id="node"></div>
                {{-- <input type="hidden" name="enrollId" id="enrollId" value="">
                <input type="hidden" name="tag" id="tag" value="">
                 <input type="hidden" name="no_sample" class="form-control form-control-line sampleId" value="" id="no_sample">				 
                <input type="hidden" name="tagId" id="tagId" value="">
                <input type="hidden" name="sampleID" id="sampleID" value="">
                <input type="hidden" name="serviceId" id="serviceId" value="">				
                <input type="hidden" name="rec_flag" id="recFlagId" value="">
                <input type="hidden" name="decontamination_sent_for" id="decontamination_sent_for" value="">
                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                      <input type="text" name="sample_ids" class="form-control form-control-line sample_ids"  id="sample_ids" readonly>
                   </div> --}}
                <br>
                <label class="col-md-12"><h5>Sample sent for:<span id="ssentfor"></span></br><span id="ssentforreq" class="red"></span></h5></label>
                <div class="col-md-12">
                   <select name="service_id[]" class="form-control form-control-line test_reason multi-select-xl" id="service_id" multiple required>
                     <!-- <option value="">--Select--</option> -->
                     @foreach ($data['services'] as $key=> $category)
                     <option value="{{$key}}" id="select{{$key}}">{{$category}}</option>
                     @endforeach
                    <option value="Send to BWM">Send to BWM</option>
                     <!-- <option value="micro" id="micro">Sent for Microbiologist review</option> -->
                   </select>
               </div>

               <label class="col-md-12"><h5>Request for another Sample : </h5></label>
                   <div class="col-md-12">
                      <input type="checkbox"  name="request_another" id="request_another">

                      </input>
                  </div>
               <br>
               <div id="other" class="hide">
                   <label class="col-md-12"><h5>Sample sent for:</h5></label>
                  <div class="col-md-12">
                         <input type="text" id="other" name="other" value="" class="form-control form-control-line">
                  </div>
              </div>
              <br>
               <label class="col-md-12"><h5>Date Of Decontamination</h5></label>
                    <div class="col-md-12">
                       <input type="text" id="test_date" name="test_date" value="" class="form-control form-control-line datepicker" disabled>
                   </div>

                   <label class="col-md-12"><h5>Comments</h5></label>
                        <div class="col-md-12">
                          <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                       </div>


            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirm" onclick="return submit_form()">Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>

 @endif

<script>
function wasDeselected (sel, val) {
  if (!val) {
    return true;      
  }
  return sel && sel.some(function(d) { return val.indexOf(d) == -1; })
}

$(document).on('change', 'select', function (event) {
  var message,
      $select = $(event.target),
      val     = $select.val(),
      sel     = $('select').data('selected');

  // Store the array of selected elements
  $select.data('selected', val);

  // Check the previous and current val
  if ( wasDeselected(sel, val) ) { //alert('desel'+sel); alert('deval'+val);
    //message = "You have deselected this item.";
	$.each(sel, function(index, sell){
		if((sell==3)||(sell==4)||(sell==5)){
		  $("#service_id").find('option[value=3]').prop('disabled',false);
		  $("#service_id").find('option[value=4]').prop('disabled',false);
		  $("#service_id").find('option[value=5]').prop('disabled',false);
		}else if((sell==8)||(sell==10)||(sell==11)){
		  $("#service_id").find('option[value=8]').prop('disabled',false);
		  $("#service_id").find('option[value=10]').prop('disabled',false);
		  $("#service_id").find('option[value=11]').prop('disabled',false);
		} 
    });	
  } else {  //alert('selsel'+sel); alert('seval'+val);
    //message = "You have selected this item.";
	$.each(val, function(index, valll){
		if(valll==3){ 
		  $("#service_id").find('option[value=4]').prop('disabled',true);
		  $("#service_id").find('option[value=5]').prop('disabled',true);
		}else if(valll==4){ 
		  $("#service_id").find('option[value=3]').prop('disabled',true);
		  $("#service_id").find('option[value=5]').prop('disabled',true);
		}else if(valll==5){ 
		  $("#service_id").find('option[value=3]').prop('disabled',true);
		  $("#service_id").find('option[value=4]').prop('disabled',true);
		}else if(valll==8){ 
		  $("#service_id").find('option[value=10]').prop('disabled',true);
		  $("#service_id").find('option[value=11]').prop('disabled',true);
		}else if(valll==10){ 
		  $("#service_id").find('option[value=8]').prop('disabled',true);
		  $("#service_id").find('option[value=11]').prop('disabled',true);
		}else if(valll==11){ 
		  $("#service_id").find('option[value=8]').prop('disabled',true);
		  $("#service_id").find('option[value=10]').prop('disabled',true);
		}
	});
  }
  //alert(message);
});
 $(document).ready(function(){
	  $("#cbnaat_result").on("submit", function(){
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

/*
   $.fn.dataTableExt.afnFiltering.push(

    function( oSettings, aData, iDataIndex ) {
        var reason_test = document.getElementById('filter_by').value;

        var filter_col = 4;

        console.log(reason_test);

        var filter_val=aData[filter_col];
        if ( reason_test == "" )
        {
            return true;
        }
        else if ( reason_test == filter_val)
        {
            return true;
        }

        return false;
    }
) */

    $('#request_another').on('click', function (e) {
      var service = $("#request_another:checked").val();
      var no_sample = $("#no_sample").val();
      console.log(service);
      if(service=="on" && no_sample=='0'){
        alert("standby sample not available");
        $('#request_another').prop('checked', false);
      }

     });


  // var table=$('#table_decontamin').DataTable( {
  //      "order": [[ 0, "desc" ]],
  //      dom: 'Bfrtip',
  //       buttons: [
  //          // 'excel', 'pdf',
  //          'excel'
  //       ]
  //  } );






  $("#service_id").change(function() {
    var id = $(this).children(":selected").attr("id");
    if(id=='select3'){
      $('#tag').val('LC');
    }else if(id=='select4'){
      $('#tag').val('LJ');
    }else if(id=='select5'){
      $('#tag').val('LC & LJ Both');
    }else{
      $('#tag').val('');
    }
  });

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {

      // Pass form reference to modal for submission on yes/ok
      var form = $(e.relatedTarget).closest('form');
      $(this).find('.modal-footer #confirm').data('form', form);
    });


   $('#filter_button').click( function() {
        table.draw();
    } );
});





 function openCbnaatForm(sample_id){
  //console.log("sample_ids", sample_ids.split(','));
  //alert(no);
    $('#smpl_id_'+sample_id).prop('checked', true);
    bulk_action_review();

  /* $("#enrollId").val(enroll_id);
  $('#no_sample').val(no);
  $("#sent_for").val(sent_for);
  $("#test_date").val(test_date);
  //$("#ssentfor").text("("+tag+")");
  $("#sample_ids").val(sample_ids);  
  $("#tagId").val(tag);
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);
  $("#decontamination_sent_for").val(Deconta_sent_for);

  $('#myModal').modal('toggle'); */
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
    $('#table_decontamin').DataTable({
        dom: 'Bfrtip',
		pageLength:25,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_Decontamination_Next_'+today+''
            },
            {
              text: 'Submit',            
                action: bulk_action_review
            }
        ],
        "order": [[ 2, "desc" ]]
    });

});

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

function bulk_action_review(){
            var $modal = $('#myModal');
            //var selected = [];
            var $checkboxes = $('.bulk-selected:checked');          

            // Display an error message and stop if no checkboxes are selected.
            if( $checkboxes.length === 0 ){
                alert("First select one or more items from the list.");
                return;
            }

            var err_html = "";
              var success_html = "";
              var html = "";
              var full_html = "";
              var enroll_id="";
              var sample_id="";
              var service_id="";
              var tag="";
              var rec_flag="";
              var no_sample ="";
              var decontamination_sent_for ="";
              var sampleids ="";
              var err_sample_id = [];
              var success_sample_id = "";
              var samples_data = [];

            //
            $checkboxes.each(function(i, e){
              //console.log($("#enroll_id_7").val());
              enroll_id=$("#enroll_id_"+$(e).val()).val();
              sample_id=$(e).val();
              service_id=$("#service_id_"+$(e).val()).val();
              tag=$("#tag_"+$(e).val()).val();
              rec_flag=$("#rec_flag_"+$(e).val()).val();
              no_sample = $("#no_sample_"+$(e).val()).val();
              decontamination_sent_for = $("#Deconta_sent_for_"+$(e).val()).val();
              sampleids = $("#samples_"+$(e).val()).val();

              samples_data.push({
                sample_id: sample_id,
                enroll_id: enroll_id,
                service_id: service_id,
                tag: tag,
                rec_flag: rec_flag,               
              });
        
            });

              //console.log(samples_data.length);

              for(i=0; i < samples_data.length; i++)
              {
                //var smap = samples_data[i].sample_id;
                $.ajax({
                      url: "{{url('check_for_sample_already_process_mcroscopy_next_deconta')}}"+'/'+samples_data[i].sample_id+'/'+samples_data[i].enroll_id+'/'+samples_data[i].service_id+'/'+samples_data[i].tag+'/'+samples_data[i].rec_flag,
                      type:"GET",
                      processData: false,
                      contentType: false,
                      //async: true,
                      dataType: 'json',
                      success: function(response){
                        console.log(response);
                        if(response.result == 1)
                        {
                          $('.alert-danger').removeClass('hide');
                          $('.alert-danger').show();
                          $('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                                        $('#nxtconfirm').prop("type", "button");
                                        e. preventDefault();
                        }
                        else
                        {
                          //success_sample_id+=response.sample_id;
                          html+= '<input type="hidden" name="enrollId'+response.sample_id+'" value="'+$("#enroll_id_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="tag'+response.sample_id+'"  value="">';                          
                          html+= '<input type="hidden" name="no_sample'+response.sample_id+'" class="form-control form-control-line sampleId" value="'+$("#no_sample_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="tagId'+response.sample_id+'"  value="'+$("#tag_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="sampleID[]"  value="'+response.sample_id+'">';
                          html+='<input type="hidden" name="serviceId'+response.sample_id+'"  value="'+$("#service_id_"+response.sample_id).val()+'">';				
                          html+='<input type="hidden" name="rec_flag'+response.sample_id+'"  value="'+$("#rec_flag_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="decontamination_sent_for'+response.sample_id+'" value="'+$("#Deconta_sent_for_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="sample_ids'+response.sample_id+'"  value="'+$("#samples_"+response.sample_id).val()+'">';
                          $("#node").append(html);
                          html = "";
                        }					
                      },
                    failure: function(response){
                      console.log("err")
                    }
                });
              };            

              $modal.modal('show');
        }
	
//Confirm ok submit
function submit_form(){ 

  var form = $(document).find('#cbnaat_result');
                        form.submit();	

	//alert("here");
/* 	var enroll_id=$("#enrollId").val();
	var sample_id=$("#sampleID").val();
	var service_id=$("#serviceId").val();
	//var STATUS=$("#statusId").val();
	var tag=$("#tagId").val();
	var rec_flag=$("#recFlagId").val();	
  		    
	
	$.ajax({
			  url: "{{url('check_for_sample_already_process_mcroscopy_next')}}"+'/'+sample_id+'/'+enroll_id+'/'+service_id+'/'+tag+'/'+rec_flag,
			  type:"GET",
			  processData: false,
			  contentType: false,
			  //async: true,
			  dataType: 'json',
			  success: function(response){
				  //console.log(response);				  
					if(response==1){
						$('.alert-danger').removeClass('hide');
						$('.alert-danger').show();
						$('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
						$('#confirm').prop("type", "button");
						e.preventDefault();
					}else{
						$('.alert-danger').addClass('hide');
						$('.alert-danger').hide();
						//$('form#cbnaat_result').submit();	
						$('#confirm').prop("type", "submit");
						$("#confirm").text("OK");
						var form = $(document).find('#cbnaat_result');
                        form.submit();				     
						
					}
			  },
			failure: function(response){
				console.log("err")
			}
	}); */
	
}
</script>


@endsection
