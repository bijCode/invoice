@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Invoice</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="invoice-form" method="POST" action="{{ route('invoices.store') }}">
        @csrf

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">-- Select Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price per Liter</label>
            <input type="text" id="price_per_liter" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Liters Delivered</label>
            <input type="number" step="0.001" name="liters" id="liters" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Subtotal</label>
            <input type="text" id="subtotal" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">GST ({{ config('invoice.gst_rate', 0.10) * 100 }}%)</label>
            <input type="text" id="gst" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" id="total" class="form-control fw-bold" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Generate Invoice (PDF)</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    function recalc(){
        let price = parseFloat($('#price_per_liter').val()) || 0;
        let liters = parseFloat($('#liters').val()) || 0;
        let subtotal = +(price * liters).toFixed(2);
        let gstRate = parseFloat('{{ config("invoice.gst_rate", 0.10) }}') || 0.10;
        let gst = +(subtotal * gstRate).toFixed(2);
        let total = +(subtotal + gst).toFixed(2);
        $('#subtotal').val(subtotal);
        $('#gst').val(gst);
        $('#total').val(total);
    }

    $('#product_id').on('change', function(){
        let productId = $(this).val();
        if (!productId) {
            $('#price_per_liter').val('');
            recalc();
            return;
        }
        $.getJSON('/api/products/' + productId + '/price')
            .done(function(resp){
                $('#price_per_liter').val(resp.price);
                recalc();
            })
            .fail(function(){
                alert('Failed to fetch product price.');
            });
    });

    $('#liters').on('input', recalc);
});
</script>
@endpush
