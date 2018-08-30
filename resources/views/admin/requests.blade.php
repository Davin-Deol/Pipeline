@extends('layouts.user') @section('content')
    @if(count($requests))
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
                        <div class="col-xs-12">
                            <textarea name="message" placeholder="Message to creator..." rows="5" id="messageTextArea" class="col-xs-12"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="button" id="cancelButton">Cancel</button>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="button" id="confirmationButton"></button>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row" style="width: 80%; margin: 0 auto;">
            @foreach ($requests as $request)
                <div class="col-md-6" id="{{ $request->requestID }}">
                    <div class="row field" style="float: left; @if (!is_null($request->readStatus))
                                                  background-color: #DDD;
                                                  @endif width: 100%;">
                        <div class="row">
                            <div class="col-xs-12">
                                <b>Name</b>
                                <p>{{ $request->fullName }}</p>
                                <hr>
                                <b>Individual/Organization</b>
                                <p>{{ ucwords($request->individualOrOrganization) }}</p>
                                <hr>
                                @if ($request->linkedInURL)
                                    <b>LinkedIn:</b>
                                    <a href="{{ $request->linkedInURL }}" target="_blank"><p>{{ $request->linkedInURL }}</p></a>
                                    @if (count($request->interests) == 0)
                                        <p style="text-align: right; font-style: italic;">{{ $request->whenSent }}</p>
                                    @endif
                                    <hr>
                                @endif
                                @if (count($request->interests))
                                    <b>Interests</b>
                                    <p>
                                        @for ($i = 0; $i < count($request->interests); $i++)
                                            @if ($i != (count($request->interests) - 1))
                                                {{ $request->interests[$i]->interest }}, 
                                            @else
                                                {{ $request->interests[$i]->interest }}
                                            @endif
                                        @endfor
                                    </p>
                                    <p style="text-align: right; font-style: italic;">{{ $request->whenSent }}</p>
                                    <hr>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-xs-6">
                                <button class="button denyButton" value="{{ $request->requestID }}">Deny</button>
                            </div>
                            <div class="col-lg-4 col-xs-6">
                                <button class="button approveButton" value="{{ $request->requestID }}">Approve</button>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <button class="button messageButton" value="{{ $request->requestID }}">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row field" style="display: none;" id="outOfRequests">
            <div class="col-lg-12">
                <h1>There are no requests at this time</h1>
            </div>
        </div>
        <script>
            function denyRequest(element)
            {
                displayLoadingModal("Deleting request...");
                var requestID = $(event.target).val();
                var message = $("#messageTextArea").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin-denyRequest') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        requestID: requestID,
                        message: message
                    },
                    success: function(response) {
                        if (response)
                        {
                            removeRequest(requestID);
                            displaySuccessModal(response);
                        }
                        else
                        {
                            displayErrorModal("Failed to delete the request. Please try again later.");
                        }
                    },
                    error: function() {
                        displayErrorModal("Failed to delete the request. Please try again later.");
                    }
                });
            }
            function messageSender(element)
            {
                displayLoadingModal("Messaging sender...");
                var requestID = $(event.target).val();
                var message = $("#messageTextArea").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin-messageRequestSender') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        requestID: requestID,
                        message: message
                    },
                    success: function(response) {
                        if (response)
                        {
                            $(location).attr('href', response);
                        }
                        else
                        {
                            displayErrorModal("Failed to message the sender. Please try again later.");
                        }
                    },
                    error: function() {
                        displayErrorModal("Failed to message the sender. Please try again later.");
                    }
                });
            }
            function approveRequest(element)
            {
                displayLoadingModal("Sending invite...");
                var requestID = $(event.target).val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin-approveRequest') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        requestID: requestID
                    },
                    success: function(response) {
                        if (response)
                        {
                            removeRequest(requestID);
                            displaySuccessModal(response);
                        }
                        else
                        {
                            displayErrorModal("Failed to approve the request. Please try again later.");
                        }
                    },
                    error: function() {
                        displayErrorModal("Failed to approve the request. Please try again later.");
                    }
                });
            }
            
            $(document).ready(function() {
                $(".denyButton").click(function() {
                    $("#confirmationModal").css('display', 'inline');
                    $("#confirmationButton").text("Deny Request");
                    $("#confirmationButton").attr("onclick", "denyRequest(this);");
                    $("#confirmationButton").attr("value", $(this).val());
                    $("#confirmationMessage").text("Are you sure you want to deny this request? Note: you can specify your reason in the box below if you wish.");
                    $("#messageTextArea").css("display", "block");
                });
                
                $(".messageButton").click(function() {
                    $("#confirmationModal").css('display', 'inline');
                    $("#confirmationButton").text("Send Message");
                    $("#confirmationButton").attr("onclick", "messageSender(this);");
                    $("#confirmationButton").attr("value", $(this).val());
                    $("#confirmationMessage").text("What would you like to say to the sender of this request? Note: messaging the sender will mark this request as read.");
                    $("#messageTextArea").css("display", "block");
                });
                
                $(".approveButton").click(function() {
                    $("#confirmationModal").css('display', 'inline');
                    $("#confirmationButton").text("Approve Request");
                    $("#confirmationButton").attr("onclick", "approveRequest(this);");
                    $("#confirmationButton").attr("value", $(this).val());
                    $("#confirmationMessage").text("Are you sure you want to approve this request?");
                    $("#messageTextArea").css("display", "none");
                });
            });
            
            var numberOfRequests = $('.field').length - 1;
            
            function removeRequest(requestID) {
                $("#" + requestID).remove();
                
                numberOfRequests--;
                if (numberOfRequests == 0) {
                    $("#outOfRequests").css("display", "block");
                }
            }
        </script>
    @else
        <div class="row field">
            <div class="col-lg-12">
                <h1>There are no requests at this time</h1>
            </div>
        </div>
    @endif
@endsection