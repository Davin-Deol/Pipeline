@extends('layouts.user') @section('content')
<div class="row field">
    <div class="col-lg-12">
        <!-- The Modal -->
        <div id="myImage" class="modalImage">
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
                        <button class="button" id="cancelButton">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Cancel
                        </button>
                    </div>
                    <div class="col-xs-6">
                        <button class="button" value="{{ $listing->listingID }}" id="confirmationButton"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <h1 style="text-align: left;">{{ $listing->name }}</h1>
            </div>
            <div class="col-sm-4">
                <p style="color:green;font-size:1.5em;font-weight:300;text-align: right;">{!! $listing->typeOfCurrency !!}{{ number_format($listing->priceBracketMin) }} - {{ number_format($listing->priceBracketMax) }}</p>
            </div>
        </div>
        <div class="row">
            @if (count($listingImages))
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="slider-for">
                        <div class="row">
                            <div class="reviewImageMain reviewImage" id="0" style="background-image:url('{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listingImages[0]->image) }}');background-size:cover;background-position:center;border: 1px solid #DDD;"></div>
                        </div>
                    </div>
                    <div class="slider-nav">
                        @for ($i = 1; $i < count($listingImages); $i++)
                            <div class="row">
                                <div class="reviewImage" id="{{ $i }}" style="background-image:url('{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listingImages[$i]->image) }}');background-size:cover;background-position:center;border: 1px solid #DDD;"></div>
                            </div>
                        @endfor
                    </div>
                </div>
            @else
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="reviewImageMain reviewImage" id="mainImage" style="background-image:url('{{ asset('public/img/placeholder.png') }}');background-size:cover;background-position:center;"></div>
                    </div>
                </div>
            @endif
            <div class="col-md-8 col-sm-6">
                <hr>
                <b>Category</b>
                <p>{{ $listing->category }}</p>
                <hr>
                <b>Sub Category</b>
                <p>{{ $listing->subCategory }}</p>
                <hr>
                <b>Jurisdiction</b>
                <p>{{ $listing->jurisdiction }}</p>
                <hr>
                <b>Investment Type</b>
                <p>{{ $listing->investmentType }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr>
                <b>Introduction</b>
                <p>{!! nl2br($listing->introduction) !!}</p>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <b>Additional Details</b>
                <p>{!! nl2br($listing->additionalDetails) !!}</p>
                <hr>
            </div>
        </div>
        <div class="row">
            <form action="" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="listingID" id="listingID" value="{{ $listing->listingID }}" />
                @if ($listing->status == "draft" and $listing->userId == $user->userId and $user->type != "admin")
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="{{ route('user-editListing', ['listingID' => $listing->listingID]) }}" class="button">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </a>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="button" formaction="{{ route('user-deleteListing') }}">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="button" formaction="{{ route('user-submitListingForApproval') }}">Submit</button>
                        </div>
                    </div>
                @elseif ($listing->status == "draft" and $listing->userId == $user->userId and $user->type == "admin")
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="{{ route('user-editListing', ['listingID' => $listing->listingID]) }}" class="button">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </a>
                        </div>
                        <div class="col-xs-4">
                            <button type="button" class="button" id="postButton">
                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Post
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button id="removeButton" type="button" class="button">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                            </button>
                        </div>
                    </div>
                @elseif ($listing->status == "submitted" and $listing->userId != $user->userId and $user->type == "admin")
                    <div class="row">
                        <div class="col-xs-4">
                            <button type="button" class="button" id="denyButton">
                                <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Deny
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <a href="{{ route('user-editListing', ['listingID' => $listing->listingID]) }}" class="btn button">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </a>
                        </div>
                        <div class="col-xs-4">
                            <button type="button" class="button" id="postButton">
                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Approve
                            </button>
                        </div>
                    </div>
                @elseif ($listing->status == "posted" and $listing->userId != $user->userId)
                    <div class="row">
                        <div class="col-xs-6">
                            @if ($data['userHasSentAConnectionRequest'])
                                <button type="button" class="button" style="font-size:0.9em;" id="cancelOrSendRequestConnection">
                                    <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> Cancel Request Connection
                            </button>
                            @else
                                <button type="button" class="button" style="font-size:0.9em;" id="cancelOrSendRequestConnection">
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Request Connection
                            </button>
                            @endif
                        </div>
                        <div class="col-xs-6">
                            @if ($data['userHasSavedThisListing'])
                                <button id="saveUnsaveButton" type="button" class="button" value="{{ $listing->listingID }}">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Unsave
                            </button>
                            @else
                                <button id="saveUnsaveButton" type="button" class="button" value="{{ $listing->listingID }}">
                                    <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Save
                            </button>
                            @endif
                        </div>
                    </div>
                @elseif ((($listing->userId == $user->userId) || ($user->type == "admin" and $listing->status != "submitted")) and ($listing->status != "draft"))
                    <div class="row">
                        <div class="col-xs-6">
                            <button id="editButton" type="button" class="button">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button id="removeButton" type="button" class="button">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                            </button>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12">
                        <button type="button" class="button" name="Back" onclick="window.history.back()">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function sendRequest(element)
    {
        displayLoadingModal("Sending request...");
        var listingID = $(event.target).val();
        $.ajax({
            type: "POST",
            url: "{{ route('user-requestConnection') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                listingID: listingID
            },
            success: function(response) {
                if (response)
                {
                    displaySuccessModal(response);
                    $("#cancelOrSendRequestConnection").html("<span class='glyphicon glyphicon-minus-sign' aria-hidden='true'></span> Cancel Connection Request");
                }
                else
                {
                    displayErrorModal("Failed to send request. Please try again later.");
                }
            }
        });
    }
    
    function cancelConnectionRequest(element)
    {
        displayLoadingModal("Cancelling connection request...");
        var listingID = $(event.target).val();
        $.ajax({
            type: "POST",
            url: "{{ route('user-cancelConnectionRequest') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                listingID: listingID
            },
            success: function(response) {
                if (response)
                {
                    displaySuccessModal(response);
                    $("#cancelOrSendRequestConnection").html("<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Request Connection");
                }
                else
                {
                    displayErrorModal("Failed to send request. Please try again later.");
                }
            }
        });
    }
    
    function postListing(element)
    {
        displayLoadingModal("Posting listing...");
        var listingID = $(event.target).val();
        $.ajax({
            type: "POST",
            url: "{{ route('user-postListing') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                listingID: listingID
            },
            success: function(response) {
                if (response)
                {
                    $(location).attr('href', response);
                }
                else
                {
                    displayErrorModal("Failed to send request. Please try again later.");
                }
            }
        });
    }
    
    function denyListing(element)
    {
        displayLoadingModal("Denying listing...");
        var listingID = $(event.target).val();
        var message = $("#messageTextArea").val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin-denyListing') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                listingID: listingID,
                message: message
            },
            success: function(response) {
                if (response)
                {
                    $(location).attr('href', response);
                }
                else
                {
                    displayErrorModal("Failed to deny listing. Please try again later.");
                }
            }
        });
    }
    
    function deleteListing(element)
    {
        displayLoadingModal("Deleting listing...");
        var listingID = $(event.target).val();
        $.ajax({
            type: "POST",
            url: "{{ route('user-deleteListing') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                listingID: listingID
            },
            success: function(response) {
                if (response)
                {
                    $(location).attr('href', response);
                }
                else
                {
                    displayErrorModal("Failed to send request. Please try again later.");
                }
            }
        });
    }
    
    function editListing(element)
    {
        $(location).attr('href', "{{ route('user-editListing', ['listingID' => $listing->listingID]) }}");
    }
    $(document).ready(function() {
        var images = [@foreach ($listingImages as $listingImage)
                        "{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listingImage->image) }}",
                    @endforeach
                       ];
        // Get the image
        var image = document.getElementById('displayImage');
        var imageIndex = 0;
        $("#displayImage").click(function(e) {
            if (e.pageX >= ($(this).offset().left + $(this).width() / 2)) {
                if (++imageIndex >= images.length)
                    imageIndex = 0;
            } else {
                if (--imageIndex < 0)
                    imageIndex = images.length - 1;
            }
            image.src = images[imageIndex];
        });
        // Get the modal
        var modal = document.getElementById('myImage');
        $(".reviewImage").click(function(e) {
            imageIndex = $(this).attr('id');
            image.src = images[imageIndex];
            modal.style.display = "flex";
        });

        $("#myImage").click(function(e) {
            if (e.target.id != "displayImage") {
                $("#myImage").css("display", "none");
            }
        });
    
        $("body").keydown(function(e) {
            if (e.keyCode == 37) { // left
                if (--imageIndex < 0)
                    imageIndex = images.length - 1;
            } else if (e.keyCode == 39) { // right
                if (++imageIndex >= images.length)
                    imageIndex = 0;
            }
            image.src = images[imageIndex];
        });
        $("#denyButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("<span class='glyphicon glyphicon-remove-sign' aria-hidden='true'></span> Deny");
            $("#confirmationButton").attr("onclick", "denyListing(this);");
            $("#confirmationMessage").text("Are you sure you want to deny this?");
        });
        $("#postButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("<span class='glyphicon glyphicon-ok-sign' aria-hidden='true'></span> Post");
            $("#confirmationButton").attr("onclick", "postListing(this);");
            $("#confirmationMessage").text("Are you sure you want to post this?");
            $("#messageTextArea").css("display", "none");
        });
        $("#editButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("<span class='glyphicon glyphicon-edit' aria-hidden='true'></span> Edit");
            $("#confirmationButton").attr("onclick", "editListing(this);");
            $("#confirmationMessage").text("Are you sure you want to edit this? Doing so will remove the listing from being public and it will need to be resubmitted.");
            $("#messageTextArea").css("display", "none");
        });
    
        var connectionSent = true;
        
        $("#cancelOrSendRequestConnection").click(function() {
            $("#confirmationModal").css("display", "block");
            
            if ($("#cancelOrSendRequestConnection").text() == "Request Connection")
            {
                $("#confirmationButton").html("<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Send Request");
                $("#confirmationButton").attr("onclick", "sendRequest(this);");
                $("#confirmationMessage").text("Are you sure you want to establish a connection with the creator of this listing?");
            }
            else
            {
                $("#confirmationButton").html("<span class='glyphicon glyphicon-minus-sign' aria-hidden='true'></span> Cancel Connection Request");
                $("#confirmationButton").attr("onclick", "cancelConnectionRequest(this);");
                $("#confirmationMessage").text("Are you sure you want to cancel your connection request?");
            }
            
            $("#messageTextArea").css("display", "none");
        });
        $("#removeButton").click(function() {
            $("#confirmationModal").css("display", "block");
            $("#confirmationButton").html("<span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Remove");
            $("#confirmationButton").attr("onclick", "deleteListing(this);");
            $("#confirmationMessage").text("Are you sure you want to delete this? Doing so will remove the listing permanently.");
            $("#messageTextArea").css("display", "none");
        });
        $("#cancelButton").click(function() {
            closeAllModals();
        });
    
        @if ($data['userHasSavedThisListing'])
            var isSaved = true;
        @else
            var isSaved = false;
        @endif
        
        $("#saveUnsaveButton").click(function() {
            var saveOrUnsaveURL;
            var savedListingId = $(this).attr("value");
            if (isSaved) {
                displayLoadingModal("Removing listing...");
                $(this).html("<span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span> Save");
                saveOrUnsaveURL = "{{ route('user-removeSavedListing')}}";
            } else {
                displayLoadingModal("Saving listing...");
                saveOrUnsaveURL = "{{ route('user-saveUsersListing') }}";
                $(this).html("<span class='glyphicon glyphicon-star' aria-hidden='true'></span> Unsave");
            }
                isSaved = !isSaved;
            $.ajax({
                type: "POST",
                url: saveOrUnsaveURL,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    savedListingId: savedListingId
                },
                success: function(response) {
                    if (response)
                    {
                        closeAllModals();
                    }
                    else
                    {
                        displayErrorModal("Failed to save/unsave listing. Please try again later.");
                    }
                }
            });
        });
    });

</script>
@endsection