@extends('layouts.user') @section('content')
<style>
    .label-cbx input:checked+.checkbox svg path {
        fill: white;
    }
    polyline {
        stroke: #FFF;
    }
</style>
<div class="row attachToNav">
    <div class="row" id="filtersToggle" style="width: 70%; margin: 0 auto; cursor: pointer;">
        <h3 style="margin-top: 10px; text-align: center;">
            <span id="filtersToggleIcon" class="glyphicon glyphicon-plus" style="font-size: 0.8em;"></span> Filters
        </h3>
    </div>
    <div class="row">
        <form action="" method="POST" id="filtersContent" style="display: none; width: 70%; margin: 0 auto;">
            <div class="row">
                <b>Price Range</b><br />
                <div class="col-sm-4 col-xs-6">
                    <input name="minPrice" id="minPrice" type="number" min="0" max="99999999999" placeholder=" from" />
                </div>
                <div class="col-sm-4 col-xs-6">
                    <input name="maxPrice" id="maxPrice" type="number" min="0" max="99999999999" placeholder=" to" />
                </div>
            </div>
            <div class="row">
                <b>Interests</b><br />
                <div class="col-sm-4 col-xs-12">
                    @php ($i = 0)
                    @foreach ($interests as $interest)
                    @if (($i == (ceil(count($interests) / 3))) || ($i == (ceil(count($interests) / 3) * 2)))
                </div>
                <div class="col-sm-4 col-xs-12">
                    @endif
                    <label for="interest{{ $i }}" class="label-cbx">
                        <input id="interest{{ $i }}" type="checkbox" class="invisible" name="interests[]" value="{{ $interest->interest }}" checked>
                        <div class="checkbox" style="padding-top: 0;">
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
                <b>Investment Types</b><br />
                <div class="col-sm-4 col-xs-12">
                    @php ($i = 0)
                    @foreach ($investmentTypes as $investmentType)
                    @if (($i == (ceil(count($investmentTypes) / 3))) || ($i == (ceil(count($investmentTypes) / 3) * 2)))
                </div>
                <div class="col-sm-4 col-xs-12">
                    @endif
                    <label for="investmentType{{ $i }}" class="label-cbx">
                        <input id="investmentType{{ $i }}" type="checkbox" class="invisible" name="investmentTypes[]" value="{{ $investmentType->investmentType }}" checked>
                        <div class="checkbox" style="padding-top: 0;">
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
                <b>Jurisdictions</b><br />
                <div class="col-sm-4 col-xs-12">
                    @php ($i = 0)
                    @foreach ($jurisdictions as $jurisdiction)
                    @if (($i == (ceil(count($jurisdictions) / 3))) || ($i == (ceil(count($jurisdictions) / 3) * 2)))
                </div>
                <div class="col-sm-4 col-xs-12">
                    @endif
                    <label for="jurisdiction{{ $i }}" class="label-cbx">
                        <input id="jurisdiction{{ $i }}" type="checkbox" class="invisible" name="jurisdictions[]" value="{{ $jurisdiction->jurisdiction }}" checked>
                        <div class="checkbox" style="padding-top: 0;">
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
            <div class="row" style="margin-bottom: 1em;">
                <div class="col-md-offset-3 col-md-3 col-sm-4 col-xs-12">
                    <button type="button" class="btn btn-default button" name="clear" id="clear">Clear</button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <button type="reset" class="btn btn-default button" name="reset" id="reset">Reset</button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <button type="button" class="btn btn-default button" name="apply" id="apply">Apply</button>
                </div>
            </div>
            <input type="hidden" name="offset" id="offset" value="0" />
        </form>
    </div>
</div>
@if (count($listings))
<span id="listings"></span>
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
        var numberOfListings = 0;
        var startPoint = 0;
        var endPoint = 0;
        var numberOfListingsLoaded = 0;

        $("#filtersToggle").on('click', function() {
            filtersExpanded = !filtersExpanded;
            if (filtersExpanded) {
                $("#filtersToggleIcon").removeClass("glyphicon-plus");
                $("#filtersToggleIcon").addClass("glyphicon-minus");
            } else {
                $("#filtersToggleIcon").removeClass("glyphicon-minus");
                $("#filtersToggleIcon").addClass("glyphicon-plus");
            }
            $("#filtersContent").slideToggle(300, function() {});
        });
        $("#clear").click(function() {
            $('#filtersContent :input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
            $('#filtersContent :checkbox, :radio').prop('checked', false);
        });
        $("#apply").click(function() {
            $("#listings").empty();
            numberOfListings = 0;
            numberOfListingsLoaded = 0;
            $("#offset").val(0);
            loadMoreListings();
        });
        loadMoreListings();
        //var numberOfListings = $('.field').length - 2;

        function decrementNumberOfListings() {
            numberOfListings--;
            if (numberOfListings == 0) {
                $("#outOfSavedListings").css("display", "block");
            }
        }

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

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                loadMoreListings();
            }
        });

        function loadMoreListings() {
            displayLoadingModal("Loading listings...");
            $.ajax({
                type: "POST",
                url: "{{ route('user-browseListings_listingLayout') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                data: new FormData($('#filtersContent')[0]),
                success: function(response) {
                    closeAllModals();
                    $("#listings").append(response["data"]);
                    numberOfListings += response["count"];
                    numberOfListingsLoaded += response["count"];
                    $("#offset").val(numberOfListingsLoaded);
                    

                    if (numberOfListings) {
                        $("#outOfSavedListings").css("display", "none");
                    }

                    $(".field:not(:last)").draggable({
                        axis: "x",
                        delay: 300,
                        shouldPreventDefault: true,
                        revert: "invalid",
                        revertDuration: 100,
                        scroll: false
                    });

                    $(".saveListing").click(function() {
                        var listingId = $(this).attr("value");
                        saveListing(listingId);
                    });
                    $(".discardListing").click(function() {
                        var listingId = $(this).attr("value");
                        discardListing(listingId);
                    });

                    $(".field:not(:last)").on('mousedown', function(e) {
                        try {
                            startPoint = e.originalEvent.changedTouches[0].clientX;
                        } catch (err) {
                            startPoint = e.pageX;
                        }
                    });

                    $(".field:not(:last)").on('mouseup', function(e) {
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
                    
                    implementSlick();
                }
            });
        }
    });

</script>
@endsection
