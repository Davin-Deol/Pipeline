<div class="updateCookies field">
    <form class="form-horizontal" id="updateCookiesForm" enctype="multipart/form-data">
        <textarea class="form-control" rows="10" id="cookie" name="cookie">{{ stripslashes(htmlspecialchars_decode($data['cookies'], ENT_NOQUOTES)) }}</textarea>
        <button type="button" class="button" id="updateCookies">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Cookie Policy
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#updateCookies").click(function() {
            displayLoadingModal("Updating cookies policy...");
            var element = $('.nicEdit-main')[3];
            var encodedHTML = String(element.innerHTML);
            $('#cookie').val(encodedHTML);
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateCookie') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#updateCookiesForm')[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response)
                    {
                        displaySuccessModal(response);
                    }
                    else
                    {
                        displayErrorModal("Failed to update the cookies policy. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to update the cookies policy. Please try again later.");
                }
            });
        });
    });
</script>