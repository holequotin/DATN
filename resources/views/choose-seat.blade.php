@extends('layouts.app')

@section('content')
    <div class="main-container">
        <h1 class="page-title">BOOKING ONLINE</h1>
        <div class="schedule-info">
            <p class="cinema">{{$schedule->cinema->name}} 
                | Room: {{$schedule->room->name}} 
                | Số ghế ({{$schedule->available_seat}}/{{count($schedule->seats)}})</p>
            <p class="time">{{$schedule->play_time}}, {{$schedule->start_at}} ({{$schedule->movie->length}} phút)</p>
        </div>
        <h2 class="sub-title">Người / Ghế</h2>
        <img src="https://www.cgv.vn/skin/frontend/cgv/default/images/bg-cgv/bg-screen.png" alt="" class="screen">
        <form action="{{route('payment',[$schedule->id])}}" method="POST">
            @csrf
        <ul class="seat-row">
            @for ($i = 0; $i < count($schedule->row_seat); $i++)
                <li class="seat-row-item">
                    <ul class="seats">
                        @for ($j = 0; $j < count($schedule->seats); $j++)
                            @if ($schedule->row_seat[$i]==substr($schedule->seats[$j]->name,0,1))
                                
                                @if ($schedule->seats[$j]->pivot->status == 0)
                                    <li>
                                        <input type="text" id="{{$schedule->seats[$j]->name}}" name="seat[]" class="seat" readonly placeholder="{{$schedule->seats[$j]->name}}" onclick="chooseSeat('{{$schedule->seats[$j]->name}}','{{$schedule->seats[$j]->id}}')">
                                        <input type="hidden" name="seats_id[]" class="seat_id{{$schedule->seats[$j]->name}}">
                                    </li>
                                @else
                                    <li class="seat seat-disable" style="cursor: context-menu">{{$schedule->seats[$j]->name}}</li>
                                @endif
                            @endif
                        @endfor
                    </ul>
                </li>
            @endfor
        </ul>
        <div class="seat-type">
            <p><span class="checked"></span>Đang được chọn</p>
            <p><span class="normal"></span>Trống</p>
            <p><span class="choosen"></span>Đã được chọn</p>
        </div>
        <div class="general-info">
            <ul class="general-info-list">
                <li class="general-info-list-item">
                    <table class="movie">
                        <tr>
                            <td><img src="{{asset('storage/'.$schedule->movie->images[0]->path)}}" alt="" class="movie-image"></td>
                            <td>
                                <table class="movie-info">
                                    <tr><td class="movie-name">{{$schedule->movie->name}}</td></tr>
                                    <tr><td>{{$schedule->movie->language}}</td></tr>
                                    <tr><td>{{$schedule->movie->rating->name}}</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </li>
                <li class="general-info-list-item">
                    <table class="schedule">
                        <tr>
                            <td class="lable">Rạp:</td>
                            <td class="info">{{$schedule->cinema->name}}</td>
                        </tr>
                        <tr>
                            <td class="lable">Suất chiếu:</td>
                            <td class="info">{{$schedule->play_time}}, {{$schedule->start_at}}</td>
                        </tr>
                        <tr>
                            <td class="lable">Phòng chiếu:</td>
                            <td class="info">{{$schedule->room->name}}</td>
                        </tr>
                        <tr>
                            <td class="label">Ghế:</td>
                            <td class="info seat-num"></td>
                        </tr>
                    </table>
                </li>
                <li class="general-info-list-item">
                    <p>Tổng: <input type="text" class="price" name="price" value="0,00 ₫"></p>
                    <button class="btn-pay">Thanh toán</button>
                </li>
            </ul>
        </div>
        </form>
    </div>
@endsection
<script>
    function chooseSeat(seatName,seat_id){
        //choose seat in UI
        if (document.getElementById(seatName).className.length > 4){            
            document.getElementById(seatName).className = 'seat'
            document.getElementsByClassName('seat_id'+seatName)[0].value = "";
        }
        else {
            document.getElementById(seatName).className += ' checked checked-seat'
        }

        if (document.getElementById(seatName).value != ""){
            document.getElementById(seatName).value = "";            
        }
        else {
            document.getElementById(seatName).value = seatName;
            document.getElementsByClassName('seat_id'+seatName)[0].value = seat_id;
        }

        //set seats is choosen in UI for setup order
        var seats = document.getElementsByClassName('seat-num')[0].innerHTML;
        if (!seats.includes(seatName)){
            seats += seatName+" ";
        }
        else {
            seats = seats.substring(0,seats.indexOf(seatName)) + seats.substring(seats.indexOf(seatName)+seatName.length);
        }
        document.getElementsByClassName('seat-num')[0].innerHTML = seats;

        //display total price
        var seat_total = document.getElementsByClassName('checked-seat').length;
        var weekday = {{date('w',strtotime($schedule->start_at))}};
        var unit_price;
        switch (weekday){
            case 0:
                unit_price = {{config('define.price.sun')}};
                break;
            case 1:
                unit_price = {{config('define.price.mon')}};
                break;
            case 2:
                unit_price = {{config('define.price.tue')}};
                break;
            case 3:
                unit_price = {{config('define.price.wed')}};
                break;
            case 4:
                unit_price = {{config('define.price.thu')}};
                break;
            case 5:
                unit_price = {{config('define.price.thu')}};
                break;
            case 6:
                unit_price = {{config('define.price.fri')}};
                break;
        }
        document.getElementsByClassName('price')[0].value = seat_total * unit_price * {{$schedule->price_rate}} + " ₫";
    }
</script>
