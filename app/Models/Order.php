<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductColor;
use App\Models\OrderItem;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_delivered',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ProductColors() {
        return $this->belongsToMany(ProductColor::class, 'order_item', 'order_id', 'product_color_id')->using(OrderItem::class)->withPivot('quantity');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, "order_id");
    }

    /**
     * Get Order with its array of OrderItem(s) and for each OrderItem get its ProductColor and Size and for productColor get its product
     * 
     */
    public function orderWithDescendantModels() {
        return Order::with(["orderItems", "orderItems.productColor.product", "orderItems.size"])->where("id", $this->id)->firstOrFail();
    }

    /**
     * Return order to stock that was pre-ordered
     * 
     * @param App\Models\Order $order 
     * return void
     */
    public function returnOrderToStock()
    {
        $order = $this->orderWithDescendantModels();

        foreach ($order->orderItems as $orderItem) {
            $colorSizeModel = ColorSize::colorSizeModel($orderItem->productColor, $orderItem->size);
            $colorSizeModel->decreaseUnits($orderItem->quantity);
        }
    }
}
