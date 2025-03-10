{{-- Reschedule Button --}}
<button id="rescheduleBtn{{ $order->id }}" class="btn btn-warning" title="Reschedule Delivery">
    <span><i class="fa-solid fa-calendar-alt"></i> Reschedule</span>
</button>

{{-- Reschedule Modal --}}
<div class="modal fade" id="rescheduleModal{{ $order->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('delivery.reschedule', $order) }}" method="POST" id="rescheduleForm{{ $order->id }}">
                @csrf
                @method('PUT')

                {{-- Modal Header --}}
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Reschedule Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    <h6 class="fw-bold mb-3">Please select a reason for rescheduling.</h6>
                    <div class="mb-3">
                        <label for="delivery_remarks{{ $order->id }}" class="form-label">Reschedule Reason: <span class="text-danger">*</span></label>
                        <select name="delivery_remarks" id="delivery_remarks{{ $order->id }}" class="form-control" required>
                            <option value="" disabled selected>Select a reason</option>
                            <option value="Customer Cannot be reached">Customer Cannot be reached</option>
                            <option value="Customer Refused to Accept the parcel">Customer Refused to Accept the parcel</option>
                            <option value="Customer Re-scheduled the delivery">Customer Re-scheduled the delivery</option>
                            <option value="Payment is not ready">Payment is not ready</option>
                            <option value="Rider Cannot locate the address (incomplete)">Rider Cannot locate the address (incomplete)</option>
                        </select>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" onclick="markReschedule({{ $order->id }})" class="btn btn-warning" title="Submit Reschedule">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    
    // Reschedule Button: show modal
    document.querySelector('#rescheduleBtn{{ $order->id }}').addEventListener('click', function(){
        $('#rescheduleModal{{ $order->id }}').modal('show');
    });

    // Function to handle Reschedule action
    function markReschedule(orderId) {
        const reason = document.getElementById('delivery_remarks' + orderId).value;
        if (!reason) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select a reschedule reason.',
                allowOutsideClick: false
            });
            return;
        }
        document.getElementById('rescheduleForm' + orderId).submit();
        $('#rescheduleModal' + orderId).modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Processing reschedule...',
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }
</script>
@endpush
