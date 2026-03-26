<?php
require_once '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

// Conectar Base de Datos
$db = conectarBDD();

// Obtener vendedores
$consulta = 'SELECT * FROM vendedores';
$resultado = mysqli_query($db, $consulta);
// Array para los errores
$errores = Propiedad::getErrores();

$propiedad = new Propiedad;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Crea una nueva instancia
  $propiedad = new Propiedad($_POST['propiedad']);

  // Generar nombre unico
  $manager = new Image(new Driver());
  $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

  if ($_FILES['propiedad']['tmp_name']['imagen']) {
    // Solo para Intervention Image v3
    $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
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
    $imagen->save(CARPETA_IMAGENES . $nombreImagen);

    $resultado = $propiedad->guardar();
    if ($resultado) {
      // Redireccionar al usuario
      header("Location: /admin?resultado=1");
    }
  }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Crear propiedad</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>
  <?php foreach ($errores as $error): ?>
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
