{{-- View Profile --}}
<div class="modal fade" id="viewProfile{{ Auth::id() }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-left">

            {{-- Modal Header --}}
            <div class="modal-header align-items-center" id="lightGreenModal">
                <h5 class="modal-title">View Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" name="name" id="name{{ Auth::id() }}" class="form-control" 
                        value="{{ Auth::user()->name }}" readonly>
                </div>

                {{-- Username --}}
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" name="username" id="username{{ Auth::id() }}" class="form-control" 
                        value="{{ Auth::user()->username }}" readonly>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email{{ Auth::id() }}" name="email" 
                        value="{{ Auth::user()->email }}" readonly>
                </div>

                {{-- Contact Number --}}
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number:</label>
                    <input type="contact_number" class="form-control" id="contact_number{{ Auth::id() }}" name="contact_number" 
                        value="{{ Auth::user()->contact_number }}" readonly>
                </div>

                {{-- Branch --}}
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Branch:</label>
                    <input type="text" class="form-control" id="branch_id{{ Auth::id() }}" name="branch_id" 
                        value="{{ Auth::user()->branch->branch_name }}" readonly>
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label for="role_id" class="form-label">Role:</label>
                    <input type="text" class="form-control" id="role_id{{ Auth::id() }}" name="role_id" 
                        value="{{ Auth::user()->role->role_name }}" readonly>
                </div>

            </div>
            {{-- Modal Body --}}

            {{-- Modal Footer --}}
            <div class="modal-footer">
                <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Close">Close</button>
            </div>

        </div>
    </div>
</div>
{{-- View Profile --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#viewProfileBtn{{ Auth::id() }}').addEventListener('click', function() {
        $('#viewProfile{{ Auth::id() }}').modal('show');
    });
</script>
@endpush
