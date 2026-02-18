<?php
$resultado = $_GET['resultado'] ?? null;
require '../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">

  <h1>Administrador de Bienes Raices</h1>
  <?php if (intval($resultado) === 1): ?>
    <p class="alerta exito">Propiedad creada correctamente</p>
  <?php endif ?>
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
      <tr>
        <td>1</td>
        <td>Casa en la playa</td>
        <td><img src="/imagenes/b113bfde2f9af1d711dbdf895dc427d4.jpg" class="imagen-tabla" /></td>
        <td>$650,000</td>
        <td>
          <a href="" class="boton-rojo-block">Eliminar</a>
          <a href="" class="boton-amarillo-block">Actualizar</a>
        </td>
      </tr>
    </tbody>
  </table>


</main>

<?php
incluirTemplate('footer');
?>
