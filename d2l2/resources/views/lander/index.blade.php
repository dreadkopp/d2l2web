@extends('layouts.app')

@section('content')
    <h2>Welcome to D2L2 website</h2>
    @if(Auth::check())
        Moin {{ $User->name }}
    @else
        <a href="/login">Login</a>
    @endif



@endsection