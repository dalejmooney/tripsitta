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
        </div>
    </div>
@endsection
