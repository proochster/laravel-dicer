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
    
    public function show($roomHash)
    {

        $room = Room::where('hash', $roomHash)->firstOrFail();

        return DB::table('users')
        ->join('messages', 'messages.from', 'users.id')
        ->where('toRoom', $room->id)
        ->select('from', 'name', 'text', 'diceType', 'diceRoll', 'messages.created_at' )
        ->get();

    }

    public function store(Request $request)
    {
        
        $user = User::where('hash', $request->userHash)->firstOrFail();
        $room = Room::where('hash', $request->roomHash)->firstOrFail();
        
        $message = Message::create([
            'from' => $user->id,
            'toRoom' => $room->id,
            'text' => $request->text,
            'diceType' => $request->diceType,
            'diceRoll' => $request->diceRoll
        ]);

        event( new NewMessage($message, $user->name, $request->roomHash));
    }
}


