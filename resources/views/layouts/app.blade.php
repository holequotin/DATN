@php use App\Models\User; @endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--Full Calendar-->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js"></script>

    <script>
        function showMovieOption() {
            document.getElementsByClassName('movie-option')[0].style.display = 'block';
        }

        function hideMovieOption() {
            document.getElementsByClassName('movie-option')[0].style.display = 'none';
        }
    </script>

</head>

<body>
<header class="header">
    <div class="header-container">
        <a href="{{route('home')}}"><img src="https://www.cgv.vn/skin/frontend/cgv/default/images/cgvlogo.png"
                                         alt="Logo" class="logo-page"></a>
        <ul class="nav-list">
            <li class="nav-list-item" onmouseenter="showMovieOption()" onmouseleave="hideMovieOption()">
                Phim
                <ul class="movie-option">
                    <li class="movie-option-item"><a href="{{route('home')}}">Phim đang chiếu</a></li>
                    <li class="movie-option-item"><a href="{{route('movie-coming')}}">Phim sắp chiếu</a></li>
                </ul>
            </li>
            <li class="nav-list-item" style="min-width: 120px;"><a href="/cinema">Rạp CGV</a></li>
            @guest
                @if (Route::has('login'))
                    <li class="nav-list-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-list-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-list-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Đăng xuất') }}
                        </a>
                        @if (Auth::user()->role_id == User::ROLE_CUSTOMER)
                            <a href="{{route('order.index',[Auth::user()->id])}}" class="dropdown-item">Vé của tôi</a>
                        @elseif (Auth::user()->role_id == User::ROLE_MANAGER)
                            <a href="{{route('order.cinema',[Auth::user()->id])}}" class="dropdown-item">Danh sách vé
                                tại rạp</a>
                        @endif
                        @isset(Auth::user()->role_id)
                            @if (Auth::user()->role_id == User::ROLE_MANAGER)
                                <a href="{{route('schedule.create')}}" class="dropdown-item">Đăng ký lịch chiếu phim</a>
                            @elseif (Auth::user()->role_id == User::ROLE_ADMIN)
                                <a href="{{route('schedule.create')}}" class="dropdown-item">Đăng ký lịch chiếu phim</a>
                                <a href="{{route('movie.create')}}" class="dropdown-item">Đăng ký phim</a>
                            @endif
                        @endisset

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</header>
<main>
    <form method="GET" action="{{ route('search') }}"
          class="main-container search-form container-fluid d-flex justify-content-center w-100">
        @csrf
        <!-- <div class="search-option">
                <select class="form-select" name="search_type">
                    <option value="categories" {{ request()->get('search_type') === 'name' ? 'selected' : '' }}>Thể loại</option>
                    <option value="movies" {{ request()->get('search_type') === 'email' ? 'selected' : '' }}>Phim</option>
                    <option value="cinemas" {{ request()->get('search_type') === 'address' ? 'selected' : '' }}>Rạp</option>
                    <option value="rating" {{ request()->get('search_type') === 'address' ? 'selected' : '' }}>Độ tuổi</option>
                </select>
            </div> -->
    </form>

    <div class="container-fluid d-flex">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast"
                 class="toast align-items-center text-bg-{{session()->has('alert') ? session('alert')['type'] : 'primary'}} border-0"
                 role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{session()->has('alert') ? session('alert')['message'] : 'Some thing when wrong'}}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>
        </div>
        @if(session()->has('alert'))
            <script>
                var myToastEl = document.getElementById('liveToast');
                var myToast = new bootstrap.Toast(myToastEl, {
                    autohide: true,
                    delay: 5000 // 5000 milliseconds = 5 seconds
                });
                myToast.show();
            </script>
            {{--            <x-alert :message="session('alert')['message']" :type="session('alert')['type']"></x-alert>--}}
        @endif
    </div>
    <div class="chatbot">
        <button class="button_chatbot" aria-placeholder="click me!">
            <img class="image_chatbot" src="{{asset('storage/image/helping-icon-png-3.jpeg')}}" alt="" width="50"
                 height="50">
            <span class="tooltiptext">Bạn cần giúp đỡ?</span>
        </button>
    </div>
    <div id="chatbox" class="box" style="display: none">
        <div>
            <div class="container-fluid m-0 d-flex p-2">
                <div>
                    <img src="{{ asset('storage/image/helping-icon-png-3.jpeg') }}" alt="" width="30px" height="30px"
                         style="object-fit: cover;">
                </div>
                <div class="text-black font-weight-bold ml-2 fs-6" style="align-self: center;">ChatBot</div>
                <button id="button-close" type="button" class="close" aria-label="Close"
                        style="margin-left: auto; margin-right: 10px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div style="background:#818997; height:1px;"></div>
        <div id="content-box" class="container-fluid p-2" style="height: calc(100% - 96px); overflow-y:scroll">
            <div class="d-flex mb-2">
                <div class="mr-2 mt-2" style=" height:30px">
                    <img src="{{ asset('storage/image/helping-icon-png-3.jpeg') }}" alt="" width="25px" height="25px"
                         style="object-fit: cover;">
                </div>
                <div class="text-white px-3 py-2"
                     style="max-width: 210px; background:rgb(96, 89, 89);border-radius:10px; font-size:85%">
                    Chào! Tôi có thể giúp gì cho bạn?
                </div>
            </div>
        </div>
        <div class="container-fluid w-100 px-3 py-2 d-flex" style="background: #e7e9ec;height:48px;">
            <div class="mr-2 pl-2" style="background: white;width:calc(100% - 45px);border-radius:5px">
                <input id="input" class="text-black" type="text" name="input"
                       style="background: none; height:100%; width:100%; border:0; outline: none">
            </div>
            <div id="button-submit" class="text-center"
                 style="background:#4acfee; height:100%; width:40px; border-radius:5px">
                <i class="fa fa-paper-plane text-white" aria-hidden="true" style="line-height: 30px"></i>
            </div>
        </div>
    </div>
    @yield('content')
    @yield('sub-content')
</main>
<footer>
    <section class="footer-container">
        <ul class="about-me">
            <li class="about-me-item">
                <h4 class="heading-page-third">CGV Việt Nam</h4>
                <ul class="about-company">
                    <li class="about-company-item">Giới thiệu</li>
                    <li class="about-company-item">Tiện Ích Online</li>
                    <li class="about-company-item">Thẻ Quà Tặng</li>
                    <li class="about-company-item">Tuyển Dụng</li>
                    <li class="about-company-item">Liên Hệ Quảng Cáo CGV</li>
                </ul>
            </li>
            <li class="about-me-item">
                <h4 class="heading-page-third">Điều khoản sử dụng</h4>
                <ul class="term">
                    <li class="term-item">Điều Khoản Chung</li>
                    <li class="term-item">Điều Khoản Giao Dịch</li>
                    <li class="term-item">Chính Sách Thanh Toán</li>
                    <li class="term-item">Chính Sách Bảo Mật</li>
                    <li class="term-item">Câu Hỏi Thường Gặp</li>
                </ul>
            </li>
            <li class="about-me-item">
                <h4 class="heading-page-third">Kết nối với chúng tôi</h4>
                <ul class="connect-company">
                    <li class="connect-company-item" style="margin-left: -30px;">
                        <a href="" class="sociated">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Facebook_icon_2013.svg/2048px-Facebook_icon_2013.svg.png"
                                alt="Facebook">
                        </a>
                    </li>
                    <li class="connect-company-item">
                        <a href="" class="sociated">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/09/YouTube_full-color_icon_%282017%29.svg/2560px-YouTube_full-color_icon_%282017%29.svg.png"
                                alt="Youtube">
                        </a>
                    </li>
                    <li class="connect-company-item">
                        <a href="" class="sociated">
                            <img src="https://i.pinimg.com/736x/2c/da/19/2cda1925dcf4fb8f0644413f49671ffa.jpg"
                                 alt="Instagram">
                        </a>
                    </li>
                    <li class="connect-company-item">
                        <a href="" class="sociated">
                            <img
                                src="https://cdn1.iconfinder.com/data/icons/logos-brands-in-colors/2500/zalo-seeklogo.com-512.png"
                                alt="Zalo">
                        </a>
                    </li>
                </ul>
                <a href=""><img src="http://online.gov.vn/Content/EndUser/LogoCCDVSaleNoti/logoSaleNoti.png" alt=""></a>
            </li>
            <li class="about-me-item">
                <h4 class="heading-page-third">Chăm sóc khách hàng</h4>
                <ul class="support">
                    <li class="support-item">Hotline: 1900 6017</li>
                    <li class="support-item">Giờ làm việc: 8:00 - 22:00 (Tất cả các ngày bao gồm cả Lễ Tết)</li>
                    <li class="support-item">Email hỗ trợ: hoidap@cgv.vn</li>
                </ul>
            </li>
        </ul>
    </section>
    <section class="footer-contact">
        <h4 class="heading-page-third">CÔNG TY TNHH CJ CGV VIETNAM</h4>
        <p>Giấy CNĐKDN: 0303675393, đăng ký lần đầu ngày 31/7/2008, đăng ký thay đổi lần thứ 5 ngày 14/10/2015, cấp
            bởi Sở KHĐT thành phố Hồ Chí Minh.</p>
        <p>Địa Chỉ: Tầng 2, Rivera Park Saigon - Số 7/28 Thành Thái, P.14, Q.10, TPHCM.</p>
        <p>Hotline: 1900 6017</p>
        <p>COPYRIGHT 2017 CJ CGV. All RIGHTS RESERVED .</p>
    </section>
    <section class="end-page"></section>
</footer>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#button-submit').on('click', function () {
        $value = $('#input').val();
        $('#content-box').append(`<div class="mb-2">
                <div class="float-right text-white px-3 py-2" style="max-width:210px; background:rgb(49, 49, 244); border-radius:10px; font-size:85%">
                    ` + $value + `
                </div>
                <div style="clear:both"></div>
            </div>`);
        $('#input').val('');
        $('#content-box').append(`<div class="d-flex mb-2" id="loading">
                    <div class="mr-2 mt-2" style=" height:30px">
                        <img src="{{ asset('storage/image/helping-icon-png-3.jpeg') }}" alt="" width="25px" height="25px" style="object-fit: cover;">
                    </div>
                    <div class="text-white px-3 py-2" style="max-width: 210px; background:rgb(96, 89, 89);border-radius:10px; font-size:85%">
                        ...
                    </div>
                </div>`)
        $.ajax({
            type: 'post',
            url: '{{ url("http://127.0.0.1:5000/chat/") }}',
            data: {
                'question': $value
            },
            success: function (data) {
                $("#loading").remove();
                $('#content-box').append(`<div class="d-flex mb-2">
                    <div class="mr-2 mt-2" style=" height:30px">
                        <img src="{{ asset('storage/image/helping-icon-png-3.jpeg') }}" alt="" width="25px" height="25px" style="object-fit: cover;">
                    </div>
                    <div class="text-white px-3 py-2" style="max-width: 210px; background:rgb(96, 89, 89);border-radius:10px; font-size:85%">
                        ` + data['response'] + `
                    </div>
                </div>`);
            }
        })
    })
    $('#button-close').on('click', function () {
        $('#chatbox').css({
            display: "none"
        });
    })
    $('.chatbot').on('click', function () {
        $('#chatbox').css({
            display: "block"
        });
    })
</script>
