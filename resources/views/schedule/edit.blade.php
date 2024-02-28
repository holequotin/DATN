@extends('layouts.app')

@section('content')
<div class="container">
    <form enctype="multipart/form-data" action="" id="edit-schedule">
        @csrf
        <input type="hidden" id="method" name="_method" value="PUT">
        <!-- Cinema Info -->
        <div class="row mb-3">
            <label for="cinema" class="col-md-4 col-form-label text-md-end">{{ __('Rạp:') }}</label>
            <div class="col-md-6">
                <input type="hidden" name="cinema_id" id="cinema_id" readonly value="{{ $schedule->cinema->id }}" required />
                <input id="{{$schedule->cinema->id}}" type="text" readonly class="form-control" name="cinema" value="{{ $schedule->cinema->name }}">
            </div>
        </div>
        <!-- Room Info -->
        <div class="row mb-3">
            <label for="room_id" class="col-md-4 col-form-label text-md-end">{{ __('Phòng chiếu:') }}</label>
            <div class="col-md-6">
                <input type="hidden" name="room_id" id="room_id" readonly value="{{ $schedule->room->id }}" required />
                <input id="{{$schedule->room->id}}" type="text" readonly class="form-control" name="room" value="{{ $schedule->room->name }}">
            </div>
        </div>
        <!-- Movie Info -->
        <div class="row mb-3">
            <label for="release_date" class="col-md-4 col-form-label text-md-end">{{ __('Ngày phát hành:') }}</label>
            <div class="col-md-6">
                <input id="release_date" type="text" readonly class="form-control" value="{{ $schedule->movie->release_at }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="movie" class="col-md-4 col-form-label text-md-end">{{ __('Phim:') }}</label>
            <div class="col-md-6">
                <input type="hidden" name="movie_id" readonly id="movie_id" value="{{ $schedule->movie->id }}" required />
                <input id="release_date" type="text" readonly class="form-control" value="{{ $schedule->movie->name }}">
            </div>
        </div>
        <!-- Start date Info -->
        <div class="row mb-3">
            <label for="start_at" class="col-md-4 col-form-label text-md-end">{{ __('Ngày chiếu') }}</label>

            <div class="col-md-6">
                <input id="start_at" required type="date" class="form-control" name="start_at" required>
            </div>
        </div>
        <!-- Play time info -->
        <div class="row mb-3">
            <label for="play_time" class="col-md-4 col-form-label text-md-end">{{ __('Thời gian chiếu:') }}</label>

            <div class="col-md-6">
                <input id="play_time" type="time" class="form-control" name="play_time" required>
            </div>
        </div>
        <!-- error message -->
        <div class="row mb-3">
            <div class="col-md-6" id="error-list">
            </div>
            <div class="col-md-6">
                <button type="button" id="submit-btn" class="btn btn-primary" onclick="edit()">
                    {{ __('Sửa lịch') }}
                </button>
                <button type="button" id="cancle-btn" class="btn btn-danger" onclick="cancle()">
                    {{ __('Hủy lịch') }}
                </button>
            </div>
        </div>
    </form>
    <form id="delete-schedule">
        @csrf
        <input type="hidden" id="method" name="_method" value="DELETE">
    </form>
</div>
<script>
    // initial
    var play_date = new Date(<?php echo json_encode($schedule->start_at) ?>);
    var start_date = document.getElementById('start_at');
    var play_time = document.getElementById('play_time');
    //if schedule has been played
    if (play_date <= Date.now()) {
        start_date.readOnly = true;
        play_time.readOnly = true;
        start_date.valueAsDate = new Date(<?php echo json_encode($schedule->start_at) ?>);
        play_time.setAttribute('value', <?php echo json_encode($schedule->play_time) ?>);
        var error = document.getElementById("error-list");
        error.setAttribute('class', "alert alert-danger col-md-6");
        error.innerHTML = "Lịch chiếu này đã được công chiếu, không thể thay đổi thời gian chiếu";
        var button = document.getElementById("submit-btn");
        button.remove();
        var button = document.getElementById("cancle-btn");
        button.remove();
    } else {
        // set start date
        const today = new Date();
        var first_date = new Date(<?php echo json_encode($schedule->movie->release_at) ?>);
        var last_date = new Date(<?php echo json_encode($schedule->movie->release_at) ?>);
        last_date.setDate(last_date.getDate() + parseInt('{{App\Models\Schedule::LONGEST_PERIOD}}'))
        start_date.valueAsDate = first_date;
        play_time.setAttribute('value', "07:00");
        //if release date in the pass
        if (first_date <= Date.now()) {
            first_date = new Date();
        }

        start_date.setAttribute('min', first_date.toISOString().split("T")[0]);
        start_date.setAttribute('max', last_date.toISOString().split("T")[0]);

    }

    // on change movie
    function changeDate(id) {
        // set start date
        const today = new Date()
        var start_date = document.getElementById('start_at');
        var play_time = document.getElementById('play_time');
        start_date.innerHTML = "";
        var movies = <?php echo json_encode($schedule->movie) ?>;
        var first_date = new Date(movies.release_at);
        start_date.valueAsDate = first_date;
        play_time.setAttribute('value', "07:00");
        if (first_date < Date.now()) {
            start_date.valueAsDate = today;
            first_date = new Date();
            //set play time
            today.setHours(today.getHours() + 1)
            var current = today.getHours() + ":" + today.getMinutes();
            play_time.setAttribute('value', current);
        }
    }
    //send edit API
    async function edit() {
        var form = new FormData(document.getElementById("edit-schedule"));
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('schedule.update',[$schedule->id])}}", true);
        xhr.onload = await

        function() {
            var error = document.getElementById("error-list")
            error.setAttribute('class', "col-md-6")
            error.innerHTML = "";
            //success
            if (xhr.status === 200) {
                alert("Đã thay đổi lịch chiếu thành công!");
            }
            //if receive error
            else {
                data = JSON.parse(this.responseText);
                error.setAttribute('class', "alert alert-danger col-md-6")
                //Display the unique location-time error
                if (data.cinema_id) {
                    error.innerHTML = data.cinema_id[0];
                }
                //Display other error
                else {
                    error.innerHTML = data.message;
                }
            }
        }
        xhr.send(form)
    }
    //send delete API
    async function cancle() {
        var form = new FormData(document.getElementById("delete-schedule"));
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('schedule.destroy',[$schedule->id])}}", true);
        xhr.onload = await

        function() {
            var error = document.getElementById("error-list")
            error.setAttribute('class', "col-md-6")
            error.innerHTML = "";
            //success
            if (xhr.status === 200) {
                alert("Đã hủy lịch chiếu thành công!");
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
</script>
@endsection