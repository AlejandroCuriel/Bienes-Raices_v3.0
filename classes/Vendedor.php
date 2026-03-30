<?php

namespace App;

class Vendedor extends ActiveRecord
{
  protected static $tabla = 'vendedores';
  protected static $columnasDB = ['id', 'imagen', 'nombre', 'apellido', 'telefono'];

  public $imagen;
  public $nombre;
  public $apellido;
  public $telefono;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->imagen = $args['imagen'] ?? '';
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
  }

  public function validar()
  {
    if (!$this->imagen) {
      self::$errores[] = "La imagen es obligatoria";
    }
    // Validar el tamaño de la imagen (máximo 150kb)
    if (isset($_FILES['vendedor']['tmp_name']['imagen']) && $_FILES['vendedor']['tmp_name']['imagen'] != '') {
      $sizeImagen = $_FILES['vendedor']['size']['imagen'];
      if ($sizeImagen > 150 * 1024) {
        self::$errores[] = "La imagen debe ser menor a 150kb";
      }
    }
    if (!$this->nombre) {
      self::$errores[] = "Debes añadir un nombre";
    }
    if (!$this->apellido) {
      self::$errores[] = "Debes añadir un apellido";
    }
    if (!$this->telefono) {
      self::$errores[] = "Debes añadir un teléfono";
    }
    if (!preg_match('/^[0-9]{10}$/', $this->telefono)) {
      self::$errores[] = "El teléfono debe tener 10 dígitos numéricos";
    }

    return self::$errores;
  }

  protected function despuesDeEliminar(): void
  {
    $this->borrarImagen();
    header('location: /admin?resultado=3');
  }

  // Eliminar el archivo
  public function borrarImagen()
  {
    $existeArchivo = file_exists(CARPETA_IMAGENES_PERFIL . $this->imagen);
    if ($existeArchivo) {
      unlink(CARPETA_IMAGENES_PERFIL . $this->imagen);
    }
  }

  // Subir/Sobreescribir la imagen de la propiedad
  public function setImagen($imagen)
  {
    // Eliminar la imagen previa
    if (!is_null($this->id)) {
      $this->borrarImagen();
    }
    // Asignar al atributo de imagen el nombre de la imagen
    if ($imagen) {
      $this->imagen = $imagen;
    }
  }
}
