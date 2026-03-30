 <fieldset>
   <legend>Información General</legend>

   <label for="titulo">Titulo:</label>
   <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo sanitizarHTML($propiedad->titulo); ?>">

   <label for="Precio">Precio:</label>
   <input type="number" id="Precio" name="propiedad[precio]" min='1' placeholder="Precio Propiedad" value="<?php echo sanitizarHTML($propiedad->precio); ?>">

   <label for="imagen">Image:</label>
   <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

   <?php if ($propiedad->imagen) : ?>
     <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Propiedad en venta" class="imagen-small" />
   <?php endif ?>

   <label for="descripcion">Descripcion:</label>
   <textarea id="descripcion" name="propiedad[descripcion]"><?php echo sanitizarHTML($propiedad->descripcion); ?></textarea>
 </fieldset>

 <fieldset>
   <legend>Información Propiedad</legend>

   <label for="habitaciones">Habitaciones:</label>
   <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->habitaciones); ?>">

   <label for="wc">Baños:</label>
   <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 2" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->wc); ?>">

   <label for="estacionamiento">Estacionamiento:</label>
   <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 1" min="1" max="9" value="<?php echo sanitizarHTML($propiedad->estacionamiento); ?>">
 </fieldset>

 <fieldset>
   <legend>Vendedor</legend>

   <select name="propiedad[vendedorId]">
     <option selected value="">-- Seleccione --</option>
     <?php foreach ($vendedores as $vendedor): ?>
       <option
         <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : '' ?>
         value="<?php echo sanitizarHTML($vendedor->id) ?>">
         <?php echo sanitizarHTML($vendedor->nombre) . ' ' . sanitizarHTML($vendedor->apellido) ?></option>
     <?php endforeach ?>
   </select>
 </fieldset>
