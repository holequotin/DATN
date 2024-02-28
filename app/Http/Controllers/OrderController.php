<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Order;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\countOf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $user->load('orders.scheduleSeat.seat');
        for ($i=0; $i < count($user->orders); $i++) { 
            $user->orders[$i]->cinema = Cinema::find($user->orders[$i]->cinema_id);
            $user->orders[$i]->movie = Movie::find($user->orders[$i]->movie_id)->load('images');
            $user->orders[$i]->room = Room::find($user->orders[$i]->room_id);
        }
        
        $orders = $user->orders;
        
        for ($i=0; $i < $orders->count(); $i++) { 
            $seats = "";
            for ($j=0; $j < $orders[$i]->scheduleSeat->count(); $j++) { 
                $seats .= $orders[$i]->scheduleSeat[$j]->seat->name.' ';
            }
            $orders[$i]->seats = $seats;
        }   

        return view('order.order-list',compact('orders'));
        // dd($orders->toArray());
        //
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
     * Choose seat for selected-movie
     * 
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function chooseSeat(Schedule $schedule){
        $available_seat = 0;
        $row_seat = [];
        $row_seat_name = "";

        $schedule->load(array('seats' => function($query){
            $query->orderBy('name');
        }));
        $schedule->cinema = Cinema::find($schedule->cinema_id)->load('prices');
        $schedule->movie = Movie::find($schedule->movie_id)->load('images','rating');
        $schedule->room = Room::find($schedule->room_id);
        for ($i=0; $i < count($schedule->seats); $i++) { 
            if ($schedule->seats[$i]->pivot->status == 0){
                $available_seat++;
            }
            if ($row_seat_name != substr($schedule->seats[$i]->name,0,1)){
                $row_seat_name = substr($schedule->seats[$i]->name,0,1);
                array_push($row_seat,$row_seat_name);
            }
        }
        $schedule->available_seat = $available_seat;
        $schedule->row_seat = $row_seat;
        $schedule->price_rate = $schedule->cinema->prices[0]->price;
        return view('choose-seat',compact('schedule'));
    }

    /**
     * Display order-detail
     * @param \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function payment(Schedule $schedule,Request $request){
        $schedule->load('cinema','movie.images','room');
        $seats = "";
        for ($i=0; $i < count($request->seat); $i++) { 
            if ($request->seat[$i] != ""){
                $seats .= $request->seat[$i]." ";
            }
        }
        $seats_id = "";
        for ($i=0; $i < count($request->seats_id); $i++) { 
            if ($request->seats_id[$i] != ""){
                $seats_id .= $request->seats_id[$i]." ";
            }
        }
        $price = $request->price;
        return view('payment',compact('schedule','seats','seats_id','price'));
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cinemaIndex()
    {
        $cinema = Cinema::find(Auth::user()->cinema_id);
        $cinema->load('rooms');
        $cinema->rooms->load('orders.movie.images','orders.cinema','orders.user','orders.scheduleSeat.seat');
        // dd($cinema->toArray());
        return view('order.cinema_view',compact('cinema'));
    }
}
