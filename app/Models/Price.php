<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Get the cinema that owns the Price
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
    
    protected $date = ['delete_at'];
}
