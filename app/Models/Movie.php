<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'release_at',
        'name',
        'director',
        'actor',
        'language',
        "length",
        "description",
        "rating_id",
        "trailer",
        "created_at",
        "updated_at",
    ];

    /**
     * Get the rating that owns the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    /**
     * The categories that belong to the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The cinemas that belong to the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    
    protected $date = ['delete_at'];
}
