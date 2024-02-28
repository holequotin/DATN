@extends('layouts.app')

@section('content')
    <div class="order-container">
        <h2><b>Kết quả</b></h2>
        {{-- {{count($movies)}} --}}
        <table class="order-list">
            <tr>
                <th class="label">Phim</th>
                <td class="label">Đạo diễn</td>
                <td class="label">Diễn viên</td>
                <td class="label">Ngôn ngữ</td>
                <td class="label">Thể loại</td>
                <td class="label">Thời lượng</td>
                <td class="label">Rate</td>
            </tr>
            @forelse ($movies as $movie)
                <tr>
                    <td class="movie">
                        <a href="/movie-detail/{{$movie['_id']}}">
                            <img src="{{asset('storage/'.$movie['_source']['image'])}}" alt="" class="movie-img">
                            <p class="movie-name">{{$movie['_source']['name']}}</p>
                        </a>
                    </td>
                    <td class="cinema">{{$movie['_source']['director']}}</td>
                    <td class="room">{{$movie['_source']['actor']}}</td>
                    <td class="seats">{{$movie['_source']['language']}}</td>
                    <td class="schedule">{{$movie['_source']['categories']}}</td>
                    <td class="date-order">{{$movie['_source']['length']}}</td>
                    <td class="price">{{$movie['_source']['rating']}}</td>
                </tr>
                @empty
                <tr class="movie">
                    <td span=3>
                    There are no movies available
                    </td>
                </tr>
                @endforelse
        </table>
    </div>
@endsection