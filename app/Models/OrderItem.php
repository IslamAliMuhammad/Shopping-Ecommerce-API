<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Size;
use App\Models\ProductColor;

class OrderItem extends Pivot
{
    //

    public $incrementing = true;

    
    public function size() {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function productColor() {
        return $this->belongsTo(ProductColor::class, "product_color_id");
    }

}
