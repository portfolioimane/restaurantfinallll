<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = ['name', 'description', 'base_price'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
