<?php
require_once '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

// Consulta para obtener los vendedores
$vendedores = Vendedor::all();

// Array para los errores
$errores = Propiedad::getErrores();

$propiedad = new Propiedad();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una nueva instancia
    $args = $_POST['propiedad'] ?? [];
    $args = is_array($args) ? $args : [];
    /** @var array<string, mixed> $args */
    $propiedad = new Propiedad($args);
    $imagen = null;
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

    // Generar nombre unico
    $manager = new Image(new Driver());
    $nombreImagen = md5(uniqid('', true)) . '.jpg';

    if ($tmpImagen !== '') {
        // Solo para Intervention Image v3
        $imagen = $manager->read($tmpImagen)->cover(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();

    if (empty($errores)) {
        // *** SUBIDA DE ARCHIVOS ****
        // Crear carpeta

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        // Guardar la imagen en el servidor
        if ($imagen !== null) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }

        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Crear propiedad</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>
  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
        <?php print($error) ?>
    </div>
  <?php endforeach ?>
  <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
    <?php include_once '../../includes/templates/formulario_propiedades.php' ?>

    <button type="submit" class="boton boton-verde">Crear Propiedades</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
