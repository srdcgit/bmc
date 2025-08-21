@extends('collection_staff.layout.index')

@section('title')
     Manual Payment
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Card Layout -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">💰 Manual Payment</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item text-white" data-action="collapse"></a>
                        <a class="list-icons-item text-white" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('collection_staff.manual_payment.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">

                    <!-- Shop & Establishment Info -->
                    <h6 class="text-primary border-bottom pb-2 mb-3">Shop Information</h6>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><strong>Establishment Name</strong></label>
                            <input type="text" class="form-control" value="{{ $payment->establishment->name }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label><strong>Shop Name / Number</strong></label>
                            <input type="text" class="form-control" 
                                   value="{{ $payment->shop->shop_name }} ({{ $payment->shop_number }})" readonly>
                        </div>
                        
                        
                    </div>

                    <!-- Payment Breakdown -->
                    <h6 class="text-primary border-bottom pb-2 mb-3">Payment Breakdown</h6>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><strong>Amount</strong></label>
                            <input type="number" class="form-control" value="{{ $payment->amount }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>CAM Charges</strong></label>
                            <input type="number" class="form-control" value="{{ $payment->cam_charges }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Tax</strong></label>
                            <input type="number" class="form-control" value="{{ $payment->tax_amount }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Total Payable</strong></label>
                            <input type="number" class="form-control bg-light font-weight-bold" value="{{ $totalPayment }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Already Paid</strong></label>
                            <input type="number" class="form-control bg-light text-success font-weight-bold" value="{{ $paidAmount }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Remaining Amount</strong></label>
                            <input type="number" class="form-control bg-light text-danger font-weight-bold" value="{{ $remainingAmount }}" readonly>
                        </div>
                    </div>

                    <!-- New Payment -->
                    <h6 class="text-primary border-bottom pb-2 mb-3">Make Payment</h6>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label><strong>Payment Date</strong></label>
                            <input name="payment_date" type="date" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Amount to Pay</strong></label>
                            <input id="payAmount" name="pay_amount" type="number" step="0.01" class="form-control" max="{{ $remainingAmount }}" required>

                            <h7 id="amountError" class="text-danger d-none">Amount cannot be greater than Remaining Amount ({{ $remainingAmount }})</h7>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label><strong>Interest</strong></label>
                            <input name="interest" type="number" class="form-control" value="0">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        {{-- <a href="{{ route('collection_staff.manual_payment.index') }}" class="btn btn-outline-secondary">
                            <i class="icon-arrow-left mr-2"></i> Back to List
                        </a> --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-check mr-2"></i> Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Card Layout -->
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const payAmount = document.getElementById("payAmount");
    const errorMsg = document.getElementById("amountError");
    const maxAllowed = parseFloat(payAmount.getAttribute("max"));

    payAmount.addEventListener("input", function() {
        if (parseFloat(this.value) > maxAllowed) {
            errorMsg.classList.remove("d-none");
            this.classList.add("is-invalid");
        } else {
            errorMsg.classList.add("d-none");
            this.classList.remove("is-invalid");
        }
    });
});
</script>
@endsection

