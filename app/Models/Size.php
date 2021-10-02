<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductColor;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['code'];

    public function product_colors() {
        return $this->belongsToMany(ProductColor::class, 'color_size', 'size_id', 'product_color_id')->withPivot('units');
    }
}
