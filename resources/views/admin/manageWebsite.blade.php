@extends('layouts.user') @section('content')
<script src="{{ asset('public/js/nicEdit/nicEdit.js') }}"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
        nicEditors.allTextAreas()
    });
</script>
<div class="updateTheme field">
    <h1>Update Theme</h1>
    <form class="form-horizontal" id="updateThemeForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <b>Primary Colour</b>
                <input type="color" class="form-control" id="primaryColour" name="primaryColour" value="{{ $data['primaryColour'] }}"/>
            </div>
            <div class="col-sm-4">
                <b>Text Colour On Primary</b>
                <input type="color" class="form-control" id="textColourOnPrimary" name="textColourOnPrimary" value="{{ $data['textColourOnPrimary'] }}"/>
            </div>
            <div class="col-sm-4">
                <b>Background Colour Transparency</b>
                <input type="range" class="form-control" id="backgroundColourTransparency" name="backgroundColourTransparency" min="0" max="1" value="{{ $data['backgroundColourTransparency'] }}" step="0.1" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="button" id="updateTheme">Update Theme</button>
            </div>
        </div>
    </form>
</div>

<div class="updateProfile field">
    <h1>Update Homepage</h1>
    <form class="form-horizontal" id="updateHomepageForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 vcenter">
                <b>Row One Image</b>
                <img id="RowOneImage" src="{{ $data['indexImages'][0] }}" width="100%">
                <input type="file" id="rowOneImage" name="rowOneImage" accept="image/*">
                <label for="rowOneImage">Change Image</label>
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
                <label for="rowTwoImage">Change Image</label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="button" id="updateHomepage">Update Homepage</button>
            </div>
        </div>
    </form>
</div>

<div class="updateCredits field">
    <h1>Update Credits</h1>
    <form class="form-horizontal" id="updateCreditsForm" enctype="multipart/form-data">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <b>Background Colour</b>
            <input type="color" class="form-control" id="backgroundColour" name="backgroundColour" value="{{ $data['creditsBackgroundColour'] }}"/>
        </div>
        <textarea class="form-control" rows="10" id="creditsBody" name="creditsBody">{{ stripslashes(htmlspecialchars_decode($data['credits'], ENT_NOQUOTES)) }}</textarea>
        <button type="button" class="button" id="updateCredits">Update Credits</button>
    </form>
</div>

<div class="updateCookies field">
    <h1>Update Cookie Policy</h1>
    <form class="form-horizontal" id="updateCookiesForm" enctype="multipart/form-data">
        <textarea class="form-control" rows="10" id="cookie" name="cookie">{{ stripslashes(htmlspecialchars_decode($data['cookies'], ENT_NOQUOTES)) }}</textarea>
        <button type="button" class="button" id="updateCookies">Update Cookie Policy</button>
    </form>
</div>

<div class="updateProfile field">
    <h1>Update NDA</h1>
    <h4 style="color:red;">The NDA must be a PDF</h4>
    <object data="{{ asset('public/img/NDAs/nda.pdf') }}" type="application/pdf" style="width:100%;height:70vh;">
            <p>Your web browser doesn't have a PDF plugin.
          Instead you can <a href="Uploads/nda.pdf">click here to
          download the PDF file.</a></p>
    </object>

    <form class="form-horizontal" id="updateNDAForm" enctype="multipart/form-data">
        <input type="file" id="NDA" name="NDA" accept="application/pdf">
        <label for="NDA">Upload NDA</label>
        <i style="float:right;">Last Modified: {{ date("F d Y H:i:s", filemtime('public/img/NDAs/nda.pdf')) }}</i>
        <button type="button" class="button" id="updateNDA">Update NDA</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#updateTheme").click(function() {
            displayLoadingModal("Updating theme...");
            $.ajax({
                type: "POST",
                url: "{{ route('admin-updateTheme') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#updateThemeForm').serialize(),
                success: function(response) {
                    if (response)
                    {
                        displaySuccessModal(response);
                        var links = document.getElementsByTagName("link");
                        for (var i = 0; i < links.length;i++) 
                        {
                            var link = links[i];
                            if (link.rel === "stylesheet")
                            {
                                link.href += "?";
                            }
                        }
                    }
                    else
                    {
                        displayErrorModal("Failed to update theme. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to update theme. Please try again later.");
                }
            });
        });
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
        $("#updateCredits").click(function() {
            displayLoadingModal("Updating credits...");
            var element = $('.nicEdit-main')[2];
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
        var element = $(".nicEdit-main")[2];
        element.style.backgroundColor = "{{  $data['creditsBackgroundColour'] }}";
        $("#backgroundColour").change(function() {
            var element = $(".nicEdit-main")[2];
            element.style.backgroundColor = $(this).val();
        });
    });
</script>
@endsection