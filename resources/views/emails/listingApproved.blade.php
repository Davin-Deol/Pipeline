<html>
<header>
</header>
<body style="font-family: 'Helvetica Neue', HelveticaNeue, 'TeX Gyre Heros', TeXGyreHeros, FreeSans, 'Nimbus Sans L', 'Liberation Sans', Arimo, Helvetica, Arial, sans-serif; height: 100%; margin: 0px;">
    <div style="height: 10vh; background-color: #136cb2; margin: 0; text-align: center;">
        <h1 style="color: #FFF; line-height: 10vh;">{{ config('app.name')}}</h1>
    </div>
    <div style="color: #777; text-align: center;">
        <p style="font-size: 2em;">Your listing "{{ $listing->name }}" was approved and has now been posted for all {{ config('app.name')}} users to see!</p>
    </div>
</body>
</html>