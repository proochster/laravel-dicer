<?php

namespace App\Http\Controllers;

use App\Events\DestroyLink;
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
        ->where('toRoom', $room->id)
        ->select('url', 'title', 'created_at', 'links.id' )
        ->get();

    }

    public function store(Request $request)
    {
        $room = Room::where('hash', $request->room_hash)->firstOrFail();
        
        $link = Link::create([
            'toRoom' => $room->id,
            'url' => $request->url,
            'title' => $request->title
        ]);

        NewLink::dispatch($link);

        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($room_hash, $id)
    {
        $room = Room::where('hash', $room_hash)->firstOrFail();

        $link = Link::where('toRoom', $room->id)->where('id', $id)->firstOrFail();

        DestroyLink::dispatch($link);   
        
        $link->delete();
    }
}
