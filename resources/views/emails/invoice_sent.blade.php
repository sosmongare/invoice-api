<!DOCTYPE html>
<html>
<head>
    <title>Invoice Generated</title>
</head>
<body>
    <p>Dear {{ $invoice->from_name }},</p>
    <p>Your invoice <strong>{{ $invoice->invoice_number }}</strong> has been generated successfully. Please find the attached PDF copy of the invoice.</p>
    <p>Thank you!</p>
</body>
</html>
