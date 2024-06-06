<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
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
        $movies = Movie::where('release_at', '>=', Carbon::now()->subDays(Schedule::LONGEST_PERIOD))->get();
        if (Auth::user()->role_id == User::ROLE_MANAGER) {
            $cinemas = Cinema::find(Auth::user()->cinema_id);
            $cinemas->load('rooms');
            $cinemas = [$cinemas];
        } else if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $cinemas = Cinema::get();
            $cinemas->load('rooms');
        } else return redirect(route('home'));
        //load calendar
        $calendars = [];
        foreach ($cinemas as $cinema) {
            foreach ($cinema->rooms as $room) {
                $calendars[$room->id] = [];
                $schedules = Schedule::where('room_id', $room->id)->get();
                foreach ($schedules as $schedule) {
                    $title = $schedule->movie->name;
                    $start = Carbon::parse($schedule->start_at . ' ' . $schedule->play_time);
                    $end = $start->clone()->addMinutes($schedule->movie->length);
                    $calendars[$room->id][] = [
                        'title' => $title,
                        'start' => (string)$start,
                        'end' => (string)$end,
                    ];
                }
            }
        }
        return view('schedule.create', compact('movies', 'cinemas', 'calendars'));
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
        $scheduleRooms = Schedule::where('room_id', $schedule->room_id)->get();

        $calendars = [];

        foreach ($scheduleRooms as $scheduleRoom) {
            $title = $scheduleRoom->movie->name;
            $start = Carbon::parse($scheduleRoom->start_at . ' ' . $scheduleRoom->play_time);
            $end = $start->clone()->addMinutes($scheduleRoom->movie->length);
            $event = [
                'title' => $title,
                'start' => (string)$start,
                'end' => (string)$end,
            ];
            if ($scheduleRoom->id == $schedule->id) {
                $event['color'] = '#E4080A';
            }
            $calendars[] = $event;
        }
        $schedule->load('movie', 'cinema', 'room');
        return view('schedule.edit', compact('schedule', 'calendars'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Schedule $schedule
     * @return Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        try {
            $data = $schedule->toArray();
            if ($request->has('start_at')) {
                $data['start_at'] = $request->start_at;
            }
            if ($request->has('play_time')) {
                $data['play_time'] = $request->play_time;
            }
            $schedule->update([
                'start_at' => $data['start_at'],
                'play_time' => $data['play_time'],
                "updated_at" => Carbon::now(),
            ]);
            return redirect(route('schedule.edit', ['schedule' => $schedule->id]))->with('alert', ['message' => 'Chỉnh sửa lịch thành công', 'type' => 'success']);
        } catch (Exception $e) {
            return redirect(route('schedule.edit', ['schedule' => $schedule->id]))->with('alert', ['message' => $e->getMessage(), 'type' => 'error']);
        }
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
