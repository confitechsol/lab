<div class="modal fade" id="cbnaatresultpopupDiv" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CBNAAT Details</h4>
        </div>
         <form class="form-horizontal form-material" action="{{ url('/cbnaat') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                  @if(count($errors))
                    @foreach ($errors->all() as $error)
                       <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                   @endforeach
                 @endif
		        <div class="modal-body">

		           	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		           	<input type="hidden" name="enrollId" id="enrollId" value="">
                    <input type="hidden" name="service" id="service" value="4">
                    <input type="hidden" name="editresult" id="editresult" value="edit">

		            <label class="col-md-12">Sample ID</label>
                    <div class="col-md-12">
                       <input type="text" name="sampleid" class="form-control form-control-line sampleid"  id="sampleid" readonly>
                   </div>

                   	<label class="col-md-12">Result of MTB: <span class="red">*</span></label>
		            <div class="col-md-12">
		              <select name="mtb" id="mtb" class="form-control form-control-line" id="mtb" required>
		                <option>--Select--</option>
		                <option value="MTB Detected">MTB Detected</option>
		                <option value="MTB Not Detected">MTB Not Detected</option>
		                <option value="Invalid">Invalid</option>
                        <option value="No Result">No Result</option>
		                <option value="Error">Error</option>
                        <option value="NA">N/A</option>
		              </select>
		           </div>

		           <div id="error" class="hide">
		           	 <label class="col-md-12">Error:</label>
		            <div class="col-md-12">
                       <input type="number" name="error" id="error_cbnaat" value="" class="form-control form-control-line">
                   </div>
               		</div>


		            <label class="col-md-12">Result of RIF: <span class="red">*</span></label>
		            <div class="col-md-12">
		              <select name="rif" id="rif" class="form-control form-control-line rif_val" required>
		                <option>--Select--</option>
		                <option value="RIF Detected">RIF Resistance Detected</option>
		                <option value="RIF Not Detected">RIF Resistance Not Detected</option>
		                <option value="RIF Indeterminate">RIF Indeterminate</option>
		                <option value="NA">NA</option>
		              </select>
		           </div>


               <label class="col-md-12">Machine Serial No. </label>
               <div class="col-md-12">
                 <select name="equipment_name" id="equipment_name" class="form-control form-control-line">

                 </select>
              </div>




		           <label class="col-md-12 hide">Date Tested</label>
                    <div class="col-md-12 hide">
                       <input type="text" name="test_date" value="{{date('d/m/Y')}}" max="<?php echo date("Y-m-d");?>" class="form-control form-control-line datepicker" >
                   </div>
               <label class="col-md-12">Reason for Edit <span class="red">*</span></label>
                  <div class="col-md-12">
                      <input type="text" name="reason_edit" class="form-control form-control-line" value="" id="reason_edit" required>
                  </div>


		        </div>
		        <div class="modal-footer">
		          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Save</button> -->
		          <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
        		  <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
		        </div>

		  </form>
      </div>
    </div>
 </div>
