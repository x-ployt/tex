<div class="card">
    <div class="card-header border-0">
        <h5 class="card-title text-primary-color fw-bold">Order Summary</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <x-small-box class="col-12" icon="fas fa-box" text="Total Orders" 
                :count="\App\Models\Order::where('branch_id', Auth::user()->branch_id)->count()" 
                href="{{ route('order.index') }}"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-motorcycle" text="For Delivery" 
                :count="\App\Models\Order::where('order_status', 'For Delivery')->where('branch_id', Auth::user()->branch_id)->count()"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-spinner" text="Re-Schedule Delivery" 
                :count="\App\Models\Order::where('order_status', 'Re-Schedule Delivery')->where('branch_id', Auth::user()->branch_id)->count()"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-check" text="Delivered" 
                :count="\App\Models\Order::where('order_status', 'Delivered')->where('branch_id', Auth::user()->branch_id)->count()"/>

            <x-info-box class="col-md-3 col-sm-6 col-12" icon="fas fa-times-circle" text="Cancelled" 
                :count="\App\Models\Order::where('order_status', 'Cancelled')->where('branch_id', Auth::user()->branch_id)->count()"/>
        </div>
    </div>
</div>
