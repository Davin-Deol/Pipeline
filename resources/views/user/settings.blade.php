@extends('layouts.user') @section('content')

<div class="field" id="updateCategories">
    <h1>
    <select name="sectionsToUpdate" id="sectionsToUpdate">
        <optgroup label="Account">
            <option value="changePassword" selected>Change Password</option>
            <option value="profile">Profile</option>
            
            @if ($user->NDAStatus != "approved")
            <option value="nda">NDA</option>
            @endif
            
        </optgroup>
    </select>
    </h1>
</div>


<div class="row">
    <div class="col-lg-12">
        <span id="fields">
        </span>
    </div>
</div>
<script>
    $(document).ready(function() {
        displayUpdateFields($("#updateCategories option:selected").val());
        $("#updateCategories").change(function() {
            displayUpdateFields($("#updateCategories option:selected").val());
        });

        function displayUpdateFields(category) {
            $.ajax({
                type: "POST",
                url: "{{ route('user-settings') }}",
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
                    } else {
                        displayErrorModal("Failed to send request. Please try again later.");
                    }
                }
            });
        }
    });
</script>
@endsection
