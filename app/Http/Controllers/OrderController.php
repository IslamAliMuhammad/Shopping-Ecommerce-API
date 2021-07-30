<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

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

        return response()->json(['orders' => $orders], 200);
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

        $order = Order::create(['user_id' => auth()->id(), 'is_delivered' => false]);

        $quantities = [];
        foreach(auth()->user()->productDetails as $productDetail){
            $quantities[] = ['quantity' => $productDetail->pivot->quantity];
        }

        $order->productDetails()->attach(array_combine(auth()->user()->productDetails->pluck('id')->all(), $quantities));

        auth()->user()->productDetails()->detach();

        return response()->json(['message' => 'Order successfully Placed', 'order' => $order], 200);
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

        return response()->json(['order' => $order], 200);
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
        
        return response()->json(['message' => 'Order updated successfully'], 200);
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

        $order->delete();

        return response()->json(['message' => 'Order successfully deleted '], 200);
    }
}
