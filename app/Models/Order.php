<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'driver_id', 'status', 'name', 'email', 'phone', 'address'];

    // Assuming 'customer' refers to a user in your system
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with the driver
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Relationship with order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Assign driver to the order
    public function assignDriver(User $driver)
    {
        $this->driver_id = $driver->id;
        $this->status = 'assigned';
        $this->save();
    }
}
