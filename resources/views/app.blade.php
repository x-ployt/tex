@extends('layout')
@section('title', 'Dashboard')
@section('content')

    @if (Auth::user()->role->role_name == 'SuperAdmin')
        I'm super admin
    @elseif (Auth::user()->role->role_name == 'Admin') 
        I'm admin
    @elseif (Auth::user()->role->role_name == 'Rider')
        I'm super rider
    @endif

@endsection
