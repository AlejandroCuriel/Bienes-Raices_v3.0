<?php
// Obtener las propiedades existentes
// 1.- Importar la conexión
require '../includes/config/database.php';
$db = conectarBDD();

// 2.- Escribir el Query
$query = 'SELECT * FROM propiedades';
// 3.- Consultar la BDD
$resultadoPropiedades = mysqli_query($db, $query);

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

// Incluye un template
require '../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">

  <h1>Administrador de Bienes Raices</h1>
  <?php switch (intval($resultado)) {
    case 1:
      echo "<p class='alerta exito'>Propiedad creada correctamente</p>";
      break;
    case 2:
      echo "<p class='alerta exito'>Propiedad creada correctamente</p>";
      break;
    case 3:
      echo "<p class='alerta exito'>Propiedad creada correctamente</p>";
      break;
    default:
      null;
  } ?>

  <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nuega Propiedad</a>
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
            <a href="admin/propiedades/actualizar.php?id=<?= $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>
            <a href="#" class="boton-rojo-block">Eliminar</a>
          </td>
        </tr>
      <?php endwhile ?>
    </tbody>
  </table>


</main>

<?php
// 4.- Cerrar conexión de la BDD (opcional)
mysqli_close($db);
incluirTemplate('footer');
?>
