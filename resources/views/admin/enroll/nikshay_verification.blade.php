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
    .lblue{ background: #ADD8E6; }
    .lgreen{ background: #90EE90; text-align: center; }

    #exampl{ opacity: 1 !important;}

    table.dataTable thead .lblue{ background: #ADD8E6; }
    table.dataTable thead .lgreen{ background: #90EE90; }


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
              <h3 class="text-themecolor m-b-0 m-t-0">Enrollment with Nikshay Verification</h3>
			   
          </div>
          {{-- <div class="col-md-7 col-4 align-self-center">
            <form action="{{ url('/enroll/print') }}" method="post" target="_blank">           
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="pull-right btn-sm btn-info" >Print</button>
            </form>
         </div> --}}

      </div>
      <?php //dd($data); ?>

        <div class="row">

            <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12" >
                <div class="card" style="border: none;">
                    <div class="card-block">
                        <div class="col-lg-12 col-lg-12 col-md-12 col-sm-12 col-sm-12" width="100%" style="width: auto;overflow-y: scroll;">
							   <!---Custom Filter Start--->
							   <table>
								 <tr>
								   <td>
									 <meta name="csrf-token" content="{{ csrf_token() }}">
									 <input type="text" name="enrollment_no" id="enrollment_no"  placeholder="Search enrol. no from db" class="form-control" />
								   </td>									  
								 </tr>
							   </table>
							   <!---Custom Filter End--->

                 <table id="exampl" class=" export table table-striped table-bordered responsive col-lg-12" cellspacing="0" width="100%">
                  <thead>

                    <tr>
                      <th>&nbsp;</th>
                      <th class="lblue">&nbsp;</th>
                      <th colspan="2" class="lblue">LIMS</th>
                      <th colspan="6" class="lgreen">NIKSHAY</th>
                      <th class="lgreen">&nbsp;</th>
                    </tr>
                    <tr>
                      <th class="hide">ID</th>
                      <th><input type="checkbox" id="bulk-select-all"></th> 
                      <th class="lblue">Enrolment ID</th>
                      <th class="lblue">Sample ID</th>
                      <th class="lblue">Patient First Name</th>
                      <th class="lgreen">First Name</th>
                      <th class="lgreen">Last Name</th>
                      <th class="lgreen">Gender</th>
                      <th class="lgreen">Age</th>
                      <th class="lgreen">PHI</th>
                      <th class="lgreen">Sample Collection Date</th>
                      <th class="lgreen">Action</th>
                      {{-- <th>Error Links</th>
                      <th>Change Nikshay Id</th> --}}
                    </tr>

                  </thead>         
                  
                </table>
							   
                            

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <footer class="footer"> </footer>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal_nikshay_change" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Nikshay ID</h4>
        </div>
         <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
         <form class="form-horizontal form-material" action="{{ url('/updateWithNikshayIdChange') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollid" id="enrollid" value="">
				
				<label class="col-md-12"><h5>Enrolment ID:</h5></label>
                    <div class="col-md-12">
                   <input type="text" class="form-control form-control-line" name="enrolllabelid" id="enrolllabelid" readonly>
                   </div>
                <br>
				
                <label class="col-md-12"><h5>Sample ID:</h5></label>
                    <div class="col-md-12">
          <input type="text" class="form-control form-control-line sampleId" name="sampleid" id="sampleid" readonly>
                   </div>
                <br>

                <label class="col-md-12"><h5>Nikshay ID:<span class="red">*</span></h5></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="nikshayid" id="nikshayid" onkeypress="return isNumberKey(event)"  onchange="try{setCustomValidity('')}catch(e){}" required="required" >
                   </div>
				    <p  style="color:red;" id="errorNikshayid"></p>
                <br>

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>
      </form>
      </div>
    </div>
 </div>


 <div class="modal fade" id="myModal_submit" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Enrollment Status</h4>
        </div>
         <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
         <form class="form-horizontal form-material" action="{{ url('/updateEnrollmentStatus') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enrollid" id="enrollidstatus" value="">
				
				<h2>Are You sure want to change Enrollment Status?</h2>                   

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>
      </form>
      </div>
    </div>
 </div>

 <div class="modal fade" id="myModal_bulk_submit" role="dialog"  id="confirmDelete">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Enrollment Status</h4>
        </div>
         <!----------loader------------>
				<div id="pageloader">
				  <div class="loader"></div>
				</div>
				<!----------loader------------>
         <form class="form-horizontal form-material" action="{{ url('/bulk_updateEnrollmentStatus') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="enroll_ids" id="enroll_ids" value="">
				
				<h2>Are You sure want to change Enrollment Status?</h2>                   

            </div>
            <div class="modal-footer">
              <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
              <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm" >Ok</button>
            </div>
      </form>
      </div>
    </div>
 </div>





<!-- Modal -->


<script>
$(function(){

});



</script>

<script>

    function openStatusChange(enroll_id)
    {
        $("#enrollidstatus").val(enroll_id);
        $('#myModal_submit').modal('toggle');
    }

function openNikshayIdEntryForm(enroll_id, sample_id, enroll_label,nikshay_id){
  //console.log("sample_ids", sample_ids.split(','));
  $("#enrollid").val(enroll_id);
  $("#enrolllabelid").val(enroll_label);
  $("#sampleid").val(sample_id);
  $("#nikshayid").val(nikshay_id);
  
  $('#myModal_nikshay_change').modal('toggle');
 }

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

     var dataTable =$('#exampl').DataTable( {
        dom: 'Bfrtip',
        stateSave: true,
		pageLength:25,
		processing: true,
		language: {
            loadingRecords: '&nbsp;',
            //processing: 'Loading...'
            processing: '<div class="spinner"></div>'
        } , 
        serverSide: true,
        serverMethod: 'post',
       //searching: false, // Remove default Search Control
		ajax: {
			   url: "{{url('nikshay-verification')}}",
			   data: function(data){
				     // Read values
                    var enrollment_no = $('#enrollment_no').val();          

					  // Append to data
					  data.searchByEnrollmentNo = enrollment_no;
         
				},
				headers: 
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		  },
          fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            console.log(aData.p_name);
            if (aData.p_name != aData.firstname) {

                $('td', nRow).css('background-color', 'Pink');

            } 
        },
		 columns: [        
		   { data: 'enroll_id',className: "hide_column" },   
           { data: 'inputs' },        
		   { data: 'enroll_label' },
		   { data: 'sample_label' },
		   { data: 'p_name' },
		   { data: 'firstname' },
		   { data: 'lastname' },
		   { data: 'gender' },
		   { data: 'age' },
		   { data: 'DMC_PHI_Name' },
           { data: 'receive_date' },
           { data: 'submitaction' }
          
		],
        buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'LIMS_NikshayVerification_'+today+'',
                    exportOptions: {
                        columns: [  2, 3,4,5,6,7,8,9 ]
                    }
                },
                {
                text: 'Submit',            
                    action: bulk_action_review            
                }
            
        ],
        columnDefs: [
                          { targets: [1, 11], orderable: false, className: "text-center" }
                        ],
                        
        "order": [[ 2, "desc" ]]
    });

	$('#enrollment_no').keyup(function () { //alert();
        dataTable.draw();
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

        function bulk_action_review()
        {
            var $modal = $('#myModal_bulk_submit');
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
                    $modal.find('input[name="enroll_ids"]').val( selected.join(',') );
                }
            });
        }

</script>
@endsection
