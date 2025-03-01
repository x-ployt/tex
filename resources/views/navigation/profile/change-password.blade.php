{{-- Change Password Modal --}}
<div class="modal fade" id="changePasswordModal{{ Auth::id() }}" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">
            <form action="{{ route('changePassword', Auth::user()) }}" method="post" id="changePasswordForm{{ Auth::id() }}">
                @method('put')
                @csrf

                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="lightGreenModal">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body">
                    {{-- Current Password --}}
                    <div class="mb-3">
                        <label for="currentPassword{{ Auth::id() }}" class="form-label">Current Password:<span class="text-danger">*</span></label>
                        <input type="password" name="currentPassword" id="currentPassword{{ Auth::id() }}" class="form-control" required>
                        @error('currentPassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="mb-3">
                        <label for="newPassword{{ Auth::id() }}" class="form-label">New Password:<span class="text-danger">*</span></label>
                        <input type="password" name="newPassword" id="newPassword{{ Auth::id() }}" class="form-control" required>
                        @error('newPassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="mb-3">
                        <label for="confirmPassword{{ Auth::id() }}" class="form-label">Confirm New Password:<span class="text-danger">*</span></label>
                        <input type="password" name="newPassword_confirmation" id="confirmPassword{{ Auth::id() }}" class="form-control" required>
                        @error('confirmPassword')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn lightGreenBtn" onclick="changePassword{{ Auth::id() }}()">Save Changes</button>
                    <button type="button" class="btn whiteBtn" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelector('#changePasswordBtn{{ Auth::id() }}').addEventListener('click', function() {
        $('#changePasswordModal{{ Auth::id() }}').modal('show');
    });

    async function changePassword{{ Auth::id() }}() {
        const currentPassword = document.getElementById('currentPassword{{ Auth::id() }}').value.trim();
        const newPassword = document.getElementById('newPassword{{ Auth::id() }}').value.trim();
        const confirmPassword = document.getElementById('confirmPassword{{ Auth::id() }}').value.trim();

        if (!currentPassword || !newPassword || !confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'New passwords do not match.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
            return;
        }

        const form = document.querySelector('#changePasswordForm{{ Auth::id() }}');
        form.submit();

        // Show loading indicator immediately after form submission
        Swal.fire({
            icon: 'info',
            title: 'Changing password, please wait.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        });
    }

</script>

@if ($errors->has('currentPassword'))
    @foreach ($errors->get('currentPassword') as $error)
        <script type="module">
            $(function(){
                $('#changePasswordModal{{ Auth::id() }}').modal('show');
                Toast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                })
            })
        </script>
    @endforeach
@endif

@if ($errors->has('newPassword'))
    @foreach ($errors->get('newPassword') as $error)
        <script type="module">
            $(function(){
                $('#changePasswordModal{{ Auth::id() }}').modal('show');
                Toast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                })
            })
        </script>
    @endforeach
@endif

@if(session()->has('changeSuccess'))
<script type="module">
    $(function(){
        Toast.fire({
            icon: 'success',
            title: '{{ session('changeSuccess') }}'
        })
    })
</script>
@endif
@endpush
