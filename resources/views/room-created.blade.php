@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card mt-4 text-center">
                <div class="card-body">
                    <h2 class="text-success">{{ $room_name }}</h2>
                    <p>room created</p>
                    <p>Share this url with your team</p>
                    <input type="text" class="form-control mb-2 mr-2 border-success" value="<?php echo url()->current(); ?>/{{ $room_hash }}">
                    <br>
                    <a href="<?php echo url()->current(); ?>/{{ $room_hash }}" class="btn btn-primary w-100">Go the room</a>
                </div>                
            </div>
        </div>
    </div>
</div>

@endsection
