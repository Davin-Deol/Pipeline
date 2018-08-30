<div class="row">
    @if (count($listing->ListingImages))
        <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <div class="slider-for">
                <div class="row">
                    <div class="reviewImageMain reviewImage squareImage" style="background-image:url('{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listing->ListingImages[0]->image) }}');background-size:cover;background-position:center; border: 1px solid #DDD;"></div>
                </div>
            </div>
            <div class="slider-nav">
                @for ($j = 1; $j < count($listing->ListingImages); $j++)
                    <div class="row">
                        <div class="reviewImage" style="background-image:url('{{ asset('public/img/Listing-Images/' . $listing->userId . '/' . $listing->listingID . '/' . $listing->ListingImages[$j]->image) }}');background-size:cover;background-position:center;"></div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
            
    @if (count($listing->ListingImages))
        <div class="col-md-8 col-xs-12">
    @else
        <div class="col-xs-12">
    @endif
        <div class="row">
            <div class="col-md-8">
                <h3 style="margin: 0;">{{ $listing->name }}</h3>
            </div>
            <div class="col-md-4">
                <p style="color:green;font-size:1.5em;font-weight:300;">{!! $listing->typeOfCurrency !!}{{ number_format($listing->priceBracketMin) }} - {{ number_format($listing->priceBracketMax) }}</p>
            </div>
        </div>
        <hr>
        <p>{{ $listing->introduction }}</p>
        <hr>
    </div>
</div>