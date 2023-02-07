#!/bin/sh

php artisan migrate
php artisan db:seed --class=ProductsSeeder
php artisan db:seed --class=CustomersSeeder