@extends('layouts.app')

@section('content')
<div class="container">
    <form enctype="multipart/form-data" action="" id="add-schedule">
        @csrf
        <!-- Cinema Info -->
        <div class="row mb-3">
            <label for="cinema" class="col-md-4 col-form-label text-md-end">{{ __('Rạp:') }}</label>
            @if(Auth::user()->role_id==App\Models\User::ROLE_MANAGER)
            <div class="col-md-6">
                <input type="hidden" name="cinema_id" id="cinema_id" value="{{ $cinemas->id }}" required />
                <input id="{{$cinemas->id}}" type="text" readonly class="form-control" name="cinema" value="{{ $cinemas->name }}">
                <div id="cinema_id"></div>
            </div>
            @endif
            @if(Auth::user()->role_id==App\Models\User::ROLE_ADMIN)
            <div class="col-md-6">
                <select class="form-control" name="cinema_id" onchange="changeRoom(options[selectedIndex].id)" required>
                    @foreach ($cinemas as $cinema)
                    <option id="{{ $loop->index }}" value="{{$cinema->id}}">
                        {{$cinema->name}}
                    </option>
                    @endforeach
                </select>
                <div id="cinema_id"></div>
            </div>
            @endif
        </div>
        <!-- Room Info -->
        <div class="row mb-3">
            <label for="room" class="col-md-4 col-form-label text-md-end">{{ __('Phòng chiếu:') }}</label>
            <div class="col-md-6">
                @if(Auth::user()->role_id==App\Models\User::ROLE_MANAGER)
                <select class="form-control" name="room_id" required>
                    @foreach ($cinemas->rooms as $room)
                    <option value="{{$room->id}}">
                        {{$room->name}}
                    </option>
                    @endforeach
                </select>
                @endif
                @if(Auth::user()->role_id==App\Models\User::ROLE_ADMIN)
                <select class="form-control" id="room" name="room_id" required>
                    @foreach ($cinemas[0]->rooms as $room)
                    <option value="{{$room->id}}">
                        {{$room->name}}
                    </option>
                    @endforeach
                </select>
                @endif
                <div id="room_id"></div>
            </div>
        </div>
        <!-- Movie Info -->
        <div class="row mb-3">
            <label for="release_date" class="col-md-4 col-form-label text-md-end">{{ __('Ngày phát hành:') }}</label>
            <div class="col-md-6">
                <input type="text" readonly class="form-control" value="{{ $movies[0]->release_at }}">
                <div id="release_date"></div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="movie" class="col-md-4 col-form-label text-md-end">{{ __('Phim:') }}</label>
            <div class="col-md-6">
                <select class="form-control" name="movie_id" onchange="changeDate(options[selectedIndex].id)" required>
                    @foreach ($movies as $movie)
                    <option id="{{ $loop->index }}" value="{{$movie->id}}">
                        {{$movie->name}}
                    </option>
                    @endforeach
                </select>
                <div id="movie_id"></div>
            </div>
        </div>
        <!-- Start date Info -->
        <div class="row mb-3">
            <label for="start_at" class="col-md-4 col-form-label text-md-end">{{ __('Ngày chiếu') }}</label>

            <div class="col-md-6">
                <input id="start_at_input" required defaultValue type="date" class="form-control" name="start_at" required>
                <div id="start_at"></div>
            </div>
        </div>
        <!-- Play time info -->
        <div class="row mb-3">
            <label for="play_time" class="col-md-4 col-form-label text-md-end">{{ __('Thời gian chiếu:') }}</label>

            <div class="col-md-6">
                <input id="play_time_input"type="time" class="form-control" name="play_time" required>
                <div id="play_time"></div>
            </div>
        </div>
        <!-- error message -->
        <div class="row mb-3">
            <div class="col-md-6" id="error-list">
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" onclick="finish()">
                    {{ __('Đăng ký') }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Admin Script -->
@if(Auth::user()->role_id==App\Models\User::ROLE_ADMIN)
<script>
    function changeRoom(id) {
        var rooms = document.getElementById("room");
        rooms.innerHTML = "";
        var cinema_data = <?php echo $cinemas ?>;
        var room_data = cinema_data[id].rooms;
        for (room of room_data) {
            var option = document.createElement("option");
            option.setAttribute('value', room.id);
            option.innerHTML = room.name;
            rooms.appendChild(option);
        }
    }
</script>
@endif
<script>
    // initial
    // set start date
    const today = new Date()
    var start_date = document.getElementById('start_at_input');
    var play_time = document.getElementById('play_time_input');
    const first_date = new Date(<?php echo json_encode($movies[0]->release_at) ?>);
    var last_date = new Date(<?php echo json_encode($movies[0]->release_at) ?>);
    last_date.setDate(last_date.getDate() + parseInt('{{App\Models\Schedule::LONGEST_PERIOD}}'))
    start_date.valueAsDate = first_date;
    play_time.setAttribute('value', "07:00");
    //if release date in the pass
    if (first_date <= Date.now()) {
        start_date.valueAsDate = today;
        //set play time
        today.setHours(today.getHours() + 1)
        var current = today.getHours() + ":" + today.getMinutes();
        play_time.setAttribute('value', current);
    }
    start_date.setAttribute('min', first_date.toISOString().split("T")[0]);
    start_date.setAttribute('max', last_date.toISOString().split("T")[0]);

    // on change movie
    function changeDate(id) {
        // set start date
        const today = new Date()
        var start_date = document.getElementById('start_at_input');
        var play_time = document.getElementById('play_time_input');
        start_date.innerHTML = "";
        var movies = <?php echo json_encode($movies) ?>;
        var first_date = new Date(movies[id].release_at);
        var last_date = new Date(movies[id].release_at);
        last_date.setDate(last_date.getDate() + parseInt('{{App\Models\Schedule::LONGEST_PERIOD}}'))
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
        start_date.setAttribute('min', first_date.toISOString().split("T")[0]);
        start_date.setAttribute('max', last_date.toISOString().split("T")[0]);
    }
    //send API
    async function finish() {
        var form = new FormData(document.getElementById("add-schedule"));
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('schedule.store')}}", true);
        xhr.onload = await
        function() {
            var error = document.getElementById("error-list")
            error.setAttribute('class', "col-md-6")
            error.innerHTML = "";
            //success
            if (xhr.status === 200) {
                alert("Đã đăng ký lịch chiếu thành công!");
                window.location.href = "{{route('home')}}"
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
                    errors = JSON.parse(this.responseText);
                    console.log(errors);
                    for(let error in errors)
                    {
                        displayError(error,errors[error])
                    }
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