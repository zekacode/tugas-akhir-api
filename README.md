# Tugas Akhir API

Lightweight REST API built with Laravel (app structure present) for managing foods, categories, cuisine types, moods, occasions, weather conditions and dietary restrictions.

This repository contains the API backend including models, migrations, seeders and basic tests.

## Quick overview

- Framework: Laravel (project scaffold)
- PHP: ^8.2 (see `composer.json`)
- Main app directory: `app/`
- Routes: `routes/web.php`
- API docs (if generated): `storage/api-docs/`

## Requirements

- PHP 8.2 or newer
- Composer
- A database (MySQL, MariaDB, SQLite, Postgres supported by Laravel)
- Node.js & npm (only required if you need to run frontend assets or the `dev` script)

## Setup (Windows / PowerShell instructions)

1. Clone the repo and change into project folder:

```powershell
cd C:\path\to\projects
git clone <repo-url>
cd tugas-akhir-api
```

2. Install PHP dependencies with Composer:

```powershell
composer install
```

3. Copy the environment file and set environment variables:

```powershell
Copy-Item .env.example .env
# Then edit .env with your DB credentials and other settings (APP_NAME, APP_URL, DB_*, JWT_SECRET etc.)
```

Tip: If your repo doesn't include `.env.example`, create a `.env` file and set at least the following:

- APP_ENV=local
- APP_KEY=base64:...
- APP_DEBUG=true
- APP_URL=http://localhost
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=your_database
- DB_USERNAME=your_user
- DB_PASSWORD=your_pass

4. Generate application key (if using Laravel) and JWT secret (if needed):

```powershell
php artisan key:generate
php artisan jwt:secret
```

5. Run database migrations and (optionally) seeders:

```powershell
php artisan migrate
php artisan db:seed
```

If you want a fresh database during development:

```powershell
php artisan migrate:fresh --seed
```

## Running the app locally

Start the built-in PHP server (development):

```powershell
php artisan serve
# listens on http://127.0.0.1:8000 by default
```

Alternatively, the `dev` composer script boots multiple services (requires Node/npm and npx):

```powershell
composer run dev
```

## Tests

Run the test suite with Composer's `test` script (this clears config cache then runs tests):

```powershell
composer test
```

You can also run PHPUnit directly:

```powershell
./vendor/bin/phpunit
```

## API

Routes are defined in `routes/web.php`. The controllers live in `app/Http/Controllers/` (e.g. `Api/FoodsController.php`).

If the repository includes API documentation, check `storage/api-docs/` for generated docs (OpenAPI/Swagger JSON or YAML).

Example (generic) curl request to check server is up:

```powershell
curl http://127.0.0.1:8000/
```

Replace with the actual API endpoints listed in `routes/web.php` for working endpoints like `/api/foods`.

## Environment / Configuration notes

- Ensure database credentials in `.env` are correct before running migrations.
- If you change env variables, run `php artisan config:clear` and `php artisan cache:clear` as needed.

## Common commands

- Install dependencies: `composer install`
- Run migrations: `php artisan migrate`
- Seed database: `php artisan db:seed`
- Run tests: `composer test`
- Serve app locally: `php artisan serve`

## Contributing

Feel free to open issues or pull requests. Keep changes small and focused. Add/update tests for new behavior.

## License

This project is provided under the MIT license (see `composer.json`).

## Contact

If you need help, open an issue in this repository with details about your environment and the problem.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
