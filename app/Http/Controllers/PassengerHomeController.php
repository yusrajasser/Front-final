<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class PassengerHomeController extends Controller
{
    public function index()
    {
        return view('passengerHome');
    }
}
