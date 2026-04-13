<?php

function conectarBDD(): mysqli
{
    $host = getenv('DB_HOST') ?: getenv('MYSQL_HOST') ?: 'localhost';
    $port = (int) (getenv('DB_PORT') ?: getenv('MYSQL_PORT') ?: 3306);
    $database = getenv('DB_NAME') ?: getenv('MYSQL_DATABASE') ?: 'bienesraices_crud';
    $user = getenv('DB_USER') ?: getenv('MYSQL_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: getenv('MYSQL_PASSWORD') ?: 'root';

    $db = new mysqli($host, $user, $password, $database, $port);
    if ($db->connect_errno) {
        echo 'No se pudo conectar: ' . $db->connect_error;
        exit;
    }
    return $db;
}
