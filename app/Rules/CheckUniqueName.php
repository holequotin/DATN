<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Movie;

class CheckUniqueName implements Rule
{
    /**
     * Store all request attribute
     */
    public $movie;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Movie::where('id','!=', $this->movie->id)
            ->where('name', $value)->first()
        ) {
            return false;
        };
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hãy nhập tên bộ phim không trùng với những bộ phim đã phát hành';
    }
}
