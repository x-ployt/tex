<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\BulkOrderValidation;
use App\Http\Requests\OrderValidation;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Redirecting to order.index
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $query = Order::query();

        $today = now()->toDateString();

        // Updated: Use Carbon to get full day range
        $fromDate = Carbon::parse($request->input('from_date', $today))->startOfDay();
        $toDate = Carbon::parse($request->input('to_date', $today))->endOfDay();
        $selectedBranch = $request->input('branch_id', $authUser->branch_id);

        $branches = Branch::get();

        if ($selectedBranch !== 'all') {
            $query->where('branch_id', $selectedBranch);
        }

        // Apply fixed date range filter
        $query->whereBetween('created_at', [$fromDate, $toDate]);

        if ($request->filled('order_status') && $request->order_status !== 'all') {
            $query->where('order_status', $request->order_status);
        }

        $orders = $query->get();

        return view('navigation.order.index', compact('orders', 'fromDate', 'toDate', 'branches', 'selectedBranch'));
    }

    /**
     * Redirecting to order.create
     */
    public function create()
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
        
        
        return view('navigation.order.create', compact('riders', 'branches'));
    }

    /**
     * Function for creating single order
     */
    public function store(OrderValidation $request)
    {
        // Create order
        $order = Order::create($request->validated());

        // Create order history
        OrderHistory::create([
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'delivery_remarks' => 'Order is out for delivery'
        ]);

        return redirect()->route('order.create')->with('addSuccess', 'Order created successfully.');
    }

    /**
     * Function for creating bulk orders
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'bulk_orders' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('bulk_orders');

        // Read CSV file
        $data = array_map('str_getcsv', file($file->getRealPath()));

        if (empty($data)) {
            return back()->withErrors(['error' => 'CSV file is empty or not formatted correctly.']);
        }

        $csvHeaders = array_shift($data); // Extract headers

        // Define a mapping from CSV column names to database fields
        $columnMap = [
            'Order Date'         => 'order_date',
            'Order No.'          => 'order_no',
            'Customer Name'      => 'customer_name',
            'Address'            => 'customer_address',
            'Contact Number'     => 'customer_contact_number',
            'Amount'             => 'order_amount',
            'MOP'                => 'order_mop',
            'Branch'             => 'branch_name',
            'Rider'              => 'rider_name',
            'Status'             => 'order_status',
        ];

        // Check if headers match expected values
        foreach ($csvHeaders as $header) {
            if (!isset($columnMap[$header])) {
                return back()->withErrors(['error' => 'Invalid column name in CSV file. Please check the template.']);
            }
        }

        $orderHistories = [];

        foreach ($data as $row) {
            $mappedRow = [];

            foreach ($csvHeaders as $index => $csvHeader) {
                if (isset($columnMap[$csvHeader])) {
                    $value = $row[$index] ?? null;

                    // Trim specific fields
                    if (in_array($columnMap[$csvHeader], ['order_no', 'branch_name', 'rider_name', 'order_status', 'customer_contact_number']) && $value !== null) {
                        $value = trim($value);
                    }

                    $mappedRow[$columnMap[$csvHeader]] = $value;
                }
            }

            if (!$mappedRow) {
                return back()->withErrors(['error' => 'CSV format issue. Please check the file.']);
            }

            // Normalize order_date to Y-m-d format
            if (!empty($mappedRow['order_date'])) {
                try {
                    $mappedRow['order_date'] = \Carbon\Carbon::parse($mappedRow['order_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    return back()->withErrors(['error' => "Invalid date format for order date: '{$mappedRow['order_date']}'"]);
                }
            }

            // Find the branch ID based on branch name
            $branch = Branch::where('branch_name', $mappedRow['branch_name'])->first();
            if (!$branch) {
                return back()->withErrors(['error' => "Branch '{$mappedRow['branch_name']}' not found in the system."]);
            }
            $mappedRow['branch_id'] = $branch->id;
            unset($mappedRow['branch_name']);

            // Find the user ID based on rider name
            $user = User::where('name', $mappedRow['rider_name'])->first();
            if (!$user) {
                return back()->withErrors(['error' => "Rider '{$mappedRow['rider_name']}' not found in the system."]);
            }
            $mappedRow['assigned_user_id'] = $user->id;
            unset($mappedRow['rider_name']);

            // Create or update the order
            $order = Order::updateOrCreate(
                ['order_no' => $mappedRow['order_no']],
                $mappedRow
            );

            // Default delivery remarks for "For Delivery" status
            $deliveryRemarks = ($order->order_status === "For Delivery") ? "Order is out for delivery" : null;

            // Create order history entry
            $orderHistories[] = [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'delivery_remarks' => $deliveryRemarks,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all order history records
        if (!empty($orderHistories)) {
            OrderHistory::insert($orderHistories);
        }

        return back()->with('addSuccess', 'Bulk orders processed successfully.');
    }


    /**
     * Redirecting to view $order
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

        return view('navigation.order.view', compact('order', 'branches', 'riders'));
    }

    /**
     * Function to update order
     */
    public function update(OrderValidation $request, Order $order)
    {
        // Check previous order status before updating
        $previousStatus = $order->order_status;
        // $userName = Auth::user()->name;
        // $roleName = Auth::user()->role->role_name;

        // Update order
        $order->update($request->validated());

        if ($request->order_status == 'For Delivery') {
            $deliveryRemarks = 'Order is out for delivery.';
        } elseif ($request->order_status == 'Re-Schedule Delivery') {
            $deliveryRemarks = 'Order Re-Scheduled by an admin.';
        } elseif ($request->order_status == 'RTS') {
            $deliveryRemarks = 'An admin updated this order status to RTS.';
        } elseif ($request->order_status == 'Delivered') {
            $deliveryRemarks = 'An admin updated this order status to Delivered.';
        }

        // Check if the order status has changed
        if ($previousStatus !== $order->order_status) {
            // Create an order history entry
            OrderHistory::create([
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'delivery_remarks' => $deliveryRemarks
            ]);
        }

        return redirect()->back()->with('updateSuccess', 'Order updated successfully.');
    }

    /**
     * Function to delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully.');
    }
}

