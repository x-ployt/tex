{{-- Add Button --}}
<button id="addAccountBtn" class="btn greenBtn" title="Add Account">
    <span> <i class="fa-solid fa-plus"> </i> Add Account </span>
</button>

{{-- Add Account--}}
<div class="modal fade" id="addAccount">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{route('account.addAccount')}}" method="post" id="addAccountForm">
                @csrf
                @method('post')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="greenModal">
                    <h5 class="modal-title">Add Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Full Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ old('name') }}" required>
                        <x-error-message field="name"/>
                    </div>

                    {{-- Username --}}
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ old('username') }}" required>
                        <x-error-message field="username"/>
                    </div>
                    
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" 
                        oninput="this.value = this.value.replace(/\s/g, '');"
                        value="{{ old('email') }}" 
                        maxlength="50" required>
                        <x-error-message field="email"/>
                    </div>
                    
                    {{-- Contact Number --}}
                    <div class="mb-3">
                        <label for="contact_number">Contact Number:<span class="text-danger">*</span></label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control" 
                        placeholder="Enter Contact Number" 
                        pattern="[0-9]+" 
                        maxlength="11" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                        value="{{ old('contact_number') }}" 
                        autocomplete="off" required>
                    </div>
                    
                    {{-- Branch Name --}}
                    <div class="mb-3">
                        <label for="branch_id">Branch:<span class="text-danger">*</span></label>
                        <select class="form-control" name="branch_id" id="branch_id" required>
                            <option value="" selected disabled>Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <x-error-message field="branch_id"/>
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label for="role_id">Role:<span class="text-danger">*</span></label>
                        <select class="form-control" name="role_id" id="role_id" required>
                            <option value="" selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        <x-error-message field="role_id"/>
                    </div>
                    
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="addAccount()" id="greenBtn" type="button" class="btn" title="Add Account" style="width: 70px;">Add</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Add Account --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#addAccountBtn').addEventListener('click', function(){
        $('#addAccount').modal('show')
    })
</script>

<script> 
    async function addAccount() {

        const name = document.getElementById('name').value.trim();
        const username = document.getElementById('username').value.trim();
        const contact_number = document.getElementById('contact_number').value.trim();
        const email = document.getElementById('email').value.trim();
        const branch_id = document.getElementById('branch_id').value.trim();
        const role_id = document.getElementById('role_id').value.trim();

        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter full name',
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

        if (!contact_number) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter contact number',
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
                text: 'Please select role',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        const form = document.querySelector(`#addAccountForm`);
        form.submit();
        $('#addAccount').modal('hide')
        // Show loading indicator immediately after form submission
        Swal.fire({
            icon: 'info',
            title: 'Adding Account, please wait.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        });
    }
</script>
@endpush

