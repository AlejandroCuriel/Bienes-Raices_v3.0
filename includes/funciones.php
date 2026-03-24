<?php

define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate(string $nombre, bool $inicio = false)
{
  include_once TEMPLATES_URL . "{$nombre}.php";
}

function estaAutenticado(): bool
{
  session_start();
  $auth = $_SESSION['login'];
  return $auth ? true : false;
}
