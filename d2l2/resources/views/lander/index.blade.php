@extends('master')

@section('content')
    <img src="banner/d2l2banner.jpeg" class="im-fluid d2l2-banner">
    @if(Auth::check())
        Moin {{ $User->name }}
    @else
        <a href="/login">Login</a>
    @endif


    <style>
        .d2l2-banner {
            background-blend-mode: darken;
            height: 25rem;
            background-color: #a531f6;

        }
    </style>


@endsection

@section('breadcrumbs')

@endsection