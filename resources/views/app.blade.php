@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @if (Auth::user()->role->role_name == 'SuperAdmin')
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-users" text="Total Users" :count="\App\Models\User::count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-store" text="Total Branches" :count="\App\Models\Branch::count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-box" text="Total Orders" :count="\App\Models\Order::count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-truck" text="Pending Deliveries" :count="\App\Models\Order::where('order_status', 'Pending')->count()" />
        @elseif (Auth::user()->role->role_name == 'Admin')
            <x-small-box class="col-12" icon="fas fa-box" text="Total Orders" :count="\App\Models\Order::where('branch_id', Auth::user()->branch_id)->count()" href="#"/>
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-motorcycle" text="For Delivery" :count="\App\Models\Order::where('order_status', 'For Delivery')->where('branch_id', Auth::user()->branch_id)->count()"/>
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-spinner" text="Re-Schedule Delivery" :count="\App\Models\Order::where('order_status', 'Re-Schedule Delivery')->where('branch_id', Auth::user()->branch_id)->count()"/>
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-check" text="Delivered" :count="\App\Models\Order::where('order_status', 'Delivered')->where('branch_id', Auth::user()->branch_id)->count()"/>
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-times-circle" text="Cancelled" :count="\App\Models\Order::where('order_status', 'Cancelled')->where('branch_id', Auth::user()->branch_id)->count()"/>
        @elseif (Auth::user()->role->role_name == 'Rider')
            <x-small-box class="col-12" icon="fas fa-box" text="Assigned Deliveries" :count="\App\Models\Order::where('assigned_user_id', Auth::id())->count()" href="#"/>
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-motorcycle" text="For Delivery" :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'For Delivery')->count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-spinner" text="Re-Schedule Delivery" :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Re-Schedule Delivery')->count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-check" text="Delivered" :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Delivered')->count()" />
            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-times-circle" text="Cancelled" :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Cancelled')->count()" />
        @endif
    </div>
</div>
@endsection
