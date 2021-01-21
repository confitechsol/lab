@extends('admin.logistics.base')
@section('logistics-title', 'Shipment Details')
@section('logistics')

    logistics.shipment

    <div class="card">
        <div class="card-block p-2">
            <form action="#">

                <table class="table table-striped table-sm">

                    <thead>
                    <tr>
                        <th>
                            <select class="form-control">
                                <option value="#">Lab Name</option>
                                <option value="sms-jaipur">SMS JAIPUR</option>
                                <option value="bc-roy">BC ROY</option>
                                <option value="ndtb">NDTB</option>
                            </select>
                        </th>
                        <th class="text-center">Purchase Advice No.</th>
                        <th class="text-center">Purchase Advice Date</th>
                        <th class="text-center">Requisition No</th>
                        <th class="text-center">Requisition Date</th>
                        <th class="text-center">Current Status</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>SMS JAIPUR</td>
                        <td>PRQ/SMS JAIPUR/19-20/00001</td>
                        <td>10/05/2019</td>
                        <td>2309875</td>
                        <td>12/05/2019</td>
                        <td>PO Adviced</td>
                        <td><a href="#" class="btn btn-info btn-sm">Shipment</a></td>
                    </tr>
                    <tr>
                        <td>BC ROY</td>
                        <td>PRQ/BC ROY/19-20/00002</td>
                        <td>10/05/2019</td>
                        <td>2309875</td>
                        <td>12/05/2019</td>
                        <td>PO Adviced</td>
                        <td><a href="#" class="btn btn-info btn-sm">Shipment</a></td>
                    </tr>
                    <tr>
                        <td>NDTB</td>
                        <td>PRQ/NDTB/19-20/00003</td>
                        <td>10/05/2019</td>
                        <td>2309875</td>
                        <td>12/05/2019</td>
                        <td>Shiped</td>
                        <td></td>
                    </tr>
                    </tbody>

                </table>

            </form>
        </div>
    </div>


@endsection