{{-- Edit Button --}}
<x-edit-button id="editOrderBtn{{$order->id}}" class="extra-class" title="Edit Order"/>

{{-- Edit Order Modal --}}
<div class="modal fade" id="editOrder{{$order->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            <form action="{{ route('order.update', $order) }}" method="post" id="editOrderForm{{$order->id}}">
                @csrf
                @method('put')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">

                     {{-- Order Date --}}
                    <div class="mb-3">
                        <label for="order_date{{$order->id}}" class="form-label">Order Date:<span class="text-danger">*</span></label>
                        <input type="text" name="order_date" id="order_date{{$order->id}}" class="form-control" value="{{ date("Y-m-d", strtotime($order->order_date)) }}" required>
                    </div>

                    {{-- Order No --}}
                    <div class="mb-3">
                        <label for="order_no{{$order->id}}" class="form-label">Order No:<span class="text-danger">*</span></label>
                        <input type="text" name="order_no" id="order_no{{$order->id}}" class="form-control" 
                               value="{{ $order->order_no }}" required>
                    </div>

                    {{-- Customer Name --}}
                    <div class="mb-3">
                        <label for="customer_name{{$order->id}}" class="form-label">Customer Name:<span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" id="customer_name{{$order->id}}" class="form-control" 
                               value="{{ $order->customer_name }}" required>
                    </div>

                    {{-- Customer Address --}}
                    <div class="mb-3">
                        <label for="customer_address{{$order->id}}" class="form-label">Customer Address:<span class="text-danger">*</span></label>
                        <input type="text" name="customer_address" id="customer_address{{$order->id}}" class="form-control" 
                               value="{{ $order->customer_address }}" required>
                    </div>

                    {{-- Customer Contact Number --}}
                    <div class="mb-3">
                        <label for="customer_contact_number{{$order->id}}" class="form-label">Contact Number:<span class="text-danger">*</span></label>
                        <input type="text" name="customer_contact_number" id="customer_contact_number{{$order->id}}" class="form-control" 
                            value="{{ old('customer_contact_number', $order->customer_contact_number) }}" required>
                    </div>

                    {{-- Order Amount --}}
                    <div class="mb-3">
                        <label for="order_amount{{$order->id}}" class="form-label">Order Amount<span class="text-danger">*</span></label>
                        <input type="text" name="order_amount" id="order_amount{{$order->id}}" class="form-control" 
                            placeholder="Enter Order Amount" 
                            pattern="^\d+(\.\d{1,2})?$"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^(\d*\.\d{2}).*$/, '$1');"
                            value="{{ old('order_amount', $order->order_amount) }}" 
                            autocomplete="off" required>
                    </div>

                    {{-- Order Mode of Payment --}}
                    <div class="mb-3">
                        <label for="order_mop{{$order->id}}" class="form-label">MOP:<span class="text-danger">*</span></label>
                        <select name="order_mop" id="order_mop{{$order->id}}" class="form-control">
                            @foreach(['COD', 'GCASH', 'Remittance', 'Bank', 'Credit/Debit Card', 'Xendit'] as $mop)
                                <option value="{{ $mop }}" {{ old('order_mop', $order->order_mop) == $mop ? 'selected' : '' }}>
                                    {{ $mop }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Branch --}}
                    <div class="mb-3">
                        <label for="branch_id{{$order->id}}" class="form-label">Branch:<span class="text-danger">*</span></label>
                        <select name="branch_id" id="branch_id{{$order->id}}" class="form-control" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $order->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Assigned Rider --}}
                    <div class="mb-3">
                        <label for="assigned_user_id{{$order->id}}" class="form-label">Assigned Rider:</label>
                        <select name="assigned_user_id" id="assigned_user_id{{$order->id}}" class="form-control">
                            @foreach($riders as $rider)
                                <option value="{{ $rider->id }}" {{ $order->assigned_user_id == $rider->id ? 'selected' : '' }}>
                                    {{ $rider->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Order Status --}}
                    <div class="mb-3">
                        <label for="order_status{{$order->id}}" class="form-label">Order Status:</label>
                        <select name="order_status" id="order_status{{$order->id}}" class="form-control">
                            <option value="For Delivery" {{ $order->order_status == 'For Delivery' ? 'selected' : '' }}>For Delivery</option>
                            <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="RTS" {{ $order->order_status == 'RTS' ? 'selected' : '' }}>RTS</option>
                        </select>
                    </div>

                </div>
                {{-- Modal Body End --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="editOrder({{$order->id}})" type="button" class="btn lightGreenBtn" title="Update Order">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Order Modal --}}

{{-- Scripts --}}
@push('scripts')

{{-- DatePicker --}}
<script>
    $(document).ready(function() {
        $("#order_date{{$order->id}}").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>

<script>
    document.querySelector('#editOrderBtn{{$order->id}}').addEventListener('click', function(){
        $('#editOrder{{$order->id}}').modal('show');
    });

    async function editOrder(orderId) {
        const orderDate = document.getElementById(`order_date${orderId}`).value.trim();
        const customerName = document.getElementById(`customer_name${orderId}`).value.trim();
        const customerAddress = document.getElementById(`customer_address${orderId}`).value.trim();
        const customerNumber = document.getElementById(`customer_contact_number${orderId}`).value.trim();
        const branchId = document.getElementById(`branch_id${orderId}`).value;
        const orderStatus = document.getElementById(`order_status${orderId}`).value;

        if (!orderDate || !customerName || !customerNumber || !branchId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill all required fields',
                allowOutsideClick: false,
            });
            return;
        }

        Swal.fire({
            title: "Do you want to update this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#002050',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`editOrderForm${orderId}`).submit();
                $('#editOrder' + orderId).modal('hide');

                Swal.fire({
                    icon: 'info',
                    title: 'Updating Order, please wait...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });
            }
        });
    }
</script>
@endpush
