<?php

namespace Model;

class ActiveRecord
{
    protected $id;
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];
    protected static $alerts = [];

    /**
     * Sets the database connection.
     *
     * @param object $database The database connection object.
     */
    public static function setDB($database)
    {
        self::$db = $database;
    }

    /**
     * Sets an alert message.
     *
     * @param string $type    The type of the alert.
     * @param string $message The message content.
     */
    public static function setAlert($type, $message)
    {
        static::$alerts[$type][] = $message;
    }

    /**
     * Retrieves all alerts.
     *
     * @return array Returns an array of alerts.
     */
    public static function getAlerts()
    {
        return static::$alerts;
    }

    /**
     * Clears validation alerts.
     *
     * @return array Returns an empty array for alerts.
     */
    public function validate()
    {
        static::$alerts = [];

        return static::$alerts;
    }

    /**
     * Executes an SQL query to fetch data into memory objects.
     *
     * @param string $query The SQL query to execute.
     * @return array Returns an array of memory objects created from the query results.
     */
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

    /**
     * Creates a memory object similar to the database object.
     *
     * @param array $register The database record to convert into a memory object.
     * @return object Returns a memory object.
     */
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

    /**
     * Identifies and retrieves database attributes.
     *
     * @return array Returns an array of database attributes.
     */
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

    /**
     * Sanitizes data before saving it into the database.
     *
     * @return array Returns sanitized attributes.
     */
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

    /**
     * Synchronizes the database with memory objects.
     *
     * @param array $args An array of arguments.
     */
    public function synchronizeDB($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Saves the record in the database.
     *
     * @return mixed Returns the result of the save operation.
     */
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

    /**
     * Retrieves all records from the database table.
     *
     * @return array Returns an array of all records from the table.
     */
    public static function all()
    {
        $query = 'SELECT * FROM ' . static::$table;
        $result = self::consultSQL($query);

        return $result;
    }

    /**
     * Finds a record by its ID.
     *
     * @param int $id The ID of the record to find.
     * @return mixed|null Returns the record with the specified ID or null if not found.
     */
    public static function find($id)
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE id = {$id}";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    /**
     * Executes an SQL query based on a specific column equality criterion.
     *
     * @param string $column The name of the column in the table.
     * @param mixed $value The value being sought in the specified column.
     * @return mixed|null Returns the first result of the query or null if no result is found.
     */
    public static function where($column, $value)
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE {$column} = '{$value}'";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    /**
     * Executes a raw SQL query. Use when model methods are insufficient.
     *
     * @param string $query The SQL query to be executed.
     * @return mixed The result of the SQL query.
     */
    public static function SQL($query)
    {
        $result = self::consultSQL($query);

        return $result;
    }

    /**
     * Retrieves records with a specific limit.
     *
     * @param int $limit The number of records to retrieve.
     * @return mixed|null Returns the first set of records based on the specified limit or null if no records are found.
     */
    public static function get($limit)
    {
        $query = 'SELECT * FROM ' . static::$table . " LIMIT {$limit}";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    /**
     * Creates a new record.
     *
     * @return array Returns an array with the result of the query and the ID of the newly created record.
     */
    public function create()
    {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Insert into the database
        $query = ' INSERT INTO ' . static::$table . ' ( ';
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        /* return json_encode(['query' => $query]); */

        // Query result
        $result = self::$db->query($query);

        return [
            'result' => $result,
            'id' => self::$db->insert_id
        ];
    }

    /**
     * Updates the record.
     *
     * @return bool Returns true if the update operation was successful, otherwise false.
     */
    public function update()
    {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Iterate to add each database field
        $values = [];
        foreach ($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // SQL query
        $query = 'UPDATE ' . static::$table . ' SET ';
        $query .= join(', ', $values);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= ' LIMIT 1 ';

        // Update the database
        $result = self::$db->query($query);

        return $result;
    }

    /**
     * Deletes a record by its ID.
     *
     * @return bool Returns true if the deletion operation was successful, otherwise false.
     */
    public function delete()
    {
        $query = 'DELETE FROM ' . static::$table . ' WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $result = self::$db->query($query);

        return $result;
    }
}
