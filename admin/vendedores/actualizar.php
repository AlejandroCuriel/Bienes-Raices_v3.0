<?php

use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require_once '../../includes/app.php';

estaAutenticado();

// Validar que sea un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
    exit;
}

// Obtener los datos del vendedor
$vendedor = Vendedor::find($id);

if ($vendedor === null) {
    header('Location: /admin');
    exit;
}

// Consulta para obtener los vendedores
$vendedores = Vendedor::all();

// Array para los errores
$errores = Vendedor::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar los atributos
    $args = $_POST['vendedor'];
    $args = is_array($args) ? $args : [];
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

    // Sincronizar objeto en memoria con lo que el usuario escribió
    $vendedor->sincronizar($args);

    // Validaciones
    $errores = $vendedor->validar();

    // Generar nombre unico
    $manager = new Image(new Driver());
    $nombreImagen = md5(uniqid('', true)) . '.jpg';

    // Subida de archivos
    if ($tmpImagen !== '') {
        // Solo para Intervention Image v3
        $imagen = $manager->decode($tmpImagen)->cover(200, 200);
        $vendedor->setImagen($nombreImagen);
    }

    if (empty($errores)) {
        if ($tmpImagen !== '') {
            // Almacenar la imagen
            $imagen->save(CARPETA_IMAGENES_PERFIL . $nombreImagen);
        }
        $vendedor->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Actualizar Vendedor(a)</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
        <?php print($error) ?>
    </div>
  <?php endforeach ?>

  <form class="formulario" method="POST" enctype="multipart/form-data">
    <?php include_once '../../includes/templates/formulario_vendedores.php' ?>

    <button type="submit" class="boton boton-verde">Actualizar Vendedor</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
