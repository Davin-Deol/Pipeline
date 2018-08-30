@extends('layouts.guest')
@section('content')
    <div class="allTextSections textSectionWithLightBackground row" id="creditsRow" style="background-color: {{ $data['backgroundColour'] }};">
        <!-- Label for the section -->
        {!! $data['credits'] !!}
    </div>
@endsection