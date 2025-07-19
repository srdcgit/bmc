<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Cam;
use Exception;
use Illuminate\Http\Request;

class CamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cam = Cam::all();
        $establishments = Establishment::all();
        return view('super_admin.cam.index',compact('establishments','cam'));
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
            $isAlready = Cam::where('establishment_id',$request->establishment_id)->first();
            if($isAlready)
            {
                toastr()->warning("Alread Exists.");
                return redirect()->back();
            }else{
                Cam::create($request->all());
            }
            toastr()->success('CAM Added Successfully');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopTax  $shopTax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cam = Cam::find($id);
        $establishments = Establishment::all();
        return view('super_admin.cam.edit',compact('establishments','cam'));
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
        $cam = Cam::find($id);
        $cam->update($request->all());
        toastr()->success('CAM Charges Updated successfully');
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
        $cam = Cam::find($id);
        $cam->delete();
        toastr()->success('Shop Interest Deleted successfully');
        return redirect()->back();
    }
}
