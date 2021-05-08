
@extends('admin.layout.app')
@section('content')
<style>
  .activa{
    background-color:#FFDFBF!important;
    color:#1E88E5;
    font-weight: bold;
    font-family: serif;
  }
  .history-activa{
    background-color:#FFDFBF!important;
    color:#1E88E5;
    font-weight: bold;
    font-family: serif;
  }
  input[type="checkbox"][readonly] {
    pointer-events: none;
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
  }
  
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .hide_column {
      display : none;
  }
  @keyframes spinner {
    to {transform: rotate(360deg);}
  }
   
  .spinner:before {
    content: '';
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    margin-left: -10px;
    border-radius: 50%;
    border: 2px solid #ccc;
    border-top-color: #333;
    animation: spinner .6s linear infinite;
  }
  </style>
 <div class="page-wrapper">
            <div class="container-fluid">
              <div class="row page-titles">
                  <div class="col-md-5 col-8 align-self-center">
                      <h3 class="text-themecolor m-b-0 m-t-0">PCR</h3>

                  </div>

                  <div class="col-md-7 col-4 align-self-center">
                    <form action="{{ url('/pcr/print') }}" method="post" >
                    <!--   <input type ="hidden" name="enroll" value = "1"> -->
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="pull-right btn-sm btn-info" >Print</a>
                    </form>
                 </div>

              </div>
              <div class="row"> </div>

                <div class="row">
                    <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
                    <div class="col-lg-12 col-xlg-12 col-md-12 col-sm-12" >
                        <div class="card" >
                            <div class="card-block col-lg-12 col-xlg-12 col-md-12 col-sm-12 col-sm-12">
                              <button class="btn-sm btn-info filterBtn" value="1st line LPA" id="default-btn">1st line LPA&nbsp;<span id="tot_1st_lpa">( 0 )</span></button>
                                  <button class="btn-sm btn-info filterBtn" value="2nd line LPA">2nd line LPA&nbsp;<span id="tot_2nd_lpa">( 0 )</span></button>
                                <div class="table-scroll" >
                                    <table id="exampl" class="table table-striped table-bordered responsive col-xlg-12" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                              <th><input type="checkbox" id="bulk-select-all"></th>
                                              <th class="hide">ID</th>
                                              <th>Enrollment ID</th>
                                              <th>Sample ID</th>
                                              <th>Date of Decontamination </th>
                                              <th>Action</th>
                                              <th>Microscopy result</th>
                                              <th>Date of Extraction</th>
                                              <th>LPA test type</th>
                                              <th>PCR completed</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <tr class="sel"> 
                                            <td></td>
                                            <td class="hide"></td>                                                                                                                      
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>                                            
                                          </tr>

                                         {{--  @if($data['sample'])
                                            @foreach ($data['sample'] as $key=> $samples)

                                                  <tr>
                                                    <td>
                                                      @if($samples->STATUS!=0)
                                                        <input class="bulk-selected" type="checkbox" id="sample_id_{{ $samples->sample_id }}" value="{{ $samples->sample_id }}" />
                                                        <input type="hidden" name="enroll_id_{{$samples->sample_id}}" id="enroll_id_{{$samples->sample_id}}" value="{{ $samples->enroll_id }}" />
                                                        <input type="hidden" name="samples_{{$samples->sample_id}}" id="samples_{{$samples->sample_id}}" value="{{ $samples->samples }}" />
                                                        <input type="hidden" name="tag_{{$samples->sample_id}}" id="tag_{{$samples->sample_id}}" value="{{ $samples->tag }}" />
                                                        <input type="hidden" name="service_id_{{$samples->sample_id}}" id="service_id_{{$samples->sample_id}}" value="{{ $samples->service_id }}" />
                                                        <input type="hidden" name="rec_flag_{{$samples->sample_id}}" id="rec_flag_{{$samples->sample_id}}" value="{{ $samples->rec_flag }}" />
                                                      @endif
                                                    </td>
                                                    <td class="hide">{{$samples->ID}}</td>
                                                    <td>{{$samples->enroll_label}}</td>
                                                    <td>{{$samples->samples}}</td>
                                                    
                                                    <td>
                                                   
                                                    </td>
                                                    <td>
                                                      @if($samples->STATUS==0)
                                                      Done
                                                      @else
                                                    <button type="button" onclick="openCbnaatForm({{$samples->sample_id}})" class="btn btn-info btn-sm resultbtn" >Submit</button>
                                                    @endif
                                                    </td>
                                                    <td>{{$samples->result}}</td>
                                                     
                                                    <td>{{$samples->tag}}</td>
                                                    <td>
                                                      @if($samples->completed==1)
                                                      yes
                                                      @else
                                                      no
                                                      @endif
                                                    </td>
                                                </tr>

                                          @endforeach
                                        @endif --}}
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
<div class="modal fade" id="myModal" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">PCR Result</h4>
        </div>

         <form class="form-horizontal form-material" action="{{ url('/PCR') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
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
                <input type="hidden" name="sampleID" id="sampleID" value="">
                <input type="hidden" name="serviceId" id="serviceId" value="">				
                <input type="hidden" name="rec_flag" id="recFlagId" value="">

                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="sampleid" id="sampleid">

                       </select>
                   </div> --}}
                <br>

                <label class="col-md-12"><h5>PCR Completed:</h5></label>
                    <div class="col-md-12">
                       <select class="form-control form-control-line sampleId" name="completed" value="" id="completed" required>
                        <option value="">select</option>
                        <option value="1">Yes</option>
                        <option value="0">Repeat PCR</option>
                       </select>
                   </div>
                <br>

                <label class="col-md-12"><h5>Comments:</h5></label>
                    <div class="col-md-12">
                      <textarea name="comments" class="form-control form-control-line" id="comments" rows="5" cols="5"></textarea>
                   </div>



            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="button" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>

      </form>
      </div>
    </div>
 </div>
<script>
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

  $(".resultbtn").click(function(){
      $('#sample_id').val($(this).val());
    });

    $('#confirmDelete').on('show.bs.modal', function (e) {

    // Pass form reference to modal for submission on yes/ok
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-footer #confirm').data('form', form);
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

          //var $modal = $('#myModal')
          ;
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
              var sampleids ="";
              var err_sample_id = [];
              var success_sample_id = "";
              var samples_data = [];
              $("#node").html("");
            //
            $checkboxes.each(function(i, e){
              //console.log($("#enroll_id_7").val());
              enroll_id=$("#enroll_id_"+$(e).val()).val();
              sampleids = $("#samples_"+$(e).val()).val();
              tag=$("#tag_"+$(e).val()).val();
              service_id=$("#service_id_"+$(e).val()).val();
              rec_flag=$("#rec_flag_"+$(e).val()).val();
              sample_id=$(e).val();             

              samples_data.push({
                sample_id: sample_id,
                enroll_id: enroll_id,
                service_id: service_id,
                tag: tag,
                rec_flag: rec_flag,               
              });
        
            });

            for(i=0; i < samples_data.length; i++)
            {
                      $.ajax({
                      url: "{{url('check_for_sample_already_process_pcr')}}"+'/'+samples_data[i].sample_id+'/'+samples_data[i].enroll_id+'/'+samples_data[i].service_id+'/'+samples_data[i].tag+'/'+samples_data[i].rec_flag,
                      type:"GET",
                      processData: false,
                      contentType: false,
                      dataType: 'json',
                      success: function(response){
                        console.log(response);
                        
                      if(response.result == 1){
                          $('.alert-danger').removeClass('hide');
                          $('.alert-danger').show();
                          $('.alert-danger').html("Sorry!! Action already taken of the selected Sample");
                                        $('#nxtconfirm').prop("type", "button");
                                        e. preventDefault();                                        
                        }else{
                          /* $('.alert-danger').addClass('hide');
                          $('.alert-danger').hide();                          
                          $('#nxtconfirm').prop("type", "submit");
                          $("#nxtconfirm").text("OK"); */
                            
                          html+= '<input type="hidden" name="enrollId'+response.sample_id+'" value="'+$("#enroll_id_"+response.sample_id).val()+'">';                                          
                          html+='<input type="hidden" name="tag'+response.sample_id+'"  value="'+$("#tag_"+response.sample_id).val()+'">';
                          html+='<input type="hidden" name="sampleID[]"  value="'+response.sample_id+'">';
                          html+='<input type="hidden" name="serviceId'+response.sample_id+'"  value="'+$("#service_id_"+response.sample_id).val()+'">';				
                          html+='<input type="hidden" name="rec_flag'+response.sample_id+'"  value="'+$("#rec_flag_"+response.sample_id).val()+'">';                         
                          html+='<input type="hidden" name="sample_ids'+response.sample_id+'"  value="'+$("#samples_"+response.sample_id).val()+'">';
                            
                            $("#node").append(html);
                            html = "";                          
                          }
                      },
                    failure: function(response){
                      console.log("err")
                    }
                });
            }

            $('#myModal').modal('toggle');

        }

 function openCbnaatForm(sample_id){

  $("#node").html("");
  $('.bulk-selected').prop('checked', false);
  $('#bulk-select-all').prop('checked', false);
  $('#sample_id_'+sample_id).prop('checked', true);
    bulk_action_review();

  //console.log("sample_ids", sample_ids.split(','));
  /* $("#enrollId").val(enroll_id);
  $("#tag").val(tag);
  
  $("#sampleID").val(sample_id);
  $("#serviceId").val(service_id);	
  $("#recFlagId").val(rec_flag);

  var sampleArray = sample_ids.split(',');
  $('#sampleid option').remove();
  $.each(sampleArray, function (i, item) {
      $('#sampleid').append($('<option>', {
          text : item
      }));
  });
  $('#myModal').modal('toggle'); */

 }

</script>
<script>

function arrangeTable(tag)
{

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

  var url = '{{ route("ajax_pcr_list") }}';

    $('#exampl').DataTable({
        dom: 'Bfrtip',
        bDestroy: true,
            //stateSave: true,
		pageLength:25,
    processing: true,
    serverSide: true,
            serverMethod: 'post',
                          language: {
                              loadingRecords: '&nbsp;',
                              //processing: 'Loading...'
                              processing: '<div class="spinner"></div>'
                          } ,        
                ajax: {
                          url: url,	
                          data: {tag: tag},	  
                          headers: 
                          {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                        },
                        drawCallback: function (settings) { 
                            // Here the response
                            var response = settings.json;
                            //console.log(response);                            
                             $('#tot_1st_lpa').html('('+response.no_1st_lpa+')');
                            $('#tot_2nd_lpa').html('('+response.no_2st_lpa+')');                            
                          },
                columns: [  
                          { data: 'inputs'}, 
                          { data: 'ID',className: "hide_column"},                                                                                    
                          { data: 'enroll_label'},
                          { data: 'sample_label' },
                          { data: 'sample_test_date' },
                          { data: 'action' },
                          { data: 'sample_result' },
                          { data: 'created_extraction' },
                          { data: 'tag' },
                          { data: 'is_completed' },                        
                      ],
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'LIMS_DNAextraction_'+today+''
            },
            {
              text: 'Submit',            
                action: bulk_action_review
            }
        ],
        "order": [[ 1, "desc" ]],
        columnDefs: [
                          { targets: [0], orderable: false }
                        ]
    });
}

$(document).ready(function() {

  arrangeTable('1st line LPA');
  $('#default-btn').css('background', '#1e88e5');
    $('#default-btn').css('border', '#1e88e5');

    $('#default-btn').css('background', '#FFA500');
    $('#default-btn').css('border', '#FFA500'); 

  $('.filterBtn').on('click', function(){

    var tag = "";

    tag = $(this).val();

    $('.filterBtn').css('background', '#1e88e5');
        $('.filterBtn').css('border', '#1e88e5');

        $(this).css('background', '#FFA500');
        $(this).css('border', '#FFA500');

    arrangeTable(tag);

});
  
	
	//Confirm ok submit
	$('.resultbtn, #confirm').click( function(e) {
            $('.alert-danger').addClass('hide');
							$('.alert-danger').hide();
							//$('form#cbnaat_result').submit();	
							$('#confirm').prop("type", "submit");
							$("#confirm").text("OK");		
	});


} );
</script>

@endsection
