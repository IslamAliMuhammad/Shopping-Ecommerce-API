<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductColor;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['product_detail_id', 'path'];

   public function ProductColor(){
       return $this->belongsTo(ProductColor::class, 'product_color_id');
   }
}
