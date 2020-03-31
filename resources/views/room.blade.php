@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 align-items-center justify-content-end flex-column d-flex">
            Dice
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome to <span class="font-weight-bold">{{ $room->name }}</span> room</div>

                <div class="card-body" id="app">
                    <chat-box :room_hash="{{ json_encode($room->hash) }}"></chat-box>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection
