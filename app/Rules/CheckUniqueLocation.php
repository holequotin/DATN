<?php

namespace App\Rules;

use App\Models\Movie;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

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
        $isConflict = false;
        //get movie
        $movie = Movie::findOrFail($this->request->movie_id);
        //get schedule in day
        $schedules = Schedule::where('cinema_id', $this->request->cinema_id)
            ->where('room_id', $this->request->room_id)
            ->where('start_at', $this->request->start_at)
            ->get();
        foreach ($schedules as $schedule) {
            $scheduleMovie = Movie::find($schedule->movie_id);
            $scheduleStartTime = Carbon::parse($schedule->play_time);
            $scheduleEndTime = $scheduleStartTime->clone()->addMinutes($scheduleMovie->length);

            $newScheduleStartTime = Carbon::parse($this->request->play_time);
            $newScheduleEndTime = $newScheduleStartTime->clone()->addMinutes($movie->length);

            $isConflict = $newScheduleStartTime->between($scheduleStartTime, $scheduleEndTime) || $newScheduleEndTime->between($scheduleStartTime, $scheduleEndTime) || ($newScheduleStartTime->lessThan($scheduleStartTime) && $newScheduleEndTime->greaterThan($scheduleEndTime));

            if ($isConflict) {
                break;
            }
        }
        return !$isConflict;
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
