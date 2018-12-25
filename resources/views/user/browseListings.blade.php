@extends('layouts.user') @section('content')
<div class="row field" id="filters" style="cursor: pointer;">
    <h1 id="filtersToggle">Filters <span id="filtersToggleIcon" class="glyphicon glyphicon-plus" style="font-size: 0.8em; float: right;"></span></h1>
    <div class="col-xs-12">
        <form  class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="filtersContent" style="display: none;">
            <div class="row">
                <h3>Price Range</h3>
                <div class="col-xs-4">
                    <select name="filterPriceRange" id="filterPriceRange">
                        @foreach ($currencies as $currency)
                        <option value="{{ $currency->currency }}">{{ $currency->currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4">
                    <input name="minPrice" id="minPrice" type="number" min="0" max="99999999999" placeholder="min" />
                </div>

                <div class="col-xs-4">
                    <input name="maxPrice" id="maxPrice" type="number" min="0" max="99999999999" placeholder="max" />
                </div>
            </div>
            <div class="row">
                <h3>Interests</h3>
                <div class="col-lg-4 col-sm-6">
                    @php ($i = 0)
                    @foreach ($interests as $interest)
                    @if (($i == (ceil(count($interests) / 3))) || ($i == (ceil(count($interests) / 3) * 2)))
                </div>
                <div class="col-lg-4 col-sm-6">
                    @endif
                    <label for="interest{{ $i }}" class="label-cbx">
                        <input id="interest{{ $i }}" type="checkbox" class="invisible" name="interests[]" value="{{ $interest->interest }}">
                        <div class="checkbox">
                            <svg viewBox="0 0 20 20">
                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                        </div>
                        <span>{{ $interest->interest }}</span>
                    </label>
                    <br><br>
                    @php ($i++)
                    @endforeach
                </div>
            </div>
            <div class="row">
                <h3>Investment Types</h3>
                <div class="col-lg-4 col-sm-6">
                    @php ($i = 0)
                    @foreach ($investmentTypes as $investmentType)
                    @if (($i == (ceil(count($investmentTypes) / 3))) || ($i == (ceil(count($investmentTypes) / 3) * 2)))
                </div>
                <div class="col-lg-4 col-sm-6">
                    @endif
                    <label for="investmentType{{ $i }}" class="label-cbx">
                        <input id="investmentType{{ $i }}" type="checkbox" class="invisible" name="investmentTypes[]" value="{{ $investmentType->investmentType }}">
                        <div class="checkbox">
                            <svg viewBox="0 0 20 20">
                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                        </div>
                        {{ $investmentType->investmentType }}
                    </label>
                    <br><br>
                    @php ($i++)
                    @endforeach
                </div>
            </div>
            <div class="row">
                <h3>Jurisdictions</h3>
                <div class="col-lg-4 col-sm-6">
                    @php ($i = 0)
                    @foreach ($jurisdictions as $jurisdiction)
                    @if (($i == (ceil(count($jurisdictions) / 3))) || ($i == (ceil(count($jurisdictions) / 3) * 2)))
                </div>
                <div class="col-lg-4 col-sm-6">
                    @endif
                    <label for="jurisdiction{{ $i }}" class="label-cbx">
                        <input id="jurisdiction{{ $i }}" type="checkbox" class="invisible" name="jurisdictions[]" value="{{ $jurisdiction->jurisdiction }}">
                        <div class="checkbox">
                            <svg viewBox="0 0 20 20">
                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                <polyline points="4 11 8 15 16 6"></polyline>
                            </svg>
                        </div>
                        {{ $jurisdiction->jurisdiction }}
                    </label>
                    <br><br>
                    @php ($i++)
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-default button">Apply</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
<div id="outOfSavedListings" class="row field noMoreListings" style="display:none;">
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
        var filtersExpanded = false;
        $("#filtersToggle").on('click', function() {
            filtersExpanded = !filtersExpanded;
            if (filtersExpanded) {
                $("#filtersToggleIcon").removeClass("glyphicon-plus");
                $("#filtersToggleIcon").addClass("glyphicon-minus");
            } else {
                $("#filtersToggleIcon").removeClass("glyphicon-minus");
                $("#filtersToggleIcon").addClass("glyphicon-plus");
            }
            $("#filtersContent").slideToggle("slow", function() {
            });
        });
        $(".field:not(:first)").draggable({
            axis: "x",
            delay: 300,
            shouldPreventDefault: true,
            revert: "invalid",
            revertDuration: 100,
            scroll: false
        });
        $('.noMoreListings').draggable("disable");
        var numberOfSavedListings = $('.field').length - 2;

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
        $(".field:not(:first)").on('mousedown', function(e) {
            try {
                startPoint = e.originalEvent.changedTouches[0].clientX;
            } catch (err) {
                startPoint = e.pageX;
            }
        });

        $(".field:not(:first)").on('mouseup', function(e) {
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
