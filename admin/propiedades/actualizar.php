<?php
require '../../includes/config/database.php';
require '../../includes/funciones.php';

$auth = estaAutenticado();
if (!$auth) {
  header('Location: /');
}

// Validar que sea un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
  header('location: /admin');
}

// Conectar Base de Datos
$db = conectarBDD();

// Obtener información de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = {$id}";

$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

// echo '<pre>';
// var_dump($propiedad);
// echo '</pre>';
// Obtener vendedores
$consulta = 'SELECT * FROM vendedores';

$resultado = mysqli_query($db, $consulta);

// Array para los errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad = $propiedad['imagen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";

  $titulo = mysqli_real_escape_string($db,  $_POST['titulo']);
  $precio = mysqli_real_escape_string($db,  $_POST['precio']);
  $descripcion = mysqli_real_escape_string($db,  $_POST['descripcion']);
  $habitaciones = mysqli_real_escape_string($db,  $_POST['habitaciones']);
  $wc = mysqli_real_escape_string($db,  $_POST['wc']);
  $estacionamiento = mysqli_real_escape_string($db,  $_POST['estacionamiento']);
  $vendedorId = mysqli_real_escape_string($db,  $_POST['vendedor']);
  $creado = date('Y/m/d');

  // Asignar files hacia una variable
  $imagen = $_FILES['imagen'];
  // var_dump($imagen['name']);


  if (!$titulo) {
    $errores[] = 'Debes añadir un Titulo';
  }

  if (!$precio) {
    $errores[] = 'Debes añadir un Precio';
  }

  if (strlen($descripcion) < 50) {
    $errores[] = 'Debes añadir una Descripción y debe tener al menos 50 caracteres';
  }

  if (!$habitaciones) {
    $errores[] = 'El Número de Habitaciones es obligatorio';
  }

  if (!$wc) {
    $errores[] = 'El Número de Baños es obligatorio';
  }

  if (!$estacionamiento) {
    $errores[] = 'El Número de Estacionamientos es obligatorio';
  }

  if (!$vendedorId) {
    $errores[] = 'Elige un vendedor';
  }

  // Validar por tamaño (1mb máximo)
  $medida = 1000 * 1000;

  if ($imagen['size'] > $medida) {
    $errores[] = 'La Imagen es muy pesada, peso recomendando 100 Kb';
  }


  if (empty($errores)) {

    // *** SUBIDA DE ARCHIVOS ****

    // Crear carpeta
    $carpetaImagenes = '../../imagenes/';
    if (!is_dir($carpetaImagenes)) {
      mkdir($carpetaImagenes);
    }

    $nombreImagen = '';
    // Si hay nueva imagen, se elimina la anterior
    if ($imagen['name']) {
      unlink($carpetaImagenes . $propiedad['imagen']);

      // Generar nombre unico
      $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

      // Subir la imagen
      move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
    } else {
      $nombreImagen = $imagenPropiedad;
    }



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
    <fieldset>
      <legend>Información General</legend>

      <label for="titulo">Titulo:</label>
      <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

      <label for="Precio">Precio:</label>
      <input type="number" id="Precio" name="precio" min='1' placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

      <label for="imagen">Image:</label>
      <input type="file" id="imagen" accept="image/jpeg, image/pnp" name="imagen">

      <img src="/imagenes/<?= $imagenPropiedad ?>" class="imagen-small" />

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

      <select name="vendedor">
        <option value="">-- Seleccione --</option>
        <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
          <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : '' ?> value='<?php echo $vendedor['id'] ?>'>
            <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido'] ?></option>
        <?php endwhile ?>
      </select>
    </fieldset>

    <button type="submit" class="boton boton-verde">Actualizar Propiedad</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>
