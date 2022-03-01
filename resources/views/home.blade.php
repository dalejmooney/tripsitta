@extends('layouts.app_home')

@section('meta_title'){{ $page->meta_title }}@endsection
@section('meta_desc'){{ $page->meta_desc }}@endsection

@section('scripts')
    <script src="{{ mix('js/pages/home.js') }}"></script>
@endsection

@section('carousel-items')
    @foreach($page->slideshows as $i => $slideshow)
        @php list($r, $g, $b) = sscanf($slideshow->colour, "#%02x%02x%02x"); @endphp
        <div class="item item-{{$i}}" style="background-image: url('{{$slideshow->image('image')}}')">
            <div class="carousel-text-box" @if(!empty($slideshow->colour)) style="background-color: rgba({{$r}},{{$g}},{{$b}}, 0.85)" @endif>
                <h1 class="title is-size-3 is-size-1-desktop">{{$slideshow->title}}</h1>
                {!!$slideshow->description!!}
                <div class="carousel-bullets"></div>
            </div>
        </div>
    @endforeach
@endsection

@section('content')
    <div>
        {!! $page->renderBlocks(false, [], [
            'featured_babysitters' => $featured_babysitters,
            'countries' => $countries,
            'places' => $places
        ]) !!}
    </div>
@endsection
