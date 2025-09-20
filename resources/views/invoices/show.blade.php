@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Invoice: {{ $invoice->invoice_number }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Customer</h5>
            <p class="card-text">
                {{ $invoice->order->customer->first_name }} {{ $invoice->order->customer->last_name }}<br>
                {{ $invoice->order->customer->delivery_address }}
            </p>

            <h5 class="card-title mt-3">Product</h5>
            <p class="card-text">
                {{ $invoice->order->product->name }}<br>
                Price per L: {{ number_format($invoice->order->product->price_per_liter, 2) }}<br>
                Liters: {{ number_format($invoice->order->liters, 3) }}
            </p>

            <h5 class="card-title mt-3">Totals</h5>
            <p class="card-text">
                Subtotal: {{ number_format($invoice->subtotal, 2) }}<br>
                GST: {{ number_format($invoice->gst, 2) }}<br>
                <strong>Total: {{ number_format($invoice->total, 2) }}</strong>
            </p>
        </div>
    </div>

    <div class="d-flex gap-2">
        @if($invoice->pdf_path)
            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-success">
                Download PDF
            </a>
        @endif
        <a href="{{ route('invoices.create') }}" class="btn btn-secondary">
            Create Another Invoice
        </a>
    </div>
</div>
@endsection
