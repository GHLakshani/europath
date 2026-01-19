@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end gap-2 site_pagination mb-0">

            {{-- First & Previous (Only show if NOT on the first page) --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="First">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                    </a>
                </li>
            @endif

            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();

                // Ensure pagination only shows three elements at a time
                $start = max(1, min($current - 1, $last - 2));
                $end = min($last, $start + 2);
            @endphp

            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $current ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Next & Last (Only show if NOT on the last page) --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
