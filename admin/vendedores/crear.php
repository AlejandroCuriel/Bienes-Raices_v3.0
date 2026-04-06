<?php

require_once '../../includes/app.php';

use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

$vendedor = new Vendedor();

// Array para los errores
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una nueva instancia
    $args = $_POST['vendedor'] ?? [];
    $args = is_array($args) ? $args : [];
    /** @var array<string, mixed> $args */
    $vendedor = new Vendedor($args);
    $imagen = null;
    $tmpImagen = '';
    $archivoVendedor = $_FILES['vendedor'] ?? null;
    if (
        is_array($archivoVendedor)
        && isset($archivoVendedor['tmp_name'])
        && is_array($archivoVendedor['tmp_name'])
        && isset($archivoVendedor['tmp_name']['imagen'])
        && is_string($archivoVendedor['tmp_name']['imagen'])
    ) {
        $tmpImagen = $archivoVendedor['tmp_name']['imagen'];
    }

    // Generar nombre unico
    $manager = new Image(new Driver());
    $nombreImagen = md5(uniqid('', true)) . '.jpg';

    if ($tmpImagen !== '') {
        // Solo para Intervention Image v3
        $imagen = $manager->decode($tmpImagen)->cover(200, 200);
        $vendedor->setImagen($nombreImagen);
    }

    $errores = $vendedor->validar();

    if (empty($errores)) {
        // *** SUBIDA DE ARCHIVOS ****
        // Crear carpeta

        if (!is_dir(CARPETA_IMAGENES_PERFIL)) {
            mkdir(CARPETA_IMAGENES_PERFIL);
        }

        // Guardar la imagen en el servidor
        if ($imagen !== null) {
            $imagen->save(CARPETA_IMAGENES_PERFIL . $nombreImagen);
        }
        $vendedor->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Registrar Vendedor(a)</h1>

  <a href="/admin" class="boton boton-verde">Volver</a>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
        <?php print($error) ?>
    </div>
  <?php endforeach ?>

  <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
    <?php include_once '../../includes/templates/formulario_vendedores.php' ?>

    <button type="submit" class="boton boton-verde">Registrar Vendedor</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
