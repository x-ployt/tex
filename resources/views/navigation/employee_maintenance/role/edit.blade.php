{{-- Edit Button --}}
<button id="editRoleBtn{{$role->id}}" class="btn lightGreenBtn" title="Edit Role">
    <span> <i class="fa-solid fa-pencil"> </i> Edit </span>
</button>

{{-- Edit Role--}}
<div class="modal fade" id="editRole{{$role->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            <form action="{{route('role.update', $role)}}" method="post" id="editRoleForm">
                @csrf
                @method('put')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Role Name --}}
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name:<span class="text-danger">*</span></label>
                        <input type="text" name="role_name" id="role_name{{$role->id}}" class="form-control" placeholder="Role Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ $role->role_name }}" required>
                        <x-error-message field="role_name"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="editRole()" id="yellowBtn" type="button" class="btn" title="Update Role" style="width: auto;">Update</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Role --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#editRoleBtn{{$role->id}}').addEventListener('click', function(){
        $('#editRole{{$role->id}}').modal('show')
    })
</script>

<script> 
    async function editRole() {
        const role_name = document.getElementById('role_name{{$role->id}}').value.trim();
        const role_address = document.getElementById('role_address{{$role->id}}').value.trim();

        // Perform validations
        if (!role_name || !role_address) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        // Show a confirmation dialog before submitting the form
        Swal.fire({
            title: "Do you want to update this Role's details?",
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
                document.querySelector(`#editRoleForm`).submit();
                $('#editRole{{$role->id}}').modal('hide');

                // Show loading indicator
                Swal.fire({
                    icon: 'info',
                    title: 'Updating Role, please wait...',
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

