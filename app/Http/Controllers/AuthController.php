<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Establishment;
use App\Models\EstablishmentShop;
use App\Models\Payment;
use App\Models\PaymentCollection;
use App\Models\Shop;
use App\Models\State;
use App\Models\User;
use App\Services\BillDeskService;
use App\Services\SmsService;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $creds = [
            'email' => $request->email,
            'password' => $request->password
        ];
        //Checking User Registeration Code Start
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            toastr()->error('User is Not Registered.');
            return redirect()->back();
        }
        //Checking User Registeration Code End
        //User Authentication Code Start
        if (Auth::guard('user')->attempt($creds)) {
            if ($user->role->name == 'Admin') {
                toastr()->success('You Login Successfully');
                return redirect()->intended(route('admin.dashboard.index'));
            } else if ($user->role->name == 'Collection Staff') {
                toastr()->success('You Login Successfully');
                return redirect()->intended(route('collection_staff.dashboard.index'));
            } else if ($user->role->name == 'ZDC') {
                return redirect()->intended(route('zdc.dashboard.index'));
                toastr()->success('You Login Successfully');
            } else if ($user->role->name == 'Super Admin') {
                return redirect()->intended(route('super_admin.dashboard.index'));
                toastr()->success('You Login Successfully');
            } else {
                Auth::logout();
                toastr()->error('User is In Active or Not Verified Yet By Admin.');
                return redirect()->back();
            }
        } else {
            toastr()->error('Wrong Password.');
            return redirect()->back();
        }
        //User Authentication Code End
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        toastr()->success('You Logout Successfully');
        return redirect('/');
    }
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'image' => 'required',
                'password' => 'required',
                'role_id' => 'required',
            ]);
            if ($request->password != $request->confirm_password) {
                toastr()->error('Password do not match');
                return redirect()->back();
            }
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users'
            ]);
            if ($validator->fails()) {
                toastr()->error('Email already exists');
                return redirect()->back();
            }
            $user = User::create($request->all());
            toastr()->success('Your Account Has Been successfully Created, Please Login and See Next Step Guides.');
            return redirect(url('/'));
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function success(Request $request)
    {
        try {
            if ($request->transaction_response) {
                list(, $response,) = explode('.', $request->transaction_response);
                $result_decoded = base64_decode(strtr($response, '-_', '+/'));
                $result_array = json_decode($result_decoded, true);
                if ($result_array['transaction_error_type'] == 'success') {
                    $payment = Payment::where('order_id', $result_array['orderid'])->first();
                    $payment->update([
                        'is_paid' => 1,
                        'payment_date' => Carbon::now(),
                        'transcation_id' => $result_array['transactionid'],
                        'payment_method' => $result_array['payment_method_type'],
                    ]);
                    $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                    if ($phone && strlen($phone) == 10) {
                        (new SmsService())->sendSMS($phone);
                        (new SmsService())->sendWhatsappSMS($phone, $payment);
                    }
                    $user = User::find($payment->user_id);
                    Auth::guard('user')->loginUsingId($user->id);
                    toastr()->success('Your Payment Received');
                    return redirect()->intended(route('collection_staff.payment.index'));
                } else {

                    toastr()->error($result_array['transaction_error_type']);
                    return redirect()->intended(route('collection_staff.payment.index'));
                }
            } else {
                toastr()->error("Something Went Wrong");
                return redirect()->intended(route('collection_staff.payment.index'));
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->intended(route('collection_staff.payment.index'));
        }
    }
    public function success_for_multiple(Request $request)
    {
        try {
            if ($request->transaction_response) {
                list(, $response,) = explode('.', $request->transaction_response);
                $result_decoded = base64_decode(strtr($response, '-_', '+/'));
                $result_array = json_decode($result_decoded, true);
                if ($result_array['transaction_error_type'] == 'success') {
                    $user_id = null;
                    $paymentCollections = PaymentCollection::where('order_id', $result_array['orderid'])->get();
                    foreach ($paymentCollections as $paymentCollection) {
                        $paymentCollection->update([
                            'transcation_id' => $result_array['transactionid'],
                            'payment_method' => $result_array['payment_method_type'],
                        ]);
                        $payment = Payment::find($paymentCollection->payment_id);
                        if ($payment->dueAmount() == 0) {
                            $payment->update([
                                'is_paid' => 1,
                                'payment_date' => Carbon::now(),
                                'transcation_id' => $result_array['transactionid'],
                                'payment_method' => $result_array['payment_method_type'],
                            ]);
                        }
                        if (!$user_id) {
                            $user_id = $paymentCollection->payment->user_id;
                        }
                        $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                        if ($phone && strlen($phone) == 10) {
                            (new SmsService())->sendSMS($phone);
                            (new SmsService())->sendWhatsappSMS($phone, $payment);
                        }
                    }
                    if ($user_id) {
                        $user = User::find($user_id);
                        Auth::guard('user')->loginUsingId($user->id);
                    }
                    toastr()->success('Your Payment Success Successfully');
                    return redirect()->intended(route('collection_staff.payment.index'));
                } else {

                    toastr()->error($result_array['transaction_error_type']);
                    return redirect()->intended(route('collection_staff.payment.index'));
                }
            } else {
                toastr()->error("Something Went Wrong");
                return redirect()->intended(route('collection_staff.payment.index'));
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->intended(route('collection_staff.payment.index'));
        }
    }
    public function successForApi(Request $request)
    {
        try {
            if ($request->transaction_response) {
                list(, $response,) = explode('.', $request->transaction_response);
                $result_decoded = base64_decode(strtr($response, '-_', '+/'));
                $result_array = json_decode($result_decoded, true);
                if ($result_array['transaction_error_type'] == 'success') {
                    $payment = Payment::where('order_id', $result_array['orderid'])->first();
                    if ($payment) {
                        $payment->update([
                            'is_paid' => 1,
                            'payment_date' => Carbon::now(),
                            'transcation_id' => $result_array['transactionid'],
                            'payment_method' => $result_array['payment_method_type'],
                        ]);
                        $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                        if ($phone && strlen($phone) == 10) {
                            (new SmsService())->sendSMS($phone);
                            (new SmsService())->sendWhatsappSMS($phone, $payment);
                        }
                        // $user = User::find($payment->user_id);
                        return redirect()->intended(url('?success=1'));
                    } else {
                        return redirect()->intended(url('?success=0'));
                    }
                    // return response([
                    //     "message" => "Your Payment Done Successfully!"
                    // ], 200);
                } else {
                    return redirect()->intended(url('?success=0'));
                }
            } else {
                return redirect()->intended(url('?success=0'));
            }
        } catch (Exception $e) {
            return redirect()->intended(url('?success=0'));
        }
    }
    public function paymentForApi(Request $request)
    {
        $this->validate($request, [
            'payment_id' => 'required',
            'from_api' => 'required',
        ]);
        $payment = Payment::find($request->payment_id);
        $billdeskService = new BillDeskService();
        $response = $billdeskService->createOrder($payment);
        if ($response['success'] == true) {
            $authorization_token = $response['authorization_token'];
            $order_id = $response['order_id'];
            $original_order_id = $response['original_order_id'];
            $payment->update([
                'order_id' => $original_order_id
            ]);
            $url = url('success-for-api');
            return view('collection_staff.payment.show', compact('authorization_token', 'order_id', 'url'));
        } else {
            toastr()->error($response['error']);
            return redirect()->back();
        }
    }
    public function paymentIssue()
    {
        $payments = Payment::all();
        foreach ($payments as $payment) {
            $payment->update([
                'amount' => $payment->amount
            ]);
        }
    }
    public function search_shop(Request $request)
    {
        $input = $request->identifier;
        $shop = null;

        if ($input) {
            // Check if it's likely a phone number (you can improve this logic as needed)
            $isPhone = preg_match('/^\d{10,12}$/', $input); // allow 10-digit numbers or 91-prefixed

            if ($isPhone) {
                if (strpos($input, "91") === 0) {
                    $input = substr($input, 2);
                }
                $shop = Shop::where('phone', $input)->first();
            }

            // If not found or not phone, try as ID proof number
            if (!$shop) {
                $shop = Shop::where('id_proof_number', $input)->first();
            }

            if (!$shop) {
                toastr()->error('Shop does not exist with this Phone or ID Proof Number.');
                return redirect()->intended(url('search_shop'));
            }

            $payment = Payment::where('shop_id', $shop->id)
                ->where('month', Carbon::now()->format('F'))
                ->where('year', Carbon::now()->format('Y'))
                ->where('type', 'monthly')
                ->where('is_arrear', 0)
                ->where('is_paid', '0')
                ->first();

            return view('auth.search_shop', compact('shop', 'payment'));
        }

        return view('auth.search_shop');
    }
    public function mobile_verify(Request $request)
    {
        $input = $request->identifier;
        $shop = null;

        if ($input) {
            // Check if it's likely a phone number (you can improve this logic as needed)
            $isPhone = preg_match('/^\d{10,12}$/', $input); // allow 10-digit numbers or 91-prefixed

            if ($isPhone) {
                if (strpos($input, "91") === 0) {
                    $input = substr($input, 2);
                }
                $shop = Shop::where('phone', $input)->first();
            }

            // If not found or not phone, try as ID proof number
            if (!$shop) {
                $shop = Shop::where('id_proof_number', $input)->first();
            }

            if (!$shop) {
                toastr()->error('Shop does not exist with this Phone or ID Proof Number.');
                return redirect()->intended(url('search_shop'));
            }

            $payment = Payment::where('shop_id', $shop->id)
                ->where('month', Carbon::now()->format('F'))
                ->where('year', Carbon::now()->format('Y'))
                ->where('type', 'monthly')
                ->where('is_arrear', 0)
                ->where('is_paid', '0')
                ->first();

            return view('auth.mobile_verify', compact('shop', 'payment'));
        }

        return view('auth.mobile_verify');
    }
    public function search_details(Request $request)
    {
        $establishments = Establishment::select('id', 'name')->get();
        $shop = null;
        $payment = null;

        // Only search if form submitted
        if ($request->filled('establishment_id') && $request->filled('shop_number')) {
            $shop = Shop::where('establishment_id', $request->establishment_id)
                ->where('establishment_shop_id', $request->shop_number)
                ->with('establishment_shop', 'establishment')
                ->first();

            if (!$shop) {
                toastr()->error('Shop not found for selected establishment and shop number.');
                return redirect()->route('search_details');
            }

            $payment = Payment::where('shop_id', $shop->id)
                ->where('month', Carbon::now()->format('F'))
                ->where('year', Carbon::now()->format('Y'))
                ->where('type', 'monthly')
                ->where('is_arrear', 0)
                ->where('is_paid', '0')
                ->first();
        }

        return view('auth.search_shop_with_details', compact('establishments', 'shop', 'payment'));
    }
    public function getShopsByEstablishment($id)
    {
        $shops = Shop::with('establishment_shop')
            ->where('establishment_id', $id)
            ->get()
            ->map(function ($shop) {
                return [
                    'id' => $shop->establishment_shop_id,
                    'shop_name' => $shop->shop_name,
                    'shop_number' => $shop->establishment_shop->shop_number ?? 'N/A',
                ];
            });
        return response()->json($shops);
    }

    public function shopDetail($id)
    {
        $shop = Shop::find($id);
        $payments = Payment::where('shop_id', $shop->id)->where('type', 'monthly')->get();
        return view('auth.shop_detail', compact('shop', 'payments'));
    }
    public function shop_payments($id)
    {
        $shop = Shop::find($id);
        $payments = Payment::where('shop_id', $shop->id)->get();
        return view('auth.shop_payments', compact('shop', 'payments'));
    }
    public function invoices($id)
    {
        $payment = Payment::find($id);
        $invoices = PaymentCollection::where('payment_id', $payment->id)->whereNotNull('transcation_id')->get();
        return view('auth.invoices', compact('invoices', 'payment'));
    }
    public function receipt($id)
    {
        $payment = Payment::find($id);
        $shop = Shop::find($payment->shop_id);
        return view('auth.receipt', compact('shop', 'payment'));
    }
    public function storePay(Request $request)
    {
        if ($request->shop_id && $request->amount > 0) {
            return redirect()->to(route('pay', ['shop_id' => $request->shop_id, 'amount' => $request->amount]));
        }
        toastr()->error('Please Choose Amount!');
        return redirect()->back();
    }
    public function pay(Request $request)
    {
        $totalAmount = 0;
        $name = null;
        $type = null;
        $shop = Shop::find($request->shop_id);
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
                        'order_id' => $original_order_id
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
                        'order_id' => $original_order_id
                    ]);
                }
                if($payment->month != Carbon::now()->format('F')){
                    $payment->update([
                        'interest' => $payment->getInterestValue(),
                    ]);
                }
            }
            $url = url('muliple_for_non_auth');
            return view('collection_staff.payment.show',compact('authorization_token','order_id','url'));
        }else{
            toastr()->error($response['error']);
            return redirect()->to(url('search_shop'));
        }
    }
    public function otpVerification()
    {
        return redirect()->to(url('search_shop'));
    }
    public function muliple_for_non_auth(Request $request)
    {
        try {
            if ($request->transaction_response) {
                list(, $response,) = explode('.', $request->transaction_response);
                $result_decoded = base64_decode(strtr($response, '-_', '+/'));
                $result_array = json_decode($result_decoded, true);
                if ($result_array['transaction_error_type'] == 'success') {
                    $paymentCollections = PaymentCollection::where('order_id', $result_array['orderid'])->get();
                    foreach ($paymentCollections as $paymentCollection) {
                        $paymentCollection->update([
                            'transcation_id' => $result_array['transactionid'],
                            'payment_method' => $result_array['payment_method_type'],
                        ]);
                        $payment = Payment::find($paymentCollection->payment_id);
                        if ($payment->dueAmount() == 0) {
                            $payment->update([
                                'is_paid' => 1,
                                'payment_date' => Carbon::now(),
                                'transcation_id' => $result_array['transactionid'],
                                'payment_method' => $result_array['payment_method_type'],
                            ]);
                        }
                        $phone = $payment->phone ? $payment->phone : @$payment->shop->phone;
                        if ($phone && strlen($phone) == 10) {
                            (new SmsService())->sendSMS($phone);
                            (new SmsService())->sendWhatsappSMS($phone, $payment);
                        }
                    }
                    toastr()->success('Your Payment Received');
                    return redirect()->intended(route('shop_payments', $payment->shop_id));
                } else {

                    toastr()->error($result_array['transaction_error_type']);
                    return redirect()->intended(url('search_shop'));
                }
            } else {
                toastr()->error("Something Went Wrong");
                return redirect()->intended(url('search_shop'));
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->intended(url('search_shop'));
        }
    }
}
