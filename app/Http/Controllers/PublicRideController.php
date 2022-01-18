<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\Ride;
use Illuminate\Http\Request;

class PublicRideController extends Controller
{
    public function destroy(Ride $ride)
    {
        try {
            $ride->delete();
            ManualEvent::notificationEvent([
                'user_id' => auth()->user()->id,
                'message' => "تم حذف الرحلة رقم $ride->id الوجهة $ride->from --> $ride->to",
                'alert_type' => 'delete',
                'af_model' => 'Ride',
                'af_model_id' => $ride->id
            ]);
            return back();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
