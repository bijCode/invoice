<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number ?? 'Invoice' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ config('app.name') }}</h2>
        <p><strong>Invoice:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Date:</strong> {{ $invoice->created_at->format('Y-m-d') }}</p>
    </div>

    <h4>Customer</h4>
    <p>{{ $invoice->order->customer->first_name }} {{ $invoice->order->customer->last_name }}</p>
    <p>{{ $invoice->order->customer->delivery_address }}</p>

    <h4>Items</h4>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price / L</th>
                <th>Liters</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->order->product->name }}</td>
                <td class="right">{{ number_format($invoice->order->product->price_per_liter, 2) }}</td>
                <td class="right">{{ number_format($invoice->order->liters, 3) }}</td>
                <td class="right">{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="right">GST ({{ config('invoice.gst_rate', 0.10) * 100 }}%)</td>
                <td class="right">{{ number_format($invoice->gst, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="right"><strong>Total</strong></td>
                <td class="right"><strong>{{ number_format($invoice->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
