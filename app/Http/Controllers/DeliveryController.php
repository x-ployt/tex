<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryValidation;
use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    /**
     * Redirecting to delivery.index
     */
    public function index(Request $request)
    {
        $query = Order::where('branch_id', Auth::user()->branch_id)
                    ->where('assigned_user_id', Auth::user()->id);

        // Apply order status filter if it's not 'all'
        if ($request->has('order_status') && $request->order_status !== 'all') {
            $query->where('order_status', $request->order_status);
        }

        // Apply search filter for order_no
        if ($request->has('search') && !empty($request->search)) {
            $query->where('order_no', 'like', '%' . $request->search . '%');
        }

        $orders = $query->get();

        // Return JSON if request is AJAX
        if ($request->ajax()) {
            return response()->json(['orders' => $orders]);
        }

        return view('navigation.delivery.index', compact('orders'));
    }

    /**
     * Redirecting to delivery.view
     */
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

    /**
     * Function to mark the order as "Delivered"
     */
    public function markDelivered(DeliveryValidation $request, Order $order)
    {
        $files = $request->file('delivery_photos');
        $filePaths = [];

        if ($files) {
            foreach ($files as $file) {
                // Store the file without compression
                $path = $file->store('delivery_photos', 'public');
                $filePaths[] = $path;
            }
        }

        $order->update([
            'order_status' => 'Delivered',
            'file_paths'   => json_encode($filePaths),
        ]);

        OrderHistory::updateOrCreate([
            'order_id' => $order->id,
            'order_status' => 'Delivered',
            'delivery_remarks' => 'Order has been delivered.',
        ]);

        return redirect()->route('delivery.view', $order)
                        ->with('updateSuccess', 'Order marked as delivered.');
    }

    /**
     * Function to mark the order as "Cancelled"
     */
    public function markCancelled(DeliveryValidation $request, Order $order)
    {
        $order->update([
            'order_status' => 'Cancelled',
            'reason' => $request->reason
        ]);

        OrderHistory::updateOrCreate(
            ['order_id' => $order->id, 'order_status' => 'Cancelled', 'delivery_remarks' => $order->reason]
        );
        
        return redirect()->route('delivery.view', $order)
                         ->with('updateSuccess', 'Order marked as cancelled.');
    }

    /**
     * Function to mark the order as "Re-Schedule Delivery"
     */
    public function markReschedule(Request $request, Order $order)
    {
        $request->validate([
            'delivery_remarks' => 'required|in:Customer Cannot be reached,Customer Refused to Accept the parcel,Customer Re-scheduled the delivery,Payment is not ready,Rider Cannot locate the address (incomplete)'
        ]);

        // Update order status
        $order->update([
            'order_status' => 'Re-Schedule Delivery',
        ]);

        // Store the reschedule remarks in Order History
        OrderHistory::create([
            'order_id' => $order->id,
            'order_status' => 'Re-Schedule Delivery',
            'delivery_remarks' => $request->delivery_remarks,
        ]);

        return redirect()->route('delivery.view', $order)
                        ->with('updateSuccess', 'Order marked as Re-Schedule Delivery.');
    }

}
