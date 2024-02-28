<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->only(['cinema_id', 'room_id', 'movie_id', 'start_at', 'play_time']);
        // pass the validate
        try {
            Schedule::insert([
                'cinema_id' => $data['cinema_id'],
                'room_id' => $data['room_id'],
                'movie_id' => $data['movie_id'],
                'start_at' => $data['start_at'],
                'play_time' => $data['play_time'],
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
            //if insert success
            return ['message', 'success'];
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        try {
            $data = $schedule->toArray();
            if($request->has('start_at')){
                $data['start_at'] = $request->start_at;
            }
            if($request->has('play_time')){
                $data['play_time'] = $request->play_time;
            }
            $schedule->update([     
                'start_at' => $data['start_at'],
                'play_time' => $data['play_time'],
                "updated_at" => \Carbon\Carbon::now(),
            ]);
            return ['message', 'success'];
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        return $schedule->delete();
    }
}
