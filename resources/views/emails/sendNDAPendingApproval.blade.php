<html>
<header>
</header>
<body style="font-family: 'Helvetica Neue', HelveticaNeue, 'TeX Gyre Heros', TeXGyreHeros, FreeSans, 'Nimbus Sans L', 'Liberation Sans', Arimo, Helvetica, Arial, sans-serif; height: 100%; margin: 0px;">
    <div id="header" style="height: 10vh; background-color: #136cb2; margin: 0; text-align: center;">
        <h1 style="color: #FFF; line-height: 10vh; font-size: 3em; font-weight: 400;">{{ config('app.name') }}</h1>
    </div>
    <div id="mainSection" style="width: 80%; margin: 0 auto; color: #777; text-align: center;">
        <p style="font-size: 2em;">{{ $user["fullName"] }} Has Submitted a NDA!</p>
    </div>
</body>
</html>