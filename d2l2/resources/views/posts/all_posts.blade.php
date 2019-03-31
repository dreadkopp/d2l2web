@extends('master')

@section('content')
<div class="row">
    @foreach($posts as $post)
        <div class="col-md-12 row">
            <a href="/post/{{ $post->slug }}">
                <img class="col-sm-4" src="{{ Voyager::image( $post->image ) }}">
                <span class="col-sm-8 h3">{{ $post->title }}</span>
            </a>
        </div>
        <hr class="rule">
    @endforeach
</div>


@endsection

@section('breadcrumbs')

@endsection