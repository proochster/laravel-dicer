<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    
    protected $fillable = [
        'name', 'hash'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'id', 'toRoom');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'id', 'toRoom');        
    }

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($room) {

            $room->messages()->delete();
            $room->links()->delete();

        });
    }
}
