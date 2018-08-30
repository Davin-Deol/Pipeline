@extends('layouts.email') @section('content')
<div style="color: #777; text-align: left; width: 90%; margin: 0 auto;">
    <p style="font-size: 2em;">Dear {{ $request->fullName }},</p>
    <p style="font-size: 2em;">Your request to join {{ config('app.name') }}, which was submitted {{ $request->whenSent }}, was unfortuantely denied by one of our admins.</p>
    @if ($data['message'])
        <p style="font-size: 2em;">Note: {{ $data['message'] }}</p>
    @endif
</div>
@endsection