{{-- Delivered Button --}}
<button id="deliveredBtn{{ $order->id }}" class="btn greenBtn" title="Mark as Delivered">
    <span><i class="fa-solid fa-check"></i> Delivered</span>
</button>

{{-- Delivered Modal --}}
<div class="modal fade" id="deliveredModal{{ $order->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('order.markDelivered', $order) }}" method="POST" enctype="multipart/form-data" id="deliveredForm{{ $order->id }}">
                @csrf
                @method('PUT')
                {{-- Modal Header --}}
                <div class="modal-header" id="greenBtn">
                    <h5 class="modal-title">Mark Order as Delivered</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <div class="modal-body">
                    <h6 class="fw-bold mb-3">Please upload at least one proof photo to confirm delivery.</h6>
                    <div class="mb-3">
                        <label for="deliveryPhotos{{ $order->id }}" class="form-label">
                            Upload Proof Photo(s): <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="delivery_photos[]" id="deliveryPhotos{{ $order->id }}" class="form-control" multiple required accept="image/jpeg, image/png">
                    </div>                    
                </div>
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" onclick="markDelivered({{ $order->id }})" class="btn greenBtn" title="Submit Delivered">Submit</button>
                    <button type="button" class="btn whiteBtn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Delivered Button: show modal
    document.querySelector('#deliveredBtn{{ $order->id }}').addEventListener('click', function(){
        $('#deliveredModal{{ $order->id }}').modal('show');
    });
    
    // Function to handle Delivered action
    function markDelivered(orderId) {
        const proofInput = document.getElementById('deliveryPhotos' + orderId);
        if (proofInput.files.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please upload at least one proof photo.',
                allowOutsideClick: false
            });
            return;
        }
        document.getElementById('deliveredForm' + orderId).submit();
        $('#deliveredModal' + orderId).modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Processing delivered status...',
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }

</script>
@endpush