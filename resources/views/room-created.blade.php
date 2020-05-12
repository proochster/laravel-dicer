@extends('layouts.app')

@section('pageTitle')Created {{ $room_name }}@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card mt-4 text-center">
                <div class="card-body">
                    <h2 class="text-success">{{ $room_name }}</h2>
                    <p>room created</p>
                    <p>Share this url with your team</p>
                    <input type="text" class="bg-light form-control mb-2 mr-2 text-center" value="<?php echo url()->current(); ?>/{{ $room_hash }}">
                    <hr>
                    <a href="<?php echo url()->current(); ?>/{{ $room_hash }}" class="btn btn-success w-100">Go the room</a>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
