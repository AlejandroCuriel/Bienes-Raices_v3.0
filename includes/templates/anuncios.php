<?php

use App\Propiedad;

if ($_SERVER['SCRIPT_NAME'] === '/anuncios.php') {
  $propiedades = Propiedad::all();
} else {
  $propiedades = Propiedad::get(3);
}

?>

<div class="contenedor-anuncios">
  <?php foreach ($propiedades as $propiedad) : ?>
    <div class="anuncio">
      <img loading="lazy" src="/imagenes/<?= $propiedad->imagen ?>" alt="Anuncio de <?= $propiedad->titulo ?>" />

      <div class="contenido-anuncio">
        <h3><?= $propiedad->titulo ?></h3>
        <p>Casa en el lago con excelente vista, acabados de lujo a un excelente precio</p>
        <p class="precio"><?= $propiedad->precio ?></p>

        <ul class="iconos-caracteristicas">
          <li>
            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
            <p><?= $propiedad->wc ?></p>
          </li>
          <li>
            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
            <p><?= $propiedad->estacionamiento ?></p>
          </li>
          <li>
            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
            <p><?= $propiedad->habitaciones ?></p>
          </li>
        </ul>

        <a href="anuncio.php?id=<?= $propiedad->id ?>" class="boton-amarillo-block">
          Ver Propiedad
        </a>
      </div><!--.contenido-anuncio-->
    </div><!--anuncio-->
  <?php endforeach ?>

</div> <!--.contenedor-anuncios-->
