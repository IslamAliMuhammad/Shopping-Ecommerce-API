<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductDetail;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_delivered',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productDetails(){
        return $this->belongsToMany(ProductDetail::class, 'order_item', 'order_id', 'product_detail_id')->withPivot('quantity');
    }
}
