<?php

namespace App\Http\Requests;

use App\Rules\CheckUniqueUpdateLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $schedule = $this->route('schedule');
        return [
            'room_id' => 'required',
            'movie_id' => 'required',
            'start_at' => 'required',
            'play_time' => 'required',
            'cinema_id' => ['required', new CheckUniqueUpdateLocation($this,$schedule)],

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
