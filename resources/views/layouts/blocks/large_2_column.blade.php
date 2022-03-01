<!-- large_2_column -->
@php
    $title = $block->input('title');
    if(!empty($block->input('title_font_colour'))){
        $title = '<span style="color: '.$block->input('title_font_colour').'">'.$block->input('title').'</span>';
    }

    $selected_url = $block->browserIds('page_url');
    $page = \App\Models\Page::find($selected_url)->first();
    $page_slug = ($page && $page->getActiveSlug()) ? $page->getActiveSlug()->slug : '';

    $line_color = '';
    if(!empty($block->input('title_line_colour')))
    {
        $line_color = 'style="border-left-color:'.$block->input('title_line_colour').'"';
    }

    $button_class = 'is-secondary has-text-white';
    if(!empty($block->input('button_style')))
    {
        if($block->input('button_style') == 'primary') $button_class = 'is-primary';
        elseif($block->input('button_style') == 'secondary') $button_class = 'is-secondary has-text-white';
        elseif($block->input('button_style') == 'dark') $button_class = 'is-dark';
        elseif($block->input('button_style') == 'primary_outlined') $button_class = 'is-primary is-outlined';
        elseif($block->input('button_style') == 'secondary_outlined') $button_class = 'is-secondary is-outlined';
        elseif($block->input('button_style') == 'dark_outlined') $button_class = 'is-dark is-outlined';
    }
@endphp
<div class="container">
    <div class="columns tripsitta-large2column @if($block->input('column_setup') == 1) reverse-row-order @endif">
        <div class="column is-6">
            @if(!empty($block->input('title_font_size')))
                @php
                    $size = $block->input('title_font_size');
                    $size_tablet = $size + 2;
                    if($size_tablet >= 6) $size_tablet = 6;

                    $size_mobile = $size + 3;
                    if($size_mobile >= 6) $size_mobile = 6;
                @endphp
                <p class="title is-size-{{$size_mobile}} is-size-{{$size_tablet}}-tablet is-size-{{$size}}-desktop" {!! $line_color !!}>{!! $title !!}</p>
            @else
                <p class="title is-size-4 is-size-3-tablet is-size-1-desktop">{!! $title !!}</p>
            @endif
            <div class="content">
                {!! $block->input('content') !!}
            </div>
            <p><a href="{{ $page_slug }}" class="button {{$button_class}} is-tripsitta">{{ $block->input('button_text') }}</a></p>
        </div>
        <div class="column is-6">
            <figure class="image">
                <img src="{{ $block->image('cover') }}" alt=""/>
            </figure>
        </div>
    </div>
</div>
