@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="app">
        <div class="col-md-8 col-lg-6">
            <div class="card mt-4">
                <div class="card-header">Welcome to <span class="text-capitalize text-info">{{ $room->name }}</span> room. Room address: <span class="text-success"><?php echo url()->current(); ?></span></div>

                <div class="card-body">
                    <chat-box :room_hash="{{ json_encode($room->hash) }}"></chat-box>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="mt-4">Links:</h5>            
            <link-box :room_hash="{{ json_encode($room->hash) }}"></link-box>
            {{-- <iframe src="https://discordapp.com/widget?id=700754598910099498&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe> --}}
        </div>
    </div>
</div>
@endsection
