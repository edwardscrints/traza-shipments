##Requerimientos de sistema

php 8.3
comoposer
laravel 9

##Creacion de Proyecto
composer create-project laravel/laravel:^9.0 traza-shipments

##Creacion de Migraciones
# Tablas sin dependencias
php artisan make:migration create_thirds_table
php artisan make:migration create_merchandises_table

# Tabla con foreign keys
php artisan make:migration create_shipments_table

##Creacion de DB
CREATE DATABASE traza_shipments CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;