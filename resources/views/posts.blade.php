@extends('layouts.app')

@section('meta_title'){{ $page->meta_title }}@endsection
@section('meta_desc'){{ $page->meta_desc }}@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">{{ $page->title }}</h1>
            @if($page->subtitle)
                <p class="subtitle is-6">{{ $page->subtitle }}</p>
            @endif
            {!! $page->renderBlocks(false) !!}

            <div class="columns is-multiline">
                @foreach($posts as $post)
                    <div class="column is-4">
                        <div class="box blog_post has-text-centered">
                            <p class="title is-5"><a href="{{route('blog')}}/{{$post->slug}}">{{$post->title}}</a></p>
                            <p class="subtitle is-7">Posted on {{$post->created_at->format('d M Y \a\t H:i')}}</p>
                            <figure class="image is-1by1">
                                <a href="{{route('blog')}}/{{$post->slug}}"><img src="{{$post->image('thumbnail')}}" alt="{{$post->title}}"/></a>
                            </figure>
                            <div class="content">
                                {!! $post->description !!}
                            </div>
                            <p>
                                <a href="{{route('blog')}}/{{$post->slug}}" class="button is-small">read more...</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
