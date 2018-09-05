@extends('layouts.user') @section('content')
    @if (count($savedListings))
        @foreach ($savedListings as $savedListing)

                @php
                    $listing = $savedListing->listing;
                @endphp
            <div class="row field" id="{{ $listing->listingID }}">
                @include('include.listingSummary')
                <div class="row">
                    <div class="col-xs-6">
                        <a href="{{ route('user-reviewListing', ['listingID' => $listing->listingID]) }}" class="btn btn-default button">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Review
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <button class="removeSavedListing btn btn-default button" value="{{ $listing->listingID }}">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
                        </button>
                    </div>
                </div>
            </div>
            <div id="outOfSavedListings" class="row field" style="display:none;">
                <div class="col-lg-12" style="text-align: center;">
                    <h1>You have no more saved listings</h1>
                    <a href="{{ route('user-browseListings') }}"><h4>Click here to browse the listings we have to offer</h4></a>
                </div>
            </div>
        @endforeach
        
    @else
        <div class="row field">
            <div class="col-lg-12" style="text-align: center;">
                <h1>You have no saved listings</h1>
                <a href="{{ route('user-browseListings') }}"><h4>Click here to browse the listings we have to offer</h4></a>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            var numberOfSavedListings = $('.field').length;
            $(".removeSavedListing").click(function() {
                var savedListingId = $(this).attr("value");
                $.ajax({
                    type: "POST",
                    url: "{{ route('user-removeSavedListing')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        savedListingId: savedListingId
                    },
                    success: function(response) {
                        $("#" + savedListingId).remove();
                    }
                });
                numberOfSavedListings--;
                if (numberOfSavedListings == 1) {
                    $("#outOfSavedListings").css('display', 'block');
                }
            });
        });
    </script>
@endsection