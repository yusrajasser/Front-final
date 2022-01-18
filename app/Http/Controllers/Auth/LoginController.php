<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['guest']);
    // }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'access_key' => 'required|string',
            'password' => 'required',
        ]);

        $remember = false;
        if (isset($request['remember'])) {
            $remember = true;
        }

        if (Auth::attempt($request->only('access_key', 'password'), $remember)) {
            if (in_array(auth()->user()->user_role, ['passenger', 'driver'])) {
                if (DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]->confirmed == 0) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect('/login')->with('error', 'الأدمن لم يقم بقبول طلبك الرجاء الإنتظار');
                }
            }
            $request->session()->regenerate();

            $welcome = new \App\Http\Controllers\welcomeController();
            $notify = new \App\Http\Controllers\PublicNotificationController();

            $notify->publicnNotify();

            return $welcome->welcome();
            // return view('welcome');
        }

        return back()->with('message', 'البيانات المدخلة غير صحيحة');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
