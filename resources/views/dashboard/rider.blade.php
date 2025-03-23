<div class="card">
    <div class="card-header border-0">
        <h5 class="card-title text-primary-color fw-bold">Order Summary</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <x-small-box class="col-12" icon="fas fa-box" text="Assigned Deliveries" 
                :count="\App\Models\Order::where('assigned_user_id', Auth::id())->count()" href="{{ route('delivery.index') }}"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-motorcycle" text="For Delivery" 
                :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'For Delivery')->count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-spinner" text="Re-Schedule Delivery" 
                :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Re-Schedule Delivery')->count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-check" text="Delivered" 
                :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Delivered')->count()" />

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-times-circle" text="Cancelled" 
                :count="\App\Models\Order::where('assigned_user_id', Auth::id())->where('order_status', 'Cancelled')->count()" />
        </div>
    </div>
</div>
