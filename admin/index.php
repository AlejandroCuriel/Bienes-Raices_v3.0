<?php
require_once '../includes/app.php';
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

// Implementar un método para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if ($id) {
    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);
    $resultado = $propiedad->eliminar();
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
  <?php if (count($propiedades) > 0) : ?>
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
        <?php foreach ($propiedades as $propiedad) : ?>
          <tr>
            <td><?= $propiedad->id ?></td>
            <td><?= $propiedad->titulo ?></td>
            <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" /></td>
            <td><?= $propiedad->precio ?></td>
            <td>
              <a href="admin/propiedades/actualizar.php?id=<?= $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>

              <form method="POST" class="w-100">
                <input type="hidden" name="id" value="<?= $propiedad->id ?>" />
                <input type="submit" class="boton-rojo-block" value="Eliminar" />
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>

</main>

<?php
// 4.- Cerrar conexión de la BDD (opcional)
mysqli_close($db);
incluirTemplate('footer');
?>
