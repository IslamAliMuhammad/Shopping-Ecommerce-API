<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use Illuminate\Http\Request;

class CartItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItems  $cartItems
     * @return \Illuminate\Http\Response
     */
    public function show(CartItems $cartItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItems  $cartItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItems $cartItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItems  $cartItems
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItems $cartItems)
    {
        //
    }
}
