<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\ScheduleSeat;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $cinema_id = $request->cinema_id;
        $movie_id = $request->movie_id;
        $room_id = $request->room_id;
        $total_price = substr($request->total_price,0,strlen($request->total_price)-4);
        $amount_people = count(explode(" ",$request->seats));
        $show_at = $request->show_at;
        try {
            // store order
            $order = Order::create([
                'user_id' => $user_id,
                'movie_id' => $movie_id,
                'cinema_id' => $cinema_id,
                'room_id' => $room_id,
                'date_order' => Carbon::now(),
                'total_price' => $total_price,
                'amount_people' => $amount_people,
                'show_at' => Carbon::create($show_at),
            ]);

            $schedule_id = $request->schedule_id;

            // set status of seat to 1(booked)
            $seats_id = explode(" ",$request->seats_id);
            ScheduleSeat::where('schedule_id',$schedule_id)->whereIn('seat_id',$seats_id)->update(['status' => 1]);
            
            $schedule_seat_id = [];
            for ($i=0; $i < count($seats_id); $i++) { 
                $schedule_seat = ScheduleSeat::where('schedule_id',$schedule_id)->where('seat_id',$seats_id[$i])->get();
                array_push($schedule_seat_id,$schedule_seat[0]->id);
            }
            for ($i=0; $i < count($schedule_seat_id); $i++) { 
                $order->scheduleSeat()->attach([
                    'seat_schedule_id' => $schedule_seat_id[$i],
                ]);
            }

            //if insert success
            return ['message', 'success'];
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
