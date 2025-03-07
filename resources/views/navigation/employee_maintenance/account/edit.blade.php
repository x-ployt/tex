{{-- Edit Button --}}
<button id="editAccountBtn{{$user->id}}" class="btn lightGreenBtn" title="Edit Account">
    <span> <i class="fa-solid fa-pencil"> </i> Edit </span>
</button>

{{-- Edit Account--}}
<div class="modal fade" id="editAccount{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            <form action="{{route('account.updateAccount', $user)}}" method="post" id="editAccountForm">
                @csrf
                @method('put')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name{{$user->id}}" class="form-control" placeholder="Enter Full Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ $user->name }}" required>
                        <x-error-message field="name"/>
                    </div>

                    {{-- Username --}}
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username{{$user->id}}" class="form-control" placeholder="Enter Username" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ $user->username }}" required>
                        <x-error-message field="username"/>
                    </div>
                    
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email{{$user->id}}" name="email" placeholder="Enter email" 
                        oninput="this.value = this.value.replace(/\s/g, '');"
                        value="{{ $user->email }}" 
                        maxlength="50" required>
                        <x-error-message field="email"/>
                    </div>
                    
                    {{-- Branch Name --}}
                    <div class="mb-3">
                        <label for="branch_id">Branch Name:<span class="text-danger">*</span></label>
                        <select class="form-control" name="branch_id" id="branch_id{{$user->id}}" required>
                            <option value="{{$user->branch_id}}">{{$user->branch->branch_name}}</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name}}</option>
                            @endforeach
                        </select>
                        <x-error-message field="branch_id"/>
                        </div>

                    {{-- Role Name --}}
                    <div class="mb-3">
                        <label for="role_id">Role Name:<span class="text-danger">*</span></label>
                        <select class="form-control" name="role_id" id="role_id{{$user->id}}" required>
                            <option value="{{$user->role_id}}">{{$user->role->role_name}}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name}}</option>
                            @endforeach
                        </select>
                        <x-error-message field="role_id"/>
                        </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    {{-- Reset Button --}}
                    <button type="button" id="resetBtn{{$user->id}}" class="btn redBtn" title="Reset password">
                        Reset Password
                    </button>
                    <button onclick="editAccount()" id="lightGreenBtn" type="button" class="btn" title="Update Account" style="width: auto;">Update</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Account --}}

{{-- Reset Password Modal --}}
@include('navigation/employee_maintenance/account/reset-password')

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#editAccountBtn{{$user->id}}').addEventListener('click', function(){
        $('#editAccount{{$user->id}}').modal('show')
    })
</script>

<script> 
    async function editAccount() {
        const name = document.getElementById('name{{$user->id}}').value.trim();
        const username = document.getElementById('username{{$user->id}}').value.trim();
        const email = document.getElementById('email{{$user->id}}').value.trim();
        const branch_id = document.getElementById('branch_id{{$user->id}}').value.trim();
        const role_id = document.getElementById('role_id{{$user->id}}').value.trim();

        // Perform validations
        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter name',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!username) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter username',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter email',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!branch_id) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select branch',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (!role_id) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select department',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        // Show a confirmation dialog before submitting the form
        Swal.fire({
            title: "Do you want to update this Account's details?",
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
                document.querySelector(`#editAccountForm`).submit();
                $('#editAccount{{$user->id}}').modal('hide');

                // Show loading indicator
                Swal.fire({
                    icon: 'info',
                    title: 'Updating Account, please wait...',
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

