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
                    'labels' => $labs->pluck('name'),
                    'datasets' => [
                        [
                            'label' => 'Requisitions Received',
                            'backgroundColor' => '#33ff88',
                            'data' => $requisitions_received->values(),
                        ],
                        [
                            'label' => 'No. of Shipment Sent - Procurement',
                            'backgroundColor' => '#3388ff',
                            'data' => $shipment_sent_procurement->values(),
                        ],
                        [
                            'label' => 'No. of Transfer Advice Sent',
                            'backgroundColor' => '#eeee44',
                            'data' => $transfer_advice_sent->values(),
                        ],
                        [
                            'label' => 'Action to be Taken',
                            'backgroundColor' => '#ff2222',
                            'data' => $action_to_be_taken->values(),
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
                    <th>Lab Name</th>
                    <th>No. of Requisition Received</th>
                    <th>No. of Shipment Sent - Procurement</th>
                    <th>No. of Transfer Advice Sent</th>
                    <th>Action to be Taken</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $labs as $lab )
                <tr>
                    <th>{{ $lab->name }}</th>
                    <th>{{ $requisitions_received[ $lab->name ] }}</th>
                    <th>{{ $shipment_sent_procurement[ $lab->name ] }}</th>
                    <th>{{ $transfer_advice_sent[ $lab->name ] }}</th>
                    <th>{{ $action_to_be_taken[ $lab->name ] }}</th>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection