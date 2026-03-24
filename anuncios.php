<?php
require_once 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">

  <h2>Casas y Depas en Venta</h2>

  <?php
  $limit = 10;
  include_once 'includes/templates/anuncios.php'
  ?>
</main>

<?php incluirTemplate('footer'); ?>
