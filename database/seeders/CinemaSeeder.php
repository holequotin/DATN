<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Image;
use App\Models\Movie;
use App\Models\Price;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table('cinemas')->insert([
            [
                'name' => 'CGV Vĩnh Trung Plaza',
                'location' => 'Đà Nẵng',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Vincom Đà Nẵng',
                'location' => 'Đà Nẵng',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Hồ Gươm Plaza',
                'location' => 'Hà Nội',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Mac Plaza (Machinco)',
                'location' => 'Hà Nội',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Vincom Nguyễn Chí Thanh',
                'location' => 'Hà Nội',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Hùng Vương Plaza',
                'location' => 'HCM',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Vincom Center Landmark 81',
                'location' => 'HCM',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Vincom Thủ Đức',
                'location' => 'HCM',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Crescent Mall',
                'location' => 'HCM',
                'address' => $faker->address,
                'fax' => '+84 (8)'.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
            [
                'name' => 'CGV Lam Sơn Square',
                'location' => 'Bà Rịa-Vũng Tàu',
                'address' => $faker->address,
                'fax' => '+84 (8) '.rand(10000000,99999999),
                'phone' => '0'.strval(rand(100000000,999999999))
            ],
        ]);
     
        $cinemas = Cinema::all();
        $cinemas->each(function($cinema){
            User::factory(1)->create([
                'role_id' => User::ROLE_MANAGER,
                'cinema_id' => $cinema->id,
            ]);

            for ($i=1; $i < rand(5,8); $i++) { 
                Room::create([
                    'cinema_id' => $cinema->id,
                    'name' => $cinema->name." ".$i,
                ]);
            }
            Price::create([
                'cinema_id' => $cinema->id,
                'price' => rand(8,10)*0.1,
            ]);
            Image::create([
                'imageable_id' => $cinema->id,
                'imageable_type' => 'App\Models\Cinema',
                'path' => 'image/cinemas/'.$cinema->id.'.png'
            ]);
        });
    }
}
