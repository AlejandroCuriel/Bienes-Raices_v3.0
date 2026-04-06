<?php

function conectarBDD(): mysqli
{
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');
    if ($db->connect_errno) {
        echo 'No se pudo conectar: ' . $db->connect_error;
        exit;
    }
    return $db;
}
