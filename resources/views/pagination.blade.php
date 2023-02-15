@if ($paginator->lastPage() > 1)
<nav class="a_center">
    <ul class="pagination mt50 mb0">
        <li class="prev_pagination">
            <a href="{{ ($paginator->currentPage() == 1) ? 'javascript:void(0)' : $paginator->url(1) }}"><i class="fa fa-angle-left"></i></a>
        </li>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="next_pagination">
            <a href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'javascript:void(0)' : $paginator->url($paginator->currentPage()+1) }}" class="{{}}"><i class="fa fa-angle-right"></i></a>
        </li>
    </ul>
</nav>
@endif

