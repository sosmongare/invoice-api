<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Mail\InvoiceGenerated;
use Illuminate\Support\Facades\Mail;

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
        // Find the last invoice based on the invoice_number
        $lastInvoice = Invoice::orderBy('invoice_number', 'desc')->first();

        if ($lastInvoice) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = (int) str_replace('INV-', '', $lastInvoice->invoice_number);
            $invoiceNumber = 'INV-' . sprintf('%05d', $lastInvoiceNumber + 1);
        } else {
            $invoiceNumber = 'INV-00001';
        }

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }
        $tax = $subtotal * 0.16; 
        $total = $subtotal + $tax;

        $invoiceData = [
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            // Biller Information
            'from_name' => $request->from_name,
            'from_address' => $request->from_address,
            'from_pin' => $request->from_pin,
            'from_email' => $request->from_email,
            'from_phone' => $request->from_phone,
            'payment_bank' => $request->payment_bank,
            'payment_branch' => $request->payment_branch,
            'payment_name' => $request->payment_name,
            'payment_account' => $request->payment_account,
            'payment_pin' => $request->payment_pin,
            'payment_method' => $request->payment_method,
            'payment_phone' => $request->payment_phone,

            // customer information
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_terms' => $request->payment_terms,
            'notes' => $request->notes,
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
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'from_name' => $request->from_name,
            'from_address' => $request->from_address,
            'from_pin' => $request->from_pin,
            'from_email' => $request->from_email,
            'from_phone' => $request->from_phone,
            'payment_bank' => $request->payment_bank,
            'payment_branch' => $request->payment_branch,
            'payment_name' => $request->payment_name,
            'payment_account' => $request->payment_account,
            'payment_pin' => $request->payment_pin,
            'payment_method' => $request->payment_method,
            'payment_phone' => $request->payment_phone,
            // customer details
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_terms' => $request->payment_terms,
            'notes' => $request->notes,
            
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

    // public function generateInvoicePDF($id)
    // {
    //     $invoice = Invoice::with('items')->findOrFail($id);

    //     // Load view and pass the invoice data
    //     $pdf = PDF::loadView('invoice', compact('invoice'));

    //     // Return the generated PDF
    //     return $pdf->download($invoice->invoice_number . '.pdf');
    // }

    
    private function createInvoicePDF(Invoice $invoice)
    {
        // Load view and pass the invoice data
        $pdf = PDF::loadView('invoice', compact('invoice'));
        return $pdf->output();
    }

    public function generateInvoicePDF($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $pdfContent = $this->createInvoicePDF($invoice);

        // Send the email
        Mail::to($invoice->from_email)->send(new InvoiceGenerated($invoice, $pdfContent));

        $pdf = PDF::loadView('invoice', compact('invoice'));

        return $pdf->download($invoice->invoice_number . '.pdf'); // return the generated email invoice

    }

}
