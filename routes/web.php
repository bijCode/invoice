<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;

Route::get('/invoices/create', [InvoiceController::class,'create'])->name('invoices.create');
Route::post('/invoices', [InvoiceController::class,'store'])->name('invoices.store');
Route::get('/invoices/{invoice}', [InvoiceController::class,'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/download', [InvoiceController::class,'download'])->name('invoices.download');

// API route for product price
Route::get('/api/products/{product}/price', [InvoiceController::class,'productPrice']);
