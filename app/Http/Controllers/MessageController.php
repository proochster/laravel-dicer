<?php

namespace App\Http\Controllers;

use App\Models\DiceRoll;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
// use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    
    public function show($roomHash)
    {

        $room = Room::where('hash', $roomHash)->firstOrFail();



        // $get_messages = DB::table('users')
        // ->join('messages', 'messages.from', 'users.id')
        // ->where('toRoom', $room->id)
        // ->select('from', 'name', 'text', 'diceType', 'diceRoll', 'messages.created_at' );
        $get_messages = Message::with('diceRolls', 'user')        
        // ->select('from', 'text', 'diceType', 'messages.created_at' )
        ->where('toRoom', $room->id);
        // ->select('id');
        

        // return $get_messages->dicerolls();

        // $get_dice_rolls = DiceRoll::where('message_id', $message_id)->pluck('dice_roll')->all();

        return $get_messages->get();

    }    
    
    public function single($message_id)
    {
        
        $single_message = Message::where('id', $message_id)->firstOrFail();
        $get_dice_rolls = DiceRoll::where('message_id', $message_id)->pluck('dice_roll')->all();
        return $get_dice_rolls;

        // $room = Room::where('hash', $roomHash)->firstOrFail();

        // return DB::table('users')
        // ->join('messages', 'messages.from', 'users.id')
        // ->where('toRoom', $room->id)
        // ->select('from', 'name', 'text', 'diceType', 'diceRoll', 'messages.created_at' )
        // ->get();

    }

    public function store(Request $request)
    {

        // dd($request->dice_rolls);
        
        $user = User::where('hash', $request->userHash)->firstOrFail();
        $room = Room::where('hash', $request->roomHash)->firstOrFail();
        
        $message = Message::create([
            'from' => $user->id,
            'toRoom' => $room->id,
            'text' => $request->text,
            'diceType' => $request->diceType,
            // 'diceRoll' => $request->diceRoll,
            // 'diceRolls' => $request->diceRolls,
        ]);
        
        // Loop through array of rolls and store in DB
        if(count($request->dice_rolls)){
            for ($i = 0; $i < count($request->dice_rolls); $i++) {
                $diceroll = DiceRoll::create([
                    'message_id' => $message->id,
                    'dice_roll' => $request->dice_rolls[$i]['dice_roll'],
                ]);
            }
        }

        event( new NewMessage($message, $message->user->name, $request->roomHash, $request->dice_rolls, $message->id));
    }
}