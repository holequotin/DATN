<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The schedules that belong to the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }

    /**
     * Get the room that owns the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    protected $date = ['delete_at'];

    /**
     * Get all of the schedule_seat for the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule_seats()
    {
        return $this->hasMany(ScheduleSeat::class);
    }
}
