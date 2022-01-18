<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Helper\ValidateUser;
use App\Helper\ManualEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterDriverController extends Controller
{
    public function index()
    {
        return view('auth.registerdriver');
    }

    public function store(Request $request)
    {
        $driver = new Driver();

        $validate = $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|max:191',
            'email' => 'required|email|unique:drivers,email',
            'driver_license' => 'required|max:191',
            'password' => 'required|confirmed',
        ]);

        // validate user
        ValidateUser::do($request);

        foreach ($validate as $key => $value) {
            $driver->$key = $value;
            if ($key == 'password') {
                $driver->$key = Hash::make($value);
            }
            if ($key == 'driver_license') {
                $driver->driver_license = Str::substr($request->file('driver_license')->store('public/DriverLicenses'), 6);
            }
        }

        DB::beginTransaction();
        try {
            // save driver
            $driver->save();

            $validate['password'] = $driver->password;
            // save user
            ManualEvent::CreateUser($validate, 'driver');

            DB::commit();
            return view('auth.login', [
                'send_access_key_to' => $driver->email
            ]);
        } catch (\Exception $th) {

            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
