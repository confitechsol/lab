@extends('admin.logistics.base')

@section('logistics-title', 'Stock Issue for Internal Consumption')

@section('logistics')

    <style>
        .form-material .form-group{float: none;}
        .form-group { margin-bottom: 24px; }
        .item-info{ margin: 16px -34px; padding: 32px 32px 16px 32px; background: white; box-shadow: rgba(0,0,0,0.2) 0px 1px 4px; }
    </style>

    <form class="form-material form-horizontal" action="">

        <div class="card">
            <div class="card-block">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Lab Name</label>
                                <input type="text"
                                       class="form-control form-control-line"
                                       value="{{ 'SMS Jaipur' }}"
                                       readonly
                                       placeholder="Date of Issue">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="issue-date">Issue Date</label>
                                <input id="issue-date"
                                       type="date"
                                       class="form-control form-control-line"
                                       placeholder="Date of Issue">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="issue-purpose">Purpose</label>
                        <textarea id="issue-purpose"
                                  class="form-control form-control-line"
                                  style="height: 40px">
                        </textarea>
                    </div>
            </div>
        </div>


        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="issue-item-type">Item Type</label>
                            <select id="issue-item-type"
                                    class="form-control form-control-line">
                                <option value="C">Consumable</option>
                                <option value="NC">Non Consumable</option>
                                <option value="X">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="issue-item-code">Select Item</label>
                            <div class="row">
                                <div class="col-9">
                                    <input id="issue-item-code"
                                           type="text"
                                           placeholder="Item Code"
                                           class="form-control form-control-line">
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mt-2">Browse</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-info mb-4">
                    <h4 class="mb-3 font-weight-bold">245122 BBL MGIT Tubes tube 7ml</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="issue-item-pack-size">Pack Size</label>
                                <input id="issue-item-pack-size"
                                       type="text"
                                       disabled readonly
                                       value="100"
                                       class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="issue-item-uom">UOM</label>
                                <input id="issue-item-uom"
                                       type="text"
                                       disabled readonly
                                       value="3"
                                       class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="issue-item-stock">Current Stock</label>
                                <input id="issue-item-stock"
                                       type="text"
                                       disabled readonly
                                       value="67"
                                       class="form-control form-control-line">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="issue-quantity">Issue Quantity</label>
                            <input id="issue-quantity"
                                   type="number"
                                   class="form-control form-control-line">
                        </div>
                    </div>
                </div>

                <h6>Issue the Quantity from Batch/Lot</h6>

                <table class="table table-sm table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Batch / Lot No.</th>
                        <th>Expiry On</th>
                        <th>Available Qty.</th>
                        <th width="100">Issue Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>7297833</td>
                        <td>01/12/2018</td>
                        <td>10</td>
                        <td>
                            <input type="number" value="0" class="form-control form-control-line">
                        </td>
                    </tr>
                    <tr>
                        <td>7193837</td>
                        <td>17/02/2019</td>
                        <td>12</td>
                        <td>
                            <input type="number" value="0" class="form-control form-control-line">
                        </td>
                    </tr>
                    <tr>
                        <td>7279563</td>
                        <td>15/04/2019</td>
                        <td>3</td>
                        <td>
                            <input type="number" value="0" class="form-control form-control-line">
                        </td>
                    </tr>
                    <tr>
                        <td>FF0717AA</td>
                        <td>06/05/2019</td>
                        <td>25</td>
                        <td>
                            <input type="number" value="0" class="form-control form-control-line">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-info">Save</button>

            </div>
        </div>
    </form>

@endsection