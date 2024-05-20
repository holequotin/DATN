<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckAfterCurrent implements Rule
{
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date = Carbon::parse($this->request->start_at);
        return $date > Carbon::today() || ($date->isToday() && Carbon::parse($value)->greaterThan(Carbon::parse(Carbon::now()->toTimeString())));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Thời gian chiếu phải trễ hơn bây giờ.';
    }
}
