<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiceRoll extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $fillable = [
    //     'from', 'toRoom', 'text', 'diceType', 'diceRoll'
    // ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}