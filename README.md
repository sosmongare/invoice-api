# Invoice API

Invoice API is a RESTful API for managing invoices, providing functionalities to create, retrieve, update, and delete invoices. It also supports generating PDF versions of invoices.It provides a straightforward and scalable solution for businesses and developers to handle invoicing tasks seamlessly. Built on Laravel, it ensures robustness, security, and flexibility in invoice management.

## User case

1. Creating invoices for VAT compliance
2. Generate a PDF of an invoice that you have the details to (recipient, items, etc)
3. Selling products or services on credit terms

## Installation

1. Clone the repository:

```bash
git clone https://github.com/sosmongare/invoice-api.git
```

2. Install dependencies:

```bash
cd invoice-api
composer install
```

3. Set up your environment variables:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Configure your database in the `.env` file.

6. Run migrations and seed the database:

```bash
php artisan migrate --seed
```

7. Start the server:

```bash
php artisan serve
```

## Usage

### Endpoints

- `GET /invoices`: Retrieve all invoices.
- `POST /invoices`: Create a new invoice.
- `GET /invoices/{id}`: Retrieve a specific invoice.
- `PUT /invoices/{id}`: Update a specific invoice.
- `DELETE /invoices/{id}`: Delete a specific invoice.
- `GET /invoices/{id}/pdf`: Generate a PDF version of a specific invoice.

### Request and Response Formats

Refer to the API controller for details on request and response formats.

```bash
{
    "invoice_date": "2024-05-22",
    "due_date": "2024-06-22",
    "from_name": "Sospeter Mongare",
    "from_address": "1234 Main St, Nairobi, KENYA",
    "from_email": "info@sos.dev",
    "from_phone": "0708***430",
    "payment_bank": "Absa Bank",
    "payment_branch": "Main Branch",
    "payment_name": "Sospeter Mongare",
    "payment_account": "123456789",
    "payment_pin": "A0109***5432G",
    "payment_method": "Bank Transfer",
    "payment_phone": "555-555-5555",
    "customer_name": "Customer Name",
    "customer_address": "5678 RiverRoad, Nairobi, Kenya",
    "customer_email": "info@customer.com",
    "customer_phone": "555-555-1234",
    "items": [
        {
            "description": "Backend Development",
            "quantity": 1,
            "unit_price": 500000.00
        },
        {
            "description": "Quality Assurance",
            "quantity": 1,
            "unit_price": 100000.00
        }
    ],
    "payment_terms": "To be paid by Due Date",
    "notes": "Thank you for your business."
}
```

## Demo
![alt text](image.png)

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Make your changes and commit them (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Create a new pull request.
