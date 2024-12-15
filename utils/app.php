<?php
require __DIR__ . '/../vendor/autoload.php';

require 'config/database.php';
require 'funciones.php';


use Model\ActiveRecord as ActiveRecord;

ActiveRecord::setDB(conectarDB('localhost', 'root', 'cr7eselmejorjugador', 'up_task', 3306));