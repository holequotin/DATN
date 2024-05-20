<?php

namespace App\Http\Requests;

use App\Rules\CheckAfterCurrent;
use App\Rules\CheckUniqueLocation;
use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
        return [
            'room_id' => ['required'],
            'movie_id' => ['required'],
            'start_at' => ['required', 'after_or_equal:today'],
            'play_time' => ['required', new CheckAfterCurrent($this)],
            'cinema_id' => ['required', new CheckUniqueLocation($this)]
        ];
    }
//    protected function failedValidation(Validator $validator)
//    {
//        throw new HttpResponseException(response()->json($validator->errors(), 422));
//    }
}
