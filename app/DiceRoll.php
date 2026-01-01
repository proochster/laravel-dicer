<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiceRoll extends Model
{
    protected $guarded = [];
    // protected $fillable = [
    //     'from', 'toRoom', 'text', 'diceType', 'diceRoll'
    // ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
