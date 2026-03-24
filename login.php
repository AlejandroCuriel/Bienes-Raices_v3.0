<?php
require_once 'includes/config/app.php';
$db = conectarBDD();

// Autenticar al usuario
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (!$email) {
    $errores[] = 'El email es obligatorio o no es válido';
  }

  if (!$password) {
    $errores[] = 'El passwor es obligatorio';
  }

  if (empty($errores)) {
    // Revisar si el usuario existe
    $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
    $resultado = mysqli_query($db, $query);

    if ($resultado->num_rows) {
      // Revisar si el password es correcto
      $usuario = mysqli_fetch_assoc($resultado);
      $auth = password_verify($password, $usuario['password']);
      var_dump($auth);
      if ($auth) {
        // El usuario esta autenticado
        session_start();

        // LLenar el arreglo de la sesion
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['login'] = true;

        header('Location: admin/');
      } else {
        $errores[] = 'Contraseña incorrecta';
      }
    } else {
      $errores[] = "El usuario no existe";
    }
  }
}

incluirTemplate('header');
?>
<main class="contenedor seccion contenido-centrado">
  <h1>Inciar Sesión</h1>

  <?php foreach ($errores as $error): ?>
    <div class="alerta error">
      <?php print($error) ?>
    </div>
  <?php endforeach ?>

  <form class="formulario" method="post">

    <fieldset>
      <legend>Email & Password</legend>
      <label for="email">E-mail</label>
      <input type="email" name="email" placeholder="Tu Email" id="email">

      <label for="password">Contraseña</label>
      <input type="password" name="password" placeholder="Tu contraseña" id="password">
    </fieldset>
    <button class="boton boton-verde" type="submit">Inciar Sesión</button>
  </form>
</main>
<?php
incluirTemplate('footer')
?>
