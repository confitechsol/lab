@extends('admin.logistics.base')

@section('logistics-title', 'Dashboard')

@section('logistics')

    <div class="card mb-3">
        <div class="card-block p-2">
            @php( $chart = [
                // The type of chart we want to create
                'type' => 'bar',

                // The data for our dataset
                'data'=> [
                    'labels' => $requisitions_sent_to->keys(),
                    'datasets' => [
                        [
                            'label' => 'No of Requisitions Raised to',
                            'backgroundColor' => '#3333aa',
                            'data' => $requisitions_sent_to->values(),
                        ],

                        [
                            'label' => 'No of Shipments on transit from vendor',
                            'backgroundColor' => '#ff5500',
                            'data' => $shipments_from_vendor->values(),
                        ],

                        [
                            'label' => 'No of Shipments Received from Vendor',
                            'backgroundColor' => '#aaaaaa',
                            'data' => $received_from_vendor->values(),
                        ],

                        [
                            'label' => 'No of Shipments Received from other Lab',
                            'backgroundColor' => '#ffee00',
                            'data' => $received_from_other_lab->values(),
                        ],

                        [
                            'label' => 'No of Transfer Advice Received from other Lab',
                            'backgroundColor' => '#5588ff',
                            'data' => $transfer_advice_received->values(),
                        ],

                        [
                            'label' => 'No of Shipment transferred to Other Lab',
                            'backgroundColor' => '#55cc00',
                            'data' => $transferred_to_other_lab->values(),
                        ],

                    ],
                ],

                // Configuration options go here
                'options' => [
                    'tooltips' => [
                        'mode' => 'index',
                    ],
                    'aspectRatio' => 3,
                ]
            ] )
            <canvas data-init-chart='<?php echo json_encode( $chart )?>'></canvas>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-block">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Head</th>
                    @foreach( $sentTos as $sentTo )
                        <th width="80" class="text-center">{{ $sentTo->name }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>No of Requisitions Raised to</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $requisitions_sent_to[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>No of Shipments on transit from vendor</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $shipments_from_vendor[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>No of Shipments Received from Vendor</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $received_from_vendor[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>No of Shipments Received from other Lab</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $received_from_other_lab[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>No of Transfer Advice Received from other Lab</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $transfer_advice_received[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>No of Shipment transferred to Other Lab</th>
                    @foreach( $sentTos as $sentTo )
                        <th class="text-center">{{ $transferred_to_other_lab[ $sentTo->name ] }}</th>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection