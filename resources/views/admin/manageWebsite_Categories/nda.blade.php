<div class="updateNDA field">
    <h4 style="color:red;">The NDA must be a PDF</h4>
    <object data="{{ asset('public/img/NDAs/nda.pdf') }}" type="application/pdf" style="width:100%;height:70vh;">
            <p>Your web browser doesn't have a PDF plugin.
          Instead you can <a href="Uploads/nda.pdf">click here to
          download the PDF file.</a></p>
    </object>

    <form class="form-horizontal" id="updateNDAForm" enctype="multipart/form-data">
        <input type="file" id="NDA" name="NDA" accept="application/pdf">
        <label for="NDA">
            <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload NDA
        </label>
        <i style="float:right;">Last Modified: {{ date("F d Y H:i:s", filemtime('public/img/NDAs/nda.pdf')) }}</i>
        <button type="button" class="button" id="updateNDA">
            <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update NDA
        </button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#updateNDA").click(function() {
            displayLoadingModal("Updating NDA file...");
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateNDA') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#updateNDAForm')[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response)
                    {
                        displaySuccessModal(response);
                    }
                    else
                    {
                        displayErrorModal("Failed to update the homepage. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to update the homepage. Please try again later.");
                }
            });
        });
    });
</script>