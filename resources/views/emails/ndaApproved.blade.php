@extends('layouts.email') @section('content')
<div style="color: #777; text-align: center;">
    <p style="font-size: 2em;">The Non-Disclosure Agreement that you submitted was approved.</p>
</div>
@if ($data['numberOfConnectionsUpdated'] > 0)
    <div style="color: #777; width: 80%; margin: 0 auto;">
        <p style="font-size: 2em;">Note: As a result {{ $data['numberOfConnectionsUpdated'] }} connections have been updated</p>
    </div>
@endif
@endsection