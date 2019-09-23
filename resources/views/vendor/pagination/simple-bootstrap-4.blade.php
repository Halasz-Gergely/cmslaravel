@if ($paginator->hasPages())
<nav class="flexbox mt-30">
    @if ($paginator->onFirstPage())
    <a class="btn btn-white disabled" aria-disabled="true"><i class="ti-arrow-left fs-9 mr-4"></i>Previous</a>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-white"><i class="ti-arrow-left fs-9 ml-4"></i>Previous</a>
    @endif
    @if ($paginator->hasMorePages())
    <a class="btn btn-white" href="{{ $paginator->nextPageUrl() }}"><i class="ti-arrow-right fs-9 mr-4"></i>Next</a>
    @else
    <a class="btn btn-white disabled" href="{{ $paginator->nextPageUrl() }}"><i class="ti-arrow-right fs-9 mr-4"></i>Next</a>
    @endif
</nav>
@endif
