<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $movies = Movie::where('release_at','>=',Carbon::now()->subDays(Schedule::LONGEST_PERIOD))->get();
        if(Auth::user()->role_id==User::ROLE_MANAGER){
            $cinemas = Cinema::find(Auth::user()->cinema_id);
        }
        else if(Auth::user()->role_id==User::ROLE_ADMIN){
            $cinemas = Cinema::get();
        }
        else return redirect(route('home'));
        $cinemas->load('rooms');
        return view('schedule.create', compact('movies','cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
            //if insert success
            return redirect()->back()->with('alert', ['type' => 'success', 'message' => 'Đăng kí lịch thành công']);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function edit(Schedule $schedule)
    {
        $schedule->load('movie','cinema','room');
        return view('schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Schedule $schedule
     * @return Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
