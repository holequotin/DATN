@extends('layouts.app')

@section('content')
<div class="container">
    <form enctype="multipart/form-data" id="add-movie">
        @csrf
        <!-- Movie Info -->
        <div class="row mb-3">
            <label for="release_date" class="col-md-4 col-form-label text-md-end">{{ __('Ngày phát hành:') }}</label>
            <div class="col-md-6">
                <input id="release_day_input" name="release_date" type="date" class="form-control">
                <div id="release_date"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên phim:') }}</label>
            <div class="col-md-6">
                <input name="name" type="text" class="form-control">
                <div id="name"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="director" class="col-md-4 col-form-label text-md-end">{{ __('Tên đạo diễn:') }}</label>
            <div class="col-md-6">
                <input name="director" type="text" class="form-control">
                <div id="director"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="actor" class="col-md-4 col-form-label text-md-end">{{ __('Tên diễn viên chính:') }}</label>
            <div class="col-md-6">
                <input name="actor" type="text" class="form-control">
                <div id="actor"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="language" class="col-md-4 col-form-label text-md-end">{{ __('Ngôn ngữ chính:') }}</label>
            <div class="col-md-6">
                <input name="language" type="text" class="form-control">
                <div id="language"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Mô tả:') }}</label>
            <div class="col-md-6">
                <input name="description" type="text" class="form-control">
                <div id="description"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="rating_id" class="col-md-4 col-form-label text-md-end">{{ __('Phân loại:') }}</label>
            <div class="col-md-6">
                <select class="form-control" name="rating_id">
                    @foreach ($ratings as $rating)
                    <option id="{{ $loop->index }}" value="{{$rating->id}}">
                        {{$rating->name}}
                    </option>
                    @endforeach
                </select>
                <div id="rating_id"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label id="categories_label" for="categories" class="col-md-4 col-form-label text-md-end">{{ __('Thể loại:') }}</label>
            <div class="col-md-6">
                <ul class="form-control d-flex flex-wrap" name="categories_id" style="height:auto">
                    @foreach ($categories as $category)
                    <li class="p-2">
                        <input type="checkbox" value="{{$category->id}}" title="{{$category->detail}}">
                        <span title="{{$category->detail}}">{{$category->name}}</span>
                    </li>
                    @endforeach
                </ul>
                <div id="categories"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Thời lượng:') }}</label>
            <div class="col-md-6">
                <input name="length" type="number" min="20" max="300" class="form-control">
                <div id="length"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="trailer" class="col-md-4 col-form-label text-md-end">{{ __('Đường dẫn đến trailer:') }}</label>
            <div class="col-md-6">
                <input name="trailer" type="url" class="form-control">
                <div id="trailer"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Ảnh minh họa:') }}</label>
            <div class="col-md-6">
                <input name="image" type="file" class="form-control">
                <div id="image"></div>
            </div>
        </div>
        <!-- error message -->
        <div class="row mb-3">
            <div class="col-md-6" id="error-list">
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" onclick="finish()">
                    {{ __('Thêm phim') }}
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    //initial
    var release_date = document.getElementById('release_day_input');
    const today = new Date();
    release_date.setAttribute('min', today.toISOString().split("T")[0]);
    //send api
    async function finish() {
        var form = new FormData(document.getElementById("add-movie"));
        var categories = document.querySelectorAll('input:checked').forEach((element,index) => {
            form.append('categories['+index+']',element.value);
        });
        // // Display the key/value pairs
        // for (var pair of form.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('movie.store')}}", true);
        xhr.onload = await

        function() {
            var announce = document.getElementById("error-list")
            announce.setAttribute('class', "col-md-6")
            announce.innerHTML = "";
            var error_list = document.querySelectorAll('.error');
            error_list.forEach(item => {
                item.remove();
            });
            //success
            if (xhr.status === 200) {
                alert("Đã đăng ký lịch chiếu thành công!");
                window.location.href = "{{route('movie-coming')}}"
            }
            //if receive error
            else {
                errors = JSON.parse(this.responseText);
                console.log(errors);
                for(let error in errors)
                {
                    displayError(error,errors[error])
                }
            }
        }
        xhr.send(form)
    }
    function displayError(name,content){
        console.log(name,content)
        var error = document.getElementById(name);
        detail = document.createElement('p');
        detail.setAttribute('class','error text-danger');
        detail.innerHTML = content;
        error.appendChild(detail);

    }
</script>
@endsection