@if (!$dataForAllViews['UserHasDismissedCookieWarning'])
    <div class="row" id="cookiePopup">
        <div class="col-md-10 col-sm-9">
            <p>This website uses cookies in order to ensure that we bring our users the optimum experience. For more information, please read our <a href="{{ route('guest-cookiePolicy') }}" target="_blank">Cookie Policy</a> as well as our <a href="{{ route('guest-termsAndConditions') }}" target="_blank">Terms and Conditions</a>. Note that by continuing to use this website, you consent to all our policies.</p>
        </div>
        <div class="col-md-2 col-sm-3">
            <button type="button" name="cookieConsent" id="cookieConsent" value="Yes" class="button">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> I Understand
            </button>
        </div>
    </div>
    <div class="row" id="invisibleBarBehindCookiePopup">
    </div>
@endif