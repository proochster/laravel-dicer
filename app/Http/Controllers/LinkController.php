<?php

namespace App\Http\Controllers;

use App\Events\NewLink;
use Illuminate\Http\Request;
use App\Link;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;


class LinkController extends Controller
{
    public function index()
    {
        $links = Link::all();

        return response()->json($links);
    }

    public function show($room_hash)
    {

        $room = Room::where('hash', $room_hash)->firstOrFail();

        return DB::table('links')
        // ->join('links', 'links.from', 'users.id')
        ->where('toRoom', $room->id)
        // ->select('from', 'name', 'url', 'title', 'links.created_at' )
        ->select('url', 'title', 'links.created_at' )
        ->get();

    }

    public function store(Request $request)
    {
        // return $request;
        // $user = User::where('hash', $request->user_hash)->firstOrFail();
        $room = Room::where('hash', $request->room_hash)->firstOrFail();
        
        $link = Link::create([
            // 'from' => $user->id,
            'toRoom' => $room->id,
            'url' => $request->url,
            'title' => $request->title
        ]);

        // Send back User hash and name
        // $link->name = $user->name;
        
        NewLink::dispatch($link);

        return response()->json($link);
    }
}
