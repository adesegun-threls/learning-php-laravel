# Laravel Example Application

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

A starter Laravel application built with Laravel 12 and Vite, featuring Tailwind CSS for styling and modern PHP 8.2+ features.

## Quick Start

### Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP 8.2 or higher** - [Download PHP](https://www.php.net/downloads)
- **Composer** - [Install Composer](https://getcomposer.org/download/)
- **Node.js & npm** - [Download Node.js](https://nodejs.org/)
- **Database** (MySQL, PostgreSQL, SQLite, or SQL Server)

### Installation

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd example-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database**
   
   Edit the `.env` file and update the database configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. **Run database migrations**
   ```bash
   php artisan migrate
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

## Running the Application

### Development Mode

1. **Start the Laravel development server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

2. **Start the Vite development server** (in a separate terminal)
   ```bash
   npm run dev
   ```
   This enables hot reloading for CSS and JavaScript changes.

### Production Mode

1. **Build production assets**
   ```bash
   npm run build
   ```

2. **Configure your web server** to point to the `public` directory

## Available Commands

### Artisan Commands
- `php artisan serve` - Start the development server
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh` - Drop all tables and re-run migrations
- `php artisan db:seed` - Run database seeders
- `php artisan tinker` - Interactive PHP shell
- `php artisan route:list` - List all registered routes
- `php artisan make:controller ControllerName` - Create a new controller
- `php artisan make:model ModelName` - Create a new model
- `php artisan make:migration migration_name` - Create a new migration

### NPM Scripts
- `npm run dev` - Start Vite development server with hot reloading
- `npm run build` - Build assets for production

## Project Structure

```
├── app/                    # Application logic
│   ├── Http/Controllers/   # HTTP controllers
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── config/                # Configuration files
├── database/              # Migrations, factories, and seeders
├── public/                # Web server document root
├── resources/             # Views, CSS, JS, and other assets
│   ├── css/              # CSS files (processed by Vite)
│   ├── js/               # JavaScript files (processed by Vite)
│   └── views/            # Blade template files
├── routes/                # Route definitions
│   ├── web.php           # Web routes
│   └── console.php       # Console routes
├── storage/               # Logs, cache, and uploaded files
└── tests/                 # Automated tests
```

## Testing

Run the test suite:
```bash
php artisan test
```

Or using PHPUnit directly:
```bash
./vendor/bin/phpunit
```

## Troubleshooting

### Common Issues

1. **Permission errors**: Ensure `storage` and `bootstrap/cache` directories are writable
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. **Missing .env file**: Copy `.env.example` to `.env` and configure your settings

3. **Database connection errors**: Verify your database credentials in `.env`

4. **Asset loading issues**: Run `npm run build` or `npm run dev`

## Learning Resources

- [Laravel Documentation](https://laravel.com/docs) - Official Laravel documentation
- [Laracasts](https://laracasts.com) - Video tutorials for Laravel and PHP
- [Laravel News](https://laravel-news.com) - Latest Laravel updates and tutorials

## License

This Laravel application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
