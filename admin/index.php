<?php
require_once '../includes/app.php';
estaAutenticado();

// Importar las clases
use App\Propiedad;
use App\Vendedor;

// Implementar un método para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validar id
  $id = $_POST['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if ($id) {

    $tipo = $_POST['tipo'];
    if (validarTipoContenido($tipo)) {
      // Compara lo que vamos a eliminar dependiendo del tipo
      if ($tipo === 'propiedad') {
        // Obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);
        $resultado = $propiedad->eliminar();
      } elseif ($tipo === 'vendedor') {
        // Obtener los datos del vendedor
        $vendedor = Vendedor::find($id);
        $resultado = $vendedor->eliminar();
      }
    }
  }
}

// Incluye un template
incluirTemplate('header');
?>

<main class="contenedor seccion">

  <h1>Administrador de Bienes Raices</h1>
  <?php if ($mensaje = mostrarNotificacion($resultado)) : ?>
    <p class="alerta exito"><?= sanitizarHTML($mensaje) ?></p>
  <?php endif; ?>

  <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
  <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo(a) Vendedor</a>

  <h2>Propiedades</h2>
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
                <input type="hidden" name="tipo" value="propiedad" />
                <input type="submit" class="boton-rojo-block" value="Eliminar" />
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif ?>

  <!-- Lista de los vendedores -->
  <h2>Vendedores</h2>
  <?php if (count($vendedores) > 0) : ?>
    <table class="vendedores">
      <thead>
        <tr>
          <th>ID</th>
          <th>Perfil</th>
          <th>Nombre</th>
          <th>Telefono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vendedores as $vendedor) : ?>
          <tr>
            <td><?= $vendedor->id ?></td>
            <td><img class="imagen-perfil" src="/imagenes_perfil/<?= $vendedor->imagen; ?>" alt="Foto de perfil de <?= $vendedor->nombre ?>" width="80px" height="80px" /></td>

            <td><?= $vendedor->nombre ?> <?= $vendedor->apellido ?></td>
            <td><?= $vendedor->telefono ?></td>
            <td>
              <a href="admin/vendedores/actualizar.php?id=<?= $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>

              <form method="POST" class="w-100">
                <input type="hidden" name="id" value="<?= $vendedor->id ?>" />
                <input type="hidden" name="tipo" value="vendedor" />
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
incluirTemplate('footer');
?>
