<div class="updateCredits field">
    <form class="form-horizontal" id="updateCreditsForm" enctype="multipart/form-data">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <b>Background Colour</b>
            <input type="color" class="form-control" id="backgroundColour" name="backgroundColour" value="{{ $data['creditsBackgroundColour'] }}"/>
        </div>
        <textarea class="form-control" rows="10" id="creditsBody" name="creditsBody">{{ stripslashes(htmlspecialchars_decode($data['credits'], ENT_NOQUOTES)) }}</textarea>
        <button type="button" class="button" id="updateCredits">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Credits
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#updateCredits").click(function() {
            displayLoadingModal("Updating credits...");
            var element = $('.nicEdit-main')[0];
            var encodedHTML = String(element.innerHTML);
            $('#creditsBody').val(encodedHTML);
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateCredits') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#updateCreditsForm')[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response)
                    {
                        displaySuccessModal(response);
                    }
                    else
                    {
                        displayErrorModal("Failed to update the credits. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to update the credits. Please try again later.");
                }
            });
        });
        var element = $(".nicEdit-main")[0];
        element.style.backgroundColor = "{{  $data['creditsBackgroundColour'] }}";
        $("#backgroundColour").change(function() {
            var element = $(".nicEdit-main")[0];
            element.style.backgroundColor = $(this).val();
        });
    });
</script>