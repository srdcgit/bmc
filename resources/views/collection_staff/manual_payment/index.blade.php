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
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        {{-- Filter Section --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Filter by Establishment</label>
                <select id="filterEstablishment" class="form-control">
                    <option value="">All</option>
                    @foreach($establishments as $id => $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Filter by Shop</label>
                <select id="filterShop" class="form-control">
                    <option value="">All</option>
                    @foreach($shops as $id => $label)
                        <option value="{{ $label }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Payment Table --}}
        <table id="manualPaymentsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Establishment Name</th>
                    <th>Shop Name</th>
                    <th>Shop Number</th>
                    <th>Owner Name</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($manualPayments as $key => $data)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $data->establishment->name ?? 'N/A' }}</td>
                        <td>{{ $data->shop->shop_name ?? 'N/A' }}</td>
                        <td>{{ $data->shop_number ?? 'N/A' }}</td>
                        <td>{{ $data->owner_name }}</td>
                        <td>{{ $data->phone }}</td>
                        <td>
                            <a href="{{ route('collection_staff.manual_payment.edit',$data->id) }}" 
                               class="btn btn-sm btn-primary">Make Payment</a>
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
<script>
$(document).ready(function () {
    var table = $('#manualPaymentsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
    });

    // Establishment filter
    $('#filterEstablishment').on('change', function () {
        table.column(1).search(this.value).draw();
    });

    // Shop filter (matches either shop name or shop number)
    $('#filterShop').on('change', function () {
        table.column(2).search(this.value.split(' (')[0]).draw(); // filter by name
        table.column(3).search(this.value.match(/\((.*?)\)/)?.[1] || '').draw(); // filter by number
    });
});
</script>
@endsection
