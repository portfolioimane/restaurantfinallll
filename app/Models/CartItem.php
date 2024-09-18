<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'food_id', 'variant_values', 'quantity'];

    // Cast variant_values from JSON to array when accessing
    protected $casts = [
        'variant_values' => 'array',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    // Accessor to get the variant details
   public function getVariantDetailsAttribute()
{
    $variantValues = $this->variant_values;
    $details = [];

    if (is_string($variantValues)) {
        $variantValues = json_decode($variantValues, true); // Decode JSON if it's a string
    }

    if (is_array($variantValues)) {
        foreach ($variantValues as $variantId => $values) {
            $variant = Variant::find($variantId);
            if ($variant) {
                $details[$variant->type] = [];
                foreach ($values as $valueId) {
                    $value = VariantValue::find($valueId);
                    if ($value) {
                        $details[$variant->type][] = $value;
                    }
                }
            }
        }
    }

    return $details;
}

}
