<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $orders = Order::where('user_id', Auth::id())->paginate(10);

        if ($orders) {
            return response()->json($orders, 200);
        }
        return response()->json(['error' => 'Internal Server Error'], 500);
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
        $validated = $request->validate([
            'product_id' => 'required|numeric|exists:products,id',
            'user_id' => 'required|numeric|exists:users,id',
            'quantity' => 'required|numeric',
            'address' => 'required|string',
        ]);

        $order = Order::create($validated);

        if ($order) {
            return response()->json($order, 201);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
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


        if ($order->user_id === Auth::id()) {
            return response()->json($order, 200);
        }

        return response()->json(['message' => 'Unauthorized action'], 401);
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

        if(!$order->is_delivered){
            if ($order->user_id === Auth::id()) {
                $isUpdated = $order->update($request->only('address'));
                if ($isUpdated) {
                    return response()->json(['message' => 'Order was updated successfully'], 200);
                }
    
                return response()->json(['error' => 'Inernal Server Errror'], 500);
            }
    
            return response()->json(['message' => 'Unauthorized action'], 401);
        }
        
        return response()->json(['message' => "Can't update a delivered order"], 403);
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
        if(!$order->is_delivered){
            if($order->user_id === Auth::id()){
                $isDeleted = $order->delete();
                if($isDeleted){
                    return response()->json(['message' => 'Order was deleted successfully'], 200);
                }

                return response()->json(['error' => 'Internal Server Error'], 500);
            }

            return response()->json(['message' => 'Unauthorized action'], 401);
        }

        return response()->json(['message' => "Can't delete a delivered order"], 403);
    }
}
