@extends('collection_staff.layout.index')

@section('title')
Street Vendors
@endsection

@section('content')


<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Street Vendors</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a href="{{ route('collection_staff.street_vendor.add') }}" class="btn btn-primary text-right">Add New Vendor</a>
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table datatable-save-state">
            <thead>
                <tr>
                    <th>Kiosk No</th>
                    <th>Vendor ID</th>
                    <th>Name of Vendors</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>Vendor photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($street_vendors  as $key => $vendor)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$vendor->uu_id}}</td>
                    <td>{{$vendor->name}}</td>                   
                    <td>{{$vendor->address}}</td>                   
                    <td>{{$vendor->mobilenumber}}</td>                   
                    <td><img src="{{ asset($vendor->photo) }}" width="70" alt="Photo"></td> 
                    <td>
                        <a href="{{ route('collection_staff.street_vendor.edit', $vendor->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> 
                        </a>
                        
                        <a href="{{ route('collection_staff.street_vendor.delete', $vendor->id) }}"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this item?')">
                            <i class="fas fa-trash-alt"></i> 
                        </a>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
@endsection
