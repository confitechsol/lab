@extends('admin.logistics.base')

@section('logistics-title', $type === \App\Model\Logistics\Advice::TYPE_TRANSFER ? 'Item Transfer' : 'Item Shipment')

@section('logistics')


    @if( session()->has('logistics.shipment.new') )
        @php( $shipments = session('logistics.shipment.new') )
        <div class="alert alert-success">
            New Shipments Generated: {{ collect( $shipments )->implode('shipment_no', ', ') }}
            {{--@foreach( $shipments as $shipment )--}}
            {{--<a href="{{ route('logistics.shipment.show', $shipment) }}">--}}
                {{--{{ $shipment->shipment_no }}--}}
            {{--</a>--}}
            {{--@endforeach--}}
        </div>
    @endif


    @if( session()->has('logistics.advice.transfer.success') )
        <div class="alert alert-success">{{ session('logistics.advice.transfer.success') }}</div>
    @endif


    {{--{{ dd( $errors ) }}--}}

    {{--@if( $errors->any() )--}}
        {{--@foreach( $errors->messages as $error )--}}
            {{--<div class="alert alert-danger">{{ $error }}</div>--}}
        {{--@endforeach--}}
    {{--@endif--}}

    <div class="card">
        <div class="card-block p-2">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    @if( $type === \App\Model\Logistics\Advice::TYPE_TRANSFER )
                        <th width="150">Send to Lab</th>
                    @endif
                    <th class="text-left">Advice No</th>
                    <th class="text-center">Advice Date</th>
                    @if( $type === \App\Model\Logistics\Advice::TYPE_PURCHASE )
                        <th class="text-left">Shipment No</th>
                        <th class="text-left">Shipment Date</th>
                    @else
                        <th class="text-left">Requisition No</th>
                        <th class="text-left">Requisition Date</th>
                    @endif
                    <th class="text-left">Adviced By</th>
                    <th></th>
                </tr>
                </thead>

                <tbody class="td-valign-top">
                @foreach( $advices as $advice )
                    <tr>
                        @if( $advice->is_transfer )
                            <td class="text-left">{{ $advice->requisition->lab->name_and_location }}</td>
                        @endif
                        {{--<td class="text-left">{{ ucwords( $advice->advice_type ) }}</td>--}}
                        <td class="text-left">{{ $advice->advice_no }}</td>
                        <td>{{ $advice->created_at->format('d/m/Y') }}</td>

                        @if( $advice->is_purchase )
                            <td class="text-left">
                                @if( count( $advice->shipments ) )
                                    @foreach( $advice->shipments as $shipment )
                                        <a href="#">{{ $shipment->shipment_no }}</a><br>
                                    @endforeach
                                @else - @endif
                            </td>
                            <td class="text-left">
                                @if( count( $advice->shipments ) )
                                    @foreach( $advice->shipments as $shipment )
                                        {{ $shipment->created_at->format('d/m/Y') }}<br>
                                    @endforeach
                                @else - @endif
                            </td>
                        @endif

                        @if( $advice->requisition )
                            <td class="text-left">
                                <a href="{{ route('logistics.requisition.show', $advice->requisition->id) }}">
                                    {{ $advice->requisition_no }}
                                </a>
                            </td>
                            <td class="text-left">{{ $advice->requisition->created_at->format('d/m/Y') }}</td>
                        @endif
                        <td class="text-left">{{ $advice->user->name }}</td>
                        <td class="text-left">

                            @if( $advice->is_purchase )
                                <form action="{{ route('logistics.advice.upload', $advice) }}"
                                      class="form-shipment-upload"
                                      method="post"
                                      enctype="multipart/form-data">

                                    {{ csrf_field() }}
                                    <input id="file-{{ $advice->id }}" type="file" class="d-none input-file" name="file[{{ $advice->id }}]">

                                    <div class="btn-group">
                                        @if( $advice->shipment_is_submitted )
                                            <a href="{{ '#' }}"
                                               class="btn btn-primary btn-sm">View <i class="fas fa-arrow-right ml-1"></i></a>
                                        @else
                                            <a href="{{ route('logistics.advice.download', $advice) }}"
                                               class="btn btn-secondary btn-sm"><i class="fas fa-download mr-1"></i> Download</a>
                                            <label class="btn btn-secondary btn-sm btn-upload"
                                                   for="file-{{ $advice->id }}">
                                                <i class="fas fa-upload mr-1"></i> Upload</label>

                                            @if( $advice->shipment_is_uploaded )
                                                <a href="{{ route('logistics.advice.shipment.generate', $advice) }}"
                                                   class="btn btn-info btn-sm">Submit <i class="fas fa-arrow-right ml-1"></i></a>
                                            @endif
                                        @endif
                                    </div>
                                    @php( $success = session("logistics.shipment.uploaded.$advice->id") )
                                    @if( $success )
                                        <div class="text-success">{{ $success }}</div>
                                    @endif

                                    @error( "file.$advice->id" )

                                </form>
                            @else
                                <a href="{{ route('logistics.advice.show', $advice) }}"
                                   class="btn btn-info btn-sm">Stock Transfer</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection