@extends('layouts.user') @section('content')
<div class="col-lg-12">
    <div class="field">
        <h1>Listing Form</h1>

        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="listingForm">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12">
                    <b>Name</b>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $listing->name }}" maxlength="127" />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <b>Introduction</b>
                    <textarea type="text" class="form-control" id="intro" rows="5" name="intro" placeholder="Introduction" maxlength="511">{{ $listing->introduction }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <b>Category</b>
                    <select class="form-control" id="category" name="category">
                        @if ($listing->category == "Looking to Invest")
                            <option>Looking for Investments</option>
                            <option selected>Looking to Invest</option>
                        @elseif ($lastInputsUsed !== null)
                            @if ($lastInputsUsed->category == "Looking for Investments")
                                <option selected>Looking for Investments</option>
                                <option>Looking to Invest</option>
                            @else
                                <option>Looking for Investments</option>
                                <option selected>Looking to Invest</option>
                            @endif
                        @else
                            <option selected>Looking for Investments</option>
                            <option>Looking to Invest</option>
                        @endif
                    </select>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <b>Sub Category</b>
                    <select class="form-control" id="subCategory" name="subCategory">
                        @foreach ($interests as $interest)
                            @if ($listing->subCategory == $interest->interest)
                                <option selected>{{ $interest['interest'] }}</option>
                            @elseif ($lastInputsUsed !== null)
                                @if ($lastInputsUsed->subCategory == $interest->interest)
                                    <option selected>{{ $interest['interest'] }}</option>
                                @else
                                    <option>{{ $interest['interest'] }}</option>
                                @endif
                            @else
                                <option>{{ $interest['interest'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <b>Jurisdiction</b>
                    <select class="form-control" id="jurisdiction" name="jurisdiction">
                        @foreach ($jurisdictions as $jurisdiction)
                            @if ($listing->jurisdiction == $jurisdiction->jurisdiction)
                                <option selected>{{ $jurisdiction['jurisdiction'] }}</option>
                            @elseif ($lastInputsUsed !== null)
                                @if ($lastInputsUsed->jurisdiction == $jurisdiction->jurisdiction)
                                    <option selected>{{ $jurisdiction['jurisdiction'] }}</option>
                                @else
                                    <option>{{ $jurisdiction['jurisdiction'] }}</option>
                                @endif
                            @else
                                <option>{{ $jurisdiction['jurisdiction'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <b>Investment Type</b>
                    <select class="form-control" id="investmentType" name="investmentType">
                        @foreach ($investmentTypes as $investmentType)
                            @if ($listing->investmentType == $investmentType->investmentType)
                                <option selected>{{ $investmentType['investmentType'] }}</option>
                            @elseif ($lastInputsUsed !== null)
                                @if ($lastInputsUsed->investmentType == $investmentType->investmentType)
                                    <option selected>{{ $investmentType['investmentType'] }}</option>
                                @else
                                    <option>{{ $investmentType['investmentType'] }}</option>
                                @endif
                            @else
                                <option>{{ $investmentType['investmentType'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <b>Price Bracket</b>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <select class="form-control" id="typeOfCurrency" name="typeOfCurrency">
                        @foreach ($currencies as $currency)
                            @if ($listing->typeOfCurrency == $currency->currency)
                                <option selected>{!! $currency['currency'] !!}</option>
                            @elseif ($lastInputsUsed !== null)
                                @if ($lastInputsUsed->typeOfCurrency == $currency->currency)
                                    <option selected>{!! $currency['currency'] !!}</option>
                                @else
                                    <option>{!! $currency['currency'] !!}</option>
                                @endif
                            @else
                                <option>{!! $currency['currency'] !!}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control priceBracket" id="minPrice" name="minPrice" value="{{ $listing->priceBracketMin }}" min="0" max="99999999999" placeholder="min" />
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control priceBracket" id="maxPrice" name="maxPrice" value="{{ $listing->priceBracketMax }}" min="0" max="99999999999" placeholder="max" />
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <b>Details</b>
                    <textarea type="text" class="form-control" id="details" rows="5" name="details" placeholder="Additional Details" maxlength="4095">{{ $listing->additionalDetails }}</textarea>
                </div>
            </div>
            <div class="row">
                <div id="fileInputs" class="col-lg-12">
                    <b>Photos</b><i style="float:right;">5MB per image (9 max)</i>
                    <input type="file" id="photos" name="files[]" accept="image/*">
                    <label for="photos">Add Image</label>
                </div>
            </div>
            <div id="images" class="row">
                @if (count($listingImages))
                    @foreach ($listingImages as $listingImage)
                        <div class="col-sm-3 col-xs-6 offset-xs-5 {{ explode('.', $listingImage->image)[0] }}">
                            <div class="image" style="position:relative;display:inline-block; margin:2% 0; background-size:cover; background-repeat: no-repeat; background-image: url('{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listingImage->image) }}'); width: 100%; background-position: 50% 50%;"></div>
                            <button id="{{ $listingImage->image }}" class="delete" type="button" style="position:absolute;top:2%;right:2.5%;background-color:black;color:white;border-width:medium;">X</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <input type="hidden" name="listingID" id="listingID" value="{{ $listing->listingID }}" />
            <div class="row">
                <div class="col-sm-4">
                    <button type="submit" class="button" formaction="{{ route('user-deleteListing') }}">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="button" id="SaveButton">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Save
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="button" formaction="{{ route('user-submitListingForReview') }}">
                        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var files = [];
    var fileNumber = 0;

    $( window ).resize(function() {
        $(".image").height($(".image").parent().width());
    });

    $(document).ready(function() {
        $(".image").height($(".image").parent().width());

        function resetListener() {
            $("#photos").change(function() {
                $('label[for="' + $(this).attr("id") + '"]').css("visibility", "hidden");
                $('label[for="' + $(this).attr("id") + '"]').css("display", "none");
                jQuery(this).attr("id", fileNumber);
                jQuery(this).attr("class", fileNumber);
                jQuery(this).css("display", "none");
                $("#fileInputs").append("<input type=\"file\" id=\"photos\" name=\"files[]\" accept=\"image/*\"><label for=\"photos\">Add Image</label>");
                var url = URL.createObjectURL(event.target.files[0]);
                $('#images').append("<div class=\"image " + fileNumber + " col-sm-3 col-xs-6\" style=\"position:relative;display:inline-block;\"><img src=\"" + url + "\" alt=\"Image Unavailable\" style=\"width:95%; margin:2% 2.5%;\" class=\"" + fileNumber + "\"><button id=\"" + fileNumber + "\" class=\"remove " + fileNumber + "\" type=\"button\" style=\"position:absolute;top:2%;right:2.5%;background-color:black;color:white;border-width:medium;\">X</button></div>");
                ++fileNumber;
                previewsAdded();
                resetListener();
            });
        }
        resetListener();
        $(".delete").click(function() {
            var btn_id = $(this).attr("id");
            var imagefile = btn_id;
            var listingID = $("#listingID").val();
            $.ajax({
                type: "POST",
                url: "{{ route('user-deleteListingImage') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    image: imagefile,
                    listingID: listingID
                },
                success: function(response) {
                    $("." + imagefile.substr(0, imagefile.indexOf('.'))).remove();
                }
            });
        });
        
        $("#SaveButton").click(function() {
            displayLoadingModal("Saving listing...");
            
            $.ajax({
                type: "POST",
                url: "{{ route('user-saveListing') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData($('#listingForm')[0]),
                processData: false, 
                contentType: false, 
                success: function(response) {
                    if (response)
                    {
                        $("#listingID").val(response);
                        closeAllModals();
                    }
                    else
                    {
                        displayErrorModal("Failed to save listing. Please try again later.");
                    }
                },
                error: function() {
                    displayErrorModal("Failed to save listing. Please try again later.");
                }
            });
        });
    });

    function previewsAdded() {
        $(".remove").click(function() {
            $("." + $(this).attr("id")).remove();
        });
    }

</script>
@endsection
