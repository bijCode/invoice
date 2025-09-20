<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use DB;

class InvoiceController extends Controller
{
    public function create()
    {
        $customers = Customer::orderBy('first_name')->get();
        $products = Product::orderBy('name')->get();
        return view('invoices.create', compact('customers','products'));
    }

    // AJAX endpoint: return product price (JSON)
    public function productPrice(Product $product)
    {
        return response()->json([
            'price' => (float) $product->price_per_liter,
            'product' => $product->only(['id','name'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'liters' => 'required|numeric|min:0.001',
        ]);

        return DB::transaction(function() use ($request) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'liters' => $request->liters,
                'delivery_date' => $request->delivery_date ?? now()->toDateString(),
            ]);

            $product = Product::findOrFail($request->product_id);
            $subtotal = round($product->price_per_liter * $order->liters, 2);

            $gstRate = (float) config('invoice.gst_rate', 0.10);
            $gst = round($subtotal * $gstRate, 2);
            $total = round($subtotal + $gst, 2);

            $invoice = Invoice::create([
                'order_id' => $order->id,
                'subtotal' => $subtotal,
                'gst' => $gst,
                'total' => $total,
            ]);

            $prefix = config('invoice.invoice_prefix', 'INV-');
            $invoiceNumber = $prefix . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
            $invoice->invoice_number = $invoiceNumber;

            $invoiceData = [
                'invoice' => $invoice->fresh()->load('order.product','order.customer'),
                'company' => config('app.name'),
            ];

            $pdf = PDF::loadView('invoices.pdf', $invoiceData)->setPaper('a4');
            $folder = rtrim(config('invoice.pdf_folder', 'invoices'), '/');
            $pdfPath = "{$folder}/{$invoiceNumber}.pdf";

            Storage::put($pdfPath, $pdf->output());

            $invoice->pdf_path = $pdfPath;
            $invoice->save();

            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', "Invoice {$invoiceNumber} generated.");
        });
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.product','order.customer');
        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::exists($invoice->pdf_path)) {
            abort(404);
        }
        return Storage::download($invoice->pdf_path, $invoice->invoice_number . '.pdf');
    }
}
