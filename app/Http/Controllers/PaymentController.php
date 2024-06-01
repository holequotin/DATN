<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Schedule;
use App\Models\ScheduleSeat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $price = (int)$request->price;
        $schedule_id = $request->schedule_id;
        $seats = explode(" ", $request->seats);
        $seats_id = explode(" ", $request->seats_id);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.callback', [
            'schedule' => $schedule_id,
            'seat' => $seats,
            'seats_id' => $seats_id,
            'price' => $price,
        ]);
        $vnp_TmnCode = "ILA6II31";//Mã website tại VNPAY
        $vnp_HashSecret = "04JUGRMPRSFI78Z30GK9G6HYAR68RBLH"; //Chuỗi bí mật

        $vnp_TxnRef = Carbon::now(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã nàysang VNPAY
        $vnp_OrderInfo = 'Thanh toán vé xem phim';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $price * 100;
        $vnp_Locale = 'vi';
        //$vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
//        $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return Redirect::away($vnp_Url);
    }

    public function callback(Request $request)
    {
        $vnp_HashSecret = "04JUGRMPRSFI78Z30GK9G6HYAR68RBLH";

        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '24') {
                return \redirect(route('payment', [
                    'schedule' => $_GET['schedule'],
                    'seat' => $_GET['seat'],
                    'seats_id' => $_GET['seats_id'],
                    'price' => $_GET['price'],
                ]));
            }
            if ($_GET['vnp_ResponseCode'] == '00') {
                return $this->StoreOrder($request);
            } else if ($_GET['vnp_ResponseCode'] == '51') {
                return \redirect(route('payment', [
                    'schedule' => $_GET['schedule'],
                    'seat' => $_GET['seat'],
                    'seats_id' => $_GET['seats_id'],
                    'price' => $_GET['price'],
                ]))->with('alert', [
                    'message' => 'Tài khoản của quý khách không đủ tiền',
                    'type' => 'danger'
                ]);
            }
        } else {
            return \redirect(route('payment', [
                'schedule' => $_GET['schedule'],
                'seat' => $_GET['seat'],
                'seats_id' => $_GET['seats_id'],
                'price' => $_GET['price'],
            ]))->with('alert', [
                'message' => 'Xảy ra lỗi trong quá trình thanh toán',
                'type' => 'danger'
            ]);
        }
    }

    private function StoreOrder(Request $request)
    {
        $user_id = Auth::user()->id;
        $schedule = Schedule::find($request->schedule);
        $cinema_id = $schedule->cinema_id;
        $movie_id = $schedule->movie_id;
        $room_id = $schedule->room_id;
        //$total_price = substr($request->total_price, 0, strlen($request->total_price) - 4);
        $total_price = (int)$request->price;
        $amount_people = count(explode(" ", $request->seats));
        $show_at = $request->show_at;
        try {
            // store order
            $order = Order::create([
                'user_id' => $user_id,
                'movie_id' => $movie_id,
                'cinema_id' => $cinema_id,
                'room_id' => $room_id,
                'date_order' => Carbon::now(),
                'total_price' => $total_price,
                'amount_people' => $amount_people,
                'show_at' => Carbon::create($show_at),
            ]);
            $schedule_id = $request->schedule;

            // set status of seat to 1(booked)
            $seats_id = $request->seats_id;
            ScheduleSeat::where('schedule_id', $schedule_id)->whereIn('seat_id', $seats_id)->update(['status' => 1]);

            $schedule_seat_id = [];
            for ($i = 0; $i < count($seats_id); $i++) {
                $schedule_seat = ScheduleSeat::where('schedule_id', $schedule_id)->where('seat_id', $seats_id[$i])->get();
                array_push($schedule_seat_id, $schedule_seat[0]->id);
            }

            for ($i = 0; $i < count($schedule_seat_id); $i++) {
                $order->scheduleSeat()->attach([
                    'seat_schedule_id' => $schedule_seat_id[$i],
                ]);
            }

            //if insert success
            return redirect('my-order/' . Auth::id())->with('alert', [
                'message' => 'Đặt vé thành công',
                'type' => 'success'
            ]);
        } catch
        (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }
}
