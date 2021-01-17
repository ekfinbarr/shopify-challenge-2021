<div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
      <a href="javascript:void(0);" class="btn btn-primary tm-btn-prev mb-2 disabled">Previous</a>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-primary tm-btn-prev mb-2">&laquo;<span>Previous</span></a>
    @endif
    
    <div class="tm-paging d-flex">

      <!-- Pagination Elements -->
      @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
        @if (is_string($element))
          <a href="#" class="tm-paging-link">{{ $element }}</a>
        @endif

        <!-- Array Of Links -->
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <a href="#" class="active tm-paging-link">{{ $page }}</a>
            @else
              <a href="{{ $url }}" class="tm-paging-link">{{ $page }}</a>
            @endif
          @endforeach
        @endif
      @endforeach
  </div>

  {{-- <!-- Next Page Link --> --}}
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-primary tm-btn-next" rel="next"><span>Next Page</span>&raquo;</a>
  @else
    <a href="javascript:void(0);" class="btn btn-primary tm-btn-next disabled">Next Page</a>
  @endif
</div>