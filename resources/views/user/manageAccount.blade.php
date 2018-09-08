@extends('layouts.user') @section('content')
<div class="row">
    <div class="col-lg-12">
        @if ($user->NDAStatus != "approved")
        <div class="uploadNDA row field">
            <h1>Upload NDA</h1>
                <h4>How To Submit NDA:</h4>
            <div class="col-md-6">
                <ol>
                    <li>Print the NDA found <a href="{{ asset('public/img/NDAs/nda.pdf') }}" target="_blank">here</a></li>
                    <li>Sign it</li>
                    <li>Take a picture or scan the signed document</li>
                    <li>Upload the document here</li>
                    <li>You will be notified whether the admin approved/denied it</li>
                </ol>
            </div>
            <div class="col-md-6">
                <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="NDAForm">
                    {{ csrf_field() }}
                    <b>Status: {{ ucwords($user->NDAStatus) }}</b>
                    <input type="file" id="NDA" name="NDA" accept="image/*">
                    <label for="NDA">
                        <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload NDA
                    </label>
                    <i class="validationError" id="NDAValidationError"></i>
                    @if ($user->NDAStatus == "submitted")
                        <i id="ndaLastUpdated" style="float:right;">Last Updated: {{ $data['NDALastModified'] }}</i>
                    @endif
                    <button type="button" class="button" style="margin-top:2%;" id="submitNDAButton">
                        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Submit NDA
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="changePassword field">
            <h1>Change Password</h1>

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

        <div class="updateProfile field">
            <h1>Update Profile</h1>
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
    </div>
</div>
<script>
    $(document).ready(function() {
        
        $("#profile_image").change(function() {
            if ($("#profile_image")[0].files.length)
            {
                $('#profileImageDisplay').attr('src', URL.createObjectURL(event.target.files[0]));
            }
            else
            {
                @if ($user->profileImage)
                    $('#profileImageDisplay').attr('src', "public/img/Profile-Images/{{ $user->profileImage }}");
                @else
                    $('#profileImageDisplay').attr('src', "public/img/Profile-Images/Default-User-Profile-Image.png");
                @endif
            }
        });
            
        function submitForm(url, formID, loadingMessage, successMessage, failMessage, context)
        {
            displayLoadingModal(loadingMessage);
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($(formID)[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    
                    $(".validationError").each(function(index) {
                        $(this).html("");
                        $(this).css("display", "none");
                    });
                    
                    if (response["result"] == "success")
                    {
                        switch (context)
                        {
                            case "Submit NDA":
                                $("#ndaLastUpdated").html("Last Updated: " + response["data"]);
                                break;
                            case "Update Password":
                                break;
                            case "Update Account":
                                break;
                            default:
                                break;
                        }
                        displaySuccessModal(successMessage);
                    
                        $(formID).trigger("reset");
                    }
                    else
                    {
                        displayErrorModal(failMessage);
                        for (var data in response["data"])
                        {
                            $("#" + data + "ValidationError").html(response["data"][data][0]);
                            $("#" + data + "ValidationError").css("display", "block");
                        }
                    }
                },
                error: function() {
                    displayErrorModal(failMessage);
                }
            });
        }
        
        $("#submitNDAButton").click(function() {
            var url = "{{ route('user-submitNDA') }}";
            var formID = "#NDAForm";
            var loadingMessage = "Submitting NDA...";
            var successMessage = "Submitted NDA";
            var failMessage = "Failed to submit NDA";
            var context = "Submit NDA";
            submitForm(url, formID, loadingMessage, successMessage, failMessage, context);
        });
        
        $("#submitChangePasswordButton").click(function() {
            var url = "{{ route('user-submitChangePassword') }}";
            var formID = "#changePasswordForm";
            var loadingMessage = "Updating password...";
            var successMessage = "Updated password";
            var failMessage = "Failed to update password";
            var context = "Update Password";
            submitForm(url, formID, loadingMessage, successMessage, failMessage, context);
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
@endsection
