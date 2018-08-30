@extends('layouts.user') @section('content')
<div class="modalImage">
    <!-- Modal content -->
    <div class="modal-image">
        <img src="" id="displayImage" width="50px" />
    </div>
</div>
<div id="confirmationModal" class="modal row">
    <!-- Modal content -->
    <div class="modal-content confirmationModal col-md-6 col-sm-8 col-xs-10">
        <div class="row">
            <div class="col-xs-12">
                <span class="close">&times;</span>
                <span id="confirmationMessage"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <textarea name="message" placeholder="Message to creator..." rows="5" id="messageTextArea" class="col-xs-12"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <button class="button" id="cancelButton">Cancel</button>
            </div>
            <div class="col-xs-6">
                <button class="button" id="confirmationButton"></button>
            </div>
        </div>
    </div>
</div>
<div class="row content">
    @foreach ($ndas as $nda)
        <div class="col-md-6" id="{{ $nda->userId }}">
            <div class="row field">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1>{{ $nda->fullName }}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="ndaImage squareImage" style="background-image: url('{{ asset('public/img/NDAs/' . $nda->NDA) }}'); width: 100%; background-size: cover; background-position: center; border: 1px solid #DDD; margin: 2% 0;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button class="button denyButton" value="{{ $nda->userId }}">Deny</button>
                        </div>
                        <div class="col-xs-6">
                            <button class="button approveButton" value="{{ $nda->userId }}">Approve</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row field" style="display: none;" id="outOfNDAs">
    <div class="col-lg-12">
        <h1>There are no NDAs pending review at this time</h1>
    </div>
</div>
<script>
    
    function approveNDA(element)
    {
        displayLoadingModal("Approving NDA...");
        var userID = $(event.target).val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin-approveNDA') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                userID: userID
            },
            success: function(response) {
                if (response)
                {
                    removeNDA(userID);
                    displaySuccessModal(response);
                }
                else
                {
                    displayErrorModal("Failed to approve NDA. Please try again later.");
                }
            }, error: function(response) {
                 displayErrorModal("Failed to approve NDA. Please try again later.");
            }
        });
    }
    
    function denyNDA(element)
    {
        displayLoadingModal("Denying NDA...");
        var userID = $(event.target).val();
        var message = $("#messageTextArea").val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin-denyNDA') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                userID: userID,
                message: message
            },
            success: function(response) {
                if (response)
                {
                    removeNDA(userID);
                    displaySuccessModal(response);
                }
                else
                {
                    displayErrorModal("Failed to deny NDA. Please try again later.");
                }
            }, error: function(response) {
                 displayErrorModal("Failed to deny NDA. Please try again later.");
            }
        });
    }
    
    var numberOfNDAs = $('.field').length - 1;
            
    function removeNDA(userId)
    {
        $("#" + userId).remove();

        numberOfNDAs--;
        if (numberOfNDAs == 0) {
            $("#outOfNDAs").css("display", "block");
        }
    }
    
    $(document).ready(function() {
        $(".modalImage").click(function(e) {
            if (e.target.id != "displayImage") {
                $(".modalImage").css("display", "none");
            }
        });
        
        $(".ndaImage").click(function(e) {
            var bg = $(this).css("background-image");
            bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
            $("#displayImage").attr("src", bg);
            $(".modalImage").css("display", "flex");
        });
        
        $(".approveButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("Approve");
            $("#confirmationButton").attr("onclick", "approveNDA(this);");
            $("#confirmationButton").attr("value", $(this).val());
            $("#confirmationMessage").text("Are you sure you want to approve this Non-Disclosure Agreement?");
            $("#messageTextArea").css("display", "none");
        });
        $(".denyButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("Deny");
            $("#confirmationButton").attr("onclick", "denyNDA(this);");
            $("#confirmationButton").attr("value", $(this).val());
            $("#confirmationMessage").text("Are you sure you want to deny this Non-Disclosure Agreement? Note: you can specify the reason using the textbox below.");
            $("#messageTextArea").css("display", "block");
        });
        
        if (numberOfNDAs == 0) {
            $("#outOfNDAs").css("display", "block");
        }
    });
</script>
@endsection