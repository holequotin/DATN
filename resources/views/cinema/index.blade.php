@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="board cinema-list rounded">
                <div class="cinema-board-header text-center">
                    <h1>CINEMAS</h1>
                </div>
                <div class="board-center total-location border-top border-bottom border-secondary p-2">
                    <div class="container">
                        <div class="row">
                            @foreach ($locations as $location)
                                <div class="cinema location col-sm-3 col-md-3" id="{{$location->location}}" onclick='showCinema(this.id)'>{{$location->location}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="board-footer cinemas">

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let cinemas = JSON.parse(<?php echo json_encode($cinemas) ?>);
    function showCinema(value){
        let locations = document.querySelectorAll(".siteactive");
        for(location of locations)
        {
            location.classList.remove('siteactive');
        }
        var  location = document.getElementById(value);
        location.className+=" siteactive";
        let list_cinema = document.getElementsByClassName("cinemas");
        let child = list_cinema[0].lastElementChild;
        while (child) {
            list_cinema[0].removeChild(child);
            child = list_cinema[0].lastElementChild;
        }
        var container = document.createElement("div");
        container.setAttribute("class","container-fluid")
        let row = document.createElement("div");
        row.setAttribute("class","row p-3 row-cols-5");
        container.appendChild(row);
        list_cinema[0].appendChild(container);
        for(i=0;i<cinemas.length;i++){
            if(cinemas[i].location == value)
            {
                var container = document.createElement("div");
                container.setAttribute("class","cinema item col");
                container.setAttribute("onclick","showDetail(this.id)");
                container.id = cinemas[i].id;
                container.innerHTML = cinemas[i].name;
                row.appendChild(container);
            }
        }
    }
    async function showDetail(id){
        var cinemas = document.querySelectorAll(".subsiteactive");
        for(cinema of cinemas)
        {
            cinema.classList.remove('subsiteactive');
        }
        let  location = document.getElementById(id);
        location.className+=" subsiteactive";
        let ajax = document.getElementsByClassName("ajax");
        const xhr = new XMLHttpRequest();
        xhr.open("GET","/api/cinema/"+id, true);
        let data;
        xhr.onload = await function(){
            data = JSON.parse(this.responseText);
            document.getElementById('main-container').style.display = 'none';
            document.getElementsByClassName('date-list')[0].innerHTML = '';
            document.getElementsByClassName('movie-schedule')[0].innerHTML = '';

            document.getElementsByClassName('theater-name')[0].innerHTML = data.name;
            document.getElementsByClassName('cinema-address')[0].innerHTML = data.address;
            document.getElementsByClassName('cinema-fax')[0].innerHTML = data.fax;
            document.getElementsByClassName('cinema-phone')[0].innerHTML = data.phone;
            document.getElementsByClassName('cinema-image')[0].setAttribute('src','http://localhost:8000/storage/'+data.images[0].path);
            let dates = getDatesInRange(data.last_date);
            for (let index = 0; index < dates.length; index++) {
                let button = document.createElement('button');
                button.setAttribute('class','date');
                if (index == 0) button.className += ' select-date';
                button.id = 'date'+dates[index].getDate()+""+(dates[index].getMonth()+1);
                button.setAttribute('onclick','changeDate('+(dates[index].getDate()+""+(dates[index].getMonth()+1))+')');
                button.innerHTML = dates[index].getDate()+"/"+(dates[index].getMonth()+1);
                document.getElementsByClassName('date-list')[0].appendChild(button);
            }
            for (let index = 0; index < dates.length; index++){
                var ul = document.createElement('ul');
                ul.setAttribute('class','movie-list date'+(dates[index].getDate()+""+(dates[index].getMonth()+1)));
                if (index == 0) {
                    ul.style.display = 'block'
                }
                else{
                    ul.style.display = 'none'
                }
                for(var key in data.movies){
                    let status = 0;
                    for (var tmp in data.movies[key].schedules){
                        let dateCmp = new Date(data.movies[key].schedules[tmp].start_at)
                        if (dates[index].getDate() == dateCmp.getDate()){
                            status = 1;
                        }
                    }
                    if (status == 0){continue}
                    let li = document.createElement('li');
                    li.setAttribute('class','movie-list-item');

                    let a = document.createElement('a');
                    a.setAttribute('href','/movie-detail/'+data.movies[key].id)
                    let span = document.createElement('span');
                    span.setAttribute('class','movie-name');
                    span.innerHTML = data.movies[key].name;
                    a.appendChild(span);

                    let img_rated = document.createElement('img');
                    img_rated.setAttribute('src','http://localhost:8000/storage/'+data.movies[key].rating.images[0].path)
                    img_rated.setAttribute('alt','Rated');
                    img_rated.setAttribute('class','rated');
                    a.appendChild(img_rated);
                    li.appendChild(a);

                    let div = document.createElement('div');
                    div.setAttribute('class','movie-schedule');
                    let link = document.createElement('a');
                    link.setAttribute('href','/movie-detail/'+data.movies[key].id)
                    let img_movie = document.createElement('img');
                    img_movie.setAttribute('src','http://localhost:8000/storage/'+data.movies[key].images[0].path);
                    img_movie.setAttribute('alt','Movie Image');
                    link.appendChild(img_movie);
                    div.appendChild(link);

                    let schedule = document.createElement('div');
                    schedule.setAttribute('class','schedule');
                    let subtt = document.createElement('p');
                    subtt.innerHTML = data.movies[key].language;
                    schedule.appendChild(subtt);

                    let time = document.createElement('div');
                    time.setAttribute('class','time');
                    for (var x in data.movies[key].schedules){
                        let dateCmp = new Date(data.movies[key].schedules[x].start_at)
                        if ((dateCmp.getDate()) == dates[index].getDate()){
                            let t = document.createElement('a');
                            t.setAttribute('href','/booking-ticket/'+data.movies[key].schedules[x].id)
                            @isset(Auth::user()->role_id)
                            var role_id = "{{Auth::user()->role_id}}"
                            if(role_id == {{\App\Models\User::ROLE_MANAGER}} || role_id == {{\App\Models\User::ROLE_ADMIN}})
                            {
                                t.setAttribute('href',"/schedule/"+data.movies[key].schedules[x].id+"/edit")
                            }
                            @endisset
                            t.setAttribute('class','btn');
                            t.innerHTML = data.movies[key].schedules[x].play_time;
                            time.appendChild(t);
                        }
                    }
                    schedule.appendChild(time);
                    div.appendChild(schedule);
                    li.appendChild(div);
                    ul.appendChild(li);
                };
                document.getElementsByClassName('movie-schedule')[0].appendChild(ul);
            }

            document.getElementById('main-container').style.display = 'block';

        };
        xhr.send();
    }
    function getDatesInRange(endDate) {
        let date = new Date();
        let end = new Date(endDate);
        end = end.setDate(end.getDate()+1);
        let dates = [];

        while (date <= end) {
            dates.push(new Date(date));
            date.setDate(date.getDate() + 1);
        }
        return dates;
    }
    function changeDate(date_num){
        let list1 = document.getElementsByClassName('date');
        for (let index = 0; index < list1.length; index++) {
            list1[index].setAttribute('class','date');
        }
        $tmp = document.getElementById('date'+date_num);
        $tmp.setAttribute('class','date select-date');

        let list2 = document.getElementsByClassName('movie-list');
        for (let index = 0; index < list2.length; index++) {
            list2[index].style.display = 'none';
        }
        document.getElementsByClassName('date'+date_num)[0].style.display = 'block';
    }
    function showDescription(){
        document.getElementsByClassName('detail')[0].style.fontWeight = 900;
        document.getElementsByClassName('trailer')[0].style.fontWeight = 100;
        document.getElementsByClassName('action-content')[0].style.display = 'block';
        document.getElementsByClassName('action-trailer')[0].style.display = 'none';
    }
    function showTrailer(){
        document.getElementsByClassName('detail')[0].style.fontWeight = 100;
        document.getElementsByClassName('trailer')[0].style.fontWeight = 900;
        document.getElementsByClassName('action-content')[0].style.display = 'none';
        document.getElementsByClassName('action-trailer')[0].style.display = 'block';
    }
</script>
@endsection
@section('sub-content')
    <div class="main-container" id="main-container" style="display: none">
        <section class="main-theater">
            <img src="https://www.cgv.vn/skin/frontend/cgv/default/images/h3_theater.gif" alt="">
            <h2 class="theater-name"></h2>
            <div class="theater-info">
                <p class="cinema-address"></p>
                <p><b>FAX: </b><span class="cinema-fax"></span></p>
                <p><b>Hotline: </b><span class="cinema-phone"></span></p>
            </div>
            <img src="" alt="" class="cinema-image">
        </section>
        <div class="main-bot">
            <p class="action">
                <button class="detail" onclick="showDescription()">Lịch chiếu</button>
                |
                <button class="trailer" onclick="showTrailer()">Giá vé</button>
            </p>
        </div>
        <section class="theater-schedule">
            <div class="date-list">
            </div>
            <div class="movie-schedule">
            </div>
        </section>
    </div>
@endsection
