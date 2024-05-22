<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{$invoice->invoice_number}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
    line-height: inherit;
    text-align: justify; /* Added */
    border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                INVOICE
                            </td>
                            <td>
								Invoice No: {{ $invoice->invoice_number }} <br>
                                Invoice Date: {{ $invoice->invoice_date }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>Invoice from:</strong><br>
                                {{ $invoice->from_name }}<br>
                                {{ $invoice->from_address }}<br>
						Email: {{ $invoice->from_email }}<br>
						Phone: {{ $invoice->from_phone }}<br>
                            </td>
                            <td>
                                <strong>Billed to:</strong><br>
                                {{ $invoice->customer_name }}<br>
								{{ $invoice->customer_address }}<br>
								{{ $invoice->customer_email }}<br>
								{{ $invoice->customer_phone }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
				<td>Quantity</td>
				<td>Price</td>
                <td>Total</td>
            </tr>
			@foreach($invoice->items as $index => $item)
            <tr class="item">
                <td>{{ $item->description }}</td>
				<td>{{ $item->quantity }}</td>
				<td>{{ $item->unit_price }}</td>
				<td>{{ $item->total_price }}</td>
            </tr>
			@endforeach

            <tr class="total" >
                <td colspan="2"></td>
                <td><strong>Subtotal: {{ $invoice->subtotal }}<strong></td>
            </tr>

        </table>
		
		<strong>Payment Information:</strong><br>
		<p>Payment method: {{ $invoice->payment_method }}</p>
		<p>Bank name: {{ $invoice->payment_bank }}</p>
		<p>Branch: {{ $invoice->payment_branch }}</p>
		<p>Account Number: {{ $invoice->payment_account }}</p>
		
		<hr>
        <p>THIS DOCUMENT IS COMPUTER GENERATED AND THEREFORE NOT SIGNED. IT IS A VALID DOCUMENT</p>
    </div>
</body>
</html>
