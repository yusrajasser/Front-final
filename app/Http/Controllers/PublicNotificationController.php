<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\notification;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PublicNotificationController extends Controller
{
    public function publicnNotify()
    {
        if (auth()->user()->user_role == 'passenger') {

            $reserve = new \App\Models\Reserve();

            $id = DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]->id;

            // dd($id);

            $all_reserves = $reserve::where('passenger_id', $id)->get()->values();

            // dd($all_reserves);

            $all_dates = [];

            // notify if there is a tomowrro date
            $date = new DateTime('tomorrow');

            $tomorrow = $date->format('Y-m-d');

            collect($all_reserves)->map(function ($value, $key) use (&$all_dates, $tomorrow) {
                // filter all dates
                if ($value['multi_dates'] != null) {

                    $multi_dates_arr = explode(', ', $value['multi_dates']);
                    // dd($multi_dates_arr);
                    foreach ($multi_dates_arr as $key_multi => $value_multi) {
                        if ($value_multi == $tomorrow) {
                            ManualEvent::notificationEvent([
                                'user_id' => auth()->user()->id,
                                'message' => "الرحلة المتجهة من " . $value['ride']['from'] . " إلى " . $value['ride']['to'] . " ستكون غدا",
                                'alert_type' => 'warn',
                                'af_model' => 'Reserve',
                                'af_model_id' => $value['id']
                            ]);
                            $all_dates[] = $value_multi;
                        }
                    }
                }
                if ($value['once_date'] != null) {
                    if ($value == $tomorrow) {
                        ManualEvent::notificationEvent([
                            'user_id' => auth()->user()->id,
                            'message' => "الرحلة المتجهة من $value[ride][from]  إلى $value[ride][to] ستكون غدا",
                            'alert_type' => 'warn',
                            'af_model' => 'Reserve',
                            'af_model_id' => $value['id']
                        ]);
                        $all_dates[] = $value['once_date'];
                    }
                }

                return $value;
            });

            $unique_dates = collect($all_dates)->unique();

            $all_notifications = new notification();

            // set session notifications
            session([
                'my_noti' => $unique_dates,
                'noti_count' => count($all_notifications::where('is_readed', 0)->get()->all())
            ]);
        }
    }

    public function getMyNotification()
    {
        $notify = new \App\Models\notification();

        $id = DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]->id;

        $all = collect($notify::where(['user_id' => auth()->user()->id])->get()->all())->sortByDesc('created_at');

        return view('pages.notifications.view', [
            'data' => $all
        ]);
    }

    public function showNotification(notification $id)
    {
        $id->is_readed = 1;

        try {
            $id->save();
            return view('pages.notifications.show', [
                'data' => $id
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
