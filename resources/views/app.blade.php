@extends('layout')
@section('title', 'Dashboard')
@section('content')

    @if (Auth::user()->role->role_name == 'SuperAdmin')
        
    @elseif (Auth::user()->role->role_name == 'Admin') 
        
    @elseif (Auth::user()->role->role_name == 'Rider')
        
    @endif

@endsection
