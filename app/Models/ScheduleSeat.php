<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ScheduleSeat extends Pivot
{
    /**
     * Get all of the orders for the ScheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BeLongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Get the seat that owns the ScheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
