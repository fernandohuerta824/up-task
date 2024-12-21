<?php
require __DIR__ . '/../vendor/autoload.php';

require 'config/database.php';
require 'funciones.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use Model\ActiveRecord as ActiveRecord;

ActiveRecord::setDB(conectarDB($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], 3306));