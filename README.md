# Laravel Starter

Pembayaran SPP v1.0.0

# Usage

Make sure you have Laravel installed, this starter only for Laravel.

# Change .env.example to .env

Change .env.example to .env, and configure whatever you want.

# Generate Key

```
php artisan key:generate
```

# Install Dependencies

```
composer install
```

# Readd class

```
composer dump-autoload
```

# Add Data

```
php artisan migrate:fresh --seed
```

# Users

| Email               | Password | Role       |
| ------------------- | -------- | ---------- |
| highadmin@gmail.com | password | High Admin |
| guest@gmail.com     | password | Guest      |
