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
    public static function setDatabaseConnection($database): void
    {
        self::$db = $database;
    }

    /**
     * Sets an alert message.
     *
     * @param string $type    The type of the alert.
     * @param string $message The message content.
     */
    public static function setAlert(string $type, string $message): void
    {
        static::$alerts[$type][] = $message;
    }

    /**
     * Retrieves all alerts.
     *
     * @return array Returns an array of alerts.
     */
    public static function getAlerts(): array
    {
        return static::$alerts;
    }

    /**
     * Executes an SQL query to fetch data into memory objects.
     *
     * @param string $query The SQL query to execute.
     *
     * @return array Returns an array of memory objects created from the query results.
     */
    public static function consultSQL(string $query): array
    {
        // Consult the database
        $result = self::$db->query($query);

        // Iterate over the results
        $array = [];
        while ($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        // Free up memory
        $result->free();

        // Return the results
        return $array;
    }

    /**
     * Creates a memory object similar to the database object.
     *
     * @param array $register The database record to convert into a memory object.
     *
     * @return object Returns a memory object.
     */
    protected static function createObject(array $register): object
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
    public function attributes(): array
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
     * @return array Returns an array containing sanitized attributes.
     */
    public function sanitizeAttributes(): array
    {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach ($attributes as $key => $value) {
            // Escapes the value and assigns an empty string if it's null using the ?? (null coalescing) operator
            $sanitized[$key] = self::$db->escape_string($value ?? '');
        }

        return $sanitized;
    }

    /**
     * Synchronizes the database with memory objects.
     *
     * @param array $args An array of arguments.
     */
    public function synchronizeDB(array $args = []): void
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
    public function save(): mixed
    {
        $result = '';
        if (!is_null($this->id)) {
            // update an existing record
            $result = $this->update();
        } else {
            // Creating a new record
            $result = $this->create();
        }

        return $result;
    }

    /**
     * Retrieves all records from the database table.
     *
     * @return array Returns an array of all records from the table.
     */
    public static function all(): array
    {
        $query = 'SELECT * FROM ' . static::$table;
        $result = self::consultSQL($query);

        return $result;
    }

    /**
     * Finds a record by its ID.
     *
     * @param int $id The ID of the record to find.
     *
     * @return mixed|null Returns the record with the specified ID or null if not found.
     */
    public static function find(int $id): mixed
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE id = {$id}";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    /**
     * Paginate the records
     *
     * @param int $per_page The number of items per page
     * @param int $offset The offset for pagination
     * @return array The paginated records
     */
    public static function paginate($per_page, $offset)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT {$per_page} OFFSET {$offset}";
        $result = self::consultSQL($query);
        return $result;
    }

    /**
     * Get records ordered by a specific column and order
     *
     * @param string $column The column to order by
     * @param string $order The order ('ASC' for ascending, 'DESC' for descending)
     * @return array The ordered records
     */
    public static function getRecordsOrderedBy($column, $order)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY {$column} {$order}";
        $result = self::consultSQL($query);
        return $result;
    }

    /**
     * Get records ordered by a specific column and order with a limit
     *
     * @param string $column The column to order by
     * @param string $order The order ('ASC' for ascending, 'DESC' for descending)
     * @param int $limit The maximum number of records to retrieve
     * @return array The ordered records with the specified limit
     */
    public static function getRecordsOrderedWithLimit($column, $order, $limit)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY {$column} {$order} LIMIT {$limit}";
        $result = self::consultSQL($query);
        return $result;
    }

    /**
     * Search with multiple WHERE options using an associative array
     *
     * @param array $conditions An associative array of conditions (column => value)
     * @return array The results matching the provided conditions
     */
    public static function searchWithConditions(array $conditions = [])
    {
        $query = "SELECT * FROM " . static::$table . " WHERE ";
        foreach ($conditions as $key => $value) {
            if ($key === array_key_last($conditions)) {
                $query .= " {$key} = '{$value}'";
            } else {
                $query .= " {$key} = '{$value}' AND ";
            }
        }
        $result = self::consultSQL($query);
        return $result;
    }

    /**
     * Retrieve the total count of records, optionally filtered by a column value
     *
     * @param string $column (Optional) The column to filter by
     * @param mixed $value (Optional) The value to match in the filtered column
     * @return int The total count of records (filtered, if column and value provided)
     */
    public static function getTotalCount($column = '', $value = '')
    {
        $query = "SELECT COUNT(*) FROM " . static::$table;
        if ($column) {
            $query .= " WHERE {$column} = {$value}";
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return array_shift($total);
    }

    /**
     * Retrieve the total count of records using an array for WHERE conditions
     *
     * @param array $conditions An associative array of conditions (column => value)
     * @return int The total count of records matching the provided conditions
     */
    public static function getTotalCountWithArrayConditions($conditions = [])
    {
        $query = "SELECT COUNT(*) FROM " . static::$table . " WHERE ";
        foreach ($conditions as $key => $value) {
            if ($key === array_key_last($conditions)) {
                $query .= " {$key} = '{$value}' ";
            } else {
                $query .= " {$key} = '{$value}' AND ";
            }
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();
        return array_shift($total);
    }



    /**
     * Executes an SQL query based on a specific column equality criterion.
     *
     * @param string $column The name of the column in the table.
     * @param mixed  $value  The value being sought in the specified column.
     *
     * @return mixed|null Returns the first result of the query or null if no result is found.
     */
    public static function where(string $column, mixed $value): mixed
    {
        $query = 'SELECT * FROM ' . static::$table . " WHERE {$column} = '{$value}'";
        $result = self::consultSQL($query);

        return array_shift($result);
    }

    /**
     * Executes a raw SQL query. Use when model methods are insufficient.
     *
     * @param string $query The SQL query to be executed.
     *
     * @return mixed The result of the SQL query.
     */
    public static function SQL(string $query): mixed
    {
        return self::consultSQL($query);
    }

    /**
     * Retrieves records with a specific limit.
     *
     * @param int $limit The number of records to retrieve.
     *
     * @return mixed|null Returns the first set of records based on the specified limit or null if no records are found.
     */
    public static function get(int $limit): mixed
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
    public function create(): array
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
    public function update(): bool
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

        return (bool) $result;
    }

    /**
     * Deletes a record by its ID.
     *
     * @return bool Returns true if the deletion operation was successful, otherwise false.
     */
    public function delete(): bool
    {
        $query = 'DELETE FROM ' . static::$table . ' WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $result = self::$db->query($query);

        return (bool) $result;
    }
}
