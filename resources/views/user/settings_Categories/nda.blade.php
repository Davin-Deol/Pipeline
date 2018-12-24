@if ($user->NDAStatus != "approved")
<div class="uploadNDA row field">
    <h4>How To Submit NDA:</h4>
    <div class="col-md-6">
        <ol>
            <li>Print the NDA found <a href="{{ asset('public/img/NDAs/nda.pdf') }}" target="_blank">here</a></li>
            <li>Sign it</li>
            <li>Take a picture or scan the signed document</li>
            <li>Upload the document here</li>
            <li>You will be notified whether the admin approved/denied it</li>
        </ol>
    </div>
    <div class="col-md-6">
        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="NDAForm">
            {{ csrf_field() }}
            <b>Status: {{ ucwords($user->NDAStatus) }}</b>
            <input type="file" id="NDA" name="NDA" accept="image/*">
            <label for="NDA">
                <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload NDA
            </label>
            <i class="validationError" id="NDAValidationError"></i>
            @if ($user->NDAStatus == "submitted")
            <i id="ndaLastUpdated" style="float:right;">Last Updated: {{ $data['NDALastModified'] }}</i>
            @endif
            <button type="button" class="button" style="margin-top:2%;" id="submitNDAButton">
                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Submit NDA
            </button>
        </form>
    </div>
</div>
@endif
<script src="{{ asset('public/js/forms.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#submitNDAButton").click(function() {
            var url = "{{ route('user-submitNDA') }}";
            var formID = "#NDAForm";
            var loadingMessage = "Submitting NDA...";
            var successMessage = "Submitted NDA";
            var failMessage = "Failed to submit NDA";
            var context = "Submit NDA";
            submitForm(url, formID, loadingMessage, successMessage, failMessage, context);
        });
    });

</script>
