<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Image;
use App\Models\Movie;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreMovieRequest $request)
    {
        $data = $request->only(
            [
                'release_date',
                'name',
                'director',
                'actor',
                'language',
                'length',
                'description',
                'rating_id',
                'categories',
                'trailer',
            ]);
        // pass the validate
        try {
            $movie = Movie::create([
                'release_at' => Carbon::parse($data['release_date']),
                'name' => $data['name'],
                'director' => $data['director'],
                'actor' => $data['actor'],
                'language' => $data['language'],
                'length' => $data['length'],
                'description' => $data['description'],
                'rating_id' => $data['rating_id'],
                'trailer' => $data['trailer'],
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
            foreach($data['categories'] as $category){
                $movie->categories()->attach([$category]);
            }
            $uploadFile = $request->file('image');
            $file_name = $uploadFile->hashName();
            $uploadFile->storeAs('public/image/movies', $file_name);
            $path = '/image/movies/'.$file_name;
            if(Image::insert([
                'imageable_id'=> $movie->id,
                'imageable_type' => 'App\Models\Movie',
                'path' => $path,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ])){
                return ['message','success'];
            }
            //if insert success
            return response()->json(['message', 'Something went wrong'], 422);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Movie $movie
     * @return Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        // pass the validate
        try {
            if($request->has('release_date')){
                $data['release_at'] = $request->release_date;
            }
            if($request->has('name')){
                $data['name'] = $request->name;
            }
            if($request->has('director')){
                $data['director'] = $request->director;
            }
            if($request->has('actor')){
                $data['actor'] = $request->actor;
            }
            if($request->has('language')){
                $data['language'] = $request->language;
            }
            if($request->has('length')){
                $data['length'] = $request->length;
            }
            if($request->has('description')){
                $data['description'] = $request->description;
            }
            if($request->has('rating_id')){
                $data['rating_id'] = $request->rating_id;
            }
            if($request->has('trailer')){
                $data['trailer'] = $request->trailer;
            }
            $movie->update($data);
            if($request->has('categories')){
                    $data['categories'] = $request->categories;
                }
            $movie->categories()->sync($data['categories']);
            if ($request->hasFile('image')){
                $image = Image::find($movie->images[0]->id);
                unlink('storage'.$image->path);
                Image::where("id", $image->id)->delete();
                $uploadFile = $request->file('image');
                $file_name = $uploadFile->hashName();
                $uploadFile->storeAs('public/image/movies', $file_name);
                $path = '/image/movies/'.$file_name;
                Image::insert([
                    'imageable_id'=> $movie->id,
                    'imageable_type' => 'App\Models\Movie',
                    'path' => $path,
                    "created_at" =>  Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
            }
            //if insert success
            return response()->json(['message','success'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return Response
     */
    public function destroy(Movie $movie)
    {
        $movie->schedules()->delete();
        return $movie->delete();
    }
}
