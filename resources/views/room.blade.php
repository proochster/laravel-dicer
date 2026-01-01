@extends('layouts.app')

@section('pageTitle'){{ $room->name }}@endsection

@section('content')
<div>
    <div class="row" id="app">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card">
                <chat-box :room_hash="{{ json_encode($room->hash) }}" :room_name="{{ json_encode($room->name) }}"></chat-box>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-8 row position-static">
            <div class="col-12 col-lg-6 col-xl-4 position-static">   
                <video-box :room_hash="{{ json_encode($room->hash) }}"></video-box> 
            </div>
            <div class="col-12 col-lg-6 col-xl-4">
                <h5>Links:</h5>            
                <link-box :room_hash="{{ json_encode($room->hash) }}"></link-box>
            </div>
        </div>
    </div>
</div>
@endsection
