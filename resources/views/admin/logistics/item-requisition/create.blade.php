@extends('admin.logistics.base')

@section('logistics-title', 'Item Requisition')

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


    <div class="card">
        <div class="card-block">
            <table class="table table-striped">
                <tbody>

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <form class="well form-horizontal">

                            <div class="cls_left">
                                <div class="form-group">
                                    <label class="col-md-12 control-label"><strong>Select Item Type *</strong></label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group">
                                            <select class="selectpicker form-control border_class">
                                                <option value="#">Consumable</option>
                                                <option value="#">Non Consumable</option>
                                                <option value="#">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cls_left">
                                <div class="form-group">
                                    <label class="col-md-12 control-label"><strong>Lab Name </strong></label>
                                    <div class="col-md-12 inputGroupContainer">
                                        <div class="input-group"><input id="view" name="view" placeholder="SelectItem" class="form-control border_class" required="true" value="SMS JAIPUR" type="text"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </tr>
                    </tbody>
                </table>

                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-block">
            {{--<table class="table table-striped">--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                    {{--<form class="well form-horizontal">--}}

                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>Receipt No *</strong></label>--}}
                                {{--<div class="col-md-12 inputGroupContainer">--}}
                                    {{--<div class="input-group"><input id="Lab_Name" name="Lab_Name" placeholder="Lab Name" class="form-control border_class" required="true" value="" type="text"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>Receipt Date *</strong></label>--}}
                                {{--<div class="col-md-12">--}}

                                    {{--<input id="submit_date" type="date" name="receive_date[]" max="2019-05-06" class="form-control form-control-line submit_date border_class" required="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>Select Document No *</strong></label>--}}
                                {{--<div class="col-md-12 inputGroupContainer">--}}
                                    {{--<div class="input-group"><input id="Lab_Name" name="Lab_Name" placeholder="Lab Name" class="form-control border_class" required="true" value="" type="text"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>Document Date</strong></label>--}}
                                {{--<div class="col-md-12">--}}

                                    {{--<input id="submit_date" type="date" name="receive_date[]" max="2019-05-06" class="form-control form-control-line submit_date border_class" required="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>TR No *</strong></label>--}}
                                {{--<div class="col-md-12 inputGroupContainer">--}}
                                    {{--<div class="input-group"><input id="Lab_Name" name="Lab_Name" placeholder="Lab Name" class="form-control border_class" required="true" value="" type="text"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>TR Date</strong></label>--}}
                                {{--<div class="col-md-12">--}}

                                    {{--<input id="submit_date" type="date" name="receive_date[]" max="2019-05-06" class="form-control form-control-line submit_date border_class" required="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="cls_left_last">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-12 control-label"><strong>Vendor / From Lab</strong></label>--}}
                                {{--<div class="col-md-12 inputGroupContainer">--}}
                                    {{--<div class="input-group"><input id="view" name="view" placeholder="SelectItem" class="form-control border_class" required="true" value="" type="text"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</form>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}


            <div class="form-horizontal form-material">

                <h3 class="text-center" style="background: #1e88e5;border: 1px solid #1e88e5; color: #FFFFFF;">List of Items whoose current stock position are lesser than Reorder Level</h3>
                <table id="mytable" class="table table-bordered table-sm table-striped">

                    <thead>

                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Pack Size</th>
                    <th>UOM</th>
                    <th>ReOrder Level</th>
                    <th>Current Stock</th>
                    <th>Required Qty *</th>

                    </thead>
                    <tbody>

                    <tr>
                        <td>71263</td>
                        <td>245124 BACTEC MGIT 960Supplement Kit</td>
                        <td>100</td>
                        <td>5</td>
                        <td>20</td>
                        <td>17</td>
                        <td><input type="number" class="form-control form-control-line" value=""></td>
                    </tr>
                    <tr>
                        <td>106278</td>
                        <td>di-Sodium hydrogen phosphate anhydrous</td>
                        <td>1KG</td>
                        <td>13</td>
                        <td>5</td>
                        <td>0</td>
                        <td><input type="number" class="form-control form-control-line" value=""></td>
                    </tr>
                    <tr>
                        <td>106414</td>
                        <td>Rapid test for Detection of MPT 64 Antigen</td>
                        <td>25</td>
                        <td>4</td>
                        <td>200</td>
                        <td>5</td>
                        <td><input type="number" class="form-control form-control-line" value=""></td>
                    </tr>


                    </tbody>

                </table>

            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" value="Generate Request">
                </div>
            </div>

            <div class="cls_left">
                <div class="form-group">
                    <label class="col-md-12 control-label"><strong>Request No </strong></label>
                    <div class="col-md-12 inputGroupContainer">
                        <div class="input-group"><input id="view" name="view" placeholder="SelectItem" class="form-control border_class" required="true" value="789789" type="text"></div>
                    </div>
                </div>
            </div>

            <div class="cls_left">
                <div class="form-group">
                    <label class="col-md-12 control-label"><strong>Requisition Date</strong></label>
                    <div class="col-md-12 inputGroupContainer">
                        <input id="view" name="view" class="form-control border_class"   type="date">
                    </div>
                </div>
            </div>

            <div class="btn_cls_left_last">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-info" value="save">
                    </div>
                </div>
            </div>
            <div class="btn_cls_left_last">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-danger" value="Cancel">
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection