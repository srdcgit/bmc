@extends('collection_staff.layout.index')

@section('title')
Manual Payment List
@endsection

@section('content')


<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Manual Payment List</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a href="{{ route('collection_staff.manual_payment.add') }}" class="btn btn-primary text-right">Add New Payment</a>
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table datatable-save-state">
            <thead>
                <tr>
                    <th>sl. No</th>
                    <th>Name</th>
                    <th>Base Amount</th>
                    <th>Payment Date</th>
                    <th>Interest</th>
                    <th>Total Collected</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($manualPayments  as $key => $data)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ optional($data->payment)->name }}</td>
                    <td>{{ number_format(optional($data->payment)->amount ?? 0, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->payment_date)->format('d-m-Y') }}</td>
                    <td>{{ number_format(optional($data->payment)->interest ?? 0, 2) }}</td>
                    <td>{{ number_format($data->amount, 2) }}</td>
                    <td>
                        <span class="badge badge-success">{{ strtoupper($data->payment_mode) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No manual payments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
@endsection
