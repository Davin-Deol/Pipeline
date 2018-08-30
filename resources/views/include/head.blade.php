<title>
    {{ config('app.name') }} | {{ $data["title"] }}</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/all.php') }}">

<link href="{{ asset('public/slick-1.8.0/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('public/slick-1.8.0/slick/slick-theme.css') }}" rel="stylesheet" />

<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('public/img/Favicon/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('public/img/Favicon/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('public/img/Favicon/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/img/Favicon/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('public/img/Favicon/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/img/Favicon/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('public/img/Favicon/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('public/img/Favicon/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/img/Favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('public/img/Favicon/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/img/Favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/img/Favicon/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/img/Favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('public/img/Favicon/manifest.json') }}">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('public/img/Favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">

<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:title" content="{{ config('app.name') }}">
<meta property="og:description" content="Bringing People, Projects, Resources and Capital Together">
<meta property="og:image" content="{{ asset('public/img/Meta-Data/large-image.png') }}">
<meta property="og:image:type" content="image/png">
<meta property="og:url" content="{{ route('guest-home') }}">
<meta name="twitter:title" content="{{ config('app.name') }}">
<meta name="twitter:description" content=" Bringing People, Projects, Resources and Capital Together">
<meta name="twitter:image" content="{{ asset('public/img/Meta-Data/large-image.png') }}">
<meta name="twitter:image:alt" content="Icon that represents {{ config('app.name') }}">
<meta name="twitter:card" content="summary">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('public/js/Animated-Text-Underlines-jQuery-linkUnderline/jquery.linkunderanim.js') }}"></script>
<script src="{{ asset('public/slick-1.8.0/slick/slick.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#nav").linkUnderlineAnim({
            "speed": 300,
            "color": "#FFF",
            "thickness": 2,
            "distance": 10
        });
    });
</script>
