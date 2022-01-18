<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateDriverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.profile.view', [
            'data' => DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.profile.update', [
            'data' => DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, $email)
    {
        $role = auth()->user()->user_role;

        $validate = $request->validated();

        $model = [
            'admin' => new \App\Models\Admin(),
            'driver' => new \App\Models\Driver(),
            'passenger' => new \App\Models\Passenger(),
        ][$role];

        $find = [
            'admin' => $model::where('email', $email)->get()->all()[0],
            'driver' => $model::where('email', $email)->get()->all()[0],
            'passenger' => $model::where('email', $email)->get()->all()[0],
        ][$role];

        $user = $model::find($find->id);

        // filter inputs
        $filter_request = array_filter($validate, function ($value) {
            return $value != null || $value != '';
        });

        foreach ($filter_request as $key => $value) {
            $user->$key = $value;
            if ($key == 'driver_license') {
                $user->driver_license = Str::substr($request->file('driver_license')->store('public/DriverLicenses'), 6);
            }
        }

        DB::beginTransaction();
        try {
            // updates user_types model
            $user->save();

            // update user model
            ManualEvent::UpdateUser($filter_request, $email);

            DB::commit();
            return view('pages.profile.view', [
                'data' => DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]
            ])->with('success', 'تم تحديث البيانات بنجاح');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
