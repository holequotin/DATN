<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cinema;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\ScheduleSeat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement("SET foreign_key_checks=0");
        // DB::table('movies')->truncate();
        // DB::table('seat_schedule')->truncate();
        // DB::table('schedules')->truncate();
        // DB::table('category_movie')->truncate();
        // DB::table('images')->truncate();
        // DB::statement("SET foreign_key_checks=1");

        $categories = Category::all();
        Movie::factory(20)->create()->each(function($movie) use ($categories){
            Image::factory(1)->create([
                'imageable_id' => $movie->id,
                'imageable_type' => 'App\Models\Movie'
            ]);
            //seed categories_movies
            $attach = $categories->shuffle();
            for ($i=0; $i < rand(2,6); $i++) { 
                $movie->categories()->attach([
                    $attach[$i]->id
                ]);
            }

            //seed cinemas_schedule
            
            Cinema::all()->each(function($cinema) use ($movie){
                /*
                    add movie to cinema movies list
                */
                $cinema->movies()->attach($movie->id,['release_at' => $movie->release_at]);
                $faker = \Faker\Factory::create();
                $rooms = $cinema->rooms->toArray();
                /*
                    create schedule for each cinema with each movie
                    number: random between 15 and 20
                */
                for ($i=0; $i < rand(15,20); $i++) { 
                    $schedule = Schedule::create([
                        'cinema_id' =>$cinema->id,
                        'room_id' => $rooms[rand(0,count($rooms)-1)]['id'],
                        'movie_id' => $movie->id,
                        'start_at' => $faker->dateTimeInInterval($movie->release_at, '+1 week'),
                        'play_time' => $faker->time(),
                    ]);             
                /**
                 * create schedule for each seat
                 * with default status value is available
                 */
                    $seats = Room::find($schedule->room_id)->seats->toArray(); 
                    $schedule_seat = [];
                    for ($j=0; $j < count($seats); $j++) { 
                        array_push($schedule_seat,[
                            'schedule_id' => $schedule->id,
                            'seat_id' => $seats[$j]['id'],
                            'status' => 0,
                        ]); 
                    }      
                    DB::table('schedule_seat')->insert($schedule_seat);
                }
            });
        });
    }
}
