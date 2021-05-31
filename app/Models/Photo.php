<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['product_detail_id', 'path'];

   public function productDetail(){
       return $this->belongsTo(ProductDetail::class, 'product_detail_id');
   }
}
