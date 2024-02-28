<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Get the cinema that owns the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Get all of the seats for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Get all of the orders for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    protected $date = ['delete_at'];
}
