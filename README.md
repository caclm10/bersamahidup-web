# BersamaHidup - Online Donation and Fundraising Application

Welcome to the repository for the BersamaHidup Online Donation and Fundraising Application. This project is a web application created for educational purposes as part of a university project. It is built using the [Laravel](https://laravel.com/) framework, utilizes the [MySQL](https://www.mysql.com) database, and integrates with the [Tripay](https://tripay.co.id) payment gateway to facilitate online donations and fundraising.

## Key Features
- Online Donation Processing
- Fundraising Campaign Management
- Payment Gateway Integration (Tripay)
- User Registration and Management
- Fundraising Progress Tracking

## Installation

**Prerequisites:**
**Prerequisites:**
- [PHP](https://www.php.net) >= 7.3
- [Composer](https://getcomposer.org)
- [MySQL](https://www.mysql.com)
- [Tripay](https://tripay.co.id) account and API keys

1. Clone this repository to your computer.
2. Navigate to the project directory.
3. Copy the `.env.example` file to `.env` and configure your database and Tripay API settings.
4. Run `composer install` to install PHP dependencies.
5. Generate an application key with `php artisan key:generate`.
6. Run database migrations with `php artisan migrate`.
7. Start the development server with `php artisan serve`.

Access the application in your web browser at http://localhost:8000.

## Tripay Configuration
To enable Tripay integration, you need to provide the necessary API credentials in the `.env` file. Follow the Tripay documentation for obtaining these credentials.

## Developer
This project is developed by [Lewin Xander Gulo](https://portfolio-caclm10.vercel.app). If you wish to get in touch with me, you can email me at [lewinxander@gmail.com](mailto:lewinxander@gmail.com).
