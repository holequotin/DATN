@extends('layouts.app')

@section('content')
    <div class="order-container">
        <h2><b>Vé của tôi</b></h2>
        {{-- {{count($orders)}} --}}
        <table class="order-list">
            <tr>
                <th class="label">NO.</th>
                <th class="label">Phim</th>
                <td class="label">Rạp</td>
                <td class="label">Phòng</td>
                <td class="label">Ghế</td>
                <td class="label">Suất chiếu</td>
                <td class="label">Ngày đặt vé</td>
                <td class="label">Tổng tiền</td>
            </tr>
            @for ($i = 0; $i < count($orders); $i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td class="movie">
                        <a href="/movie-detail/{{$orders[$i]->movie->id}}">
                            <img src="{{asset('storage/'.$orders[$i]->movie->images[0]->path)}}" alt="" class="movie-img">
                            <p class="movie-name">{{$orders[$i]->movie->name}}</p>
                        </a>
                    </td>
                    <td class="cinema">{{$orders[$i]->cinema->name}}</td>
                    <td class="room">{{$orders[$i]->room->name}}</td>
                    <td class="seats">{{$orders[$i]->seats}}</td>
                    <td class="schedule">{{date('d-m-Y H:i:s',strtotime($orders[$i]->show_at))}}</td>
                    <td class="date-order">{{$orders[$i]->date_order}}</td>
                    <td class="price">{{$orders[$i]->total_price}}</td>
                </tr>
            @endfor
        </table>
    </div>
@endsection
<script>
    console.log(JSON.parse(<?php echo $orders ?>))
</script>
