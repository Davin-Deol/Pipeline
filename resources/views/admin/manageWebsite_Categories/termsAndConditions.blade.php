<div class="updateTermsAndConditions field">
    <form class="form-horizontal" id="updateTermsAndConditionsForm" enctype="multipart/form-data">
        <textarea class="form-control" rows="10" id="termsAndConditions" name="termsAndConditions">{{ stripslashes(htmlspecialchars_decode($data['termsAndConditions'], ENT_NOQUOTES)) }}</textarea>
        <button type="button" class="button" id="updateTermsAndConditions">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Terms and Conditions
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#updateTermsAndConditions").click(function() {
            displayLoadingModal("Updating terms and conditions...");
            var element = $('.nicEdit-main')[4];
            var encodedHTML = String(element.innerHTML);
            $('#termsAndConditions').val(encodedHTML);
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateTermsAndConditions') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#updateTermsAndConditionsForm')[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response)
                    {
                        displaySuccessModal(response);
                    }
                    else
                    {
                        displayErrorModal("Failed to update the terms and conditions. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to update the terms and conditions. Please try again later.");
                }
            });
        });
    });
</script>