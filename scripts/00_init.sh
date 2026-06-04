#!/bin/bash

# Run migrations and seed database
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force
