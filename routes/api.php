<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/invoices', [InvoiceController::class, 'index']);
Route::post('/invoices', [InvoiceController::class, 'store']);
Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'generateInvoicePDF']);