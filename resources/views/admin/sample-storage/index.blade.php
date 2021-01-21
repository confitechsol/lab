@extends('admin.layout.app')
@section('content')


    <div class="page-wrapper">
        <div class="container-fluid">

            <div class="row page-titles">
                <div class="col-md-7 col-9 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Sample Storage</h3>
                </div>
                <div class="col-md-5 col-3 align-self-center">
                    <form action="{{ route('sample-storage.index') }}"
                          autocomplete="off"
                          method="get">
                        <div class="input-group">
                            @include('common.inputs.input', [
                                'name' => 'q',
                                'placeholder' => 'Search...'
                            ])
                            <button style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                    class="btn btn-info btn-sm"
                                    type="submit">Search</button>

                            <a class="btn btn-info btn-sm ml-3"
                               style="line-height: 28px"
                               href="{{ route('sample-storage.index', ['download' => true]) }}">Excel</a>
                        </div>

                    </form>

                </div>
            </div>



            <div class="card mb-3">
                <div class="card-block">
                    <table class="table table-striped table-bordered small mb-0">
                        <thead>
                        <tr>
                            <th>Enrollment ID</th>
                            <th>Sample ID</th>
                            <th>Patient Name</th>
                            <th>Date of Storage</th>
                            <th>Sample Sent From</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach( $service_logs as $service_log )
                            @php($previous_log = $service_log->previous_log)
                            <tr>
                                <th>{{ $service_log->enroll->label }}</th>
                                <th>{{ $service_log->sample->sample_label }}</th>
                                <th>{{ $service_log->patient_name }}</th>
                                <th>{{ $service_log->created_at->format('d/m/Y') }}</th>
                                <th>{{ $previous_log->service->name ?? 'Sample Opening' }}</th>
                                <th>
                                    <a data-log='{{ json_encode( $service_log ) }}'
                                       data-toggle="modal"
                                       class="btn btn-sm btn-info"
                                       href="#modal-send-sample-to">Send To</a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>


            @include('common.pagination', [ 'models' => $service_logs ])


        </div>
    </div>

    @include('admin.sample-storage.modal-send-sample-to')


@endsection