<?php

function conectarDB(string $host, string $user, string $password, string $database, int $port ): mysqli {
    try {
        return new mysqli($host, $user, $password, $database, $port);
    } catch(\Throwable $th) {
        throw $th;
    } 
}