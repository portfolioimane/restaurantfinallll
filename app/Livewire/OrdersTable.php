<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\User; // Use User for drivers

// app/Livewire/OrdersTable.php

class OrdersTable extends Component
{
    public $orders;
    public $drivers;


    public function mount()
    {
        $this->loadOrders();
        $this->drivers = User::where('role', 'driver')->get();
    }

    public function render()
    {
        return view('livewire.orders-table');
    }

    public function loadOrders()
    {
        $this->orders = Order::with(['items.food', 'driver'])->get();
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
            $this->loadOrders(); // Refresh orders after update
            $this->dispatch('orderUpdated'); // Optional: for additional refresh or notifications
        }
    }

   public function assignDriver($orderId, $driverId)
{
    $order = Order::find($orderId);
    if ($order) {
        $order->driver_id = $driverId;
        $order->save();

        // Get the assigned driver
        $driver = User::find($driverId);

        // Send notification to the driver
        $driver->notify(new \App\Notifications\DriverAssigned($order));

        // Refresh orders after update
        $this->loadOrders();
        
        // Optionally dispatch an event for additional handling
        $this->dispatch('orderUpdated');
    }
}

}
