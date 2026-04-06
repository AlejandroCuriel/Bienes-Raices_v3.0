<?php

require_once 'config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\ActiveRecord;

// Conectar a la BDD
$db = conectarBDD();
ActiveRecord::setDB($db);
