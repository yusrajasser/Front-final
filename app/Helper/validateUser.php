<?php

namespace App\Helper;

use Illuminate\Http\Request;

class ValidateUser
{
    static public function do(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email'
        ]);
    }
}
