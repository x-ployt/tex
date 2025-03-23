<div class="card">
    <div class="card-header border-0">
        <h5 class="card-title text-primary-color fw-bold">Order Summary</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <x-small-box class="col-12" icon="fas fa-box" text="Orders" 
                :count="\App\Models\Order::count()" href="{{ route('order.index') }}"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-users" text="Total Users" 
                :count="\App\Models\User::count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-store" text="Total Branches" 
                :count="\App\Models\Branch::count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-box" text="Total Orders" 
                :count="\App\Models\Order::count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-truck" text="Pending Deliveries" 
                :count="\App\Models\Order::where('order_status', 'Pending')->count()" />
        </div>
    </div>
</div>
