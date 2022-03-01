@extends('layouts.app')

@section('meta_title'){{ $post->meta_title }}@endsection
@section('meta_desc'){{ $post->meta_desc }}@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">{{ $post->title }}</h1>
            <p class="subtitle is-size-65">Posted on {{$post->created_at->format('d M Y \a\t H:i')}}</p>
            {!! $post->renderBlocks(false) !!}
        </div>
    </div>
@endsection
