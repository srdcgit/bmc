@extends('collection_staff.layout.index')

@section('title')
    Edit Vendor
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Basic layout-->
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Vendor</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('collection_staff.street_vendor.update', $street_vendors->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Vendor Name</label>
                                <input name="name" type="text" class="form-control"
                                    value="{{ $street_vendors->name }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Area</label>
                                <input name="area" type="text" class="form-control"
                                    value="{{ $street_vendors->area }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Vendor Address</label>
                                <input name="address" type="text" class="form-control"
                                    value="{{ $street_vendors->address }}"required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Vendor Mobile Number</label>
                                <input name="mobilenumber" type="number" value="{{ $street_vendors->mobilenumber }}"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Vendor Photo</label>
                                <input name="photo" type="file" class="form-control">
                                <img src="{{ asset($street_vendors->photo) }}" width="70" alt="Image">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Edit <i
                                    class="icon-paperplane ml-2"></i></button>
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
        $(document).ready(function() {
            $('input[type=radio][name="owner_type"]').on('change', function(event) {
                var value = $(this).val()
                if (value == 1) {
                    $('.tenant_fields').show();
                } else {
                    $('.tenant_fields').hide();
                }
            });
            $('#zone_id').change(function() {
                id = this.value;
                $.ajax({
                    url: "{{ route('collection_staff.shop.get_wards') }}",
                    method: 'post',
                    data: {
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(result) {
                        wards = result.wards;
                        $('#ward_id').empty();
                        $('#ward_id').append('<option disabled>Select Ward</option>');
                        for (i = 0; i < wards.length; i++) {
                            $('#ward_id').append('<option value="' + wards[i].id + '">' + wards[
                                i].name + '</option>');
                        }
                    }
                });
            });
            $('#establishment_category_id').change(function() {
                id = this.value;
                $.ajax({
                    url: "{{ route('collection_staff.shop.get_establishments') }}",
                    method: 'post',
                    data: {
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(result) {
                        establishments = result.establishments;
                        $('#establishment_id').empty();
                        $('#establishment_id').append('<option>Select Establishment</option>');
                        for (i = 0; i < establishments.length; i++) {
                            $('#establishment_id').append('<option value="' + establishments[i]
                                .id + '">' + establishments[i].name + '</option>');
                        }
                    }
                });
            });
            $('#establishment_id').change(function() {
                id = this.value;
                $.ajax({
                    url: "{{ route('collection_staff.shop.get_establishment_shops') }}",
                    method: 'post',
                    data: {
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(result) {
                        establishment_shops = result.establishment_shops;
                        $('#establishment_shop_id').empty();
                        $('#establishment_shop_id').append(
                            '<option>Select Shop Number</option>');
                        for (i = 0; i < establishment_shops.length; i++) {
                            $('#establishment_shop_id').append('<option value="' +
                                establishment_shops[i].id + '">' + establishment_shops[i]
                                .shop_number + '</option>');
                        }
                    }
                });
            });
            $('#establishment_shop_id').change(function() {
                id = this.value;
                $.ajax({
                    url: "{{ route('collection_staff.shop.get_establishment_shop') }}",
                    method: 'post',
                    data: {
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(result) {
                        establishment_shop = result.establishment_shop;
                        $('#shop_number').val(establishment_shop.shop_number);
                        $('#shop_size').val(establishment_shop.shop_size);
                        $('#shop_type').val(establishment_shop.shop_type);
                        $('#shop_rent').val(establishment_shop.shop_rent);
                    }
                });
            });
        });
    </script>
@endsection
