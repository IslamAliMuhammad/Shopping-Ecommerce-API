<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'units',
        'price',
        'photo_path',
    ];

    public function orders(){
        return $this->hasMay(Order::class);
    }
}
