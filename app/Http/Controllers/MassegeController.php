<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Support\Facades\DB;

class MassegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get my id
        $my_id = DB::table(auth()->user()->user_role . 's')->where('email', auth()->user()->email)->get()->all()[0]->id;

        // should display all related messages depends on user role from reserve table using ride id
        $ride = new \App\Models\Ride();
        $message = new Message();

        switch (auth()->user()->user_role) {
            case 'passenger':
                // get the rides id's
                $messages = $message::where('passenger_id', $my_id)->get()->all();

                return view('pages.messages.index', [
                    'data' => collect($messages)->sortByDesc('created_at')
                ]);

                break;
            case 'driver':
                $rides_ids = collect($ride::where('driver_id', $my_id)->get()->all())->pluck('id');

                $messages = $message::whereIn('ride_id', $rides_ids)->get()->all();

                return view('pages.messages.index', [
                    'data' => collect($messages)->sortByDesc('created_at')
                ]);
                break;
        }
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
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        $message = new \App\Models\Message();

        // get form request
        $validate = $request->validated();

        // filter validated request
        $filter_request = array_filter($validate, function ($item) {
            return $item != null || $item != '';
        });

        foreach ($filter_request as $key => $value) {
            $message->$key = $value;
        }

        try {
            $message->save();
            return back()->with('success', 'تم إضافة الرسالة بنجاح');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
