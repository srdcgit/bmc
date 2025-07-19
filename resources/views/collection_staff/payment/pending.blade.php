@extends('collection_staff.layout.index')

@section('title')
Pending Invoices for {{$shop->shop_name}}
@endsection

@section('content')


<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Pending Invoices for {{$shop->shop_name}}</h5>
        <div class="header-elements">
        </div>
    </div>
    <div class="card-body">
        <table class="table datatable-save-state">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total Invoice Amount</th>
                    <th>Amount Paid</th>
                    <th>Amount Due</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($payments  as $key => $payment)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$payment->month}}</td>
                    <td>{{$payment->is_arrear ? @$payment->pending_payment->financial_year : $payment->year}}</td>
                   <td>{{$payment->amount}}</td>
                    <td>{{$payment->paidAmount()}}</td>
                    <td>{{$payment->dueAmount()}}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
@endsection
