{{-- Edit Button --}}
<button id="editRemarkBtn{{$remark->id}}" class="btn lightGreenBtn" title="Edit Remark">
    <span> <i class="fa-solid fa-pencil"> </i> Edit </span>
</button>

{{-- Edit Remark--}}
<div class="modal fade" id="editRemark{{$remark->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            <form action="{{route('remark.update', $remark)}}" method="post" id="editRemarkForm">
                @csrf
                @method('put')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title">Edit Remark</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Remarks --}}
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks:<span class="text-danger">*</span></label>
                        <input type="text" name="remarks" id="remarks{{$remark->id}}" class="form-control" placeholder="Enter Remarks" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ $remark->remarks }}" required>
                        <x-error-message field="name"/>
                    </div>
                    
                    {{-- Type --}}
                    <div class="mb-3">
                        <label for="type">Type:<span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="type{{$remark->id}}" required>
                            <option value="{{$remark->type}}">{{$remark->type}}</option>
                            <option value="Re-Schedule Delivery">Re-Schedule Delivery</option>
                            <option value="RTS">RTS</option>
                        </select>
                        <x-error-message field="type"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="editRemark()" id="lightGreenBtn" type="button" class="btn" title="Update Remark" style="width: auto;">Update</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Remark --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#editRemarkBtn{{$remark->id}}').addEventListener('click', function(){
        $('#editRemark{{$remark->id}}').modal('show')
    })
</script>

<script> 
    async function editRemark() {
        const remarks = document.getElementById('remarks{{$remark->id}}').value.trim();
        const type = document.getElementById('type{{$remark->id}}').value.trim();

        // Perform validations
        if (!remarks) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter remarks',
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
                text: 'Please enter type',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }
        
        // Show a confirmation dialog before submitting the form
        Swal.fire({
            title: "Do you want to update this Remark's details?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#002050',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(`#editRemarkForm`).submit();
                $('#editRemark{{$remark->id}}').modal('hide');

                // Show loading indicator
                Swal.fire({
                    icon: 'info',
                    title: 'Updating Remark, please wait...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false
                });
            }
        });
    }
</script>
@endpush

