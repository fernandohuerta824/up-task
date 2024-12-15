<?php
require __DIR__ . '/../vendor/autoload.php';

require 'config/database.php';
require 'funciones.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use Model\ActiveRecord as ActiveRecord;

ActiveRecord::setDB(conectarDB('localhost', 'root', 'cr7eselmejorjugador', 'up_task', 3306));