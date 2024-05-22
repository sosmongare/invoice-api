<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')->get();
        return response()->json([
            'message' => 'Invoices retrieved successfully',
            'data' => $invoices
        ], 200);
    }

    public function store(Request $request)
    {
        // Generate a unique invoice number
        $lastInvoice = Invoice::latest()->first();
        $invoiceNumber = $lastInvoice ? 'INV-' . sprintf('%05d', $lastInvoice->id + 1) : 'INV-00001';

        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }
        $tax = $subtotal * 0.1; // Assuming a tax rate of 10%
        $total = $subtotal + $tax;

        $invoiceData = [
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->input('invoice_date'),
            'due_date' => $request->input('due_date'),
            // From
            'from_name' => $request->input('from_name'),
            'from_address' => $request->input('from_address'),
            'from_pin' => $request->input('from_pin'),
            'from_email' => $request->input('from_email'),
            'from_phone' => $request->input('from_phone'),
            'payment_bank' => $request->input('payment_bank'),
            'payment_branch' => $request->input('payment_branch'),
            'payment_name' => $request->input('payment_name'),
            'payment_account' => $request->input('payment_account'),
            'payment_pin' => $request->input('payment_pin'),
            'payment_method' => $request->input('payment_method'),
            'payment_phone' => $request->input('payment_phone'),

            // customer information
            'customer_name' => $request->input('customer_name'),
            'customer_address' => $request->input('customer_address'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_terms' => $request->input('payment_terms'),
            'notes' => $request->input('notes'),
        ];

        $invoice = Invoice::create($invoiceData);

        foreach ($request->items as $itemData) {
            $itemData['invoice_id'] = $invoice->id;
            $itemData['total_price'] = $itemData['quantity'] * $itemData['unit_price'];
            Item::create($itemData);
        }

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice->load('items')
        ], 201);
    }

    public function show($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return response()->json([
            'message' => 'Invoice retrieved successfully',
            'data' => $invoice
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Recalculate subtotal and total
        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }
        $tax = $subtotal * 0.16; // 16% VAT tax
        $total = $subtotal + $tax;

        $invoiceData = [
            'invoice_date' => $request->input('invoice_date'),
            'due_date' => $request->input('due_date'),
            'from_name' => $request->input('from_name'),
            'from_address' => $request->input('from_address'),
            'from_pin' => $request->input('from_pin'),
            'from_email' => $request->input('from_email'),
            'from_phone' => $request->input('from_phone'),
            'payment_bank' => $request->input('payment_bank'),
            'payment_branch' => $request->input('payment_branch'),
            'payment_name' => $request->input('payment_name'),
            'payment_account' => $request->input('payment_account'),
            'payment_pin' => $request->input('payment_pin'),
            'payment_method' => $request->input('payment_method'),
            'payment_phone' => $request->input('payment_phone'),
            // customer details
            'customer_name' => $request->input('customer_name'),
            'customer_address' => $request->input('customer_address'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_terms' => $request->input('payment_terms'),
            'notes' => $request->input('notes'),
            
        ];

        $invoice->update($invoiceData);

        $invoice->items()->delete();
        foreach ($request->items as $itemData) {
            $itemData['invoice_id'] = $invoice->id;
            $itemData['total_price'] = $itemData['quantity'] * $itemData['unit_price'];
            Item::create($itemData);
        }

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice->load('items')
        ], 200);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ], 204);
    }

    public function generateInvoicePDF($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        // Load view and pass the invoice data
        $pdf = PDF::loadView('invoice', compact('invoice'));

        // Return the generated PDF
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

}
