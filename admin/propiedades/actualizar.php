<?php

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require_once '../../includes/app.php';

estaAutenticado();

// Validar que sea un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
  header('location: /admin');
}

// Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

// Obtener información de la propiedad
$consulta = 'SELECT * FROM vendedores';
$resultado = mysqli_query($db, $consulta);


$resultado = mysqli_query($db, $consulta);

// Array para los errores
$errores = Propiedad::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Asignar los atributos
  $args = $_POST['propiedad'];

  // Sincronizar objeto en memoria con lo que el usuario escribió
  $propiedad->sincronizar($args);

  // Validaciones
  $errores = $propiedad->validar();

  // Generar nombre unico
  $manager = new Image(new Driver());
  $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

  // Subida de archivos
  if ($_FILES['propiedad']['tmp_name']['imagen']) {
    // Solo para Intervention Image v3
    $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
    $propiedad->setImagen($nombreImagen);
  }

  if (empty($errores)) {

    exit;
    // Insertar en la base de datos la propiedad
    $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedorId = {$vendedorId} WHERE id = {$id}";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
      // Redireccionar al usuario
      header("Location: /admin?resultado=2");
    }
  }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Actualizar propiedad</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>

  <?php foreach ($errores as $error): ?>
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
