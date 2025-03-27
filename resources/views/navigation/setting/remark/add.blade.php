{{-- Add Button --}}
<button id="addRemarkBtn" class="btn greenBtn" title="Add Remark">
    <span> <i class="fa-solid fa-plus"> </i> Add Remark </span>
</button>

{{-- Add Remark--}}
<div class="modal fade" id="addRemark">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{route('remark.store')}}" method="post" id="addRemarkForm">
                @csrf
                @method('post')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="greenModal">
                    <h5 class="modal-title">Add Remark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Remarks --}}
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks:<span class="text-danger">*</span></label>
                        <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ old('remarks') }}" required>
                        <x-error-message field="remarks"/>
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label for="type">Type:<span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="Re-Schedule Delivery">Re-Schedule Delivery</option>
                            <option value="RTS">RTS</option>
                            
                        </select>
                        <x-error-message field="type"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="addRemark()" id="greenBtn" type="button" class="btn" title="Add Remark" style="width: 70px;">Add</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Add Remark --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#addRemarkBtn').addEventListener('click', function(){
        $('#addRemark').modal('show')
    })
</script>

<script> 
    async function addRemark() {

        const remarks = document.getElementById('remarks').value.trim();
        const type = document.getElementById('type').value.trim();

        if (!remarks) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter full remarks',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!type) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select type',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        const form = document.querySelector(`#addRemarkForm`);
        form.submit();
        $('#addRemark').modal('hide')
        // Show loading indicator immediately after form submission
        Swal.fire({
            icon: 'info',
            title: 'Adding Remark, please wait.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        });
    }
</script>
@endpush

