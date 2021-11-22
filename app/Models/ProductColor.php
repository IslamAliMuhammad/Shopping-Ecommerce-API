<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Size;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\ColorSize;
class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'hex_code'];
    
    public function sizes() {
        return $this->belongsToMany(Size::class, 'color_size', 'product_color_id', 'size_id')->using(ColorSize::class)->withPivot('units');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function photos(){
        return $this->hasMany(Photo::class, 'product_detail_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'cart_item', 'product_detail_id', 'user_id')->using(CartItem::class)->withPivot('quantity');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_item', 'product_detail_id', 'order_id')->using(OrderItem::class)->withPivot('quantity');
    }
}
