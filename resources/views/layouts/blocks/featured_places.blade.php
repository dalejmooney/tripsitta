<!-- featured-elements -->
<div class="tripsitta-featured-elements">
    <div class="container">
        <p class="subtitle is-tripsitta is-7">{{ $block->input('small_title') }}</p>
        <p class="title is-4-mobile is-2-tablet " style="padding-top:15px">{{ $block->input('title') }}</p>

        <div class="columns is-mobile is-multiline">
            @for($i=1;$i<=4;$i++)
                <div class="column is-10-mobile is-offset-1-mobile is-3-tablet">
                    <figure class="image is-1by1">
                        <div class="image-overlay-right">
                        <span class="icon is-large">
                            <i class="flag-icon flag-icon-squared is-country flag-icon-{{strtolower($block->input('place_'.$i.'_country'))}}"></i>
                        </span>
                            <span>{{$block->input('place_'.$i.'_name')}}</span>
                        </div>
                        <img class="has-rounded-border" src="{{$block->image('place_'.$i.'_image', 'default')}}" alt="Tripsitta - {{$block->input('place_'.$i.'_name')}}">
                    </figure>
                </div>
            @endfor
        </div>
        <p class="tfe_button" style="margin-top:20px;"><a href="{{ $block->blockable->slug }}" class="button is-primary is-tripsitta">{{ $block->input('button_text') }}</a></p>
    </div>
</div>
