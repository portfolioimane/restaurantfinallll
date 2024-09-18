<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'food_id', 'quantity', 'price', 'variant_details'];

    // Cast `variant_details` attribute to an array
   protected $casts = [
    'variant_details' => 'json',
];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
