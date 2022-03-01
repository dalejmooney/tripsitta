<!-- asymmetric_2_columns -->
<div class="container has-space">
    @if(!empty($block->input('small_title')))<p class="subtitle is-tripsitta is-7">{{ $block->input('small_title') }}</p>@endif
    @if(!empty($block->input('title')))<p class="title is-2">{{ $block->input('title') }}</p>@endif
    <div class="columns @if($block->input('column_setup') == 1) reverse-row-order @endif">
        <div class="column is-9">
            <figure class="image">
                <img src="{{ $block->image('cover') }}" alt=""/>
            </figure>
        </div>
        <div class="column is-3">
            <div class="content">
                {!! $block->input('content') !!}
            </div>
            @if(!empty($block->blockable->slug) && !empty($block->input('button_text')))
            <a href="{{ $block->blockable->slug }}" class="button is-primary is-tripsitta">{{ $block->input('button_text') }}</a>
            @endif
        </div>
    </div>
</div>
