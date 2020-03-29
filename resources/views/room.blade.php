@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dice room <span class="font-weight-bold">{{ $room->name }}</span></div>

                <div class="card-body" id="app">
                    <chat-box :room_hash="{{ json_encode($room->hash) }}"></chat-box>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
