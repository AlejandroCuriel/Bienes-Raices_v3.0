<?php

namespace App;

class Propiedad
{
  // Base de Datos
  protected static $db;
  protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'vendedorId', 'creado'];

  // Errores
  protected static $errores = [];

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

  // Definir la conexión a la BDD
  public static function setDB($database)
  {
    self::$db = $database;
  }

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? '';
    $this->titulo = $args['titulo'] ?? '';
    $this->imagen = $args['imagen'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->precio = $args['precio'] ?? '';
    $this->habitaciones = $args['habitaciones'] ?? '';
    $this->wc = $args['wc'] ?? '';
    $this->estacionamiento = $args['estacionamiento'] ?? '';
    $this->vendedorId = $args['vendedorId'] ?? 1;
    $this->creado = date('Y/m/d');
  }

  public function guardar()
  {
    if (isset($this->id)) {
      $this->actualizar();
    } else {
      $this->crear();
    }
  }

  public function crear()
  {
    // Sanitizar los Datos
    $atributos = $this->sanitizarAtributos();

    // Insertar en la base de datos la propiedad
    $query = " INSERT INTO propiedades ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES (' ";
    $query .= join("', '", array_values($atributos));
    $query .= " ') ";

    $resultado = self::$db->query($query);
    return $resultado;
  }

  public function actualizar()
  {
    // Sanitizar los Datos
    $atributos = $this->sanitizarAtributos();

    $valores = [];
    foreach ($atributos as $key => $value) {
      $valores[] = "{$key}='{$value}'";
    }
    $query = "UPDATE propiedades SET ";
    $query .= join(', ', $valores);
    $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
    $query .= " LIMIT 1 ";
    $resultado = self::$db->query($query);

    if ($resultado) {
      // Redireccionar al usuario
      header("Location: /admin?resultado=2");
    }
  }

  // Identificar y unir los atributos de la clase con los de la base de datos
  public function atributos()
  {
    $atributos = [];
    foreach (self::$columnasDB as $columna) {
      if ($columna === 'id') continue;
      $atributos[$columna] = $this->$columna;
    }
    return $atributos;
  }
  // Sanitizar los atributos antes de insertarlos en la base de datos
  public function sanitizarAtributos()
  {
    $atributos = $this->atributos();
    $sanitizado = [];
    foreach ($atributos as $key => $value) {
      $sanitizado[$key] = self::$db->escape_string($value);
    }
    return $sanitizado;
  }

  // Validación de errores
  public static function getErrores()
  {
    return self::$errores;
  }

  public function setImagen($imagen)
  {
    // Eliminar la imagen previa
    if (isset($this->id)) {
      $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
      if ($existeArchivo) {
        unlink(CARPETA_IMAGENES . $this->imagen);
      }
    }
    // Asignar al atributo de imagen el nombre de la imagen
    if ($imagen) {
      $this->imagen = $imagen;
    }
  }

  public function validar()
  {
    if (!$this->titulo) {
      self::$errores[] = "Debes añadir un título";
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

  // Listar todas las propiedades
  public static function all()
  {
    $query = "SELECT * FROM propiedades";
    $resultado = self::consultarSQL($query);

    return $resultado;
  }

  // Buscar un registro por ID
  public static function find($id)
  {
    $query = "SELECT * FROM propiedades WHERE id = {$id}";
    $resultado = self::consultarSQL($query);
    return array_shift($resultado);
  }

  public static function consultarSQL($query)
  {
    // Consultar la Base de Datos
    $resultado = self::$db->query($query);

    // Iterar los resultados
    $array = [];
    while ($registro = $resultado->fetch_assoc()) {
      $array[] = self::crearObjeto($registro);
    }

    // Liberar la memoria
    $resultado->free();

    // Retornar los resultados
    return $array;
  }

  protected static function crearObjeto($registro)
  {
    $objeto = new self;

    foreach ($registro as $key => $value) {
      if (property_exists($objeto, $key)) {
        $objeto->$key = $value;
      }
    }
    return $objeto;
  }

  // Sincroniza el objeto en memoria con los cambios realizados por el usuario
  public function sincronizar($args = [])
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }
}
