<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory,SoftDeletes;
    const LONGEST_PERIOD = 5;
    protected $fillable = [
        'cinema_id',
        'room_id',
        'movie_id',
        'start_at',
        'play_time',
        "created_at",
        "updated_at",
    ];

    /**
     * The seats that belong to the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seats()
    {
        return $this->belongsToMany(Seat::class)->withPivot('status');
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    protected $date = ['delete_at'];
}
