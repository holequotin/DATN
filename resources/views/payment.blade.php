@extends('layouts.app')

@section('content')
    <div class="main-container">
        <section class="cinema-order">
            <h2 class="cinema-name">{{$schedule->cinema->name}}</h2>
        </section>
        <section class="movie-order">
            <img src="{{asset('storage/'.$schedule->movie->images[0]->path)}}" alt="Movie Image" class="movie-img">
            <div class="movie-info-order">
                <p class="movie-name">{{$schedule->movie->name}}</p>
            </div>
        </section>
        <ul class="time-order">
            <li class="">
                <p class="label">Date:</p>
                <p class="play-date">{{$schedule->start_at}}</p>
            </li>
            <li class="">
                <p class="label">Time:</p>
                <p class="play-time">{{$schedule->play_time}}</p>
            </li>
        </ul>
        <ul class="time-order">            
            <li class="">
                <p class="label">Seats:</p>
                <p class="choosen-seats">{{$seats}}</p>
            </li>
            <li>
                <p class="label">Room:</p>
                <p class="room">{{$schedule->room->name}}</p>
            </li>
        </ul>
        <section class="payment">
            <p class="total"><b>Tổng: </b>{{$price}}</p>
            <button class="btn-buy" onclick="payment()">Đặt vé</button>
        </section>
    </div>
@endsection
<script>
    async function payment(){
        var form = new FormData();
        form.append('schedule_id','{{$schedule->id}}');
        form.append('cinema_id','{{$schedule->cinema->id}}');
        form.append('movie_id','{{$schedule->movie->id}}');
        form.append('room_id','{{$schedule->room->id}}');
        form.append('total_price','{{$price}}');
        form.append('seats','{{$seats}}');
        form.append('seats_id','{{$seats_id}}');
        form.append('show_at','{{$schedule->start_at}} {{$schedule->play_time}}')
        form.append('user_id','{{Auth::user()->id}}');
        for (const [key, value] of form) {
            console.log(`${key}: ${value}\n`);
        }
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('order.store')}}", true);
        xhr.onload = await
        function() {
            //success
            if (xhr.status === 200) {
                alert("Đã đặt vé thành công!");
                window.location.href = "{{route('home')}}"
            }
            //if receive error
            else {
                alert("Xin lỗi, chúng tôi đang gặp một số vấn đề! Vui lòng thử lại!")
            }
        }
        xhr.send(form)
    }
</script>
