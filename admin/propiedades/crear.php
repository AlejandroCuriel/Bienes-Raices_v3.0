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
$titulo = "";
$precio = "";
$descripcion = "";
$habitaciones = "";
$wc = "";
$estacionamiento = "";
$vendedorId = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $propiedad = new Propiedad($_POST);

  // Generar nombre unico
  $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
  if ($_FILES['imagen']['tmp_name']) {
    $manager = new Image(Driver::class);
    $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
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
    <fieldset>
      <legend>Información General</legend>

      <label for="titulo">Titulo:</label>
      <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

      <label for="Precio">Precio:</label>
      <input type="number" id="Precio" name="precio" min='1' placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

      <label for="imagen">Image:</label>
      <input type="file" id="imagen" accept="image/jpeg, image/pnp" name="imagen">

      <label for="descripcion">Descripcion:</label>
      <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
    </fieldset>

    <fieldset>
      <legend>Información Propiedad</legend>

      <label for="habitaciones">Habitaciones:</label>
      <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

      <label for="wc">Baños:</label>
      <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo $wc; ?>">

      <label for="estacionamiento">Estacionamiento:</label>
      <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 1" min="1" max="9" value="<?php echo $estacionamiento; ?>">
    </fieldset>

    <fieldset>
      <legend>Vendedor</legend>

      <select name="vendedorId">
        <option value="">-- Seleccione --</option>
        <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
          <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : '' ?> value='<?php echo $vendedor['id'] ?>'>
            <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido'] ?></option>
        <?php endwhile ?>
      </select>
    </fieldset>

    <button type="submit" class="boton boton-verde">Crear Propiedades</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
