{{-- Reset Password --}}
<form action="{{route('account.resetPassword', $user)}}" method="post" id="resetPasswordForm{{$user->id}}">
    @csrf
    @method('put')
</form>

{{-- Scripts --}}
@push('scripts')
<script type="module">
    // Event listener for the deactivate button
    document.getElementById('resetBtn{{$user->id}}').addEventListener('click', async () => {
        const { value: isConfirmed } = await Swal.fire({
            icon: "warning",
            title: "Do you want to reset this password back to default?",
            showCancelButton: true,
            confirmButtonColor: '#002050',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        });

        if (isConfirmed) {
            const form = document.querySelector(`#resetPasswordForm{{$user->id}}`);
            form.submit();

            Swal.fire({
                icon: 'info',
                title: 'Changing password back to default, please wait.',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
        }
    });
</script>
@endpush