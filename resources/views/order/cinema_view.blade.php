@extends('layouts.app')

@section('content')
    <div class="order-container">
        <h2><b>Vé tại rạp {{$cinema->name}}</b></h2>
        @foreach ($cinema->rooms as $room)
        <div class="mb-5">
            <h4><b>Phòng {{$room->name}}</b></h4>
            <table class="order-list">
                <tr>
                    <th class="label">NO.</th>
                    <th class="label">Người mua</th>
                    <th class="label">Phim</th>
                    <td class="label">Ghế</td>
                    <td class="label">Suất chiếu</td>
                    <td class="label">Ngày đặt vé</td>
                    <td class="label">Tổng tiền</td>
                </tr>
                @foreach ($room->orders as $order)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td class="user">{{$order->user->name}}</td>
                        <td class="movie">
                            <img src="{{asset('storage/'.$order->movie->images[0]->path)}}" alt="" class="movie-img img-thumbnail w-25">
                            <p class="movie-name">{{$order->movie->name}}</p>
                        </td>
                        <td class="seats">
                            @foreach ($order->scheduleSeat as $scheduleSeat)
                                {{$scheduleSeat->seat->name}}
                            @endforeach
                        </td>
                        <td class="schedule">{{date('d-m-Y H:i:s',strtotime($order->show_at))}}</td>
                        <td class="date-order">{{$order->date_order}}</td>
                        <td class="price">{{$order->total_price}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endforeach
    </div>
@endsection
