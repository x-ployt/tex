{{-- rts Button --}}
<button id="rtsBtn{{ $order->id }}" class="btn redBtn" title="Cancel Order">
    <span><i class="fa-solid fa-times"></i> RTS </span>
</button>

{{-- rts Modal --}}
<div class="modal fade" id="rtsModal{{ $order->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('order.markRTS', $order) }}" method="POST" id="rtsForm{{ $order->id }}">
                @csrf
                @method('PUT')

                {{-- Modal Header --}}
                <div class="modal-header" id="redBtn">
                    <h5 class="modal-title">Return Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    @php
                        $remarks = \App\Models\Remark::where('type', 'RTS')->get()
                    @endphp

                    <h6 class="fw-bold mb-3">Please select a rts reason.</h6>
                    <div class="mb-3">
                        <label for="reason{{ $order->id }}" class="form-label">Rts reason: <span class="text-danger">*</span></label>
                        <select name="reason" id="reason{{ $order->id }}" class="form-control" required>
                            <option value="" disabled selected>Select a reason</option>
                            @foreach ($remarks as $remark)
                                <option value="{{ $remark->remarks }}">{{ $remark->remarks }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" onclick="markRts({{ $order->id }})" class="btn redBtn" title="Submit RTS">Submit</button>
                    <button type="button" class="btn whiteBtn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    
    // rts Button: show modal
    document.querySelector('#rtsBtn{{ $order->id }}').addEventListener('click', function(){
        $('#rtsModal{{ $order->id }}').modal('show');
    });
    
    // Function to handle rts action
    function markRts(orderId) {
        const reason = document.getElementById('reason' + orderId).value;
        if (!reason) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select a rts reason.',
                allowOutsideClick: false
            });
            return;
        }
        document.getElementById('rtsForm' + orderId).submit();
        $('#rtsModal' + orderId).modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Processing rts...',
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }
</script>
@endpush