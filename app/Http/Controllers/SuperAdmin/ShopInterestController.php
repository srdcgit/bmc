<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\ShopInterest;
use Exception;
use Illuminate\Http\Request;

class ShopInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interest = ShopInterest::all();
        $establishments = Establishment::all();
        return view('super_admin.shop_interest.index',compact('establishments','interest'));
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
        try{
            $this->validate($request,[
                'amount' => 'required',
                'establishment_id' => 'required',
            ]);
            $isAlready = ShopInterest::where('establishment_id',$request->establishment_id)->first();
            if($isAlready)
            {
                toastr()->warning("Alread Exists.");
                return redirect()->back();
            }else{
                ShopInterest::create($request->all());
            }
            toastr()->success('Shop Interest Added Successfully');
            return redirect()->back();
        }catch (Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopTax  $shopTax
     * @return \Illuminate\Http\Response
     */
    public function show(ShopTax $shopTax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopTax  $shopTax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $interest = ShopInterest::find($id);
        $establishments = Establishment::all();
        return view('super_admin.shop_interest.edit',compact('establishments','interest'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopTax  $shopTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $interest = ShopInterest::find($id);
        $interest->update($request->all());
        toastr()->success('Shop Interest Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopTax  $shopTax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopInterest = ShopInterest::find($id);
        $shopInterest->delete();
        toastr()->success('Shop Interest Deleted successfully');
        return redirect()->back();
    }
}
