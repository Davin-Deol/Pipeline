@extends('layouts.user') @section('content')
    @if (count($connections))
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
                        <div class="col-xs-6">
                            <button class="button" id="cancelButton">Cancel</button>
                        </div>
                        <div class="col-xs-6">
                            <button onclick="" id="confirmationButton" class="button"></button>
                        </div>
                        <input type="hidden" id="confirmationModalCreatorId" class="creatorId" value="" />
                        <input type="hidden" id="confirmationModalInterestedParty" class="interestedParty" value="" />
                        <input type="hidden" id="confirmationModalListingId" class="listingId" value="" />
                    </div>
            </div>
        </div>

        @foreach ($connections as $connection)
            @if ($connection->status != $data['prevStatus'])
                @if (!$data['firstStatus'])
                    </span>
                @endif
                <span class="statusGroup">
                <div class="row field statusField">
                    <h1 class="status">{{ ucwords($connection->status) }} Listings</h1>
                </div>
                @php
                    $data['prevStatus'] = $connection->status;
                    $data['firstStatus'] = false;
                @endphp
            @endif
            <div class="row field" id="{{ $connection->listingId }}">
                @php
                    $listing = $connection->listing;
                @endphp
                @include('include.listingSummary')
                <div class="row">
                    @if (($connection->creatorId == $user->userId) and ($connection->status == "pending creator approval"))
                        <div class="col-xs-6">
                            <button class="denyButton button">Deny</button>
                        </div>
                        <div class="col-xs-6">
                            <button class="approveButton button">Approve</button>
                        </div>
                    @elseif (($connection->creatorId != $user->userId) and ($connection->status == "pending creator approval"))
                        <div class="col-xs-6">
                            <a class="button" href="{{ route('user-reviewListing', ['listingID' => $connection->listingId]) }}">Review</a>
                        </div>
                        <div class="col-xs-6">
                            <button class="button" class="cancelConnectionRequest">Cancel Request</button>
                        </div>
                    @else
                        <div class="col-xs-6">
                            <a href="{{ route('user-reviewListing', ['listingID' => $connection->listingId]) }}" class="button">Review</a>
                        </div>
                        <div class="col-xs-6">
                            <button class="deleteButton button" value="{{ $connection->listingId }}">Remove Connection</button>
                        </div>
                    @endif
                    <input type="hidden" class="creatorId" value="{{ $connection->creatorId }}" />
                    <input type="hidden" class="interestedParty" value="{{ $connection->interestedPartyId }}" />
                    <input type="hidden" class="listingId" value="{{ $connection->listingId }}" />
                </div>
            </div>
        @endforeach
        </span>
        <div id="outOfConnections" class="row field" style="display:none;">
            <div class="col-lg-12">
                <h1>You have no connections at this time</h1>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".cancelConnectionRequest").click(function() {
                    $("#confirmationModal").css("display", "block");
                    $("#confirmationButton").html("Cancel Connection Request");
                    $("#confirmationButton").attr("onclick", "cancelConnectionRequest(this);");
                    $("#confirmationButton").attr("value", $(this).parent().parent().parent().attr("id"));
                    $("#confirmationMessage").text("Are you sure you want to cancel your connection request?");
                });
                
                $(".deleteButton").click(function() {
                    $("#confirmationModal").css("display", "block");
                    $("#confirmationButton").html("Delete");
                    $("#confirmationMessage").text("This action cannot be undone. Are you sure you want to cancel your connection?");
                    $("#confirmationButton").attr("onclick", "deleteConnection();");
                    
                    var creatorId = $(this).parent().parent().find(".creatorId").val();
                    var interestedParty = $(this).parent().parent().find(".interestedParty").val();
                    var listingId = $(this).parent().parent().find(".listingId").val();
                    
                    $("#confirmationModalCreatorId").val(creatorId);
                    $("#confirmationModalInterestedParty").val(interestedParty);
                    $("#confirmationModalListingId").val(listingId);
                });
                $(".denyButton").click(function() {
                    $("#confirmationModal").css("display", "block");
                    $("#confirmationButton").html("Deny");
                    $("#confirmationMessage").text("Are you sure you want to deny this connection?");
                    $("#confirmationButton").attr("onclick", "denyConnection();");
                    
                    var creatorId = $(this).parent().parent().find(".creatorId").val();
                    var interestedParty = $(this).parent().parent().find(".interestedParty").val();
                    var listingId = $(this).parent().parent().find(".listingId").val();
                    
                    $("#confirmationModalCreatorId").val(creatorId);
                    $("#confirmationModalInterestedParty").val(interestedParty);
                    $("#confirmationModalListingId").val(listingId);
                });
                $(".approveButton").click(function() {
                    $("#confirmationModal").css("display", "block");
                    $("#confirmationButton").html("Approve");
                    $("#confirmationMessage").text("Are you sure you want to approve this connection?");
                    $("#confirmationButton").attr("onclick", "approveConnection();");
                    
                    var creatorId = $(this).parent().parent().find(".creatorId").val();
                    var interestedParty = $(this).parent().parent().find(".interestedParty").val();
                    var listingId = $(this).parent().parent().find(".listingId").val();
                    
                    $("#confirmationModalCreatorId").val(creatorId);
                    $("#confirmationModalInterestedParty").val(interestedParty);
                    $("#confirmationModalListingId").val(listingId);
                });
            });
            
            function deleteConnection()
            {
                displayLoadingModal("Deleting connection...");
                var creatorId = $("#confirmationModalCreatorId").val();
                var interestedParty = $("#confirmationModalInterestedParty").val();
                var listingID = $("#confirmationModalListingId").val();
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-deleteConnection') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        creatorId: creatorId,
                        interestedParty: interestedParty,
                        listingId: listingID
                    },
                    success: function(response) {
                        if (response)
                        {
                            displaySuccessModal(response);
                            removeConnection(listingID);
                        }
                        else
                        {
                            displayErrorModal("Failed to delete connection. Please try again later.");
                        }
                    }
                });
            }
            
            function denyConnection()
            {
                displayLoadingModal("Updating connection...");
                var creatorId = $("#confirmationModalCreatorId").val();
                var interestedParty = $("#confirmationModalInterestedParty").val();
                var listingID = $("#confirmationModalListingId").val();
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-denyConnection') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        creatorId: creatorId,
                        interestedParty: interestedParty,
                        listingId: listingID
                    },
                    success: function(response) {
                        if (response)
                        {
                            displaySuccessModal(response);
                            removeConnection(listingID);
                        }
                        else
                        {
                            displayErrorModal("Failed to deny the connection request. Please try again later.");
                        }
                    }
                });
            }
            
            function approveConnection()
            {
                displayLoadingModal("Updating connection...");
                var creatorId = $("#confirmationModalCreatorId").val();
                var interestedParty = $("#confirmationModalInterestedParty").val();
                var listingID = $("#confirmationModalListingId").val();
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-approveConnection') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        creatorId: creatorId,
                        interestedParty: interestedParty,
                        listingId: listingID
                    },
                    success: function(response) {
                        if (response)
                        {
                            location.reload();
                        }
                        else
                        {
                            displayErrorModal("Failed to update connection status, please try again later.");
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
                            removeConnection(listingID);
                        }
                        else
                        {
                            displayErrorModal("Failed to send request. Please try again later.");
                        }
                    }
                });
            }
            
            var numberOfConnections = $('.field').length - $('.statusField').length - 1;
            
            function removeConnection(listingID) {
                $("#" + listingID).remove();
                $('.statusGroup').each(function(){
                    if ($(this).children().length == 1)
                    {
                        $(this).remove();
                    }
                });
                
                numberOfConnections--;
                if (numberOfConnections == 0) {
                    $("#outOfConnections").css("display", "block");
                }
            }
        </script>
    @else
        <div class="row field">
            <div class="col-xs-12">
                <h1>You have no connections at this time</h1>
            </div>
        </div>
    @endif
@endsection