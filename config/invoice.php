<?php
return [
    // GST percentage as a decimal fraction, e.g. 0.10 = 10%
    'gst_rate' => env('INVOICE_GST_RATE', 0.10),
    // Invoice filename folder under storage/app/
    'pdf_folder' => env('INVOICE_PDF_FOLDER', 'invoices'),
    // Invoice prefix
    'invoice_prefix' => env('INVOICE_PREFIX', 'INV-'),
];
