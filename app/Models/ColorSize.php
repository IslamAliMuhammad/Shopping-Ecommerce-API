<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\ProductColor;
use App\Models\Size;

class ColorSize extends Pivot
{
    //
    public $incrementing = true;


    /**
     * Get ColorSizeModel instance 
     * 
     * @param App\Models\ProductColor $productColor
     * @param App\Models\Size $sizeId
     * @return  
     */
    public static function colorSizeModel(ProductColor $productColor, Size $size)
    {
        return $productColor->sizes()->wherePivot("size_id", $size->id)->firstOrFail()->pivot;
    }

    /**
     * Decrease units ColorSzie model instance
     * 
     * @param App\Models\ProductColor $productColor 
     * @param App\Models\Size $size 
     * @return void
     */
    public function decreaseUnits($units)
    {
        if($this->units == 0) {
            return "Product is out of stock.";
        }else if($units > $this->units) {
            return [
                "error" => "Quantity is greater than what in stock.",
                "stockUnits" => $this->$units,
                "orderQuantity" => $units,
            ];
        }
        $this->update(['units' => ($this->units - $units)]);
    }

    /**
     * Increase units ColorSzie model instance
     * 
     * @param App\Models\ProductColor $productColor 
     * @param App\Models\Size $size 
     * @return void
     */
    public function increaseUnits($units)
    {
        $this->update(['units' => ($this->units + $units)]);
    }
}
