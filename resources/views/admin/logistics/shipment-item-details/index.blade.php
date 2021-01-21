@extends('admin.logistics.base')
@section('logistics-title', 'Shipment - Item Details')
@section('logistics')

    <div class="card">
        <div class="card-block">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <p class="mb-0">Lab Name: SMS JAIPUR</p>
                </div>
                <div class="col-sm-4">
                    <p class="mb-0">Purchase Order Advise No.: PAD/SMS JAIPUR/19-20/0001</p>
                </div>
                <div class="col-sm-4">
                    <p class="mb-0">Requisition No.: PAD/SMS JAIPUR/19-20/0001</p>
                </div>
            </div>
        </div>
    </div>

    <form action="#">

        <div class="card">
            <div class="card-block">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="shipment-no">Shipment No</label>
                            <input type="text" class="form-control" name="shipment-no" id="shipment-no">
                        </div>
                        <div class="form-group">
                            <label for="tr-no">T.R.No.</label>
                            <input type="text" class="form-control" name="tr-no" id="tr-no">
                        </div>
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select class="form-control">
                                <option value="">-- Select Vendor --</option>
                                <option value="TRNM">TRNM</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="shipment-date">Shipment Date</label>
                            <input type="date" class="form-control" name="shipment-date" id="shipment-date">
                        </div>
                        <div class="form-group">
                            <label for="tr-date">Tr Date</label>
                            <input type="date" class="form-control" name="tr-date" id="tr-date">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-block">

                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th width="150">
                            <select class="form-control">
                                <option value="#">Item Type</option>
                                <option value="consumable">Consumable</option>
                                <option value="non_consumable">Non Consumable</option>
                                <option value="others">Others</option>
                            </select>
                        </th>
                        <th width="150">
                            <input type="text" class="form-control" name="item-code" id="item-code" placeholder="Item Code">
                        </th>
                        <th class="text-center">Nomenclature</th>
                        <th class="text-center">Pack Size</th>
                        <th class="text-center">UOM</th>
                        <th class="text-center">Advise Quantity</th>
                        <th width="90">Dispatch Quantity</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>c</td>
                        <td>123456</td>
                        <td>
                            <span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                        </td>
                        <td>5</td>
                        <td>BOX</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                        <td><a href="#" class="btn btn-info btn-sm">Bath/Lot</a></td>
                    </tr>

                    <tr>
                        <td>c</td>
                        <td>123456</td>
                        <td>
                            <span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                        </td>
                        <td>5</td>
                        <td>BOX</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                        <td><a href="#" class="btn btn-info btn-sm">Bath/Lot</a></td>
                    </tr>

                    <tr>
                        <td>c</td>
                        <td>123456</td>
                        <td>
                            <span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                        </td>
                        <td>5</td>
                        <td>BOX</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                        <td><a href="#" class="btn btn-info btn-sm">Bath/Lot</a></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <button class="btn btn-primary">Submit</button>

    </form>


@endsection