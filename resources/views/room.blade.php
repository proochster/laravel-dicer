@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 align-items-center justify-content-end flex-column d-flex">
        </div>
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">Welcome to <span class="font-weight-bold">{{ $room->name }}</span> room. Room address: <span class="text-success"><?php echo url()->current(); ?></span></div>

                <div class="card-body" id="app">
                    <chat-box :room_hash="{{ json_encode($room->hash) }}"></chat-box>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            {{-- <iframe src="https://discordapp.com/widget?id=700754598910099498&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe> --}}
        </div>
    </div>
</div>
@endsection
