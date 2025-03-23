@extends('layout')
@section('title', 'Dashboard')
@section('content')

@if (Auth::user()->role->role_name == 'SuperAdmin')
    
    @include('dashboard.superadmin')

@elseif (Auth::user()->role->role_name == 'Admin')
    
    @include('dashboard.admin')

@elseif (Auth::user()->role->role_name == 'Rider')
    
    @include('dashboard.rider')

@endif

@endsection
