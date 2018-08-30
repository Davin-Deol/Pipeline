@extends('layouts.email') @section('content')
<div style="color: #777; text-align: center;">
    <p style="font-size: 2em;">The Non-Disclosure Agreement that you submitted was unfortunately denied.</p>
</div>
@if (!is_null($data['message']))
    <div style="color: #777; width: 80%; margin: 0 auto;">
        <p style="font-size: 2em;">Note: {!! $data['message'] !!}</p>
    </div>
@endif
@endsection