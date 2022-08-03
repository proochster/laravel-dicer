<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Room;
use App\Message;

class CleanupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old Messages and DiceRolls from the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Cleanup Cron called');

        $rooms = Room::all();

        // error_log($rooms->count() . " rooms to check:");
        Log::info($rooms->count() . " rooms to check:");

        $rooms->each(function($r) {            
            // error_log("Room ID: ". $r->id . "\t Name: " . $r->name . "\t  Hash: " . $r->hash);
            Log::info("Room ID: ". $r->id . "\t Name: " . $r->name . "\t  Hash: " . $r->hash);
            
            $messages = Message::latest()->where('toRoom', $r->id)->get();

            $mCount = $messages->count();

            if($mCount <= 50){

                $mCountMessage = "No messages to clear.";

            } else {

                $mtrimed = $messages->take($mCount)->skip(50);

                $mtrimed->each(function($mt){
                    $mt->delete();
                });
                $mCountMessage = $mCount - 50 . " messages removed.";

            }
            
            // error_log("Messages: " . $mCount . " | " . $mCountMessage);
            // error_log("\n");
            Log::info("Messages: " . $mCount . " | " . $mCountMessage);
            
        });
    }
}
