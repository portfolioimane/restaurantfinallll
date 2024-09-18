<?php
namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverOrderController extends Controller
{
    public function index()
    {
        $driverId = Auth::id(); // Get the logged-in driver's ID
       
  
        
        // Get orders assigned to the logged-in driver
        $orders = Order::where('driver_id', $driverId)
                       ->with(['customer', 'items.food'])
                       ->get();

        return view('driver.orders.index', compact('orders'));
    }

    // OrderController.php
public function show($id)
{
    $order = Order::with('items.food', 'customer')->findOrFail($id);
    return view('driver.orders.show', compact('order'));
}

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'status' => 'required|string|in:pending,progress,completed,received,ongoing,delivered',
    ]);

    $order->status = $request->input('status');
    $order->save();

    return redirect()->back()->with('success', 'Order status updated successfully.');
}



public function markAsRead(Request $request)
{
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
}



}
