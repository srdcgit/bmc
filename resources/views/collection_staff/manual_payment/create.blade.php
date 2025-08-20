@extends('collection_staff.layout.index')

@section('title')
    Add New Manual Payment
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Manual Payment</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('collection_staff.manual_payment.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Select Payment</label>
                            <select name="payment_id" id="payment_id" class="form-control" required>
                                <option value="">-- Select Payment --</option>
                                @foreach($payments as $p)
                                    <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-amount="{{ $p->amount }}">{{ $p->name }} - {{ number_format($p->amount, 2) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input id="display_name" type="text" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Amount</label>
                            <input id="display_amount" type="number" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Payment Date</label>
                            <input name="payment_date" type="date" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Amount to Pay</label>
                            <input name="pay_amount" id="pay_amount" type="number" step="0.01" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Interest</label>
                            <input name="interest" id="interest" type="number" step="0.01" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Amount</label>
                            <input name="total_amount" id="total_amount" type="number" step="0.01" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            Create <i class="icon-paperplane ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
        <!-- /basic layout -->

    </div>
</div>

@endsection

@section('scripts')
<script>
    (function() {
        function updateTotal() {
            var pay = parseFloat(document.getElementById('pay_amount').value) || 0;
            var interest = parseFloat(document.getElementById('interest').value) || 0;
            document.getElementById('total_amount').value = (pay + interest).toFixed(2);
        }

        var payInput = document.getElementById('pay_amount');
        var interestInput = document.getElementById('interest');
        if (payInput) payInput.addEventListener('input', updateTotal);
        if (interestInput) interestInput.addEventListener('input', updateTotal);

        var paymentSelect = document.getElementById('payment_id');
        if (paymentSelect) {
            paymentSelect.addEventListener('change', function() {
                var opt = this.options[this.selectedIndex];
                var name = opt.getAttribute('data-name') || '';
                var amount = opt.getAttribute('data-amount') || '';
                document.getElementById('display_name').value = name;
                document.getElementById('display_amount').value = amount;
            });
        }
    })();
</script>
@endsection
