@extends('admin.logistics.base')

@section('logistics-title', 'List of Requisitions')

@section('secondary-nav')
    @if(this_lab())
    <a href="{{ route('logistics.item.index', ['new_requisition' => 'yes']) }}"
       class="btn-sm btn-info"><i class="fas fa-plus"></i> New Requisition</a>
    @endif
@endsection


@section('logistics')

    <form action="{{ route('logistics.requisition.index') }}" method="get">
        <div class="card">
            <div class="card-block p-2">
                <form action="#">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>
                                @if( this_lab() )
                                    Lab Name
                                @else
                                    @include('common.inputs.model-select', [
                                        'name' => 'lab',
                                        'placeholder' => '-- All Labs --',
                                        'models' => \App\Model\Lab::all(),
                                        'model_label' => 'name',
                                    ])
                                @endif
                            </th>
                            <th class="text-left">
                                @include('common.inputs.input', [
                                    'name' => 'requisition_no',
                                    'placeholder' => 'Requisition Number',
                                ])
                            </th>
                            <th class="text-center">Requisition Date</th>
                            <th class="text-center">
                                @include('common.inputs.model-select', [
                                    'name' => 'sent_to',
                                    'placeholder' => '-- Sent To All --',
                                    'models' => \App\Model\Logistics\SentTo::all(),
                                    'model_label' => 'name',
                                ])
                            </th>
                            <th>
                                @include('common.inputs.select', [
                                    'name' => 'status',
                                    'placeholder' => '-- All Status --',
                                    'options' => [
                                        'pending' => 'Pending',
                                        'transfer adviced' => 'Transfer Adviced',
                                        'procurement adviced' => 'Procurement Adviced',
                                        'partial' => 'Partial',
                                        'complete' => 'Complete',
                                    ],
                                    'model_label' => 'name',
                                ])
                            </th>
                            <th width="120" class="text-right">
                                <button type="submit" class="btn btn-info btn-sm">Filter</button>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $requisitions as $requisition )
                        <tr>
                            <td class="text-left">{{ $requisition->lab->name_and_location }}</td>
                            <td class="text-left">{{ $requisition->requisition_no }}</td>
                            <td>{{ $requisition->created_at->format('d/m/Y') }}</td>
                            <td>{{ $requisition->sentTo->name }}</td>
                            <td class="text-left">{{ ucwords( $requisition->status ) }}</td>
                            <td>
                                <a href="{{ route('logistics.requisition.show', $requisition) }}"
                                   class="btn btn-info btn-sm">Item Details</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </form>

    @if( !$requisitions->count() )
        @alertinfo("We couldn't find any results.")
    @else
        <div class="pagination-wrap">
            <div class="items-count">
                Found {{ $requisitions->total() }} items.
            </div>
            {{ $requisitions->links() }}
        </div>
    @endif

@endsection