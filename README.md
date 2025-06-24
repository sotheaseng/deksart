# Hotel Management System

A comprehensive hotel management system built with Laravel 11, featuring blockchain-powered data integrity and role-based access control.

## Features

- **User Management**: Role-based access control (Admin, Front Desk, Housekeeper)
- **Room Management**: Complete room inventory with status tracking
- **Housekeeping System**: Task assignment and progress tracking
- **Blockchain Integration**: Immutable audit trail for data integrity
- **Authentication**: Secure login system with Laravel Breeze
- **Responsive Design**: Mobile-friendly interface

## Installation

1. Clone the repository:
\`\`\`bash
git clone <repository-url>
cd hotel-management-system
\`\`\`

2. Install dependencies:
\`\`\`bash
composer install
\`\`\`

3. Copy environment file:
\`\`\`bash
cp .env.example .env
\`\`\`

4. Generate application key:
\`\`\`bash
php artisan key:generate
\`\`\`

5. Configure your database in `.env`:
\`\`\`
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_blockchain
DB_USERNAME=root
DB_PASSWORD=
\`\`\`

6. Run migrations and seed data:
\`\`\`bash
php artisan migrate --seed
\`\`\`

7. Start the development server:
\`\`\`bash
php artisan serve
\`\`\`

## Demo Credentials

- **Admin**: admin@hotel.com / password
- **Front Desk**: frontdesk@hotel.com / password
- **Housekeeper**: housekeeper@hotel.com / password

## System Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Laravel 11

## Key Components

### Models
- User (with role-based permissions)
- Room (inventory management)
- HousekeepingTask (task tracking)
- BlockchainRecord (audit trail)
- Reservation (booking system)

### Services
- BlockchainService (data integrity verification)

### Controllers
- DashboardController (overview statistics)
- RoomController (room management)
- HousekeepingController (task management)
- BlockchainController (audit trail viewing)

## Security Features

- Role-based middleware protection
- CSRF protection
- Password hashing
- Session management
- Blockchain-based data integrity

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# deksart
