

<style>
.btn-sm.btn-info {
    margin-top: 10px;
    margin-bottom: 10px;
    margin-right: 0px;
  }
table.my_modal tr td{ border: 1px solid #666; text-align: center;}
table.my_modal th{ border: 1px solid #009efb; padding: 10px; text-transform: uppercase; font-size: 12px; font-weight: bold; color: #009efb;}
.modal-title{ color: #009efb; font-size: 14px; font-weight: 600; text-align: center; width: 100%;text-transform: uppercase;}
.search_feild{width: 74%;
    height: 0px;
    display: inline-block;
    min-height: 29px;
    margin-right: 5px;
  }
  .detail_modal{

    cursor:pointer;
    color:#028EE1!important;
  }
  #cuurr-status-history-modal {
    max-width: 95%;
    margin: 30px auto;
}
</style>
<div class="modal fade" id="progressdetailpopup" role="dialog">
    <div id="cuurr-status-history-modal" class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reason For Rejection <!---<span id="sample_name"></span>----></h4>
        </div>
        <div class="modal-body">
      <table id="det_modal" class="my_modal" width="100%" border='0' cellspacing='5' cellpadding="5" style='font-size:13px;'>
        <thead>
          <th class="text-center">Enrollment No</th>
          <th class="text-center">Patient Name</th>
          <!--<th class="text-center">Job Method</th>-->
          <th class="text-center">Reason For Failure</th>
        </thead>
        <tbody class='table'>

        </tbody>
        </table>

        <div class="display_status_material"></div>
        <div id="table_footer"></div>
</div>
      </div>
    </div>
 </div>
