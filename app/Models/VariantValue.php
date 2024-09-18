<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantValue extends Model
{
    protected $fillable = ['variant_id', 'value', 'price'];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
