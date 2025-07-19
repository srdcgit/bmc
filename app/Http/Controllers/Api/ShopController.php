<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentShop;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $shops = Shop::select('shops.*')->with(
                'establishment_shop',
                'establishment_category',
                'establishment',
                'zone',
                'ward',
                'structure',
                'user',
                )->where('user_id',Auth::user()->id)->get();

            return response([
                "shops" => $shops,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        
        try {
            $this->validate($request,[
                'owner_name' => 'required',
                'user_id' => 'required',
            ]);
            $shop = Shop::create($request->all());
            if($request->establishment_shop_id)
            {
                $establishment_shop = EstablishmentShop::find($request->establishment_shop_id);
                if($establishment_shop)
                {
                    $establishment_shop->update([
                        'status' => true
                    ]);
                }
            }

            return response([
                "shop" => $shop,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $shop = Shop::select('shops.*')->with(
                'establishment_shop',
                'establishment_category',
                'establishment',
                'zone',
                'ward',
                'structure',
                'user',
                )->where('id',$id)->first();
            return response([
                "shop" => $shop,
            ], 200);
        } catch (\Exception $e) {
            return response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
