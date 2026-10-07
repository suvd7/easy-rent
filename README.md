# Easy Rent

A rental property management web app built with Laravel. Owners manage their properties and apartments, set up leases with tenants, and handle maintenance requests. Tenants see their own apartments and leases and report problems. Admins manage all users and data.

## Features

- **Three roles**: admin, owner and tenant, each with its own dashboard
- **Properties and apartments**: owners create properties and the apartments inside them (unit number, floor, rent, bedrooms, bathrooms, size, parking, availability status, photo)
- **Leases**: link tenants to apartments with start and end dates
- **Maintenance requests**: tenants report issues with a priority level (low / medium / high / urgent) and an optional photo; owners track them until they're resolved
- **User management**: admins list all users and change their roles
- **Access control**: owners only see their own properties, tenants only see their own leases and requests
- **Responsive UI** built with Tailwind CSS, usable on desktop and mobile

## Tech stack

- [Laravel 13](https://laravel.com/) (PHP 8.3+)
- [Laravel Breeze](https://laravel.com/docs/starter-kits) (Blade) for authentication
- Tailwind CSS + Vite
- SQLite

## Data model

| Table | Description |
|---|---|
| `users` | All accounts, with a `role` (admin / owner / tenant) |
| `properties` | Buildings owned by an owner |
| `apartments` | Units inside a property (one property → many apartments) |
| `leases` | Connects tenants and apartments (many-to-many, with start / end dates) |
| `maintenance_requests` | Issues reported for an apartment, with priority, photo and resolution time |

## Getting started

**Requirements:** PHP 8.3+, Composer, Node.js and npm.

```bash
git clone https://github.com/suvd7/easy-rent.git
cd easy-rent

# Install dependencies, create .env, generate the app key, run migrations and build assets
composer setup

# (optional) Add sample data
php artisan db:seed

# Start the app: web server, queue worker, logs and Vite
composer dev
```

Then open http://localhost:8000 and register an account.

For uploaded photos to display, link the storage folder once:

```bash
php artisan storage:link
```

## Running tests

```bash
composer test
```

## Background

This project started as a university assignment for the *Advanced Web Programming* course at ELTE (Eötvös Loránd University), Budapest.
