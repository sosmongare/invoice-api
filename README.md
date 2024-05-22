# Invoice API

Invoice API is a RESTful API for managing invoices, providing functionalities to create, retrieve, update, and delete invoices. It also supports generating PDF versions of invoices.It provides a straightforward and scalable solution for businesses and developers to handle invoicing tasks seamlessly. Built on Laravel, it ensures robustness, security, and flexibility in invoice management.

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

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Make your changes and commit them (`git commit -am 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Create a new pull request.

Please ensure your code adheres to the existing code style and includes appropriate tests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
