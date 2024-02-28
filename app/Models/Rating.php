<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Get all of the movies for the Rating
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    
    protected $date = ['delete_at'];
}
