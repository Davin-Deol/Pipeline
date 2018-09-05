@extends('layouts.user') @section('content')
    @if (count($listings))
        <div id="confirmationModal" class="modal row">
            <!-- Modal content -->
            <div class="modal-content col-md-6 col-sm-8 col-xs-10" style="background-color: #eee;" id="confirmationModalContent">
                    <span class="close">&times;</span>
                    <div class="row">
                        <div class="col-xs-12">
                            <span id="confirmationMessage"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="button" id="cancelButton">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Cancel
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <a id="confirmationButtonLink"><button type="button" class="button" id="confirmationButton"></button></a>
                        </div>
                    </div>
            </div>
        </div>
        @foreach ($listings as $listing)
            @if ($listing->status != $data['prevStatus'])
                @if (!$data['firstStatus'])
                    </span>
                @endif
                <span class="statusGroup">
                @php
                    $data['prevStatus'] = $listing->status;
                @endphp
                <div class="row field statusField">
                    <h1 class="status">{{ ucwords($listing->status) }} Listings</h1>
                </div>
            @endif
            <div class="row field" id="{{ $listing->listingID }}">
                @include('include.listingSummary')
                <div class="col-xs-4">
                    @if ($listing->status == "draft")
                        <a href="{{ route('user-editListing', ['listingID' => $listing->listingID]) }}" class="button">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    @else
                        <button type="button" class="editButton button confirmationTriggerButton" value="{{ $listing->listingID }}">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </button>
                    @endif
                </div>
                <div class="col-xs-4">
                    <a href="{{ route('user-reviewListing', ['listingID' => $listing->listingID]) }}" class="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Review
                    </a>
                </div>
                <div class="col-xs-4">
                    <button type="button" class="deleteButton button" value="{{ $listing->listingID }}">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                    </button>
                </div>
            </div>
        @endforeach
        </span>
        <div class="row field" style="display: none;" id="outOfListings">
            <div class="col-lg-12" style="text-align: center;">
                <h1>You have no listings at this time</h1>
                <a href="{{ route('user-createListing') }}"><h4>Click here to make one</h4></a>
            </div>
        </div>
        <script>
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
                        listingID: listingID,
                        dontSetSessionVariable: true
                    },
                    success: function(response) {
                        if (response)
                        {
                            removeListing(listingID);
                            displaySuccessModal("Deleted listing.");
                        }
                        else
                        {
                            displayErrorModal("Failed to send request. Please try again later.");
                        }
                    }
                });
            }
            
            $(document).ready(function() {
                $(".confirmationTriggerButton").click(function() {
                    $("#confirmationModal").css('display', 'inline');
                    $("#confirmationButton").text("Edit Listing");
                    $("#confirmationMessage").text("This action cannot be undone. Are you sure you want to edit this listing?");

                    var listingID = $(this).val();
                    $("#confirmationButtonLink").attr("href", "/editListing/" + listingID);
                });
                
                $(".deleteButton").click(function() {
                    var value = $(this).val();
                    
                    $("#confirmationModal").css("display", "block");
                    $("#confirmationButton").html("Delete Listing");
                    $("#confirmationButton").attr("onclick", "deleteListing(this);");
                    $("#confirmationButton").attr("value", value);
                    $("#confirmationMessage").text("Are you sure you want to delete this? Doing so will remove the listing permanently.");
                    $("#messageTextArea").css("display", "none");
                });
            });
            
            var numberOfListings = $('.field').length - $('.statusField').length - 1;
            
            function removeListing(listingID) {
                $("#" + listingID).remove();
                
                $('.statusGroup').each(function() {
                    if ($(this).children().length == 1)
                    {
                        $(this).remove();
                    }
                });
                
                numberOfListings--;
                if (numberOfListings == 0) {
                    $("#outOfListings").css("display", "block");
                }
            }
        </script>
    @else
        <div class="row field">
            <div class="col-lg-12" style="text-align: center;">
                <h1>You have no listings at this time</h1>
                <a href="{{ route('user-createListing') }}"><h4>Click here to make one</h4></a>
            </div>
        </div>
    @endif
@endsection