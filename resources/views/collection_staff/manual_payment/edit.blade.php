{{-- @extends('collection_staff.layout.index')

@section('title')
    Edit Manual Payment
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Edit Manual Payment</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('collection_staff.manual_payment.update', $manual_payment->id) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control"  readonly>
                        </div> 
                        <div class="form-group col-md-6">
                            <label>Amount</label>
                            <input name="number" type="number" class="form-control"  readonly>
                        </div>                      
                        <div class="form-group col-md-6">
                            <label>Payment Date</label>
                            <input name="payment_date" type="date" class="form-control"  required>
                        </div>                      
                        <div class="form-group col-md-6">
                            <label>Amount to Pay</label>
                            <input name="amount" type="number" class="form-control"  required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Interest</label>
                            <input name="interest" type="number" class="form-control" required>
                        </div>                                 
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>

@endsection

@section('scripts')


@endsection --}}
