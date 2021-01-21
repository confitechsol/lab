<div class="modal fade" id="modal-send-sample-to" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send Sample To</h4>
            </div>
            <form class="form-horizontal form-material" action="{{ url('/decontamination') }}" method="post" enctype='multipart/form-data' id="cbnaat_result">
                @if(count($errors))
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger"><h4>{{ $error }}</h4></div>
                    @endforeach
                @endif
                <div class="modal-body">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="from_storage" value="1">
                    <input type="hidden" name="enrollId" value="">
                    <input type="hidden" name="tag" value="">
                    <input type="hidden" name="no_sample" value="0">
                    <input type="hidden" name="other" value="">
					<input type="hidden" name="rec_flag" id="rec_flag" value="">

                    <label class="col-md-12 h5">Sample ID:</label>
                    <div class="col-md-12">
                        <input type="text" name="sample_ids" class="form-control form-control-line sample_ids" readonly>
                    </div>
                    <br>
                    <label class="col-md-12"><h5>Sample sent for:<span id="ssentfor"></span></br><span id="ssentforreq" class="red"></span></h5></label>
                    <div class="col-md-12">
                        @include('common.inputs.select', [
                            'name'  => 'service_id[]',
                            'options' => $send_to_services,
                            'class' => 'form-control form-control-line test_reason multi-select-xl',
                            'id'    => 'service_id',
                            'attrs' => [ 'multiple' => true, 'required' => true ]
                        ])
                    </div>

                    <label class="col-md-12 h5">Comments</label>
                    <div class="col-md-12">
                        <textarea name="comments"
                                  class="form-control form-control-line"
                                  id="comments" rows="5" cols="5"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default add-button cancel btn-md" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="pull-right btn btn-primary btn-md" id="confirm">Ok</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

    const $modal = $('#modal-send-sample-to');
    $modal.on('show.bs.modal', function(e){
        const $btn = $( e.relatedTarget );
        const log = $btn.data('log');
        $modal.find('input[name="enrollId"]').val( log.enroll_id );
        $modal.find('input[name="tag"]').val( log.tag );
        $modal.find('input[name="sample_ids"]').val( log.sample_label );
        $modal.find('input[name="comments"]').val( '' );
		$modal.find('input[name="rec_flag"]').val( log.rec_flag );
    });

    // DATA =========
    // enrollId: 10
    // tag:
    // no_sample: 0
    // sample_ids: 19NTB00012A
    // service_id[]: 10
    // other:
    // comments: some comments

</script>