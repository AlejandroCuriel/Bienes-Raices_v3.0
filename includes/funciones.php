<?php

define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_IMAGENES_PERFIL', __DIR__ . '/../imagenes_perfil/');


function incluirTemplate(string $nombre): void
{
    include_once TEMPLATES_URL . "{$nombre}.php";
}

function estaAutenticado(): void
{
    session_start();
    if (!($_SESSION['login'] ?? false)) {
        header('Location: /');
        exit;
    }
}

function debuguear(mixed $variable): never
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

// Escapa / Sanitizar el HTML
function sanitizarHTML(mixed $html): string
{
    $html = is_scalar($html) ? (string) $html : '';
    $html = htmlspecialchars($html);
    return $html;
}

// Validar tipo de Contenido
function validarTipoContenido(string $tipo): bool
{
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

// Muestra los mensajes
function mostrarNotificacion(int|string|null $codigo): string|false
{
    $mensaje = false;
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}
