<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $ratings = Rating::all();
        return view('movie.create', compact('ratings','categories'));
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
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $movie->load('rating.images','categories','images');
        $locations = Cinema::select('location')->groupBy('location')->get();
        $cinemas = Cinema::all()->toJson();
        return view('movie-detail',compact('movie','locations','cinemas'));
    }

    /**
     * Display the movies is coming
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showMovieComing(Request $request) {
        $movies = Movie::with('categories','images')
                    ->where('release_at','>',Carbon::now())
                    ->get()
                    ->load(array('schedules' => function($query) {
                        $query->where('start_at','>=',Carbon::now());
                    }));
        return view('movie-coming',compact('movies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $movie->load("categories",'rating');
        $categories = Category::all();
        $ratings = Rating::all();
        return view('movie.edit', compact('movie','ratings','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
