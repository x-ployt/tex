<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackOrderController extends Controller
{

    public function search(Request $request)
    {
        $order = Order::where('order_no', $request->order_no)->with(['orderHistory', 'branch'])->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'order_no' => $order->order_no,
            'branch_name' => $order->branch->branch_name ?? 'N/A',
            'history' => $order->orderHistory->map(function ($history) {
                return [
                    'order_status' => $history->order_status,
                    'updated_at' => $history->updated_at->format('Y-m-d H:i:s')
                ];
            })
        ]);
    }
    
}
