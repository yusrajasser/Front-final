<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagePublicController extends Controller
{
    public function message(Ride $id)
    {
        // get my id
        $my_id = DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]->id;

        return view('pages.messages.add', [
            'data' => $id,
            'user_role' => auth()->user()->user_role . '_id',
            'user_id' => $my_id
        ]);
    }
}
