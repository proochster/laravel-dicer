@extends('layouts.app')

@section('content')
<div class="px-4">
    <div class="row" id="app">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card mt-4">
                <div class="card-header">Welcome to <span class="text-capitalize text-info">{{ $room->name }}</span> room. Room address: <span class="text-success"><?php echo url()->current(); ?></span></div>

                <div class="card-body">
                    <chat-box :room_hash="{{ json_encode($room->hash) }}"></chat-box>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-8 row">
            <div class="col-12 col-md-6 col-xl-4">
                <h5 class="mt-4">YouTube music:</h5>   
                <video-box :room_hash="{{ json_encode($room->hash) }}"></video-box> 
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <h5 class="mt-4">Links:</h5>            
                <link-box :room_hash="{{ json_encode($room->hash) }}"></link-box>
            </div>
        </div>
    </div>
</div>
@endsection
