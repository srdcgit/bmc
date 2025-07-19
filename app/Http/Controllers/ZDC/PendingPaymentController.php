<?php

namespace App\Http\Controllers\ZDC;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PendingPayment;
use App\Models\Shop;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class PendingPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = [
            '2020-2021',
            '2021-2022',
            '2022-2023',
            '2023-2024',
            '2024-2025',
        ];
        return view('zdc.pending_payment.index',compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = [
            '2020/2021',
            '2021/2022',
            '2022/2023',
            '2023/2024',
            '2024/2025',
        ];
        return view('zdc.pending_payment.create',compact('years'));
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
                'shop_id' => 'required',
            ]);
            $pending_payment = PendingPayment::create($request->all());
            $shop = Shop::find($request->shop_id);
            $currentYear = Carbon::now()->year;
            if (now()->month < 4) {
                $year = $currentYear - 1;
            } else {
                $year = $currentYear;
            }
            Payment::create([
                'month' => 'March',
                'shop_id' => $shop->id,
                'year' => $year,
                'user_id' => $shop->user_id ?? null,
                'pending_payment_id' => $pending_payment->id,
                'type' => 'monthly',
                'location' => $shop->lat_long,
                'name' => $shop->owner_name,
                'owner_name' => $shop->owner_name,
                'shop_name' => $shop->shop_name,
                'phone' => $shop->phone,
                'email' => $shop->email,
                'is_arrear' => 1,
                'is_paid' => 0,
                'establishment_shop_id' => $shop->establishment_shop ? $shop->establishment_shop->id : $shop->establishment_shop_id,
                'establishment_id' => $shop->establishment_shop ? $shop->establishment_shop->establishment_id  : $shop->establishment_id,
                'amount' => number_format($request->amount, 2),
                'tax_amount' =>$request->tax_amounts,
                'cam_charges' => number_format(0, 2),
                'shop_rent' => $shop->establishment_shop ? $shop->establishment_shop->shop_rent : $shop->shop_rent,
                'shop_size' => $shop->establishment_shop ? $shop->establishment_shop->shop_size : $shop->shop_size,
                'shop_type' => $shop->establishment_shop ? $shop->establishment_shop->shop_type : $shop->shop_type,
                'shop_number' => $shop->establishment_shop ? $shop->establishment_shop->shop_number : $shop->shop_number,
            ]);
            toastr()->success('Pending Payment Added Successfully');
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
     * @param  \App\Models\PendingPayment  $pendingPayment
     * @return \Illuminate\Http\Response
     */
    public function show(PendingPayment $pendingPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendingPayment  $pendingPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pending_payment = PendingPayment::find($id);
        $years = [
            '2020-2021',
            '2021-2022',
            '2022-2023',
            '2023-2024',
            '2024-2025',
        ];
        return view('zdc.pending_payment.edit',compact('pending_payment','years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendingPayment  $pendingPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $pendingPayment = PendingPayment::find($id);
        $pendingPayment->update($request->all());
        $shop = Shop::find($request->shop_id);
        $payment = Payment::where('pending_payment_id',$pendingPayment->id)->where('is_paid',0)->first();
        
        $currentYear = Carbon::now()->year;
        if (now()->month < 4) {
            $year = $currentYear - 1;
        } else {
            $year = $currentYear;
        }
        $payment->update([
            'month' => 'March',
            'shop_id' => $shop->id,
            'year' => $year,
            'user_id' => $shop->user_id ?? null,
            'location' => $shop->lat_long,
            'name' => $shop->owner_name,
            'owner_name' => $shop->owner_name,
            'shop_name' => $shop->shop_name,
            'phone' => $shop->phone,
            'email' => $shop->email,
            'is_arrear' => 1,
            'is_paid' => 0,
            'establishment_shop_id' => $shop->establishment_shop ? $shop->establishment_shop->id : $shop->establishment_shop_id,
            'establishment_id' => $shop->establishment_shop ? $shop->establishment_shop->establishment_id  : $shop->establishment_id,
            'amount' => number_format($request->amount, 2),
            'tax_amount' => number_format($request->tax_amounts ?? 0, 2, '.', ''),
            'cam_charges' => number_format(0, 2),
            'shop_rent' => $shop->establishment_shop ? $shop->establishment_shop->shop_rent : $shop->shop_rent,
            'shop_size' => $shop->establishment_shop ? $shop->establishment_shop->shop_size : $shop->shop_size,
            'shop_type' => $shop->establishment_shop ? $shop->establishment_shop->shop_type : $shop->shop_type,
            'shop_number' => $shop->establishment_shop ? $shop->establishment_shop->shop_number : $shop->shop_number,
        ]);
        toastr()->success('Pending Payment Updated successfully');
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendingPayment  $pendingPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendingPayment = PendingPayment::find($id);
        Payment::where('pending_payment_id',$pendingPayment->id)->where('is_paid',0)->delete();
        $pendingPayment->delete();
        
        toastr()->success('Pending Payment Deleted successfully');
        return redirect()->back();
    }
}
