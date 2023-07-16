<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profile.wishlists', [
            "wishlists" => Wishlist::with('service')->where('user_id', Auth::id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
        // return $id;
        if (!Wishlist::where('service_id', $id)->where('user_id', Auth::id())->exists()) {
            $wish = new Wishlist();
            $wish->user_id = Auth::id();
            $wish->service_id = $id;
            $wish->save();

            return "Saved to Wishlist";
        }
    }
    
    public function unstore(string $id)
    {
        // return $id;
        $wishlist = Wishlist::where('service_id', $id)->first();
        $wishlist->delete();

        return "Unsaved to Wishlist";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
