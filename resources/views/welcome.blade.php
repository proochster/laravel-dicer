@extends('layouts.app')

@section('content')

<div class="jumbotron rounded-0 text-center">
    <div class="w-50-md mx-auto">
        
        <p>Welcome to</p>
        <h1 class="display-4 text-primary">DiceChat</h1>
        <p class="lead">A free online chatroom for rolling dice with your team.</p>

        <form class="form-inline" action="{{ route('create-room') }}" method="POST">
            @csrf
            <div class="form-group mx-auto mt-5">
                <input type="text" class="form-control mb-2 mr-2" id="roomName" name="roomName" placeholder="Chat room name">
                <button type="submit" class="btn btn-primary mb-2">Create room</button>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0 text-left">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>

{{-- <div class="">
    <div class="container">
        <p class="text-white">text</p>
    </div>
</div> --}}

@endsection