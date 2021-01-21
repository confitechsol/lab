@extends('admin.layout.app')
@section('content')


    <form action="{{ route('bio-waste-sample.store') }}"
          autocomplete="off"
          method="post">

        {{ csrf_field() }}

        <div class="page-wrapper">
            <div class="container-fluid">

                <div class="row page-titles">
                    <div class="col-md-7 col-9 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">
                            BWM Samples {{ $status == \App\Model\ServiceLog::STATUS_COMPLETE ? 'History' : '' }}
                        </h3>
                    </div>
                    <div class="col-md-5 col-3 align-self-center text-right">
                        @if( $status == \App\Model\ServiceLog::STATUS_ACTIVE )
                            <button class="btn btn-danger btn-sm">Discard Selected</button>
                            <div class="d-inline-block mx-2">&mdash;</div>
                            <!--<a href="{{ route('bio-waste-sample.index', ['download' => 1]) }}" class="btn btn-info btn-sm">Excel</a>-->
                            <a href="{{ route('bio-waste-sample.index', ['status' => \App\Model\ServiceLog::STATUS_COMPLETE]) }}" class="btn btn-info btn-sm">View History</a>
                        @else
                            <a href="{{ route('bio-waste-sample.index') }}" class="btn btn-info btn-sm">View Current</a>
                        @endif
                    </div>
                </div>



                <div class="card mb-3">
                    <div class="card-block">
					<a href="{{ route('bio-waste-sample.index', ['download' => 1]) }}" class="btn btn-info btn-sm">Excel</a>
                           
                        <table class="table table-striped table-bordered small mb-0">
                            <thead>
							 <tr>
								
								
                                @if( $status == \App\Model\ServiceLog::STATUS_ACTIVE )
                                    <th width="40"></th>
                                @endif
								
								
                                <th>Enrollment ID</th>
                                <th>Sample ID</th>
                                <th>Patient</th>
                                <th>Sent From</th>
                                <th>Comments</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach( $service_logs as $service_log )
                                <tr>
                                    @if( $status == \App\Model\ServiceLog::STATUS_ACTIVE )
										 <th width="40"></th>
									 
                                    <th>
										
                                        @include('common.inputs.checkbox', [
                                            'name' => 'selected[]',
                                            'value' => $service_log->id
                                        ])
                                    </th>
                                    @endif
                                    <th>{{ !empty($service_log->enroll->label)?$service_log->enroll->label:"" }}</th>
                                    <th>{{ $service_log->sample->sample_label }}</th>
                                    <th>{{ $service_log->patient_name }}</th>
                                    <th>{{ $service_log->previous_step ?? 'From Sample Opening' }}</th>
                                    <th>
                                        @if( $service_log->previous_step ?? NULL )
                                            {{ !empty($service_log->previous_log->comments)?$service_log->previous_log->comments:"" }}
                                        @else
                                            {{ $service_log->sample->rejection }}
                                        @endif
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

                @if( $status !== \App\Model\ServiceLog::STATUS_ACTIVE )
                    @include( 'common.pagination', [ 'models' => $service_logs ])
                @endif

            </div>
        </div>

    </form>


@endsection