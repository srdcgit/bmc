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
        $manualPayments = PaymentCollection::with('payment')->orderBy('created_at', 'desc')->get();
        return view('collection_staff.manual_payment.index', compact('manualPayments'));
    }

    public function add()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();
        return view('collection_staff.manual_payment.create', compact('payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'payment_date' => 'required|date',
            'pay_amount' => 'required|numeric|min:0',
            'interest' => 'required|numeric|min:0',
        ]);
    
        $payment = Payment::findOrFail($validated['payment_id']);
        $totalAmount = (float) $validated['pay_amount'] + (float) $validated['interest'];
    
        // 🔑 Generate order_id & transaction_id same like storePay()
        $original_order_id = 'cash_' . rand(1000, 9999);
        $original_transaction_id = 'cash_transaction_' . rand(1000, 9999);
    
        // Save into payment_collections
        $collection = new PaymentCollection();
        $collection->payment_id = $payment->id;
        $collection->amount = $totalAmount;
        $collection->payment_date = $validated['payment_date'];
        $collection->payment_mode = 'Cash';
        $collection->order_id = $original_order_id;
        $collection->transcation_id = $original_transaction_id;
        $collection->save();
    
        // Update the payment record
        $payment->is_paid = 1;
        // $payment->interest = $validated['interest'];
        $payment->payment_method = 'Cash';
        $payment->transcation_id = $original_transaction_id; // keep it consistent
        $payment->order_id = $original_order_id;
        $payment->payment_date = $validated['payment_date'];
        $payment->save();
    
        return redirect()->route('collection_staff.manual_payment.index')
                         ->with('success', 'Manual payment added successfully');
    }
    
    
}
