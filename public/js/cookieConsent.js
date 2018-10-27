$(document).ready(function() {
    $("#invisibleBarBehindCookiePopup").height($('#cookiePopup').outerHeight());
    $( window ).resize(function() {
        $("#invisibleBarBehindCookiePopup").height($('#cookiePopup').outerHeight());
    });
    $('#cookieConsent').on('click', function (e) {
        $("#cookiePopup").remove();
        var d = new Date();
        d.setTime(d.getTime() + (365*24*60*60*1000));
        document.cookie = "CookieWarningDismissed=true;expires=" + d.toUTCString() + ";path=/";
    });
});