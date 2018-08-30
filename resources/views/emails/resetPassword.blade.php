<html>
<header>
</header>
<body style="font-family: 'Helvetica Neue', HelveticaNeue, 'TeX Gyre Heros', TeXGyreHeros, FreeSans, 'Nimbus Sans L', 'Liberation Sans', Arimo, Helvetica, Arial, sans-serif; height: 100%; margin: 0px;">
    <div id="header" style="height: 10vh; background-color: #136cb2; margin: 0; text-align: center;">
        <h1 style="color: #FFF; line-height: 10vh;">{{ config('app.name')}}</h1>
    </div>
    <div style="color: #777; text-align: center;">
        <p style="font-size: 2em;">To reset your {{ config('app.name')}} password, click the button below. It will only be valid for 1 day. If you did not request a password reset, please disregard this message.</p>
        <form method="post" action="{{ route('guest-resetPassword') }}">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $user->email }}" name="email"/>
            <button type="submit" style="font-size: 2em;" value="{{ $guid }}" name="link">Reset Password</button>
        </form>
    </div>
</body>
</html>