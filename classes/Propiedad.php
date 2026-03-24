<?php

namespace App;

class Propiedad
{
  // Base de Datos
  protected static $db;

  public $id;
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
    $this->id = $args['id'] ?? '';
    $this->titulo = $args['titulo'] ?? '';
    $this->imagen = $args['imagen'] ?? 'imagen.jpg';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->precio = $args['precio'] ?? '';
    $this->habitaciones = $args['habitaciones'] ?? '';
    $this->wc = $args['wc'] ?? '';
    $this->estacionamiento = $args['estacionamiento'] ?? '';
    $this->vendedorId = $args['vendedorId'] ?? '';
    $this->creado = date('Y/m/d');
  }

  public function guardar()
  {
    // Insertar en la base de datos la propiedad
    $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) VALUES ('$this->titulo','$this->precio', '$this->imagen' ,'$this->descripcion','$this->habitaciones','$this->wc','$this->estacionamiento', '$this->creado', '$this->vendedorId')";

    $resultado = self::$db->query($query);

    debuguear($resultado);
  }

  // Definir la conexión a la BDD
  public static function setDB($database)
  {
    self::$db = $database;
  }
}
