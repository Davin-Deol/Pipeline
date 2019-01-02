<div class="updateHomepage field">
    <form class="form-horizontal" id="updateHomepageForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 vcenter">
                <b>Row One Image</b>
                <img id="RowOneImage" src="{{ $data['indexImages'][0] }}" width="100%">
                <input type="file" id="rowOneImage" name="rowOneImage" accept="image/*">
                <label for="rowOneImage">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Change Image
                </label>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6">
                <b>Row One Header</b>
                <input type="text" class="form-control" id="rowOneHeader" name="rowOneHeader" value="{{ $data['rowOneHeader'] }}"/>

                <b>Row One Body</b>
                <textarea class="form-control" rows="10" id="rowOneBody" name="rowOneBody">{{ stripslashes(htmlspecialchars_decode($data['rowOneBody'], ENT_NOQUOTES)) }}</textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6">
                <b>Row Two Header</b>
                <input type="text" class="form-control" id="rowTwoHeader" name="rowTwoHeader" value="{{ $data['rowTwoHeader'] }}" />

                <b>Row Two Body</b>
                <textarea class="form-control" rows="10" id="rowTwoBody" name="rowTwoBody">{{ stripslashes(htmlspecialchars_decode($data['rowTwoBody'], ENT_NOQUOTES)) }}</textarea>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 vcenter">
                <b>Row Two Image</b>
                <img id="RowTwoImage" src="{{ $data['indexImages'][1] }}" width="100%">
                <input type="file" id="rowTwoImage" name="rowTwoImage" accept="image/*">
                <label for="rowTwoImage">
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Change Image
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="button" id="updateHomepage">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Homepage
                </button>
            </div>
        </div>
    </form>
</div>

<script>
        $("#updateHomepage").click(function() {
            displayLoadingModal("Updating homepage...");
            
            var element = $('.nicEdit-main')[0];
            var encodedHTML = String(element.innerHTML);
            $('#rowOneBody').val(encodedHTML);
            
            var element = $('.nicEdit-main')[1];
            var encodedHTML = String(element.innerHTML);
            $('#rowTwoBody').val(encodedHTML);
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateHomepage') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#updateHomepageForm')[0]),
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
        $("#rowOneImage").change(function() {
            if ($("#rowOneImage")[0].files.length) {
                $('#RowOneImage').attr('src', URL.createObjectURL(event.target.files[0]));
            } else {
                $('#RowOneImage').attr('src', "{{ asset('public/img/Index/Row-One_Image.png') }}");
            }
        });
        $("#rowTwoImage").change(function() {
            if ($("#rowTwoImage")[0].files.length) {
                $('#RowTwoImage').attr('src', URL.createObjectURL(event.target.files[0]));
            } else {
                $('#RowTwoImage').attr('src', "{{ asset('public/img/Index/Row-Two_Image.png') }}");
            }
        });
</script>