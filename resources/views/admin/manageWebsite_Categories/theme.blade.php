<div class="updateTheme field">
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
                <button type="button" class="button" id="updateTheme">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Update Theme
                </button>
            </div>
        </div>
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
    });
</script>