<?php

namespace App\Http\Controllers\Auth;

use App\Events\CreatePassengerEvent;
use App\Models\Passengers;
use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Error;
use Illuminate\Http\Request;
use App\Helper\ValidateUser;
use App\Helper\ManualEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Passengers as Authenticatable;
use Illuminate\Support\Facades\DB;

class RegisterPassengerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['guest']);
    // }

    public function index()
    {
        return view('auth.registerpassenger');
    }

    public function store(Request $request)
    {
        $passenger = new Passenger();

        $validate = $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|max:191',
            'email' => 'required|email|unique:passengers,email',
            'address' => 'required|max:191',
            'password' => 'required|confirmed',
        ]);

        // validate user
        ValidateUser::do($request);

        foreach ($validate as $key => $value) {
            $passenger->$key = $value;
            if ($key == 'password') {
                $passenger->$key = Hash::make($value);
            }
        }

        DB::beginTransaction();
        try {
            // save passenger
            $passenger->save();

            $validate['password'] = $passenger->password;
            // save user
            ManualEvent::CreateUser($validate, 'passenger');

            DB::commit();
            return view('auth.login', [
                'send_access_key_to' => $passenger->email
            ]);
        } catch (\Exception $th) {

            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
