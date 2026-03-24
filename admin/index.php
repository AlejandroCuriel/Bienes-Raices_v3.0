<?php
require_once '../includes/app.php';

estaAutenticado();

// Obtener las propiedades existentes
// 1.- Importar la conexión
$db = conectarBDD();

// 2.- Escribir el Query
$query = 'SELECT * FROM propiedades';
// 3.- Consultar la BDD
$resultadoPropiedades = mysqli_query($db, $query);

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if ($id) {
    // Eliminar el archivo
    $query = "SELECT imagen FROM propiedades WHERE id = {$id}";
    $resultado = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultado);
    unlink('../imagenes/' . $propiedad['imagen']);

    // Eliminar la propiedad
    $query = "DELETE FROM propiedades WHERE id = {$id}";
    $resultado = mysqli_query($db, $query);
    if ($resultado) {
      header('location: /admin?resultado=3');
    }
  }
}
// Incluye un template
incluirTemplate('header');
?>

<main class="contenedor seccion">

  <h1>Administrador de Bienes Raices</h1>
  <?php switch (intval($resultado)) {
    case 1:
      echo "<p class='alerta exito'>Propiedad creada correctamente</p>";
      break;
    case 2:
      echo "<p class='alerta exito'>Propiedad Actualizada correctamente</p>";
      break;
    case 3:
      echo "<p class='alerta exito'>Propiedad Eliminada correctamente</p>";
      break;
    default:
      null;
  } ?>

  <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nuega Propiedad</a>
  <?php if (mysqli_num_rows($resultadoPropiedades) > 0) : ?>
    <table class="propiedades">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titulo</th>
          <th>Imagen</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($propiedad = mysqli_fetch_assoc($resultadoPropiedades)): ?>
          <tr>
            <td><?= $propiedad['id'] ?></td>
            <td><?= $propiedad['titulo'] ?></td>
            <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" /></td>
            <td><?= $propiedad['precio'] ?></td>
            <td>
              <a href="propiedades/actualizar.php?id=<?= $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>

              <form method="POST" class="w-100">
                <input type="hidden" name="id" value="<?= $propiedad['id'] ?>" />
                <input type="submit" class="boton-rojo-block" value="Eliminar" />
              </form>
            </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  <?php endif ?>

</main>

<?php
// 4.- Cerrar conexión de la BDD (opcional)
mysqli_close($db);
incluirTemplate('footer');
?>
