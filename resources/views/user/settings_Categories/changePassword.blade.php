<div class="changePassword field">
    <form class="form-horizontal" action="" method="POST" id="changePasswordForm">
        {{ csrf_field() }}
        <b>Current Password</b>
        <input type="password" class="form-control" id="current_password" rows="5" name="current_password" placeholder="Current Password">
        <i class="validationError" id="current_passwordValidationError"></i>

        <b>New Password</b>
        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
        <i class="validationError" id="new_passwordValidationError"></i>

        <b>Confirm Password</b>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
        <i class="validationError" id="confirm_passwordValidationError"></i>

        <button type="button" class="button" id="submitChangePasswordButton">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Change Password
        </button>
    </form>

</div>

<script src="{{ asset('public/js/forms.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#submitChangePasswordButton").click(function() {
            var url = "{{ route('user-submitChangePassword') }}";
            var formID = "#changePasswordForm";
            var loadingMessage = "Updating password...";
            var successMessage = "Updated password";
            var failMessage = "Failed to update password";
            var context = "Update Password";
            submitForm(url, formID, loadingMessage, successMessage, failMessage, context);
        });
    });
</script>