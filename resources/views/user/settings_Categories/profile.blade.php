<div class="updateProfile field">
    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="updateProfileForm">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-4 col-sm-5">
                <div id="profileImage">
                    @if ($user->profileImage)
                    <img style="border:1px solid black;margin-bottom:5%;" src="public/img/Profile-Images/{{ $user->profileImage }}" width="100%" id="profileImageDisplay" />
                    @else
                    <img style="border:1px solid black;margin-bottom:5%;" src="public/img/Profile-Images/Default-User-Profile-Image.png" width="100%" id="profileImageDisplay" />
                    @endif
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    <label for="profile_image" style="margin-bottom:5%;">
                        <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Change Profile Image
                    </label>
                    <i class="validationError" id="profile_imageValidationError"></i>
                </div>
            </div>

            <div class="col-md-8 col-sm-7">
                <b>Phone Number</b>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1-613-555-0149" maxlength="32" value="{{ $user->phoneNumber }}">
                <i class="validationError" id="phoneValidationError"></i>

                <b>Date of Birth</b>
                <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" value="{{ $birthday }}">
                <i class="validationError" id="birthdayValidationError"></i>

                <b>Location</b>
                <input type="text" class="form-control" id="location" name="location" placeholder="Vancouver, BC Canada" maxlength="MAXLENGTH" value="{{ $user->location }}">
                <i class="validationError" id="locationValidationError"></i>

                <b>Bio</b>
                <textarea class="form-control" rows="5" id="bio" name="bio" placeholder="Hello, my name is Joey Klein and I am the founder of Irone, a mining company.

We have the ability to operate and build any mining development zones you can think of. Look through my listings to see how you can get involved!" maxlength="MAXLENGTH" id="bio">{{ $user->bio }}</textarea>
                <i class="validationError" id="bioValidationError"></i>

                <b>LinkedIn URL</b>
                <input type="text" class="form-control" id="linkedInURL" name="linkedInURL" placeholder="https://www.linkedin.com/in/joeycassklein/" value="{{ $user->linkedInURL }}">
                <i class="validationError" id="linkedInURLValidationError"></i>
            </div>
        </div>
        <button type="button" class="button" id="submitUpdateProfileButton">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Profile
        </button>
    </form>
</div>

<script src="{{ asset('public/js/forms.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#profile_image").change(function() {
            if ($("#profile_image")[0].files.length) {
                $('#profileImageDisplay').attr('src', URL.createObjectURL(event.target.files[0]));
            } else {
                @if($user -> profileImage)
                $('#profileImageDisplay').attr('src', "public/img/Profile-Images/{{ $user->profileImage }}");
                @else
                $('#profileImageDisplay').attr('src', "public/img/Profile-Images/Default-User-Profile-Image.png");
                @endif
            }
        });

        $("#submitUpdateProfileButton").click(function() {
            var url = "{{ route('user-submitUpdateAccount') }}";
            var formID = "#updateProfileForm";
            var loadingMessage = "Updating account...";
            var successMessage = "Updated account";
            var failMessage = "Failed to update account";
            var context = "Update Account";
            submitForm(url, formID, loadingMessage, successMessage, failMessage, context);
        });
    });

</script>
