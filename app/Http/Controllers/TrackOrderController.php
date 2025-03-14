<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackOrderController extends Controller
{

    /**
     * Function to search/track an order
     */
    public function search(Request $request)
    {
        $order = Order::where('order_no', $request->order_no)->with(['orderHistory', 'branch'])->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'order_no' => $order->order_no,
            'branch_name' => $order->branch->branch_name ?? 'N/A',
            'history' => $order->orderHistory
                ->sortByDesc('updated_at') // Sort history in descending order
                ->map(function ($history) {
                    return [
                        'order_status' => $history->order_status,
                        'delivery_remarks' => $history->delivery_remarks,
                        'updated_at' => $history->updated_at->format('Y-m-d H:i:s')
                    ];
                })->values() // Reset array keys
        ]);
        
    }

    public function verifyOrder(Request $request)
{
    $order = Order::where('order_no', $request->order_no)->first();

    if (!$order) {
        return response()->json(['error' => 'Order not found.'], 404);
    }

    if ($order->customer_contact_number !== $request->customer_contact_number) {
        return response()->json(['error' => 'Invalid contact number.'], 403);
    }

    if (!$order->assigned_user_id) {
        return response()->json(['error' => 'No assigned rider for this order.'], 404);
    }

    $rider = $order->assignedUser; // Get assigned rider details

    return response()->json([
        'rider' => [
            'name' => $rider->name,
            'contact_number' => $rider->contact_number
        ]
    ]);
}

    
}
