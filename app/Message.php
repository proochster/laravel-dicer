<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from', 'toRoom', 'text', 'diceType', 'diceRoll'
    ];

    public function diceRolls()
    {
        return $this->hasMany(DiceRoll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'from');
    }
}
