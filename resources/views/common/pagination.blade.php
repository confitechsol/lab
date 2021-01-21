@php( $models = $models ?? collect() )
@if( !$models->count() )
    @alertinfo("We couldn't find any results.")
@else
    <div class="pagination-wrap">
        <div class="items-count">
            Found {{ $models->total() }} items.
        </div>
        {{ $models->links() }}
    </div>
@endif

<style>
    .pagination-wrap{font-size: 0.9rem; display: flex; justify-content: space-between;}
</style>
<script>
    $(document).ready(() => {
        const $pagination = $('.pagination');
        if( $pagination.length === 0 ) return;
        $pagination.find('li').addClass('page-item');
        $pagination.find('a,span').addClass('page-link');
    });
</script>