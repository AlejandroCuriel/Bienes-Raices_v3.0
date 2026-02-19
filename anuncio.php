<?php
require 'includes/config/database.php';
require 'includes/funciones.php';

$db = conectarBDD();
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
  header('location: /');
}

$query = "SELECT titulo, imagen, precio, wc, estacionamiento, habitaciones, descripcion FROM propiedades WHERE id = {$id}";
$resultado = mysqli_query($db, $query);
if (!$resultado->num_rows) header('location: /');
$propiedad = mysqli_fetch_assoc($resultado);

incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
  <h1><?= $propiedad['titulo'] ?></h1>


  <img loading="lazy" src="/imagenes/<?= $propiedad['imagen'] ?>" alt="Anuncio de <?= $propiedad['titulo'] ?>">


  <div class="resumen-propiedad">
    <p class="precio">$<?= $propiedad['precio'] ?> MXN</p>
    <ul class="iconos-caracteristicas">
      <li>
        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
        <p><?= $propiedad['wc'] ?></p>
      </li>
      <li>
        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
        <p><?= $propiedad['estacionamiento'] ?></p>
      </li>
      <li>
        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
        <p><?= $propiedad['habitaciones'] ?></p>
      </li>
    </ul>

    <p><?= $propiedad['descripcion'] ?></p>
  </div>
</main>

<?php incluirTemplate('footer'); ?>
<?= mysqli_close($db); ?>
