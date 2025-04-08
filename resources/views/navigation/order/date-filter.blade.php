{{-- Filters --}}
<div class="card card-body mb-3">
    <form action="{{ route('order.index') }}" method="GET" class="row row-cols-auto g-2 align-items-end">
        {{-- Date Range Filter --}}
        <div>
            <label for="from_date" class="form-label">From</label>
            <input type="date" id="from_date" name="from_date" class="form-control"
                   value="{{ request('from_date') ?? $fromDate->format('Y-m-d') }}" required>
        </div>
        <div>
            <label for="to_date" class="form-label">To</label>
            <input type="date" id="to_date" name="to_date" class="form-control"
                   value="{{ request('to_date') ?? $toDate->format('Y-m-d') }}" required>
        </div>

        {{-- Branch Filter (Only for SuperAdmin) --}}
        @if(Auth::user()->role->role_name === 'SuperAdmin')
            <div>
                <label for="branch_id" class="form-label">Branch</label>
                <select id="branch_id" name="branch_id" class="form-select" required>
                    <option value="{{ Auth::user()->branch_id }}" {{ request('branch_id') == Auth::user()->branch_id ? 'selected' : '' }}>
                        {{ $branches->firstWhere('id', Auth::user()->branch_id)?->branch_name ?? 'Unknown Branch' }}
                    </option>
                    <option value="all" {{ request('branch_id') == 'all' ? 'selected' : '' }}>All</option>
                    @foreach($branches as $branch)
                        @if($branch->id != Auth::user()->branch_id)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif

        {{-- Status Filter --}}
        <div>
            <label for="order_status" class="form-label">Status</label>
            <select id="order_status" name="order_status" class="form-select" required>
                <option value="all" {{ request('order_status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="Re-Schedule Delivery" {{ request('order_status') == 'Re-Schedule Delivery' ? 'selected' : '' }}>Re-Schedule</option>
                <option value="For Delivery" {{ request('order_status') == 'For Delivery' ? 'selected' : '' }}>For Delivery</option>
                <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="RTS" {{ request('order_status') == 'RTS' ? 'selected' : '' }}>RTS</option>
            </select>
        </div>

        {{-- Search Button --}}
        <div>
            <button type="submit" class="btn greenBtn">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>
