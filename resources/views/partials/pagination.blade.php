
@if ($paginator->lastPage() > 1)

    @php
        $curr = $paginator->currentPage();
        $last = $paginator->lastPage();
    @endphp

    <div class="pagination-container">

        <div class="pagination-number arrow">
            <a href="{{ $paginator->url(max(1, $curr - 1)) }}" aria-label="Previous">
                <span class="arrow-text">Previous</span>
            </a>
        </div>

        @for ($i = max(1, $curr - 5); $i <= min($curr + 5, $last); $i++)
            @if($curr == $i)
                <div class="pagination-number pagination-active">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </div>
            @else
                <div class="pagination-number">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </div>
            @endif
        @endfor

        <div class="pagination-number arrow">
            <a href="{{ $paginator->url(min($last, $curr + 1)) }}" aria-label="Previous">
                <span class="arrow-text">Next</span>
            </a>
        </div>
    </div>

@endif


<style>
    .pagination-container a{
        color: black;
    }
    .pagination-container {
        display: flex;
        align-items: center;
    }
    .arrow-text {
        display: block;
        vertical-align: middle;
        font-size: 13px;
        vertical-align: middle;
    }
    .pagination-number {
        width: 50px;
        height: 30px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0 6px;
        margin: 0 20px;
    }
    .pagination-active {
        border-bottom: orangered solid 2px;
        position: relative;
    }

</style>
