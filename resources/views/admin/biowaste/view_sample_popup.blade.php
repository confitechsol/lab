

<style>
.btn-sm.btn-info {
    margin-top: 10px;
    margin-bottom: 10px;
    margin-right: 0px;
  }
table.my_modal tr td{ border: 1px solid #666; text-align: center;}
table.my_modal th{ border: 1px solid #009efb; padding: 10px; text-transform: uppercase; font-size: 12px; font-weight: bold; color: #009efb;}
.modal-title{ color: #009efb; font-size: 14px; font-weight: 600; text-align: center; width: 100%;text-transform: uppercase;}
.search_feild{
  width: 20%;
  height: 0px;
  display: inline-block;

  float: right;

  margin-bottom: 1%;
  }
  .detail_modal{

    cursor:pointer;
    color:#028EE1!important;
  }
  #bwm-modal {
    max-width: 95%;
    margin: 30px auto;
}
</style>
<div class="modal fade" id="viewsamplepopup" role="dialog">
    <div id="bwm-modal" class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">BWM Samples</h4>
        </div>
        <div class="modal-body">
      <table id="bwm_modal" class="my_modal" width="100%" border='0' cellspacing='5' cellpadding="5" style='font-size:13px;'>
        <div style="align:right;">
        <input type="text" name="search_bwm_samples" id="search_bwm_samples" class="form-control search_feild" placeholder="Search Samples" />
      </div>
        <thead>
          <th style="text-align:center;">Enrolment No.</th>
          <th style="text-align:center;">Sample ID</th>
          <th style="text-align:center;">Patient Name</th>
          <th style="text-align:center;">Test Request</th>
          <th style="text-align:center;">Date</th>

        </thead>
        <tbody class='table'>

        </tbody>
        </table>


</div>
      </div>
    </div>
 </div>
