<?php

namespace App;

class ActiveRecord
{
    // Base de Datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    /** @var string[] */
    protected static $errores = [];

    // Variables compartidas por todas las clases
    public ?int $id = null;

    // Definir la conexión a la BDD
    /** @param \mysqli $database */
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        if (is_null($this->id)) {
            $this->crear();
        } else {
            $this->actualizar();
        }
    }

    public function crear()
    {
        // Sanitizar los Datos
        $atributos = $this->sanitizarAtributos();
        // Insertar en la base de datos la propiedad
        $query = ' INSERT INTO ' . static::$tabla . ' ( ';
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar()
    {
        // Sanitizar los Datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = 'UPDATE ' . static::$tabla . ' SET ';
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= ' LIMIT 1 ';
        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar un registro
    public function eliminar()
    {
        $query = 'DELETE FROM ' . static::$tabla . ' WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->despuesDeEliminar();
            header('location: /admin?resultado=3');
        }
    }

    protected function despuesDeEliminar(): void
    {
        // Hook para que cada modelo ejecute lógica post-eliminación si la necesita.
    }

    // Identificar y unir los atributos de la clase con los de la base de datos
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') {
                continue;
            }
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
    /** @return string[] */
    public static function getErrores()
    {
        return static::$errores;
    }

    /** @return string[] */
    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    // Listar todas las propiedades
    /** @return static[] */
    public static function all()
    {
        $query = 'SELECT * FROM ' . static::$tabla;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtiene un determinado número de registros
    /** @return static[] */
    public static function get($cantidad)
    {
        $query = 'SELECT * FROM ' . static::$tabla . ' LIMIT ' . $cantidad;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Buscar un registro por ID
    /**
     * @return static|null
     */
    public static function find($id)
    {
        $query = 'SELECT * FROM ' . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    /**
     * @return static[]
     */
    public static function consultarSQL($query)
    {
        // Consultar la Base de Datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    /**
     * @return static
     */
    protected static function crearObjeto($registro)
    {
        $objeto = new static();

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
