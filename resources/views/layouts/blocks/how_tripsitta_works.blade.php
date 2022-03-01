<!-- how_tripsitta_works -->
<div id="how_tripsitta_works" class="container">
    <p class="subtitle is-tripsitta is-7">{{ $block->input('small_title') }}</p>
    <p class="title is-2">{{ $block->input('title') }}</p>
    <div class="columns">
        @for($i=1;$i<=4;$i++)
        <div class="column is-3">
            <div class="columns is-mobile">
                <div class="column is-3"><i class="icon-number">{{$i}}</i></div>
                <div class="column is-9 is-size-65">{{ $block->input('bullet_'.$i) }}</div>
            </div>
        </div>
        @endfor
    </div>
    <div class="columns">
        <div class="column is-7">
            <figure class="image">
                <img src="{{ $block->image('cover') }}" alt="How Tripsitta works?">
            </figure>
        </div>
        <div class="column is-5">
            <div class="content">
                {!! $block->input('content') !!}
            </div>
        </div>
    </div>
</div>
