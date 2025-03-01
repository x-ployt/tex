{{-- Cancelled Button --}}
<button id="cancelledBtn{{ $order->id }}" class="btn redBtn" title="Cancel Order">
    <span><i class="fa-solid fa-times"></i> Cancelled</span>
</button>

{{-- Cancelled Modal --}}
<div class="modal fade" id="cancelledModal{{ $order->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('order.markCancelled', $order) }}" method="POST" id="cancelledForm{{ $order->id }}">
                @csrf
                @method('PUT')
                {{-- Modal Header --}}
                <div class="modal-header" id="redBtn">
                    <h5 class="modal-title">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <div class="modal-body">
                    <h6 class="fw-bold mb-3">Please select a cancellation reason.</h6>
                    <div class="mb-3">
                        <label for="reason{{ $order->id }}" class="form-label">Cancellation Reason: <span class="text-danger">*</span></label>
                        <select name="reason" id="reason{{ $order->id }}" class="form-control" required>
                            <option value="" disabled selected>Select a reason</option>
                            <option value="Customer changed mind">Customer changed mind</option>
                            <option value="Payment issues">Payment issues</option>
                            <option value="Out of stock">Out of stock</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" onclick="markCancelled({{ $order->id }})" class="btn redBtn" title="Submit Cancellation">Submit</button>
                    <button type="button" class="btn whiteBtn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    
    // Cancelled Button: show modal
    document.querySelector('#cancelledBtn{{ $order->id }}').addEventListener('click', function(){
        $('#cancelledModal{{ $order->id }}').modal('show');
    });
    
    // Function to handle Cancelled action
    function markCancelled(orderId) {
        const reason = document.getElementById('reason' + orderId).value;
        if (!reason) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select a cancellation reason.',
                allowOutsideClick: false
            });
            return;
        }
        document.getElementById('cancelledForm' + orderId).submit();
        $('#cancelledModal' + orderId).modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Processing cancellation...',
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }
</script>
@endpush