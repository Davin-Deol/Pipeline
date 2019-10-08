@extends('layouts.email') @section('content')
<div style="color: #777; text-align: center;">
    <p style="font-size: 2em;">Congratulations! Your request to join {{ config('app.name') }} was approved! Click the link below to set up your account.</p>
    <form method="post" action="{{ route('user-signUp') }}">
        <input type="hidden" value="{{ $signUpLink->link }}" id="signUpLink" name="signUpLink" />
        <button type="submit" style="font-size: 1.5em;">Sign Up Now</button>
    </form>
    <p><i>Note: This link will only be valid for 7 days</i></p>
</div>
@endsection