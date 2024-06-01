<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
    {{--    <div class="alert alert-{{$type}} alert-dismissible fade show w-100" role="alert">--}}
    {{--        <p>{{$message}}</p>--}}
    {{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--            <span aria-hidden="true">&times;</span>--}}
    {{--        </button>--}}
    {{--    </div>--}}
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
             data-bs-autohide="true" data-bs-delay="2000">
            <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
</div>
