@extends('layouts.email') @section('content')
<div style="color: #777; text-align: left; width: 90%; margin: 0 auto;">
    <p style="font-size: 2em;">{!! $data['message'] !!}</p>
</div>
@endsection