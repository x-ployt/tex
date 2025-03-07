{{-- Add Button --}}
<button id="addRoleBtn" class="btn greenBtn" title="Add Role">
    <span> <i class="fa-solid fa-plus"> </i> Add Role </span>
</button>

<br> {{-- Space --}}

{{-- Add Role--}}
<div class="modal fade" id="addRole">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{route('role.addRole')}}" method="post" id="addRoleForm">
                @csrf
                @method('post')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="greenModal">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Role Name --}}
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name:<span class="text-danger">*</span></label>
                        <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Enter Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ old('role_name') }}" required>
                        <x-error-message field="role_name"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="addRole()" id="greenBtn" type="button" class="btn" title="Add Role" style="width: 70px;">Add</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Add Role --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#addRoleBtn').addEventListener('click', function(){
        $('#addRole').modal('show')
    })
</script>

<script> 
    async function addRole() {

        const role_name = document.getElementById('role_name').value.trim();

        if (!role_name) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter role name',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }


        const form = document.querySelector(`#addRoleForm`);
        form.submit();
        $('#addRole').modal('hide')
        // Show loading indicator immediately after form submission
        Swal.fire({
            icon: 'info',
            title: 'Adding Role, please wait.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        });
    }
</script>
@endpush

