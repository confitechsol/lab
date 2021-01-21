@extends('admin.logistics.base')

@section('logistics-title', 'Item Receipt')

@section('secondary-nav')
    <a href="{{ route('logistics.receipt.received.index') }}"
       class="btn btn-sm btn-info"><i class="fas fa-file-invoice mr-1"></i> All Received Details</a>
@endsection

@section('logistics')


    {{--@if( session()->has('logistics.shipment.new') )--}}
        {{--@php( $requisition = session('logistics.shipment.new') )--}}
        {{--<div class="alert alert-success">--}}
            {{--New Shipment Created:--}}
            {{--<a href="{{ route('logistics.receipt.index', $requisition) }}">--}}
                {{--{{ $requisition->requisition_no }}--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--@endif--}}

    <form action="#">
        <div class="card">
            <div class="card-block p-2">
                <form action="#">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th class="text-left">Requisition No.</th>
                            <th class="text-left">Requisition Date.</th>
                            <th class="text-left">Advice No.</th>
                            <th class="text-center">Advice Date.</th>
                            <th class="text-left">Shipment No</th>
                            <th class="text-left">Shipment Date</th>
                            <th width="120"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $shipments as $shipment )
                            <tr>
                                <td class="text-left">
                                    {{ $shipment->requisition ? $shipment->requisition_no : 'DIRECT' }}
                                </td>
                                <td class="text-left">{{ $shipment->requisition ? $shipment->requisition->created_at->format('d/m/Y') : '-' }}</td>
                                <td class="text-left">{{ $shipment->advice->advice_no }}</td>
                                <td class="text-center">{{ $shipment->advice->created_at->format('d/m/Y') }}</td>
                                <td class="text-left">{{ $shipment->shipment_no }}</td>
                                <td class="text-left">{{ $shipment->shipment_date->format('d/m/Y') }}</td>
                                <td width="120">
                                    <a class="btn btn-info btn-sm" href="{{ route('logistics.receipt.show', $shipment) }}">View Items</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </form>



@endsection