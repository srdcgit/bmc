@extends('super_admin.layout.index')

@section('title')
Manage Shop Interest
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Shop Interest By Establishment</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('super_admin.shop_interest.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Interest Amount</label>
                            <input name="amount" type="number" min="1" value="0.00" step="0.01" class="form-control" placeholder="Enter Interest Amount" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Choose Establishment</label>
                            <select  name="establishment_id"  class="form-control select-search" data-fouc required>
                                <option selected disabled>Select Establishment</option>
                                @foreach($establishments as $establishment)
                                @if(!$establishment->interest)
                                    <option value="{{$establishment->id}}">{{$establishment->name}}</option>
                                @endif
                                @endforeach
                            </select>
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

<div class="card">

    <table class="table datatable-save-state">
        <thead>
            <tr>
                <th>#</th>
                <th>Interest Percent</th>
                <th>Establishment Name</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interest  as $key => $interest)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$interest->amount}}</td>
                <td>{{$interest->establishment->name}}</td>
                <td>
                    <a href="{{route('super_admin.shop_interest.edit',$interest->id)}}" class="btn btn-primary">Edit</a> </td>
                <td>
                    <form action="{{route('super_admin.shop_interest.destroy',$interest->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                    <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')

@endsection
