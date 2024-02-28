<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMovieRequest extends FormRequest
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
            'release_date' => 'required|date|after_or_equal:now',
            'name' => 'required|unique:movies,name',
            'director' => 'required',
            'actor' => 'required',
            'language' => 'required',
            'length' => 'required|numeric|min:20|max:300',
            'description' => 'required',
            'rating_id' => 'required',
            'categories' => 'required|array|min:2|max:10',
            'trailer' => 'required|url',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ];
    }
    /**
     * custom Message
     */
    public function messages(){
            return [
                'release_date.required' => 'Hãy điền thông tin ngày phát hành phim',
                'release_date.date' => 'Hãy điền thông tin có dạng tháng/ngày/năm',
                'release_date.after_or_equal'=>'Vui lòng nhập ngày phát hành trễ hơn hôm nay',
                'name.required'  => 'Hãy nhập tên bộ phim',
                'name.unique'  => 'Hãy nhập tên bộ phim không trùng với những bộ phim đã phát hành',
                'director.required'  => 'Hãy nhập tên đạo diễn của bộ phim',
                'actor.required'  => 'Hãy nhập tên diễn viên chính tên bộ phim',
                'language.required'  => 'Hãy nhập ngôn ngữ chính của bộ phim',
                'length.required'  => 'Hãy nhập độ dài bộ phim',
                'length.numberic'  => 'Hãy nhập độ dài bộ phim ở dạng số nguyên',
                'length.min'  => 'Độ dài ngắn nhất của một bộ phim là 20 phút',
                'length.max'  => 'Một bộ phim chỉ nên dài nhất là 5 tiếng (300 phút)',
                'description.required'  => 'Hãy nhập mô tả của bộ phim',
                'rating_id.required'  => 'Hãy chọn phân loại phim',
                'categories.required'  => 'Hãy chọn thể loại của bộ phim',
                'categories.array'  => 'Thể loại của bộ phim nên được gửi dưới dạng 1 mảng',
                'categories.min'  => 'Hãy chọn ít nhất 2 thể loại của bộ phim',
                'categories.max'  => 'Một bộ phim chỉ có nhiều nhất 10 thể loại',
                'trailer.required'  => 'Hãy nhập đường dẫn đến video trailer của bộ phim',
                'trailer.url'  => 'Hãy nhập đường dẫn hợp lệ',
                'image.required'  => 'Hãy chọn một poster của bộ phim',
                'image.image'  => 'Hãy chọn một ảnh hợp lệ',
                'image.mimes'  => 'Hãy chọn một ảnh có đuôi là jpg,png,jpeg,gif,svg',
            ];
    }

    /**
     * return message when validate failed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
