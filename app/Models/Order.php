<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the scheduleSeat that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scheduleSeat()
    {
        return $this->belongsToMany(ScheduleSeat::class,'order_seat','order_id','seat_schedule_id');
    }

    /**
     * Get the room te Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the movie te Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the cinema te Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cinema_id',
        'movie_id',
        'room_id',
        'date_order',
        'total_price',
        'amount_people',
        'show_at',
    ];

    protected $date = ['delete_at'];
}
