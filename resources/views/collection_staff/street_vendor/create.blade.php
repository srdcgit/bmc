@extends('collection_staff.layout.index')

@section('title')
    Add New Vendor
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Vendor</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('collection_staff.street_vendor.store') }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Vendor Name</label>
                            <input name="name" type="text" class="form-control"  required>
                        </div> 
                        <div class="form-group col-md-6">
                            <label>Area</label>
                            <input name="area" type="text" class="form-control"  required>
                        </div>                      
                        <div class="form-group col-md-6">
                            <label>Vendor Address</label>
                            <input name="address" type="text" class="form-control"  required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vendor Mobile Number</label>
                            <input name="mobilenumber" type="number" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vendor Photo</label>
                            <input name="photo" type="file" class="form-control">
                        </div>            
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>

@endsection

@section('scripts')


@endsection
