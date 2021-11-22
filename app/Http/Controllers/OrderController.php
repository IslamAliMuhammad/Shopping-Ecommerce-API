<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\ColorSize;
/**
 * @group orders
 */
class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = auth()->user()->orders;

        return response()->json(["orders" => $orders], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $order = Order::create(["user_id" => auth()->id()]);

        $cartItems = auth()->user()->cartItems;

        if(sizeof($cartItems) == 0) {
            return response()->json(["message" => "Cart is empty."], 404);
        }

        $cartItemsFormatted = array_map(function ($arr) {
            unset($arr["user_id"]);
            return $arr;
        }, json_decode(json_encode($cartItems->all()), true));

        $orderItems = $order->orderItems()->createMany($cartItemsFormatted);

        CartItem::destroy($cartItems);

        foreach($orderItems as $orderItem) {
            $colorSize = ColorSize::colorSizeModel($orderItem->productColor, $orderItem->size);
            $colorSize->decreaseUnits($orderItem->quantity);
        }
        return response()->json(["message" => "Order successfully placed!", "order" => $order], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // 
        $order = Order::with(['orderItems', 'orderItems.productColor.product', 'orderItems.size'])->where("id", $order->id)->firstOrFail();
        return response()->json(["order" => $order], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
        $this->authorize('update', $order);

        $validated = $request->validate([
            'is_delivered' => 'required|boolean',
        ]);

        $order->update($validated);
        
        return response()->json(['message' => 'Order updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $this->authorize('delete', $order);
        
        $order->returnOrderToStock();

        $order->delete();
        
        return response()->json(['message' => 'Order successfully deleted!'], 200);
    }
}
