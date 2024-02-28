@extends('layouts.app')

@section('content')
<div class="container">
    <form enctype="multipart/form-data" id="edit-movie">
        @csrf
        <input type="hidden" id="method" name="_method" value="PUT">
        <!-- Movie Info -->
        <div class="row mb-3">
            <label for="release_date" class="col-md-4 col-form-label text-md-end">{{ __('Ngày phát hành:') }}</label>
            <div class="col-md-6">
                <input id="release_day_input" name="release_date" type="date" class="form-control">
                <div id="release_date"></div>
            </div>
        </div>
        <!-- Movie's Name -->
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Tên phim:') }}</label>
            <div class="col-md-6">
                <input id="name_input" name="name" type="text" class="form-control" value="{{$movie->name}}">
                <div id="name"></div>
            </div>
        </div>
        <!-- Movie's Director -->
        <div class="row mb-3">
            <label for="director" class="col-md-4 col-form-label text-md-end">{{ __('Tên đạo diễn:') }}</label>
            <div class="col-md-6">
                <input id="director_input" name="director" type="text" class="form-control" value="{{$movie->director}}">
                <div id="director"></div>
            </div>
        </div>
        <!-- Movie's Actor -->
        <div class="row mb-3">
            <label for="actor" class="col-md-4 col-form-label text-md-end">{{ __('Tên diễn viên chính:') }}</label>
            <div class="col-md-6">
                <input id="actor_input" name="actor" type="text" class="form-control" value="{{$movie->actor}}">
                <div id="actor"></div>
            </div>
        </div>
        <!-- Movie's language -->
        <div class="row mb-3">
            <label for="language" class="col-md-4 col-form-label text-md-end">{{ __('Ngôn ngữ chính:') }}</label>
            <div class="col-md-6">
                <input name="language" type="text" class="form-control" value="{{$movie->language}}">
                <div id="language"></div>
            </div>
        </div>
        <!-- Movie's Description -->
        <div class="row mb-3">
            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Mô tả:') }}</label>
            <div class="col-md-6">
                <input id="description_input" name="description" type="text" class="form-control" value="{{$movie->description}}">
                <div id="description"></div>
            </div>
        </div>
        <!-- Movie's Rating -->
        <div class="row mb-3">
            <label for="rating_id" class="col-md-4 col-form-label text-md-end">{{ __('Phân loại:') }}</label>
            <div class="col-md-6">
                <select id="rating_input" class="form-control" name="rating_id" value="{{$movie->rating->id}}">
                    @foreach ($ratings as $rating)
                    @if($movie->rating->id === $rating->id)
                    <option id="{{ $loop->index }}" value="{{$rating->id}}" selected="selected">
                    @else
                    <option id="{{ $loop->index }}" value="{{$rating->id}}">
                    @endif
                        {{$rating->name}}
                    </option>
                    @endforeach
                </select>
                <div id="rating_id"></div>
            </div>
        </div>
        <!-- Movie's Categories -->
        <div class="row mb-3">
            <label id="categories_label" for="categories" class="col-md-4 col-form-label text-md-end">{{ __('Thể loại:') }}</label>
            <div class="col-md-6">
                <ul class="form-control d-flex flex-wrap" name="categories_id" style="height: auto;">
                    @foreach ($categories as $category)
                    <li class="p-2">
                        @if($movie->categories->contains('id',$category->id))
                        <input type="checkbox" value="{{$category->id}}" title="{{$category->detail}}" checked>
                        @else
                        <input type="checkbox" value="{{$category->id}}" title="{{$category->detail}}">
                        @endif
                        <span title="{{$category->detail}}">{{$category->name}}</span>
                    </li>
                    @endforeach
                </ul>
                <div id="categories"></div>
            </div>
        </div>
        <!-- Movie's Lenght in minute -->
        <div class="row mb-3">
            <label for="length" class="col-md-4 col-form-label text-md-end">{{ __('Thời lượng:') }}</label>
            <div class="col-md-6">
                <input id="length_input" name="length" type="number" min="20" max="300" class="form-control" value="{{$movie->length}}">
                <div id="length"></div>
            </div>
        </div>
        <!-- Movie's Trailer link -->
        <div class="row mb-3">
            <label for="trailer" class="col-md-4 col-form-label text-md-end">{{ __('Đường dẫn đến trailer:') }}</label>
            <div class="col-md-6">
                <input name="trailer" type="url" class="form-control" value="{{$movie->trailer}}">
                <div id="trailer"></div>
            </div>
        </div>
        <!-- Movie's Poster -->
        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Ảnh minh họa:') }}</label>
            <div class="col-md-6">
                <img src="{{asset('storage/'.$movie->images[0]->path)}}" class="img-thumbnail w-25">
                <input name="image" type="file" class="form-control">
                <div id="image"></div>
            </div>
        </div>
        <!-- error message -->
        <div class="row mb-3">
            <div class="col-md-6" id="error-list">
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" onclick="edit()">
                    {{ __('Sửa thông tin phim') }}
                </button>
                <button type="button" class="btn btn-primary" onclick="cancle()">
                    {{ __('Hủy phim') }}
                </button>
            </div>
        </div>
    </form>
    <form id="delete-movie">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
    </form>
</div>
<script>
    //initial
    var release_date = document.getElementById('release_day_input');
    var date = new Date(<?php echo json_encode($movie->release_at) ?>);
    release_date.valueAsDate = date;
    //Check release date
    if (date <= Date.now()) {
        var name_input = document.getElementById('name_input');
        var director = document.getElementById('director_input');
        var actor = document.getElementById('actor_input');
        var description = document.getElementById('description_input');
        var lenght = document.getElementById('length_input');
        release_date.readOnly = true;
        name_input.readOnly = true;
        director.readOnly = true;
        actor.readOnly = true;
        description.readOnly = true;
        lenght.readOnly = true;
        var error = document.getElementById("release_date");
        var detail = document.createElement('p');
        detail.setAttribute('class', 'error text-danger');
        detail.innerHTML = 'Phim đã được công chiếu, không thể thay đổi thông tin liên quan';
        error.appendChild(detail);
    } else {
        const today = new Date();
        release_date.setAttribute('min', today.toISOString().split("T")[0]);
    }
    //send edit api
    async function edit() {
        var form = new FormData(document.getElementById("edit-movie"));
        var categories = document.querySelectorAll('input:checked').forEach((element, index) => {
            form.append('categories[' + index + ']', element.value);
        });
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('movie.update',[$movie->id])}}", true);
        xhr.onload = await

        function() {
            var announce = document.getElementById("error-list")
            announce.setAttribute('class', "col-md-6")
            announce.innerHTML = "";
            data = JSON.parse(this.responseText);
            console.log(data);
            var error_list = document.querySelectorAll('.error');
            error_list.forEach(item => {
                item.remove();
            });
            //success
            if (xhr.status === 200) {
                alert("Đã đăng ký lịch chiếu thành công!");
                window.location.href = "{{route('home')}}"
            }
            //if receive error
            else {
                errors = JSON.parse(this.responseText);
                for (let error in errors) {
                    displayError(error, errors[error])
                }
            }
        }
        xhr.send(form)
    }
    //send delete API
    async function cancle() {
        var form = new FormData(document.getElementById("delete-movie"));
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('movie.destroy',[$movie->id])}}", true);
        xhr.onload = await

        function() {
            var error = document.getElementById("error-list")
            var data = JSON.parse(this.responseText);
            console.log(data)
            error.setAttribute('class', "col-md-6")
            error.innerHTML = "";
            //success
            if (xhr.status === 200) {
                alert("Đã hủy phim thành công!");
                window.location.href = "{{route('home')}}";
            }
            //if receive error
            else {
                data = JSON.parse(this.responseText);
                error.setAttribute('class', "alert alert-danger col-md-6")
                //Display error
                error.innerHTML = data.message;
            }
        }
        xhr.send(form)
    }

    function displayError(name, content) {
        console.log(name, content)
        var error = document.getElementById(name);
        detail = document.createElement('p');
        detail.setAttribute('class', 'error text-danger');
        detail.innerHTML = content;
        error.appendChild(detail);

    }
</script>
@endsection