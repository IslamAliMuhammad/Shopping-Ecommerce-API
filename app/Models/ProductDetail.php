<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'size', 'color', 'units'];
    

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function photos(){
        return $this->hasMany(Photo::class, 'product_detail_id');
    }
}
