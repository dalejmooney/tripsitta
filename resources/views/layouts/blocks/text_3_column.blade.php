<!-- text_3_column -->
<div class="container has-space">
    <div class="columns">
        <div class="column is-4">
            @if($block->input('title_left'))
                <p class="title is-size-4 is-size-3-tablet">{{ $block->input('title_left') }}</p>
            @endif
            <div class="content">
                {!! $block->input('content_left') !!}
            </div>
        </div>
        <div class="column is-4">
            @if($block->input('title_center'))
                <p class="title is-size-4 is-size-3-tablet">{{ $block->input('title_center') }}</p>
            @endif
            <div class="content">
                {!! $block->input('content_center') !!}
            </div>
        </div>
        <div class="column is-4">
            @if($block->input('title_right'))
                <p class="title is-size-4 is-size-3-tablet">{{ $block->input('title_right') }}</p>
            @endif
            <div class="content">
                {!! $block->input('content_right') !!}
            </div>
        </div>
    </div>
</div>
