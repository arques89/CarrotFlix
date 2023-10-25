<?php

namespace Model;

class ActiveRecord
{
    protected $id;

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

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
        $result = self::$db->query($query);

        // Iterar los results
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = static::createObject($registro);
        }

        // liberar la memoria
        $result->free();

        // retornar los results
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($registro)
    {
        $object = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    // Identificar y unir los attributes de la BD
    public function attributes()
    {
        $attributes = [];
        foreach (static::$columnsDB as $column) {
            if ($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAttributes()
    {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach ($attributes as $key => $value) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
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
        $result = '';
        if (!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->create();
        }
        return $result;
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$table;
        $result = self::consultSQL($query);
        return $result;
    }

    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = {$id}";
        $result = self::consultSQL($query);
        return array_shift($result);
    }

    public static function where($column, $valor)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE {$column} = '{$valor}'";
        $result = self::consultSQL($query);
        return array_shift($result); // array_shift devuelve el primer elemento de un array
    }

    // Consulta plana de SQL (Utiliza cuando los métodos los modelo no son suficientes)
    public static function SQL($query)
    {
        $result = self::consultSQL($query);
        return $result;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limit)
    {
        $query = "SELECT * FROM " . static::$table . " LIMIT {$limit}";
        $result = self::consultSQL($query);
        return array_shift($result);
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

        // result de la consulta
        $result = self::$db->query($query);
        return [
            'result' =>  $result,
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
        $result = self::$db->query($query);
        return $result;
    }

    // delete un Registro por su ID
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}
