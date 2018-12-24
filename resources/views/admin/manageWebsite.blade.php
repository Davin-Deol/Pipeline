@extends('layouts.user') @section('content')
<script src="{{ asset('public/js/nicEdit/nicEdit.js') }}"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
        nicEditors.allTextAreas()
    });

</script>
<style>
    #sectionsToUpdate select {
        text-align: center;
    }
</style>

<div class="field" id="updateCategories">
    <h1>
    <select name="sectionsToUpdate" id="sectionsToUpdate">
        <optgroup label="Guest Pages">
            <option value="cookies">Cookie Policy</option>
            <option value="credits">Credits</option>
            <option value="homepage" selected>Homepage</option>
            <option value="termsAndConditions">Terms and Conditions</option>
        </optgroup>
        <optgroup label="General">
            <option value="theme">Theme</option>
        </optgroup>
        <optgroup label="Legal">
            <option value="nda">NDA</option>
        </optgroup>
    </select>
    </h1>
</div>

<span id="fields">
</span>

<script>
    $(document).ready(function() {

        displayUpdateFields($("#updateCategories option:selected").val());
        $("#updateCategories").change(function() {
            displayUpdateFields($("#updateCategories option:selected").val());
        });

        function displayUpdateFields(category) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin-manageWebsite') }}",
                data: {
                    category: category
                },
                dataType: "text",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response) {
                        $("#fields").html(response);
                        nicEditors.allTextAreas();
                    } else {
                        displayErrorModal("Failed to send request. Please try again later.");
                    }
                }
            });
        }
    });

</script>
@endsection
