<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryValidation;
use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('branch_id', Auth::user()->branch_id)
                    ->where('assigned_user_id', Auth::user()->id);

        // Apply order status filter if it's not 'all'
        if ($request->has('order_status') && $request->order_status !== 'all') {
            $query->where('order_status', $request->order_status);
        }

        $orders = $query->get();

        return view('navigation.delivery.index', compact('orders'));
    }

    public function view(Order $order)
    {
        $authUser = Auth::user();

        if ($authUser->role->role_name == 'Admin') {

            $riders = User::where('branch_id', $authUser->branch_id)->whereHas('role', function ($q) {
                $q->where('role_name', 'Rider');
            })->get();

            $branches = Branch::where('id', $authUser->branch_id)->get();

        } else {

            $riders = User::whereHas('role', function ($q) {
                $q->where('role_name', 'Rider');
            })->get();
            
            $branches = Branch::all(); 
        }

        return view('navigation.delivery.view', compact('order', 'branches', 'riders'));
    }

    public function markDelivered(DeliveryValidation $request, Order $order)
    {
        $files = $request->file('delivery_photos');
        $filePaths = [];
        
        // Process uploaded proof photos
        if ($files) {
            foreach ($files as $file) {
                $path = $file->store('delivery_photos', 'public');
                $filePaths[] = $path;
            }
        }

        $order->update([
            'order_status' => 'Delivered',
            'file_paths'   => json_encode($filePaths),
        ]);

        OrderHistory::create([
            'order_id' => $order->id,
            'order_status' => 'Delivered',
        ]);

        return redirect()->route('delivery.view', $order)
                         ->with('updateSuccess', 'Order marked as delivered.');
    }

    /**
     * Mark an order as cancelled.
     */
    public function markCancelled(DeliveryValidation $request, Order $order)
    {
        $order->update([
            'order_status' => 'Cancelled',
            // Assuming you have a column "cancel_reason" in your orders table
            'reason' => $request->reason,
        ]);

        OrderHistory::create([
            'order_id' => $order->id,
            'order_status' => 'Cancelled',
        ]);

        return redirect()->route('delivery.view', $order)
                         ->with('updateSuccess', 'Order marked as cancelled.');
    }

}
