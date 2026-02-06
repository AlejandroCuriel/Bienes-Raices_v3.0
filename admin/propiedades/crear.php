<?php
require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
  <h1>Crear propiedades</h1>
  <a href="/admin" class="boton boton-verde">Volver</a>

  <form class="formulario">
    <fieldset>
      <legend>Información General</legend>

      <label for="titulo">Titulo:</label>
      <input type="text" id="titulo" placeholder="Titulo Propiedad" required>

      <label for="Precio">Precio:</label>
      <input type="number" id="Precio" min='1' placeholder="Precio Propiedad" required>

      <label for="imagen">Image:</label>
      <input type="file" id="imagen" accept="image/jpeg, image/pnp" required>

      <label for="descripcion">Descripcion:</label>
      <textarea id="descripcion"></textarea>
    </fieldset>

    <fieldset>
      <legend>Información Propiedad</legend>

      <label for="habitaciones">Habitaciones:</label>
      <input type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" required>

      <label for="wc">Baños:</label>
      <input type="number" id="wc" placeholder="Ej: 2" min="1" max="9" required>

      <label for="estacionamiento">Estacionamiento:</label>
      <input type="number" id="estacionamiento" placeholder="Ej: 1" min="1" max="9" required>
    </fieldset>

    <fieldset>
      <legend>Vendedor</legend>

      <select>
        <option value="1">Alejandro</option>
        <option value="2">Minoja</option>
      </select>
    </fieldset>

    <button type="submit" class="boton boton-verde">Crear Propiedades</button>
  </form>
</main>

<?php
incluirTemplate('footer');
?>