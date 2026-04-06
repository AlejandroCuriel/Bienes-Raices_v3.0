<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require_once '../../includes/app.php';

estaAutenticado();

// Validar que sea un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('location: /admin');
    exit;
}

// Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

if ($propiedad === null) {
    header('location: /admin');
    exit;
}

// Consulta para obtener los vendedores
$vendedores = Vendedor::all();

// Array para los errores
$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar los atributos
    $args = $_POST['propiedad'];
    $args = is_array($args) ? $args : [];
    $tmpImagen = '';
    $archivoPropiedad = $_FILES['propiedad'] ?? null;
    if (
        is_array($archivoPropiedad)
        && isset($archivoPropiedad['tmp_name'])
        && is_array($archivoPropiedad['tmp_name'])
        && isset($archivoPropiedad['tmp_name']['imagen'])
        && is_string($archivoPropiedad['tmp_name']['imagen'])
    ) {
        $tmpImagen = $archivoPropiedad['tmp_name']['imagen'];
    }

    // Sincronizar objeto en memoria con lo que el usuario escribió
    $propiedad->sincronizar($args);

    // Validaciones
    $errores = $propiedad->validar();

    // Generar nombre unico
    $manager = new Image(new Driver());
    $nombreImagen = md5(uniqid('', true)) . '.jpg';

    // Subida de archivos
    if ($tmpImagen !== '') {
        // Solo para Intervention Image v3
        $imagen = $manager->read($tmpImagen)->cover(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    if (empty($errores)) {
        if ($tmpImagen !== '') {
            // Almacenar la imagen
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Actualizar propiedad</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
        <?php print($error) ?>
    </div>
  <?php endforeach ?>

  <form class="formulario" method="POST" enctype="multipart/form-data">
    <?php include_once '../../includes/templates/formulario_propiedades.php' ?>

    <button type="submit" class="boton boton-verde">Actualizar Propiedad</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
