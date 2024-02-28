<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::insert([
            'name' => "Customer"
        ]);
        \App\Models\Role::insert([
            'name' => "Manager"
        ]);
        \App\Models\Role::insert([
            'name' => "Admin"
        ]);

        $customer = \App\Models\Role::find(1);
        $customer->permissions()->attach([
            //movie
            1, 2, 
            //cinema
            6, 7, 
            //room
            11, 12,
            //seat 
            16, 17,
            //order 
            25, 26, 27,
            //schedule
            28, 29,
        ]);

        $manager = \App\Models\Role::find(2);
        $manager->permissions()->attach([
            //movie
            1, 2,
            //cinema
            6, 7, 
            //room
            11, 12, 13, 14, 15,
            //seat
            16, 17, 18, 19, 20,
            //order
            21, 22,
            //schedule
            28, 29, 30, 31, 32
        ]);
    
        $admin = \App\Models\Role::find(3);
        $admin->permissions()->attach([
            //movie
            1, 2, 3, 4, 5,
            //cinema
            6, 7, 8, 9, 10,
            //room
            11, 12,
            //seat
            16, 17,
            //order
            21, 22, 23, 24,
            //schedule
            28, 29, 30, 31, 32
        ]);
    }
}
