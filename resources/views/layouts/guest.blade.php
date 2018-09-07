<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<header>
    @include('include.head')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/index.php') }}">
    <script src="{{ asset('public/js/index.js') }}"></script>
</header>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-default" style="margin-bottom: 0;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        <a href="{{ route('guest-home') }}"><span class="navbar-brand">{{ config('app.name') }}</span></a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav" id="nav">
                            <li>
                                <a href="{{ route('guest-home') }}#howItWorksSection">
                                        {{ $data['index_rowOne_header'] }}<span class="sr-only"></span></a>
                            </li>
                            <li>
                                <a href="{{ route('guest-home') }}#aboutSection">
                                        {{ $data['index_rowTwo_header'] }}<span class="sr-only"></span></a>
                            </li>
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li onclick="displayRequestInvitationForm()">
                                <a>
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Request Invitation<span class="sr-only"></span>
                                </a>
                            </li>
                            <li onclick="displayLoginForm()">
                                <a><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login<span class="sr-only"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        @yield('content')
    </div>

    <div class="modal" tabindex="2" role="dialog" id="loadingModal" style="text-align: center;">
        <div class="modal-dialog" role="document">
            <div class="modal-content form">
                <img src="{{ asset('public/img/Loading.gif') }}" width="33%" style="margin: 0 auto;display: inherit;" />
                <b id="loadingMessage" style="text-align: center;">Authenticating...</b>
            </div>
        </div>
    </div>
    
    <div class="modal" tabindex="1" role="dialog" id="loginModal">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close" aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">Login</h3>
                </div>
                <div class="modal-body">
                    <form class="cf" method="post" action="" id="loginForm">
                        <div id="formBox">
                            <input type="email" id="loginEmail" name="email" placeholder="Email" required>
                            <input type="password" name="password" id="loginPassword" placeholder="Password">
                            <label for="keepMeSignedIn" class="label-cbx">
                                <input type="checkbox" id="keepMeSignedIn" class="invisible" name="keepMeSignedIn">
                                <div class="checkbox">
                                    <svg viewBox="0 0 20 20">
                                        <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                        <polyline points="4 11 8 15 16 6"></polyline>
                                    </svg>
                                </div>
                                <span>Keep me signed in</span>
                            </label>
                            <button type="submit" name="submitLogin" id="submitLogin" value="Login" class="button">
                                <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login
                            </button>
                        </div>
                    </form>
                    <button class="alternativeOptions" type="submit" name="requestInvitation" onclick="displayRequestInvitationForm()">Request Invitation</button>
                    <button class="alternativeOptions alternativeTwoBtn" type="submit" name="forgotPassword" onclick="displayForgotPassword()">Forgot Password</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="1" role="dialog" id="requestInvitationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    <h3 class="modal-title">Request Invitation</h3>
                </div>
                <div class="modal-body">
                    <form class="cf" method="post" action="" id="requestInvitationForm">
                        <div id="formBox">
                            <input type="email" id="requestInvitationEmail" name="email" placeholder="Email" required>
                            <input type="text" id="input-full-name" placeholder="Full Name" name="fullName" required>
                            <input type="url" id="input-linkedin-url" placeholder="LinkedIn URL" name="linkedInURL">

                            <b style="font-size: 1.3em; font-weight: 400;">You wish to join as a(n):</b>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width: auto;">
                                    <label class="radio">Individual<input id="radio1" type="radio" name="individualOrOrganization" value="individual" checked required><span class="outer"><span class="inner"></span></span></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width: auto;">
                                    <label class="radio"><input id="radio2" type="radio" name="individualOrOrganization" value="organization"><span class="outer"><span class="inner"></span></span>Organization</label>
                                </div>
                            </div>

                            <b style="font-size: 1.3em; font-weight: 400;">What are your interests?</b>
                            <div class="cntr row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @php ($i = 0) @foreach ($listOfInterests as $int) @if ($i == (count($listOfInterests) / 2))
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    @endif
                                    <label for="checkbox{{ $i }}" class="label-cbx">
                                                    <input id="checkbox{{ $i }}" type="checkbox" class="invisible" name="interests[]" value="{{ $int->interest }}"><div class="checkbox">
                                                        <svg viewBox="0 0 20 20">
                                                            <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                            <polyline points="4 11 8 15 16 6"></polyline>
                                                        </svg>
                                                    </div>
                                                    <span>{{ $int->interest }}</span>
                                                </label><br><br> @php ($i++) @endforeach
                                </div>
                            </div>

                            <button type="submit" name="submitRequestInvitation" value="Send Request" class="button"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Submit</button>
                        </div>
                    </form>
                    <button class="alternativeOptions" type="submit" name="forgotPassword" onclick="displayForgotPassword()">Forgot Password</button>
                    <button class="alternativeOptions alternativeTwoBtn" type="submit" name="login" onclick="displayLoginForm()">Login</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="1" role="dialog" id="forgotPasswordModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    <h3 class="modal-title">Forgot Password</h3>
                </div>
                <div class="modal-body">
                    <form class="cf" method="post" action="" id="forgotPasswordForm">
                        <div id="formBox">
                            <input type="email" id="forgotPasswordEmail" name="email" placeholder="Email" required>
                            <button type="submit" name="submitForgotPassword" value="Submit Email" class="button"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Submit Email</button>
                        </div>
                    </form>
                    <button class="alternativeOptions" type="submit" name="requestInvitation" onclick="displayRequestInvitationForm()">Request Invitation</button>
                    <button class="alternativeOptions alternativeTwoBtn" type="submit" name="login" onclick="displayLoginForm()">Login</button>
                </div>
            </div>
        </div>
    </div>



    <footer class="page-footer font-small unique-color-dark mt-4 textSectionsWithDarkBackground">
        <div class="container text-center text-md-left mt-5" id="footer">
            <ul class="list-unstyled list-inline text-center py-2">
                <li class="list-inline-item">
                    <h6 class="mb-1">Register for free</h6>
                </li>
                <li class="list-inline-item">
                    <button class="btn btn-rounded" onclick="displayRequestInvitationForm()" name="requestInvitation" value="requestInvitation" style="background-color: white;padding:0.4em 1em;border: 2px solid white;border-radius:2em; color: #136cb2;"><p>Send A Request</p></button>
                </li>
            </ul>
            <hr style="width:100%;">
            <div class="row mt-3">
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">{{ config('app.name') }}</h6>
                    <p>Bringing People, Projects, Resources and Capital Together</p>
                    <hr class="visible-sm visible-xs dark">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                    <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                    <p>
                        <a href="{{ route('guest-home') }}#howItWorksSection">
                            {{ $data['index_rowOne_header'] }}
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('guest-home') }}#aboutSection">
                            {{ $data['index_rowTwo_header'] }}
                        </a>
                    </p>
                    <hr class="visible-xs dark">
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <p><img src="{{ asset('public/img/Index/Email-Icon.png') }}" style="width: 1.3em; margin-right: 0.3em; margin-top: -0.2em;" />daniel@pipeline-listings.com</p>
                    <hr class="visible-xs dark">
                </div>
            </div>

        </div>
        <div class="footer-copyright text-center py-3" style="margin-top:1em;">© 2018 Copyright:
            <a href="http://pipeline-listings.ca/"> Pipeline-Listings.ca</a> | <a href="{{ route('guest-credits') }}">Credits</a> | <a href="{{ route('guest-cookiePolicy') }}">Cookies</a> | <a href="{{ route('guest-termsAndConditions') }}">Terms and Conditions</a>
        </div>
    </footer>
</body>

<script>
    $(document).ready(function() {
        $(".close").click(function() {
            resetModals();
        });
        $("#loginForm").submit(function(e) {
            $("#loadingModal").css("display", "block");
            $("#loadingModal").css("z-index", "3");
            $("#loadingMessage").html("Authenticating...");
            var url = "{{ route('guest-login') }}"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#loginForm").serialize(), // serializes the form's elements.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data) {
                        setTimeout(function() {
                            window.location.replace("{{ route('user-profile') }}");
                        }, 2000);
                        $("#loadingModal .modal-content").html("<svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'><circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/><path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/></svg><b id=\"loadingMessage\">Welcome back " + data + "!</b>");
                    } else {
                        $("#loginModal .modal-title").html("Incorrect email and/or password");
                        $("#loginModal .modal-title").css("color", "red");
                        $("#loadingModal").css("display", "none");
                    }
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        $("#forgotPasswordForm").submit(function(e) {
            $("#loadingModal").css("display", "block");
            $("#loadingModal").css("z-index", "3");
            $("#loadingMessage").html("Authenticating...");
            var url = "{{ route('guest-forgotPassword') }}"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#forgotPasswordForm").serialize(), // serializes the form's elements.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#loadingModal .modal-content").html("<svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'><circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/><path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/></svg><b id=\"loadingMessage\">Sent password reset link</b>");
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        $("#requestInvitationForm").submit(function(e) {
            $("#loadingModal").css("display", "block");
            $("#loadingModal").css("z-index", "3");
            $("#loadingMessage").html("Submitting...");
            var url = "{{ route('guest-requestInvitation') }}"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#requestInvitationForm").serialize(), // serializes the form's elements.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data) {
                        $("#loadingModal .modal-content").html("<svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'><circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/><path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/></svg><b id=\"loadingMessage\">Submitted request! You'll receive an email regarding the result</b>");
                    } else {
                        $("#requestInvitationModal .modal-title").html("This email is already being used");
                        $("#requestInvitationModal .modal-title").css("color", "red");
                        $("#loadingModal").css("display", "none");
                    }
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });

    function resetModals() {
        $(".modal").css("display", "none");
    }

    $(document).mouseup(function(e) {
        var container = $(".modal-content");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            resetModals();
        }
    });

    function displayLoginForm() {
        resetModals();
        $("#loginModal").css("display", "block");
    }

    function displayRequestInvitationForm() {
        resetModals();
        $("#requestInvitationModal").css("display", "block");
    }

    function displayForgotPassword() {
        resetModals();
        $("#forgotPasswordModal").css("display", "block");
    }

</script>

</html>
