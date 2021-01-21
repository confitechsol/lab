<div class="row">

    @foreach( $boxes as $box )

    <div class="col mb-3">
        <a class="info-box" href="{{ $box['link'] ?? '' }}">
            <span class="row align-items-center">
                <span class="col-8">
                    <h2 class="h6">{{ $box['title'] ?? '' }}</h2>
                    <span class="h2">{{ $box['value'] ?? '' }}</span>
                </span>
                @if( $box['new'] ?? false )
                <span class="col-4 text-center">
                    <span class="btn-add-new btn btn-light btn-lg"
                          title="Add new"
                          data-url="{{ $box['new'] ?? '' }}"><i class="fas fa-plus"></i></span>
                </span>
                @endif
            </span>
        </a>
    </div>

    @endforeach

</div>
