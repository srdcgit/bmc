@extends('collection_staff.layout.index')
<style>
.card-body2{
width:70%;
margin:auto;
margin-bottom:30px;
border:1px solid #c0c0c0;
	
	}
</style>
@section('title')
Invoice Details
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if($shop->is_interest_excluded)
                            <a href="{{route('collection_staff.shop.exclude_interest',$shop->id)}}" class="btn btn-danger float-right">Include Interest</a>
                        @else 
                            <a href="{{route('collection_staff.shop.exclude_interest',$shop->id)}}" class="btn btn-success float-right">Exclude Interest</a>
                        @endif
                    </div>
                </div>
            <form action="{{route('collection_staff.payment.pay')}}" method="post" enctype="multipart/form-data" >
                @csrf 
                <input type="hidden" name="shop_id" value="{{$shop->id}}">
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Shop Name:</strong> {{$shop->shop_name}}</h6>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Establishment:</strong> {{$shop->establishment->name}}</h6>
                    </div>
                </div>
                <div class="row">
                @php 
                    $arrearPayments = $shop->getDuePaymentsDetails();
                    @endphp
                    <div class="col-md-6">
                        <h6><strong>Previous Arrear:</strong></h6>
                    </div>
                    <div class="col-md-6">
                        <h6>Rs. {{$arrearPayments['totalRent']}}</h6>
                    </div>
                    <div class="col-md-2">
                        <h6><strong>Arrear Interest:</strong></h6>
                    </div>
                    <div class="col-md-1">
                        <h6>Rs. {{$arrearPayments['totalTax']}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h6><strong>Current Bill:</strong></h6>
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Rent:</strong> Rs. {{@$payment->shop_rent}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Tax :</strong> Rs. {{@$payment->tax_amount}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Cam Charges :</strong> Rs. {{@$payment->cam_charges}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        {{-- <h6><strong>Current Bill:</strong></h6> --}}
                    </div>
                    <div class="col-md-4">
                        <h6><strong>Interest :</strong> Rs. {{@$payment ? $payment->getInterestValue() : 0}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Total :</strong></h6>
                    </div>
                    <div class="col-md-4">
                        <h6>Rs. {{@$payment ? $payment->dueAmount() : 0}}</h6>
                    </div>
                </div>
                    @php
                        $totalAmount = $shop->getDuePayments() + (@$payment ? $payment->dueAmount() : 0);
                    @endphp
                <div class="row">
                    <div class="col-md-2">
                        <h6><strong>Amount to Pay :</strong></h6>
                    </div>
                    <div class="col-md-1">
                        <h6><strong>Rent :</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <input type="text" readonly id="rent_amount" class="form-control" value="{{@$payment ? $payment->dueAmount() : 0}}">
                    </div>
                    <div class="col-md-1">
                        <h6><strong>Arrear :</strong></h6>
                    </div>
                    <div class="col-md-1">
                        <input type="text" id="arrear_amount" min="0" class="form-control" value="{{$shop->getDuePayments()}}">
                    </div>
                    <div class="col-md-1">
                        <h6><strong>Total :</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <h6> <input required type="number" step="0.01"  id="amount" name="amount" readonly value="{{$totalAmount}}" class="form-control" min="0" max="{{$totalAmount}}"></h6>
                    </div>
                    <div class="col-md-2">
                        <select name="payment_method" class="form-control">
                            <option value="" disabled>Select Payment</option>
                            <option value="online" selected>Online</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="text-right" style="margin:auto; margin-bottom:20px">
                    <a href="{{route('collection_staff.payment.pending',$shop->id)}}" class="btn btn-info" style="color:white;">All Pending Invoices </a>
                    <button type="submit" class="btn btn-primary">Pay <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>      
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
   function sumTotalPayable(){
        let total = 0;
        $('.payment-checkbox:checked').each(function() {
            let amount = parseFloat($(this).attr('amount')) || 0;
            total += amount;
        });
        $('#total_payable').text(total.toFixed(2));
   }
   $('#arrear_amount').on('change',function(){
    let amount = parseFloat($(this).val()) || 0;
    let arrear_amount = "{{@$shop->getDuePayments()}}";
    arrear_amount = parseFloat(arrear_amount) || 0;
    if(amount > 0){
        if(amount > arrear_amount){
            $('#arrear_amount').val(arrear_amount);
            let rent_amount = parseFloat($('#rent_amount').val()) || 0;
            let total = rent_amount + arrear_amount;
            $('#amount').val(total.toFixed(2));
            alert('Value Must be lesser or equal to '+arrear_amount);
        }else{
            let rent_amount = parseFloat($('#rent_amount').val()) || 0;
            let total = rent_amount + amount;
            $('#amount').val(total.toFixed(2));
        }
    }else{
        $('#arrear_amount').val(arrear_amount);
        let rent_amount = parseFloat($('#rent_amount').val()) || 0;
        let total = rent_amount + arrear_amount;
        $('#amount').val(total.toFixed(2));
        alert('Value Must be greater than 0');
    }
   });
</script>
@endsection