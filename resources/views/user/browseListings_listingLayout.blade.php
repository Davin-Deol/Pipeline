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