@if ($paginator->hasPages())
    <nav class="stacks-pagination">
        @if ($paginator->onFirstPage())
            <span class="page-btn disabled">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">← Prev</a>
        @endif

        <div class="page-numbers">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="page-dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-num active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-num">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next →</a>
        @else
            <span class="page-btn disabled">Next →</span>
        @endif
    </nav>
@endif