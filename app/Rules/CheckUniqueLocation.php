<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Schedule;

class CheckUniqueLocation implements Rule
{
    /**
     * Store all request attribute
     */
    public $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
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
        if (Schedule::where('cinema_id', $this->request->cinema_id)
            ->where('room_id', $this->request->room_id)
            ->where('start_at', $this->request->start_at)
            ->where('play_time', $this->request->play_time)->first()
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
        return 'Đã có phim được chiếu vào cùng thời gian và địa điểm được chọn';
    }
}
