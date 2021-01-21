@extends('admin.logistics.base')
@section('logistics-title', 'Purchase / Stock Transfer Advice')
@section('logistics')

    <form action="#">
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
                            <th class="text-center">Requisition No</th>
                            <th class="text-center">Requisition Date</th>
                            <th>
                                <select class="form-control">
                                    <option value="#">Current Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approve">Approve</option>
                                    <option value="adviced raised">Adviced Raised</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>SMS JAIPUR</td>
                            <td>PRQ/SMS JAIPUR/19-20/00001</td>
                            <td>10/05/2019</td>
                            <td>Pending</td>
                            <td> <a href="#" class="btn btn-info btn-sm">Item Details</a> </td>
                        </tr>
                        <tr>
                            <td>SMS JAIPUR</td>
                            <td>PRQ/SMS JAIPUR/19-20/00001</td>
                            <td>10/05/2019</td>
                            <td>Pending</td>
                            <td> <a href="#" class="btn btn-info btn-sm">Item Details</a> </td>
                        </tr>
                        <tr>
                            <td>SMS JAIPUR</td>
                            <td>PRQ/SMS JAIPUR/19-20/00001</td>
                            <td>10/05/2019</td>
                            <td>Adviced Raised</td>
                            {{--<td> <a href="#" class="btn btn-info btn-sm">Item Details</a> </td>--}}
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </form>



@endsection