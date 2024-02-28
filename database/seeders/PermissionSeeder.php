<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //movie permission
        \App\Models\Permission::insert([
            'name' => "view movies"
        ]);
        \App\Models\Permission::insert([
            'name' => "view movie"
        ]);
        \App\Models\Permission::insert([
            'name' => "update movie"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete movie"
        ]);
        \App\Models\Permission::insert([
            'name' => "add movie"
        ]);
        //cinema
        \App\Models\Permission::insert([
            'name' => "view cinemas"
        ]);
        \App\Models\Permission::insert([
            'name' => "view cinema"
        ]);
        \App\Models\Permission::insert([
            'name' => "update cinema"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete cinema"
        ]);
        \App\Models\Permission::insert([
            'name' => "add cinema"
        ]);
        //room
        \App\Models\Permission::insert([
            'name' => "view rooms"
        ]);
        \App\Models\Permission::insert([
            'name' => "view room"
        ]);
        \App\Models\Permission::insert([
            'name' => "update room"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete room"
        ]);
        \App\Models\Permission::insert([
            'name' => "add room"
        ]);
        //seat
        \App\Models\Permission::insert([
            'name' => "view seats"
        ]);
        \App\Models\Permission::insert([
            'name' => "view seat"
        ]);
        \App\Models\Permission::insert([
            'name' => "update seat"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete seat"
        ]);
        \App\Models\Permission::insert([
            'name' => "add seat"
        ]);
        //order
        \App\Models\Permission::insert([
            'name' => "view orders"
        ]);
        \App\Models\Permission::insert([
            'name' => "view order"
        ]);
        \App\Models\Permission::insert([
            'name' => "update order"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete order"
        ]);
        \App\Models\Permission::insert([
            'name' => "add order"
        ]);
        \App\Models\Permission::insert([
            'name' => "view self orders"
        ]);
        \App\Models\Permission::insert([
            'name' => "view self order"
        ]);
        // schedule
        \App\Models\Permission::insert([
            'name' => "view schedules"
        ]);
        \App\Models\Permission::insert([
            'name' => "view schedule"
        ]);
        \App\Models\Permission::insert([
            'name' => "update schedule"
        ]);
        \App\Models\Permission::insert([
            'name' => "delete schedule"
        ]);
        \App\Models\Permission::insert([
            'name' => "add schedule"
        ]);
    }
}
