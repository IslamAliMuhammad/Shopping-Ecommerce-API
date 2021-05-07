<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function register(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email'=> 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $passwordHashed =  Hash::make($request->password);
        $validated['password'] = $passwordHashed;

        $user = User::create($validated);
        
        if($user){
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('personalAccessToken')->plainTextToken,
            ], 201);
        }
       
        return response()->json(['error' => 'Internal Server Error'], 500);
    }   

    public function login(Request $request) {
        $credentials = $request->only('email', 'password'); 

        if(Auth::attempt($credentials)){
            return response()->json(['token' => Auth::user()->createToken('personalAccessToken')->plainTextToken], 200);
        }

        return response()->json(['error' => 'Invalid email or password'], 401);
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $isDeleted = $user->delete();

        if($isDeleted){
            return response()->json(['message' => 'User was deleted successfully'], 200);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
