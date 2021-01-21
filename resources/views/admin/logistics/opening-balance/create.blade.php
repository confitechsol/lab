@extends('admin.logistics.base')

@section('logistics-title', 'Opening Balance Entry')

@section('logistics')
    <style>
        .form-group {
            margin-bottom:10px;
        }
        .cls_left{
            width: 50%;
            float: left;
        }
        .cls_left_last{
            width: 100%;
            float:left;
        }
        .btn_cls_left_last{
            width: 15%;
            float:left;
        }
        .fa_trash{
            background-color: red;
            padding: 5px 15px;
            color: #fff;
            font-size: 26px;
        }
        .table-responsive{
            border: 3px solid #000;
            padding: 20px;
        }
        .btn_class{
            margin-top:28px;
        }
        .border_class{
            border: none;
            border-bottom: 1px solid #000;
            border-radius: 0

        }
    </style>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form class="form-horizontal form-material" action="{{ url('/logistics/item/opening-balance/save') }}" method="post">
        {!! csrf_field() !!}
        <div class="card">
            <div class="card-block">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Lab Name</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                    <input id="Lab_Name" name="Lab_Name" placeholder="Lab Name" class="form-control border_class" required="true" value="{{ $data['lab_arr_data']['lab_name'] }}" type="text" readonly>
                                    <input id="labid" name="labid"  value="{{ $data['lab_arr_data']['lab_id'] }}" type="hidden" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Select Item Type *</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                    <select id="itemtype" name="itemtype" class="selectpicker form-control border_class">
                                        <option value="">-----Select Any Option-------</option>
                                        @foreach ($data['itemtype'] as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Item Category</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><input type="text" id="ItemCategory" name="ItemCategory" placeholder="Item Category" class="form-control border_class" required="true" value=""  readonly></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Pack Size</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><input id="PackSize" name="PackSize" placeholder="Pack Size" class="form-control border_class" required="true" value="" type="text" readonly></div>
                            </div>
                        </div>



                    </div>



                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Select Item *</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group">
                                    <select id="SelectItem" name="SelectItem" class="selectpicker form-control border_class" required="true">
                                        <option value="">-----Select Any Option-------</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong><a href="" data-toggle="modal" data-target="#myModal"> Item code</a></strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><input type="text" id="ItemCode" name="ItemCode" placeholder="Item Code" class="form-control border_class" required="true" readonly value="" ></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>UOM</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><input id="uom" name="uom" placeholder="UOM" class="form-control border_class" required="true" value="" type="text" readonly></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label"><strong>Opening Balance *</strong></label>
                            <div class="col-md-12 inputGroupContainer">
                                <div class="input-group"><input type="number" id="opening_balance" name="opening_balance" placeholder="Opening Balance" class="form-control border_class" required="true" value="" min="1"></div>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>



        <div class="card">
            <div class="card-block">
                <div id="batch_lot_section_id">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><strong>Batch / Lot No. *</strong></label>
                                <input  type="text" id="lot_no" name="lot_no" placeholder="Batch / Lot No." class="form-control form-control-line">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><strong>Expiry On *</strong></label>
                                <input type="date" id="expiry_on" name="expiry_on" placeholder="Batch / Lot No." class="form-control form-control-line" >
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><strong>Batch/Lot Qty *</strong></label>
                                <input type="text" id="lot_qty" name="lot_qty" placeholder="Batch / Lot No." class="form-control form-control-line" >
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <a href="#" class="btn btn-primary btn-sm mt-4 add-row">Add Item</a>

                        </div>


                    </div>


                    <div class="row">
                        <div class="col-sm-9">

                            <table id="batch_dtls_tbl_id" class="table table-striped table-bordered table-sm my-3">

                                <thead>
                                <th>Batch / Lot No.</th>
                                <th>Expiry On</th>
                                <th>Batch / Lot Qty</th>
                                <th>Delete</th>
                                </thead>

                                <tbody>
                                <!--<tr>
                                    <td>7193837</td>
                                    <td>29/05/2019</td>
                                    <td>28</td>
                                    <td><a href="" class="btn btn-danger p-0">
                                            <i class="fa fa-trash fa_trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>--->
                                </tbody>

                            </table>

                        </div>


                    </div>
                </div>
                <button type="submit" class="btn btn-info mr-2">Save</button>
                <a href="#" class="btn btn-danger ">Cancel</a>

            </div>
        </div>


    </form>



    <script type="text/javascript">
        $(document).ready(function() {

            // Item type  Change item will be populate
            $('#itemtype').change(function(){ //alert();

                // item code
                var code = $(this).val()?$(this).val():0;
                if((code=='NC')||(code=='X')){//If non-consumable and others hide batch section
                    $("#batch_lot_section_id").hide();
                }else{
                    $("#batch_lot_section_id").show();
                }
                // Empty the dropdown
                $('#sel_emp').find('option').not(':first').remove();

                // AJAX request
                $.ajax({
                    url: '/logistics/item/getItem/'+code,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        // console.log('ITEMS======'+response);
                        var len = 0;
                        if(response['items'] != null){
                            len = response['items'].length;
                        }
                        //alert(len);
                        $("#SelectItem").children('option').remove();
                        if(len > 0){
                            // Read data and create <option >
                            for(var i=0; i<len; i++){
                                //alert(response['items'][i].item_code);
                                var item_code = response['items'][i].item_code;
                                var description = response['items'][i].description;

                                var option = "<option value='"+item_code+"'>"+description+"</option>";

                                $("#SelectItem").append(option);
                            }
                            $("#SelectItem").prepend("<option value=''>-----Select Any Option-------</option>").val('');
                        }else{
                            var option = "<option value=''>-----Select Any Option-------</option>";

                            $("#SelectItem").append(option);
                        }

                    },
                    failure: function(response){
                        alert("failure");

                    }
                });

                // AJAX request for filling item category
                $.ajax({
                    url: '/logistics/item/getItemCategory/'+code,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        //console.log("ITEM CATEGORY=="+response);
                        var len = 0;
                        if(response != null){
                            len = response.length;
                        }
                        //alert(len);

                        if(len > 0){
                            $("#ItemCategory").val(response);
                        }else{

                            $("#ItemCategory").val('');
                        }

                    },
                    failure: function(response){
                        alert("failure");

                    }
                });

            });


            // Item Change action followings are performed
            $('#SelectItem').change(function(){
                // Item Change item code will be filled
                var itemcode = $(this).val()?$(this).val():0;
                //alert(itemcode);

                //item code input will be filled
                $('#ItemCode').prop('readonly',false);
                $("#ItemCode").val(itemcode?itemcode:'');
                $('#ItemCode').prop('readonly',true);

                // AJAX request for filling Pack size
                $.ajax({
                    url: '/logistics/item/getPackSize/'+itemcode,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        //console.log('Pack size======'+response);
                        var len = 0;
                        if(response != null){
                            len = response.length;
                        }
                        //alert(len);

                        if(len > 0){
                            $("#PackSize").val(response);
                        }else{
                            $("#PackSize").val('');
                        }

                    },
                    failure: function(response){
                        alert("failure");

                    }
                });

                // AJAX request for filling UOM
                $.ajax({
                    url: '/logistics/item/getUOM/'+itemcode,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        //console.log('UOM-------'+response);
                        var len = 0;
                        if(response != null){
                            len = response.length;
                        }
                        //alert(len);

                        if(len > 0){
                            $("#uom").val(response);
                        }else{
                            $("#uom").val('');
                        }

                    },
                    failure: function(response){
                        alert("failure");

                    }
                });

                if($('#itemtype').val()=='C'){//if consumable item then it is called
                    // AJAX request for filling Batch details
                    var labid = $('#labid').val();
                    $.ajax({
                        url: '/logistics/item/getBatchDetails/'+labid+ '/' + itemcode,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            console.log("Batch-------------"+response);
                            var len = 0;
                            if(response['batch_data_item'] != null){
                                len = response['batch_data_item'].length;
                            }
                            //alert(len);
                            $("#batch_dtls_tbl_id").find('tbody tr').remove();
                            var opening_balance =0;
                            if(len > 0){

                                for(var i=0; i<len; i++){
                                    var expiry_on = response['batch_data_item'][i]['expiry_on'].date;
                                    var lot_no = response['batch_data_item'][i].lot_no;
                                    var lot_qty = response['batch_data_item'][i].lot_qty;
                                    //var converted_expiry_on = ConvertJsonDateString(expiry_on);
                                    var date = new Date(expiry_on);
                                    var converted_expiry_on = $.datepicker.formatDate('dd-mm-yy', date);
                                    var converted_hid_expiry_on = $.datepicker.formatDate('yy-mm-dd', date);
                                    //alert(converted_expiry_on);
                                    opening_balance=opening_balance+lot_qty;

                                    var tbldata = "<tr><td>" + lot_no + "</td><td>"+converted_expiry_on+"</td><td>" + lot_qty + "</td><td><input type='hidden' name='hid_lot_no[]' value='"+lot_no+"'><input type='hidden' name='hid_expiry_in[]' value='"+converted_hid_expiry_on+"'><input type='hidden' name='hid_lot_qty[]' value='"+lot_qty+"'><a href='#' class='btn btn-danger p-0 delete-row'><i class='fa fa-trash fa_trash' aria-hidden='true'></i></a></td></tr>";

                                    $("#batch_dtls_tbl_id").append(tbldata);

                                }
                                //alert(opening_balance);

                                $("#opening_balance").val(opening_balance);//set opening balance value
                                $("#opening_balance").prop("readonly", true);//make opening balance readonly
                            }else{
                                var tbldata = "<tr><td colspan='4'>No Data available</td></tr>";
                                $("#batch_dtls_tbl_id").append(tbldata);
                                $("#opening_balance").val(opening_balance);//set opening balance value 0
                                $("#opening_balance").prop("readonly", true);//make opening balance readonly
                            }

                        },
                        failure: function(response){
                            alert("failure");

                        }
                    });
                }

            });
            //Add row
            $(".add-row").click(function(){
                var lot_no = $("#lot_no").val();
                var lot_qty = $("#lot_qty").val();
                var expiry_on = $("#expiry_on").val();
                var date = new Date(expiry_on);
                var converted_expiry_on = $.datepicker.formatDate('dd-mm-yy', date);
                var converted_hid_expiry_on = $.datepicker.formatDate('yy-mm-dd', date);
                //alert(converted_expiry_on);
                $("#opening_balance").val(parseInt($("#opening_balance").val())+parseInt(lot_qty));//set opening balance value

                var markup = "<tr><td>" + lot_no + "</td><td>"+converted_expiry_on+"</td><td>" + lot_qty + "</td><td><input type='hidden' name='hid_lot_no[]' value='"+lot_no+"'><input type='hidden' name='hid_expiry_in[]' value='"+converted_hid_expiry_on+"'><input type='hidden' name='hid_lot_qty[]' value='"+lot_qty+"'><a href='#' class='btn btn-danger p-0 delete-row'><i class='fa fa-trash fa_trash' aria-hidden='true'></i></a></td></tr>";
                $("table tbody").append(markup);
                //after append input field will blank
                $("#lot_no").val('');
                $("#lot_qty").val('');
                $("#expiry_on").val('');
            });
            // Find and remove selected table rows


            $(document).on("click", "a.delete-row" , function() {
                $(this).closest('tr').remove();
                $("#opening_balance").val(parseInt($("#opening_balance").val())-parseInt($(this).closest('tr').children('td:eq(2)').text()));//minus opening balance value

            });

        });

        setTimeout(function() {
            $('.alert-success').fadeOut('fast');
        }, 10000); // <-- time in milliseconds
    </script>
@endsection