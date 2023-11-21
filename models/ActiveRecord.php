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
    protected static $alerts = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($type, $message)
    {
        static::$alerts[$type][] = $message;
    }

    // Validación
    public static function getAlerts()
    {
        return static::$alerts;
    }

    public function validate()
    {
        static::$alerts = [];

        return static::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultSQL($query)
    {
        // Consultar la base de datos
        $result = self::$db->query($query);

        // Iterar los results
        $array = [];
        while ($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        // liberar la memoria
        $result->free();

        // retornar los results
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject($register)
    {
        $object = new static();

        foreach ($register as $key => $value) {
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
            if ('id' === $column) {
                continue;
            }
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
            // Verificar si $value no es nulo antes de escaparlo
            if ($value !== null) {
                $sanitized[$key] = self::$db->escape_string($value);
            } else {
                // Manejar el caso cuando $value es nulo
                // Puede ser asignar un valor por defecto, lanzar una excepción, etc.
                // Aquí se está asignando una cadena vacía como valor por defecto
                $sanitized[$key] = '';
            }
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

    // Registers - CRUD
    public function save()
    {
        $result = '';
        if (!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creando un nuevo register
            $result = $this->create();
        }

        return $result;
    }

    // Todos los registers
    public static function all()
    {
        $query = 'SELECT * FROM ' . static::$table;
        $result = self::consultSQL($query);

        return $result;
    }

    // Busca un register por su id
    public static function find($id)
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE id = {$id}";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    public static function where($column, $value)
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE {$column} = '{$value}'";
        $result = self::consultSQL($query);

        return array_shift($result); // array_shift devuelve el primer elemento de un array
    }

    // Consulta plana de SQL (Utiliza cuando los métodos los modelo no son suficientes)
    public static function SQL($query)
    {
        $result = self::consultSQL($query);

        return $result;
    }

    // Obtener Registers con cierta cantidad
    public static function get($limit)
    {
        $query = 'SELECT * FROM ' . static::$table . " LIMIT {$limit}";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    // crea un nuevo register
    public function create()
    {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = ' INSERT INTO ' . static::$table . ' ( ';
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        /* return json_encode(['query' => $query]); */

        // result de la consulta
        $result = self::$db->query($query);

        return [
            'result' => $result,
            'id' => self::$db->insert_id,
        ];
    }

    // Actualizar el register
    public function update()
    {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        foreach ($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = 'UPDATE ' . static::$table . ' SET ';
        $query .= join(', ', $values);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= ' LIMIT 1 ';

        // Actualizar BD
        $result = self::$db->query($query);

        return $result;
    }

    // delete un Register por su ID
    public function delete()
    {
        $query = 'DELETE FROM ' . static::$table . ' WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $result = self::$db->query($query);

        return $result;
    }
}
