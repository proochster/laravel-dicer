<?php

namespace App\Http\Controllers;

use App\Events\DestroyVideo;
use App\Events\NewVideo;
use App\Room;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();

        return response()->json($videos);
    }

    public function show($room_hash)
    {

        $room = Room::where('hash', $room_hash)->firstOrFail();

        return DB::table('videos')
        ->where('toRoom', $room->id)
        ->select('url', 'created_at', 'videos.id' )
        ->get();

    }

    public function store(Request $request)
    {
        
        $room = Room::where('hash', $request->room_hash)->firstOrFail();
        
        $video = Video::create([
            'toRoom' => $room->id,
            'url' => $request->url
        ]);
        
        NewVideo::dispatch($video);

        return response()->json($video);
    }

    public function destroy($room_hash, $id)
    {

        $room = Room::where('hash', $room_hash)->firstOrFail();

        $video = Video::where('toRoom', $room->id)->where('id', $id)->firstOrFail();

        // return $link;

        DestroyVideo::dispatch($video);
        
        $video->delete();
    }
}
