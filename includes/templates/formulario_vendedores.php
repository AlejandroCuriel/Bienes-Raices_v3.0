<?php
if (!isset($vendedor) || !($vendedor instanceof \App\Vendedor)) {
    $vendedor = new \App\Vendedor();
}
?>

<!-- Formulario para crear o actualizar vendedores -->
<fieldset>
  <legend>Información General</legend>

  <label for="nombre">Nombre:</label>
  <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre vendedor" value="<?php echo sanitizarHTML($vendedor->nombre); ?>" pattern="[a-zA-Z]+">

  <label for="apellido">Apellido:</label>
  <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido vendedor" value="<?php echo sanitizarHTML($vendedor->apellido); ?>" pattern="[a-zA-Z]+">

  <label for="imagen">Imagen de Perfil:</label>
  <small>La imagen debe ser en formato JPG o PNG (Máximo 150kb)</small>
  <input type="file" id="imagen" accept="image/jpeg, image/png" name="vendedor[imagen]">
  <?php if ($vendedor->imagen) : ?>
    <img class="imagen-perfil" src="/imagenes_perfil/<?php echo $vendedor->imagen; ?>" alt="Foto de perfil de <?= $vendedor->nombre ?>" width="80" height="80">
  <?php endif; ?>
</fieldset>

<fieldset>
  <legend>Información Extra</legend>

  <label for="telefono">Telefono:</label>
  <input type="tel" id="telefono" name="vendedor[telefono]" maxlength="10" placeholder="Telefono vendedor" value="<?php echo sanitizarHTML($vendedor->telefono); ?>" pattern="[0-9]{10}">

</fieldset>
