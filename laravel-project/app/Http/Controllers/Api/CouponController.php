<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    //
    public function applyCoupon(Request $request)
    {
        //where coupon จาก userที่ใส่สำหรับส่วนลด
        $coupon = Coupon::whereName($request->name)->first();
        //เช็ค couponที่userใส่เข้ามา กับ couponที่มีในระบบ
        if ($coupon && $coupon->checkIfValid()) {
            //ถ้าตรงrespons json กลับไป
            return response()->json([
                'message' => 'Coupon applied successfully',
                'coupon' => $coupon
            ]);
        } else {
            //coupon failed or expired
            return response()->json([
                'error' => 'Invalid or expired coupon'
            ]);
        }
    }
}
