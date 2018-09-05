@extends('layouts.user') @section('content')
    @if (count($listings))
        @foreach ($listings as $listing)
            <div class="row field" id="{{ $listing->listingID }}">
                @include('include.listingSummary')
                <div class="row">
                    @if ($listing->userId == $user->userId)
                        <div class="col-xs-6">
                            <a href="{{ route('user-reviewListing', ['listingID' => $listing->listingID]) }}" class="btn btn-default button">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Review
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="discardListing btn btn-default button" name="Discard" value="{{ $listing->listingID }}">Discard &rarr;</button>
                        </div>
                    @else
                        <div class="col-xs-4">
                            <button type="button" class="saveListing btn btn-default button" name="Save" value="{{ $listing->listingID }}">&larr; Save</button>
                        </div>
                        <div class="col-xs-4">
                            <a href="{{ route('user-reviewListing', ['listingID' => $listing->listingID]) }}" class="btn btn-default button">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Review
                            </a>
                        </div>
                        <div class="col-xs-4">
                            <button type="button" class="discardListing btn btn-default button" name="Discard" value="{{ $listing->listingID }}">Discard &rarr;</button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div id="outOfSavedListings" class="row field" style="display:none;">
            <div class="col-lg-12">
                <h1>There are no more listings at this time</h1>
            </div>
        </div>
        
    @else
        <div class="row field noMoreListings">
            <div class="col-lg-12">
                <h1>@if ($data['searchKeyUsed'] != '')
                        There are no listings at the moment with the key phrase "{{ $data['searchKeyUsed'] }}"
                    @else
                        There are no listings at the moment
                    @endif
                </h1>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $(".field").draggable({
                axis: "x",
                delay: 300,
                shouldPreventDefault: true,
                revert: "invalid",
                revertDuration: 100,
                scroll: false
            });
            $('.noMoreListings').draggable("disable");
            var numberOfSavedListings = $('.field').length - 1;

            function decrementNumberOfListings() {
                numberOfSavedListings--;
                if (numberOfSavedListings == 0) {
                    $("#outOfSavedListings").css("display", "block");
                }
            }
            $(".saveListing").click(function() {
                var listingId = $(this).attr("value");
                saveListing(listingId);
            });
            $(".discardListing").click(function() {
                var listingId = $(this).attr("value");
                discardListing(listingId);
            });
            var startPoint = 0;
            var endPoint = 0;
            $(".field").on('mousedown', function(e) {
                try {
                    startPoint = e.originalEvent.changedTouches[0].clientX;
                } catch (err) {
                    startPoint = e.pageX;
                }
            });

            $(".field").on('mouseup', function(e) {
                if (($(this).hasClass("noMoreListings")) == true) {
                    return;
                }
                try {
                    endPoint = e.originalEvent.changedTouches[0].clientX;
                } catch (err) {
                    endPoint = e.pageX;
                }

                var distanceMoved = 0;
                var swipeRight = false;
                if (startPoint < endPoint) {
                    distanceMoved = endPoint - startPoint;
                    swipeRight = true;
                } else {
                    distanceMoved = startPoint - endPoint;
                    swipeRight = false;
                }
                if (distanceMoved >= ($(document).width() / 3)) {
                    var listingId = $(this).attr("id");
                    if (swipeRight) {
                        $(this).draggable("disable");
                        discardListing(listingId);
                    } else {
                        saveListing(listingId);
                    }
                }
                startPoint = 0;
                endPoint = 0;
            });

            function saveListing(listingId) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-saveUsersListing') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        savedListingId: listingId
                    },
                    success: function(response) {
                        $("#" + listingId).css("opacity", "0");
                        $("#" + listingId).slideUp(500, function() {
                            $("#" + listingId).remove();
                        });
                        decrementNumberOfListings();
                    }
                });
            }

            function discardListing(listingId) {
                $("#" + listingId).css("opacity", "0");
                $("#" + listingId).slideUp(500, function() {
                    $("#" + listingId).remove();
                });
                decrementNumberOfListings();
            }
        });
    </script>
@endsection