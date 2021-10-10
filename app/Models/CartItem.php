<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Size;
class CartItem extends Pivot
{
    //
    public $incrementing = true;

    public function size() {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
