<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Size;
use App\Models\ProductColor;
use App\Models\User;
class CartItem extends Pivot
{
    //
    public $incrementing = true;

    protected $guarded = ["created_at", "updated_at"];
    
    public function size() {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function productColor() {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

}
