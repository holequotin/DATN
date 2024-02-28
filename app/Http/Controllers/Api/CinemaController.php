<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CinemaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cinema $cinema)
    {
        $cinema->load(array('schedules' => function($query) {
            $query->where('start_at','>=',Carbon::now()->subDays())->orderby('start_at')->orderby('play_time');
        }))->load('movies','images');
        $cinema->last_date = $cinema->schedules->max('start_at');
        $cinema->movies->load('images','rating.images');        
        foreach ($cinema->movies as $movie){
            $movie->schedules = $cinema->schedules->filter(function ($value) use($movie) {
                return $value->movie_id === $movie->id;
            });
        }
        return $cinema;
    }

    /**
     * Display movie's schedules in selected-cinema
     * @param int $cinema_id 
     * @param int $movie_id
     * @return \Illuminate\Http\Response
     */
    public function showScheduleOfMovieInCinema(Cinema $cinema,Movie $movie){
        $cinema->load(array('schedules' => function($query) use ($movie) {
            $query->where('start_at','>=',Carbon::now()->subDays())->where('movie_id',$movie->id)->orderby('start_at')->orderby('play_time');
        }))->load('movies','images');
        $cinema->last_date = $cinema->schedules->max('start_at');
        $cinema->movies->load('images','rating.images');        
        foreach ($cinema->movies as $movie){
            $movie->schedules = $cinema->schedules->filter(function ($value) use($movie) {
                return $value->movie_id === $movie->id;
            });
        }
        return $cinema;
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
