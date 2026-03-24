<?php
require_once 'funciones.php';
require_once 'config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Propiedad;

// Conectar a la BDD
$db = conectarBDD();
Propiedad::setDB($db);
