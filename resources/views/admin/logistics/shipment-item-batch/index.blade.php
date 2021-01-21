@extends('admin.logistics.base')
@section('logistics-title', 'Shipment Batch')
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
                            <label for="item-code">Item Code</label>
                            <input type="text" class="form-control" name="item-code" id="item-code">
                        </div>
                        <div class="form-group">
                            <label for="nomenclature">Nomenclature</label>
                            <input type="text" class="form-control" name="nomenclature" id="nomenclature">
                        </div>
                        <div class="form-group">
                            <label for="dispatch">Dispatch Oty.</label>
                            <input type="number" class="form-control" name="dispatch" id="dispatch">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pack">Pack Size</label>
                            <input type="number" class="form-control" name="pack" id="pack">
                        </div>
                        <div class="form-group">
                            <label for="uom">U O M</label>
                            <input type="number" class="form-control" name="uom" id="uom">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-block p-2">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th class="text-center">Batch/Lot</th>
                                <th class="text-center">Expiry On</th>
                                <th class="text-center">Batch/Lot Quantity</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control">
                                </td>
                                <td>
                                    <input type="date" class="form-control">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="text" class="form-control">
                                </td>
                                <td>
                                    <input type="date" class="form-control">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="text" class="form-control">
                                </td>
                                <td>
                                    <input type="date" class="form-control">
                                </td>
                                <td>
                                    <input type="number" value="0" class="form-control">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ok</button>
    </form>

@endsection