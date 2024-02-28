<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Room::all()->each(function($room){
            for ($i=0; $i < 5; $i++) { 
                for ($j='A'; $j < 'C'; $j++) { 
                    \App\Models\Seat::insert([
                        [
                            'room_id' => $room->id,
                            'name' => $j.($i+1),        
                        ]
                    ]);
                }
            }
            // for ($i=0; $i < 16; $i++) { 
            //     \App\Models\Seat::insert([
            //         [
            //             'room_id' => $room->id,
            //             'name' => 'K'.($i+1),        
            //         ]
            //     ]);
            // }
        });
    }
}
