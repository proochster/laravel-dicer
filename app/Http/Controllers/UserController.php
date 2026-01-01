<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  
        Validator::make($request->all(), [
            'username' => 'regex:/^[a-zA-Z0-9\s]+$/'
        ])->validate();

        $newUser = User::create([
            'name' => $request->username,
            'hash' => Str::random(16)
        ]);
            
        return response()->json($newUser);
        
    }
}
