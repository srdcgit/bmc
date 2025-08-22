<?php

namespace App\Http\Controllers\CollectionStaff;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentCollection;
use Illuminate\Http\Request;

class ManualPaymentController extends Controller
{
    public function index()
    {
        $manualPayments = Payment::where('is_paid', 0)
            ->with(['establishment', 'shop'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Get Establishments
        $establishments = $manualPayments->pluck('establishment.name', 'establishment.id')->unique();
    
        // Get Shops with Name (Number)
        $shops = $manualPayments->mapWithKeys(function ($payment) {
            $label = ($payment->shop->shop_name ?? 'N/A') . ' (' . ($payment->shop_number ?? 'N/A') . ')';
            return [$payment->shop->id => $label];
        })->unique();
    
        return view('collection_staff.manual_payment.index', compact('manualPayments', 'establishments', 'shops'));
    }
    
    

    // public function add()
    // {
    //     $payments = Payment::orderBy('created_at', 'desc')->get();
    //     return view('collection_staff.manual_payment.create', compact('payments'));
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'payment_id'   => 'required|exists:payments,id',
            'payment_date' => 'required|date',
            'pay_amount'   => 'required|numeric|min:0',   
            'interest'     => 'required|numeric|min:0',  
        ]);
        
    
        $payment = Payment::findOrFail($validated['payment_id']);
    
        // total expected = amount + cam_charges + tax
        $totalPayable = $payment->amount;
    
        // already paid
        $paidAmount = PaymentCollection::where('payment_id', $payment->id)->sum('amount');
    
        // remaining
        $remainingAmount = $totalPayable - $paidAmount;
    
        // Validate against overpayment
        if ($validated['pay_amount'] > $remainingAmount) {
            return back()->withErrors([
                'pay_amount' => 'Amount cannot be greater than remaining payable amount ('.$remainingAmount.')'
            ])->withInput();
        }
    
        // New order_id & transaction_id
        $original_order_id       = 'cash_' . rand(1000, 9999);
        $original_transaction_id = 'cash_transaction_' . rand(1000, 9999);
        $original_receipt_number = 'bmc_' . rand(1000, 9999);
    
        // Save into payment_collections
        $collection = new PaymentCollection();
        $collection->payment_id     = $payment->id;
        $collection->amount         = $validated['pay_amount']; // ✅ Only pay_amount stored here
        $collection->payment_date   = $validated['payment_date'];
        $collection->payment_mode   = 'Cash';
        $collection->order_id       = $original_order_id;
        $collection->transcation_id = $original_transaction_id;
        $collection->receipt_number = $original_receipt_number;
        $collection->interest = $validated['interest']; ;
        $collection->save();
    
        // ✅ Update interest in Payment table
        $payment->interest = $payment->interest + $validated['interest'];
        $payment->payment_method = 'Cash';
        $payment->transcation_id = $original_transaction_id;
        $payment->order_id       = $original_order_id;
        $payment->payment_date   = $validated['payment_date'];
    
        // ✅ Check if fully paid
        $newPaidAmount = $paidAmount + $validated['pay_amount'];
        if ($newPaidAmount >= $totalPayable) {
            $payment->is_paid = 1;
        }
    
        $payment->save();
    
        return redirect()->route('collection_staff.manual_payment.index')
            ->with('success', 'Manual payment added successfully');
    }
    

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
    
        // Calculate total expected from payment
        $totalPayment = $payment->amount ;
    
        // Get total paid so far from payment_collections
        $paidAmount = PaymentCollection::where('payment_id', $payment->id)->sum('amount');
    
        // Calculate remaining
        $remainingAmount = $totalPayment - $paidAmount;
    
        return view('collection_staff.manual_payment.edit', compact('payment', 'totalPayment', 'paidAmount', 'remainingAmount'));
    }
    
}
