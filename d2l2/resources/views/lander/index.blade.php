@extends('master')

@section('content')
    <div class="container">
        <img src="storage/{{ $page->image }}" style="width:100%; height: auto">

        <h2>{{ $page->title }}</h2>
    </div>

    <section>
        <div class="container">
            {!!  $page->body !!}
        </div>
    </section>





@endsection

@section('breadcrumbs')

@endsection