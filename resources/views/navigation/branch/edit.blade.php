{{-- Edit Button --}}
<button id="editBranchBtn{{$branch->id}}" class="btn lightGreenBtn" title="Edit Branch">
    <span> <i class="fa-solid fa-pencil"> </i> Edit </span>
</button>

{{-- Edit Branch--}}
<div class="modal fade" id="editBranch{{$branch->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            <form action="{{route('branch.updateBranch', $branch)}}" method="post" id="editBranchForm">
                @csrf
                @method('put')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title">Edit Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Branch Name:<span class="text-danger">*</span></label>
                        <input type="text" name="branch_name" id="branch_name{{$branch->id}}" class="form-control" placeholder="Branch Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ $branch->branch_name }}" required>
                        <x-error-message field="branch_name"/>
                    </div>

                    {{-- Branch Address --}}
                    <div class="mb-3">
                        <label for="branch_address" class="form-label">Branch Address:<span class="text-danger">*</span></label>
                        <input type="text" name="branch_address" id="branch_address{{$branch->id}}" class="form-control" placeholder="Branch address" 
                        pattern="[A-Za-z ]+" maxlength="50"
                        value="{{ $branch->branch_address }}" required>
                        <x-error-message field="branch_address"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="editBranch()" id="lightGreenBtn" type="button" class="btn" title="Update Branch" style="width: auto;">Update</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Branch --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#editBranchBtn{{$branch->id}}').addEventListener('click', function(){
        $('#editBranch{{$branch->id}}').modal('show')
    })
</script>

<script> 
    async function editBranch() {
        const branch_name = document.getElementById('branch_name{{$branch->id}}').value.trim();
        const branch_address = document.getElementById('branch_address{{$branch->id}}').value.trim();

        // Perform validations
        if (!branch_name) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter branch name',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!branch_address) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter branch address',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        // Show a confirmation dialog before submitting the form
        Swal.fire({
            title: "Do you want to update this Branch's details?",
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
                document.querySelector(`#editBranchForm`).submit();
                $('#editBranch{{$branch->id}}').modal('hide');

                // Show loading indicator
                Swal.fire({
                    icon: 'info',
                    title: 'Updating Branch, please wait...',
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

