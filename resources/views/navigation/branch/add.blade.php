{{-- Add Button --}}
<button id="addBranchBtn" class="btn greenBtn" title="Add Branch">
    <span> <i class="fa-solid fa-plus"> </i> Add Branch </span>
</button>

{{-- Add Branch--}}
<div class="modal fade" id="addBranch">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{route('branch.addBranch')}}" method="post" id="addBranchForm">
                @csrf
                @method('post')
            
                {{-- Modal Header --}}
                <div class="modal-header align-items-center" id="greenModal">
                    <h5 class="modal-title">Add Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>

               {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Branch Name --}}
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Branch Name:<span class="text-danger">*</span></label>
                        <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Enter Name" 
                        pattern="[A-Za-z ]+" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');"
                        value="{{ old('branch_name') }}" required>
                        <x-error-message field="branch_name"/>
                    </div>

                    {{-- Branch Address --}}
                    <div class="mb-3">
                        <label for="branch_address" class="form-label">Branch Address:<span class="text-danger">*</span></label>
                        <input type="text" name="branch_address" id="branch_address" class="form-control" placeholder="Enter Address" 
                        pattern="[A-Za-z ]+" maxlength="50"
                        value="{{ old('branch_address') }}" required>
                        <x-error-message field="branch_address"/>
                    </div>
                </div>
                {{-- Modal Body --}}

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button onclick="addBranch()" id="greenBtn" type="button" class="btn" title="Add Branch" style="width: 70px;">Add</button>
                    <button id="whiteBtn" type="button" class="btn" data-bs-dismiss="modal" title="Cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Add Branch --}}

{{-- Scripts --}}
@push('scripts')
<script>
    document.querySelector('#addBranchBtn').addEventListener('click', function(){
        $('#addBranch').modal('show')
    })
</script>

<script> 
    async function addBranch() {

        const branch_name = document.getElementById('branch_name').value.trim();
        const branch_address = document.getElementById('branch_address').value.trim();

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

        const form = document.querySelector(`#addBranchForm`);
        form.submit();
        $('#addBranch').modal('hide')
        // Show loading indicator immediately after form submission
        Swal.fire({
            icon: 'info',
            title: 'Adding Branch, please wait.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false
        });
    }
</script>
@endpush

