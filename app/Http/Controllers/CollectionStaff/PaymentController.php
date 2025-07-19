<?php

namespace App\Http\Controllers\CollectionStaff;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentCollection;
use App\Models\Shop;
use App\Services\BillDeskService;
use App\Services\SmsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('collection_staff.payment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('collection_staff.payment.create');
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
                'name' => 'required',
                'amount' => 'required',
                'location' => 'required',
                'type' => 'required',
                'payment_mode' => 'required',
                'user_id' => 'required',
            ]);
            if($request->payment_mode == "UPI")
            {
                $request->merge([
                    'is_paid' => 0
                ]);
            }else{
                $request->merge([
                    'is_paid' => 1
                ]);
            }
            $payment = Payment::create($request->all());
            if($payment->is_paid)
            {
                $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                if($phone && strlen($phone) == 10)
                {
                    (new SmsService())->sendSMS($phone);
                    (new SmsService())->sendWhatsappSMS($phone,$payment);
                }else{
                    Log::info("Sms Service phone number have issue : ".$phone);
                }
            }
            if($payment->payment_mode == "UPI")
            {
                return redirect()->to(route('collection_staff.payment.show',$payment->id));
            }
            toastr()->success('Payment Added Successfully');
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        $billdeskService = new BillDeskService();
        $response = $billdeskService->createOrder($payment);
        if($response['success'] == true)
        {
            $authorization_token = $response['authorization_token'];
            $order_id = $response['order_id'];
            $original_order_id = $response['original_order_id'];
            $payment->update([
                'order_id' => $original_order_id
            ]);
            $url = url('success');
            return view('collection_staff.payment.show',compact('authorization_token','order_id','url'));
        }else{
            toastr()->error($response['error']);
            return redirect()->to(route('collection_staff.payment.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::find( $id);
        $payment =   Payment::where('shop_id',$shop->id)
            ->where('month',Carbon::now()->format('F'))
            ->where('year',Carbon::now()->format('Y'))
            ->where('type','monthly')
            ->where('is_arrear',0)
            ->where('is_paid','0')->first();
        // $currentBill = 0;
        // foreach($payments as $payment){
        //     $currentBill = $currentBill + $payment->dueAmount();
        // }
        return view('collection_staff.payment.edit',compact('shop','payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $payment = Payment::find($id);
        if($request->payment_mode == "UPI")
        {
            $request->merge([
                'is_paid' => 0
            ]);
        }
        $payment->update($request->all());
        if($payment->is_paid)
        {
            $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
            if($phone && strlen($phone) == 10)
            {
                (new SmsService())->sendSMS($phone);
                (new SmsService())->sendWhatsappSMS($phone,$payment);
            }else{
                Log::info("Sms Service phone number have issue : ".$phone);
            }
        }
        if($payment->payment_mode == "UPI")
        {
            return redirect()->to(route('collection_staff.payment.show',$payment->id));
        }
        toastr()->success('Payment Updated successfully');
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        toastr()->success('Payment Deleted successfully');
        return redirect()->back();
    }
    public function storePay(Request $request)
    {
        if($request->shop_id && $request->amount > 0 && $request->payment_method){
            if($request->payment_method == 'online'){
                return redirect()->to(route('collection_staff.payment.view',['shop_id' => $request->shop_id,'amount' => $request->amount]));
            }else{
                try{
                    $totalAmount = 0;
                    $shop = Shop::find($request->shop_id);
                    $currentYear = Carbon::now()->year;
                    $payments = Payment::where('shop_id',$shop->id)
                            ->where('is_previous_payment','1')
                            ->where('type','monthly')
                            ->where('is_paid','0')
                            ->where(function ($query) use ($currentYear) {
                                $query->where('year', $currentYear)
                                    ->whereIn('month', ['January', 'February', 'March']);
                            })
                            ->orWhere(function ($query) use ($currentYear) {
                                $query->where('year','<', $currentYear);
                            })
                            ->get();
                    $currentYear = Carbon::now()->year;
                    if (now()->month < 4) {
                        $startYear = $currentYear - 1;
                        $endYear = $currentYear;
                    } else {
                        $startYear = $currentYear;
                        $endYear = $currentYear + 1;
                    }
                    $remainingPayments = Payment::where('shop_id', $shop->id)
                        ->where('month', '!=', Carbon::now()->format('F'))
                        ->where('type', 'monthly')
                        ->where('is_paid', '0')
                        ->where(function ($query) use ($startYear, $endYear) {
                            $query->where(function ($query) use ($startYear) {
                                $query->where('year', $startYear)
                                    ->whereIn('month', [
                                        'April',
                                        'May',
                                        'June',
                                        'July',
                                        'August',
                                        'September',
                                        'October',
                                        'November',
                                        'December',
                                    ]);
                            });
                            $query->orWhere(function ($query) use ($endYear) {
                                $query->where('year', $endYear)
                                    ->whereIn('month', ['January', 'February', 'March']);
                            });
                        })
                        ->get();
                    $totalAmount = $request->amount;
                    $original_order_id = 'cash_'.rand(0, 6);
                    $original_transcation_id = 'cash_transcation_'.rand(0, 6);
                    $currentPayment =   Payment::where('shop_id',$shop->id)
                        ->where('month',Carbon::now()->format('F'))
                        ->where('year',Carbon::now()->format('Y'))
                        ->where('type','monthly')
                        ->where('is_arrear',0)
                        ->where('is_paid','0')->first();
                    if($currentPayment){
                        
                        if($totalAmount > 0){
                            if($totalAmount >= $currentPayment->dueAmount()){
                                $amountToPay = $currentPayment->dueAmount();
                                $totalAmount = $totalAmount - $currentPayment->dueAmount();
                                $currentPayment->update([
                                    'is_paid' => 1,
                                    'payment_date' => Carbon::now(),
                                    'transcation_id' => $original_transcation_id,
                                    'payment_method' => 'Cash',
                                ]);
                            }else{
                                $amountToPay = $totalAmount;
                                $totalAmount = 0;
                            }
                            PaymentCollection::create([
                                'payment_id' => $currentPayment->id,
                                'amount' => $amountToPay,
                                'order_id' => $original_order_id,
                                'transcation_id' => $original_transcation_id,
                                'payment_mode' => 'Cash',
                            ]);
                        }
                    }
                    foreach($payments as $payment){
                        if($totalAmount > 0){
                            if($totalAmount >= $payment->dueAmount()){
                                $amountToPay = $payment->dueAmount();
                                $totalAmount = $totalAmount - $payment->dueAmount();
                                $payment->update([
                                    'is_paid' => 1,
                                    'payment_date' => Carbon::now(),
                                    'transcation_id' => $original_transcation_id,
                                    'payment_method' => 'Cash',
                                ]);
                            }else{
                                $amountToPay = $totalAmount;
                                $totalAmount = 0;
                            }
                            PaymentCollection::create([
                                'payment_id' => $payment->id,
                                'amount' => $amountToPay,
                                'order_id' => $original_order_id,
                                'transcation_id' => $original_transcation_id,
                                'payment_mode' => 'Cash',
                            ]);
                        }
                        if($payment->month != Carbon::now()->format('F')){
                            $payment->update([
                                'interest' => $payment->getInterestValue(),
                            ]);
                        }
                        $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                        if($phone && strlen($phone) == 10)
                        {
                            (new SmsService())->sendSMS($phone);
                            (new SmsService())->sendWhatsappSMS($phone,$payment);
                        }
                    }
                    foreach($remainingPayments as $remainingPayment){
                        if($totalAmount > 0){
                            if($totalAmount >= $remainingPayment->dueAmount()){
                                $amountToPay = $remainingPayment->dueAmount();
                                $totalAmount = $totalAmount - $remainingPayment->dueAmount();
                                $remainingPayment->update([
                                    'is_paid' => 1,
                                    'payment_date' => Carbon::now(),
                                    'transcation_id' => $original_transcation_id,
                                    'payment_method' => 'Cash',
                                ]);
                            }else{
                                $amountToPay = $totalAmount;
                                $totalAmount = 0;
                            }
                            
                            PaymentCollection::create([
                                'payment_id' => $remainingPayment->id,
                                'amount' => $amountToPay,
                                'order_id' => $original_order_id,
                                'transcation_id' => $original_transcation_id,
                                'payment_mode' => 'Cash',
                            ]);
                        }
                        if($remainingPayment->month != Carbon::now()->format('F')){
                            $remainingPayment->update([
                                'interest' => $remainingPayment->getInterestValue(),
                            ]);
                        }
                        $phone = $remainingPayment->phone ? $remainingPayment->phone : @$remainingPayment->shop->phone;
                        if($phone && strlen($phone) == 10)
                        {
                            (new SmsService())->sendSMS($phone);
                            (new SmsService())->sendWhatsappSMS($phone,$remainingPayment);
                        }
                    }
                    toastr()->success('Amount Paid Successfully!');
                    return redirect()->back();
                }catch(Exception $e){
                    toastr()->error($e->getMessage());
                    return redirect()->back();
                }
            }
        }
        toastr()->error('Please Choose Payment or Method!');
        return redirect()->back();
    }
    public function view(Request $request)
    {
        $totalAmount = 0;
        $name = null;
        $type = null;
        $shop = Shop::find($request->shop_id);
        // foreach($request->payment_id as $payment_id){
        //     $payment = Payment::find($payment_id);
        //     $totalAmount = $totalAmount + $payment->getTotalAmount();
        //     $name = $payment->name;
        //     $type = $payment->type;
        // }
        $billdeskService = new BillDeskService();
        $response = $billdeskService->createOrderForMulitplePayment($request->amount,'monthly',$shop->owner_name);
        if($response['success'] == true)
        {
            $authorization_token = $response['authorization_token'];
            $order_id = $response['order_id'];
            $original_order_id = $response['original_order_id'];
            $currentYear = Carbon::now()->year;
            $payments = Payment::where('shop_id',$shop->id)
                    ->where('is_previous_payment','1')
                    ->where('type','monthly')
                    ->where('is_paid','0')
                    ->where(function ($query) use ($currentYear) {
                        $query->where('year', $currentYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                    })
                    ->orWhere(function ($query) use ($currentYear) {
                        $query->where('year','<', $currentYear);
                    })
                    ->get();
            $totalAmount = $request->amount;
            $currentPayment =   Payment::where('shop_id',$shop->id)
                ->where('month',Carbon::now()->format('F'))
                ->where('year',Carbon::now()->format('Y'))
                ->where('type','monthly')
                ->where('is_arrear',0)
                ->where('is_paid','0')->first();
            if($currentPayment){
                
                if($totalAmount > 0){
                    if($totalAmount >= $currentPayment->dueAmount()){
                        $amountToPay = $currentPayment->dueAmount();
                        $totalAmount = $totalAmount - $currentPayment->dueAmount();
                    }else{
                        $amountToPay = $totalAmount;
                        $totalAmount = 0;
                    }
                    PaymentCollection::create([
                        'payment_id' => $currentPayment->id,
                        'amount' => $amountToPay,
                        'order_id' => $original_order_id,
                        'payment_mode' => 'Online',
                    ]);
                }
            }
            foreach($payments as $payment){
                if($totalAmount > 0){
                    if($totalAmount >= $payment->dueAmount()){
                        $amountToPay = $payment->dueAmount();
                        $totalAmount = $totalAmount - $payment->dueAmount();
                    }else{
                        $amountToPay = $totalAmount;
                        $totalAmount = 0;
                    }
                    PaymentCollection::create([
                        'payment_id' => $payment->id,
                        'amount' => $amountToPay,
                        'order_id' => $original_order_id,
                        'payment_mode' => 'Online',
                    ]);
                }
                if($payment->month != Carbon::now()->format('F')){
                    $payment->update([
                        'interest' => $payment->getInterestValue(),
                    ]);
                }
            }
            $url = url('success_for_multiple');
            return view('collection_staff.payment.show',compact('authorization_token','order_id','url'));
        }else{
            toastr()->error($response['error']);
            return redirect()->to(route('collection_staff.payment.index'));
        }
    }
    public function pending($id)
    {
        $shop = Shop::find($id);
        $payments = Payment::where('is_paid',0)->where('shop_id',$shop->id)->where('type','monthly')->get();
        return view('collection_staff.payment.pending',compact('payments','shop'));
    }
}