<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Message;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();

        return response()->json($messages);
    }
    
    public function show($room_hash)
    {

        $room = Room::where('hash', $room_hash)->firstOrFail();

        return DB::table('users')
        ->join('messages', 'messages.from', 'users.id')
        ->where('toRoom', $room->id)
        ->select('from', 'name', 'text', 'messages.created_at' )
        ->get();

    }

    public function store(Request $request)
    {
        
        $user = User::where('hash', $request->user_hash)->firstOrFail();
        $room = Room::where('hash', $request->room_hash)->firstOrFail();
        
        $message = Message::create([
            'from' => $user->id,
            'toRoom' => $room->id,
            'text' => $request->text
        ]);

        NewMessage::dispatch($message);

        return response()->json($message);
    }
}


