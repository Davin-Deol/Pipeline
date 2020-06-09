@extends('layouts.user') @section('content')
<div class="row">
    <div class="col-md-8">
        <div class="field">
            <div class="row" style="text-align: center;">
                <div class="col-xs-12">
                    @if ($profileUser->profileImage)
                        <div style="background-image: url('{{ asset('public/img/Profile-Images/' . $profileUser->profileImage) }}'); width: 33%; padding-top: 33%; margin: 0 auto; border-radius: 100%; background-size: cover; background-position: center; border: 1px solid #DDD;"></div>
                    @else
                        <div style="background-image: url('{{ asset('public/img/Profile-Images/Default-User-Profile-Image.png') }}'); width: 33%; padding-top: 33%; margin: 0 auto; border-radius: 100%; background-size: cover; background-position: center; border: 1px solid #DDD;">
                        </div>
                    @endif
                    <br /><h1>{{ $profileUser->fullName }}</h1>
                </div>
            </div>
            <hr>
            <div class="row">
                @if ($profileUser->location)
                    <div class="col-sm-6 col-xs-12">
                        <p><span class="glyphicon glyphicon-map-marker secondary" aria-hidden="true"></span> {{ $profileUser->location }}</p><br />
                        @php
                            $datetime1 = new DateTime($profileUser->birthday);
                            $datetime2 = new DateTime();
                            $interval = $datetime1->diff($datetime2);
                        @endphp
                        <p><span class="glyphicon glyphicon-calendar secondary" aria-hidden="true"></span> {{ $interval->format('%y years old') }}</p><br />
                    </div>
                @endif

                @if ($profileUser->birthday > 0)
                    <div class="col-sm-6 col-xs-12">
                        <p><span class="glyphicon glyphicon-envelope secondary" aria-hidden="true"></span> {{ $profileUser->email }}</p><br />
                        @if ($profileUser->linkedInURL)
                            <p><a href="{{ $profileUser->linkedInURL }}" target="_blank"><img src="{{ asset('public/img/Icons/LinkedInLogo.png') }}" style="width: 1em; height: 1em;"/> LinkedIn</a></p>
                        @endif
                    </div>
                @endif
            </div>
            @if ($profileUser->bio)
            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $profileUser->bio }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="field">
            <h1>Statistics</h1>
            <div class="row">
                <div class="col-xs-12">
                    @foreach ($statistics as $statistic => $datapoint)
                        <hr>
                        <h3>{{ ucwords($statistic) }}</h3>
                        @foreach ($datapoint as $value)
                            <div class="row">
                                <div class="col-xs-8">
                                    <p>{{ ucwords($value->status) }}</p>
                                </div>
                                <div class="col-xs-4" style="text-align: right;">
                                    <p>{{ $value->total }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
