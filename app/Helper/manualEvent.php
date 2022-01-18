<?php

namespace App\Helper;

use App\Models\notification;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ManualEvent
{
    private $notification_array = [
        'message',
        'user_id',
        'alert_type',
        'af_model',
        'af_model_id'
    ];

    static public function CreateUser($model, $role)
    {
        // init user
        $user = new User();

        $arr = [];

        foreach ($model as $key => $value) {
            $arr[$key] = $value;
        }

        $arr['user_role'] = $role;
        // $arr['access_key'] = Str::random(10);

        $user_cols = ['name', 'phone', 'email', 'password', 'access_key', 'user_role'];

        foreach ($arr as $key => $value) {
            if (in_array("$key", $user_cols)) {
                $user->$key = $value;
            }
        }

        try {
            $user->save();
            $user->access_key = $user->id;
            $user->save();
            $user->notify(new \App\Notifications\GetAccessKeyNotification($user->id));
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Error($e->getMessage());
        }
    }

    static public function UpdateUser($model, $email)
    {
        // get user
        $get_user = \App\Models\User::where('email', $email)->get()->all()[0];

        // find user to use it as model
        $user = \App\Models\User::find($get_user->id);

        $arr = [];

        foreach ($model as $key => $value) {
            $arr[$key] = $value;
        }

        $user_cols = ['name', 'phone', 'email'];

        foreach ($arr as $key => $value) {
            if (in_array("$key", $user_cols)) {
                $user->$key = $value;
            }
        }

        try {
            $user->save();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Error($e->getMessage());
        }
    }

    static public function DeleteUser($user_email)
    {
        // init user
        $user = new User();

        try {
            $user::where('email', $user_email)->delete();
            return true;
        } catch (\Throwable $th) {
            throw new Error($th->getMessage());
        }
    }

    public static function generateAdmin()
    {
        // create user first
        $user = new \App\Models\User();
        $admin = new \App\Models\Admin();

        $user_arr = [
            'phone' => '0111111111',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'access_key' => 'admin',
            'user_role' => 'admin',
        ];
        $admin_ar = [
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@admin.com',
            'phone' => '0111111111',
        ];

        foreach ($user_arr as $key => $value) {
            $user->$key = $value;
        }

        foreach ($admin_ar as $key => $value) {
            $admin->$key = $value;
        }

        DB::beginTransaction();
        try {
            $user->save();
            $admin->save();

            DB::commit();
            return redirect('/login')->with('success', "تم إنشاء أدمن بالبيانات التالية (access_key:admin, password:admin, email:admin@admin.com)");
        } catch (\Throwable $th) {

            DB::rollBack();
            return redirect('/login')->with('error', $th->getMessage());
        }
    }

    public static function sendMessage($request)
    {
        $message = new \App\Models\Message();

        foreach ($request as $key => $value) {
            $message->$key = $value;
        }

        try {
            $message->save();
            return true;
        } catch (\Throwable $th) {
            throw new Error($th->getMessage());
        }
    }

    public static function notificationEvent(array $notification_array)
    {
        $notify = new \App\Models\notification();

        foreach ($notification_array as $key => $value) {
            $notify->$key = $value;
        }
        $notify_exists = $notify::where($notification_array)->get()->all();

        try {
            if (count($notify_exists) < 1) {
                $notify->save();
            }
            return true;
        } catch (\Exception $th) {
            Log::info('notification_erro', $th->getMessage());
            return $th->getMessage();
        }
    }
}
