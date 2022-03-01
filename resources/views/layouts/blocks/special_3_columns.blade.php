<!-- special_3_columns -->
<div class="container has-space special_3_columns">
    <p class="subtitle is-tripsitta is-7">{{ $block->input('small_title') }}</p>
    <p class="title is-2">{{ $block->input('title') }}</p>

    <div class="columns">
        <div class="column is-4">
            <figure class="image">
                <img src="{{ $block->image('left_column_image') }}" alt="" {!! ($block->input('images_shape') == 1) ? 'class="is-rounded"' : ''!!}/>
            </figure>
            @if($block->input('left_column_subheading'))
                <p class="subtitle is-size-5 is-size-4-tablet">{{ $block->input('left_column_subheading') }}</p>
            @endif
            <div class="content">
                {!! $block->input('left_column_content') !!}
            </div>
        </div>
        <div class="column is-4">
            <figure class="image">
                <img src="{{ $block->image('middle_column_image') }}" alt="" {!! ($block->input('images_shape') == 1) ? 'class="is-rounded"' : ''!!}/>
            </figure>
            @if($block->input('middle_column_subheading'))
                <p class="subtitle is-size-5 is-size-4-tablet">{{ $block->input('middle_column_subheading') }}</p>
            @endif
            <div class="content">
                {!! $block->input('middle_column_content') !!}
            </div>
        </div>
        <div class="column is-4">
            <figure class="image {{($block->input('images_shape') == 1) ? 'is-rounded' : ''}}" >
                <img src="{{ $block->image('right_column_image') }}" alt="" {!! ($block->input('images_shape') == 1) ? 'class="is-rounded"' : ''!!}/>
            </figure>
            @if($block->input('right_column_subheading'))
                <p class="subtitle is-size-5 is-size-4-tablet">{{ $block->input('right_column_subheading') }}</p>
            @endif
            <div class="content">
                {!! $block->input('right_column_content') !!}
            </div>
        </div>
    </div>
</div>
