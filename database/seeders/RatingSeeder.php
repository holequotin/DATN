<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ratings')->insert([
            'name' => "P",
            'detail' => "Thích hợp cho mọi độ tuổi",
        ]);        
        Image::create([
            'imageable_id' => 1,
            'imageable_type' => 'App\Models\Rating',
            'path' => 'image/rated/rated_P.png',
        ]);

        DB::table('ratings')->insert([
            'name' => "C13",
            'detail' => "Cấm người dưới 13 tuổi",
        ]);
        Image::create([
            'imageable_id' => 2,
            'imageable_type' => 'App\Models\Rating',
            'path' => 'image/rated/rated_C13.png',
        ]);

        DB::table('ratings')->insert([
            'name' => "C16",
            'detail' => "Cấm người dưới 16 tuổi",
        ]);
        Image::create([
            'imageable_id' => 3,
            'imageable_type' => 'App\Models\Rating',
            'path' => 'image/rated/rated_C16.png',
        ]);

        DB::table('ratings')->insert([
            'name' => "C18",
            'detail' => "Cấm người dưới 18 tuổi",
        ]);
        Image::create([
            'imageable_id' => 4,
            'imageable_type' => 'App\Models\Rating',
            'path' => 'image/rated/rated_C18.png',
        ]);
    }
}
