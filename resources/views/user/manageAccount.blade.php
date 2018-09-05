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
                <form class="form-horizontal" action="{{ route('user-submitNDA') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <b>Status: {{ ucwords($user->NDAStatus) }}</b>
                    <input type="file" id="NDA" name="NDA" accept="image/*">
                    <label for="NDA">
                        <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload NDA
                    </label>
                    @if ($user->NDAStatus == "submitted")
                        <i style="float:right;">Last Updated: {{ $data['NDALastModified'] }}</i>
                    @endif
                    <button type="submit" class="btn btn-default button" name="submitNDA" style="margin-top:2%;">
                        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Submit NDA
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="changePassword field">
            <h1>Change Password</h1>

            <form class="form-horizontal" action="{{ route('user-submitChangePassword') }}" method="POST">
                {{ csrf_field() }}
                <b>Current Password</b>
                <input type="password" class="form-control" id="current_password" rows="5" name="current_password" placeholder="Current Password">

                <b>New Password</b>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">

                <b>Confirm Password</b>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">

                <button type="submit" class="btn btn-default button" name="submitChangePassword">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Change Password
                </button>
            </form>

        </div>

        <div class="updateProfile field">
            <h1>Update Profile</h1>
            <form class="form-horizontal" action="{{ route('user-submitUpdateAccount') }}" method="POST" enctype="multipart/form-data">
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
                            <script>
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
                            </script>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-7">
                        <b>Phone Number</b>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1-613-555-0149" maxlength="32" value="{{ $user->phoneNumber }}">

                        <b>Date of Birth</b>
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" value="{{ $birthday }}">
                        <b>Location</b><i id="locationCharCounter" style="float:right;"></i>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Vancouver, BC Canada" maxlength="MAXLENGTH" value="{{ $user->location }}">

                        <b>Bio</b>
                        <textarea class="form-control" rows="5" id="bio" name="bio" placeholder="Hello, my name is Joey Klein and I am the founder of Irone, a mining company.

We have the ability to operate and build any mining development zones you can think of. Look through my listings to see how you can get involved!" maxlength="MAXLENGTH" id="bio">{{ $user->bio }}</textarea><br>
                        <b>LinkedIn URL</b>
                        <input type="text" class="form-control" id="linkedInURL" name="linkedInURL" placeholder="https://www.linkedin.com/in/joeycassklein/" value="{{ $user->linkedInURL }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-default button" name="submitUpdateProfile">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
