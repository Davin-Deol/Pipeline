@extends('layouts.user') @section('content')
<div class="row">
    <div class="col-md-8">
        <div class="field">
            <div class="row" style="text-align: center;">
                <div class="col-xs-12">
                    @if ($user->profileImage)
                        <div style="background-image: url('{{ asset('public/img/Profile-Images/' . $user->profileImage) }}'); width: 33%; padding-top: 33%; margin: 0 auto; border-radius: 100%; background-size: cover; background-position: center; border: 1px solid #DDD;"></div>
                    @else
                        <div style="background-image: url('{{ asset('public/img/Profile-Images/Default-User-Profile-Image.png') }}'); width: 33%; padding-top: 33%; margin: 0 auto; border-radius: 100%; background-size: cover; background-position: center; border: 1px solid #DDD;">
                        </div>
                    @endif
                    <br /><h1>{{ $user->fullName }}</h1>
                </div>
            </div>
            <hr>
            <div class="row">
                @if ($user->location)
                    <div class="col-sm-6 col-xs-12">
                        <p><img src="public/img/Icons/Location.png" style="width: 1.5em;"/> {{ $user->location }}</p><br />
                        @php
                            $datetime1 = new DateTime($user->birthday);
                            $datetime2 = new DateTime();
                            $interval = $datetime1->diff($datetime2);
                        @endphp
                        <p><img src="public/img/Icons/Birthday.png" style="width: 1.5em;"/> {{ $interval->format('%y years old') }}</p><br />
                    </div>
                @endif

                @if ($user->birthday > 0)
                    <div class="col-sm-6 col-xs-12">
                        <p><img src="{{ asset('public/img/Icons/Email.png') }}" style="width: 1.5em;"/> {{ $user->email }}</p><br />
                        @if ($user->linkedInURL)
                            <p><a href="{{ $user->linkedInURL }}" target="_blank"><img src="{{ asset('public/img/Icons/LinkedInLogo.png') }}" style="width: 1.5em; height: 1.5em;"/> LinkedIn</a></p>
                        @endif
                    </div>
                @endif
            </div>
            @if ($user->bio)
            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $user->bio }}</p>
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
                        <h2>{{ ucwords($statistic) }}</h2>
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
