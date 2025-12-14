<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display the list of orders
     */
    public function index()
    {
        //ดึงข้อมูล order
        $orders = Order::with(['products', 'user', 'coupon'])->latest()->get();
        return view('admin.orders.index')->with([
            'orders' => $orders
        ]);
    }

    /**
     * Update the orders delivered at date
     */
    public function updateDeliveredAtDate(Order $order)
    {
        //update สถานะขนส่งให้เป็นส่งแล้ว
        $order->update([
            'delivered_at' => Carbon::now()
        ]);

        //reponse status
        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order updated successfully'
        ]);
    }

    /**
     * Delete orders
     */
    public function delete(Order $order)
    {
        //ลบ data order
        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order deleted successfully'
        ]);
    }
}
