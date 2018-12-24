function submitForm(url, formID, loadingMessage, successMessage, failMessage, context) {
    displayLoadingModal(loadingMessage);
    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: new FormData($(formID)[0]),
        processData: false,
        contentType: false,
        success: function (response) {

            $(".validationError").each(function (index) {
                $(this).html("");
                $(this).css("display", "none");
            });

            if (response["result"] == "success") {
                switch (context) {
                    case "Submit NDA":
                        $("#ndaLastUpdated").html("Last Updated: " + response["data"]);
                        break;
                    case "Update Password":
                        break;
                    case "Update Account":
                        break;
                    default:
                        break;
                }
                displaySuccessModal(successMessage);

                $(formID).trigger("reset");
            } else {
                displayErrorModal(failMessage);
                for (var data in response["data"]) {
                    $("#" + data + "ValidationError").html(response["data"][data][0]);
                    $("#" + data + "ValidationError").css("display", "block");
                }
            }
        },
        error: function () {
            displayErrorModal(failMessage);
        }
    });
}
