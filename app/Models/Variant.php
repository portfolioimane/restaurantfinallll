<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = ['food_id', 'type'];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function variantValues()
    {
        return $this->hasMany(VariantValue::class);
    }
}

