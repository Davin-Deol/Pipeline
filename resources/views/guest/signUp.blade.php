@extends('layouts.guest')
@section('content')
    <form class="cf" method="post" action="" style="width: 40%; margin: 8% auto; background-color: white; padding: 3em; border-radius: 1em;" id="signUpForm">
        <h3 class="modal-title" style="font-weight: 300; font-size: 3em;">Enter your password</h3>
        {{ csrf_field() }}
        <input type="hidden" value="{{ $data['signUpLink'] }}" name="signUpLink" required>
        <input type="password" name="password1" id="password1" placeholder="Password" required><br>
        <input type="password" name="password2" id="password2" placeholder="Re-Enter Password" required>
        <input type="submit" id="submitButton" class="button">
    </form>
    <script>
        $(document).ready(function() {
            $("#signUpForm").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                $("#loadingModal").css("display", "block");
                $("#loadingModal").css("z-index", "3");
                $("#loadingMessage").html("Authenticating...");
                var url = "{{ route('guest-signUpSubmission') }}"; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#signUpForm").serialize(), // serializes the form's elements.
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data) {
                            setTimeout(function() {
                                window.location.replace("{{ route('user-profile') }}");
                            }, 2000);
                            $("#loadingModal .modal-content").html("<svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'><circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/><path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/></svg><h3 id=\"loadingMessage\">Welcome to {{ config('app.name') }}, " + data + "</h3>");
                        }
                    }
                });
            });
        });
    </script>
@endsection
