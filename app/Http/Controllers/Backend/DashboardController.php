<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch data to be displayed on the dashboard
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $availableDrivers = User::where('role', 'driver')->count();

        // Fetch recent orders and drivers for the dashboard
        $orders = Order::with('customer', 'driver')->latest()->take(10)->get();
        $drivers = User::where('role', 'driver')->get();

        return view('admin.dashboard', compact('totalOrders', 'pendingOrders', 'availableDrivers', 'orders', 'drivers'));
    }
}
