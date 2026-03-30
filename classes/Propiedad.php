<?php

namespace App;

class Propiedad extends ActiveRecord
{
  protected static $tabla = 'propiedades';

  protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'vendedorId', 'creado'];

  public $titulo;
  public $imagen;
  public $descripcion;
  public $precio;
  public $habitaciones;
  public $wc;
  public $estacionamiento;
  public $vendedorId;
  public $creado;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->titulo = $args['titulo'] ?? '';
    $this->imagen = $args['imagen'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->precio = $args['precio'] ?? '';
    $this->habitaciones = $args['habitaciones'] ?? '';
    $this->wc = $args['wc'] ?? '';
    $this->estacionamiento = $args['estacionamiento'] ?? '';
    $this->vendedorId = $args['vendedorId'] ?? '';
    $this->creado = date('Y/m/d');
  }

  public function validar()
  {
    if (!$this->titulo) {
      self::$errores[] = "Debes añadir un título";
    }
    if (strlen($this->titulo) > 70) {
      self::$errores[] = "El título debe tener como máximo 70 caracteres";
    }
    if (!$this->precio) {
      self::$errores[] = "El precio es obligatorio";
    }
    if (strlen($this->descripcion) < 50) {
      self::$errores[] = "La descripción debe tener al menos 50 caracteres";
    }
    if (!$this->habitaciones) {
      self::$errores[] = "El número de habitaciones es obligatorio";
    }
    if (!$this->wc) {
      self::$errores[] = "El número de baños es obligatorio";
    }
    if (!$this->estacionamiento) {
      self::$errores[] = "El número de estacionamientos es obligatorio";
    }
    if (!$this->vendedorId) {
      self::$errores[] = "Elige un vendedor";
    }
    if (!$this->imagen) {
      self::$errores[] = "La imagen es obligatoria";
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
    $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
    if ($existeArchivo) {
      unlink(CARPETA_IMAGENES . $this->imagen);
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
