<?php

namespace Model;

class ActiveRecord
{
    protected $id;

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlerts()
    {
        return static::$alertas;
    }

    public function validate()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::createObject($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los attributes de la BD
    public function attributes()
    {
        $attributes = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $attributes[$columna] = $this->$columna;
        }
        return $attributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAttributes()
    {
        $attributes = $this->attributes();
        $sanitizado = [];
        foreach ($attributes as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function synchronizeDB($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function save()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // update
            $resultado = $this->update();
        } else {
            // Creando un nuevo registro
            $resultado = $this->create();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$table;
        $resultado = self::consultSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = {$id}";
        $resultado = self::consultSQL($query);
        return array_shift($resultado);
    }

    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultSQL($query);
        return array_shift($resultado); // array_shift devuelve el primer elemento de un array
    }

    // Consulta plana de SQL (Utiliza cuando los métodos los modelo no son suficientes)
    public static function SQL($query)
    {
        $resultado = self::consultSQL($query);
        return $resultado;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$table . " LIMIT {$limite}";
        $resultado = self::consultSQL($query);
        return array_shift($resultado);
    }

    // crea un nuevo registro
    public function create()
    {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        /* return json_encode(['query' => $query]); */

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function update()
    {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($attributes as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // delete un Registro por su ID
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
}
