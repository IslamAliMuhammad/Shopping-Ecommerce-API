<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Size;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'hex_code'];
    
    public function sizes() {
        return $this->belongsToMany(Size::class, 'color_size', 'product_color_id', 'size_id')->withPivot('units');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function photos(){
        return $this->hasMany(Photo::class, 'product_detail_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'cart_item', 'product_detail_id', 'user_id')->withPivot('quantity');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_item', 'product_detail_id', 'order_id')->withPivot('quantity');
    }
}
