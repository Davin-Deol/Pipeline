@extends('layouts.guest')
@section('content')
    <div class="allTextSections textSectionWithLightBackground row">
        <!-- Label for the section -->
        {!! $data['cookiePolicy'] !!}
    </div>
@endsection