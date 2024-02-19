<?php

namespace Model;

class Movie extends ActiveRecord
{
    protected static $table = 'catalogue';
    protected static $columnsDB = ['id', 'title', 'director', 'year', 'genre', 'synopsis', 'rating', 'cast', 'language', 'image_url', 'trailer'];

    protected $id;
    protected $title;
    protected $director;
    protected $year;
    protected $genre;
    protected $synopsis;
    protected $rating;
    protected $cast;
    protected $language;
    protected $image_url;
    protected $trailer;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->director = $args['director'] ?? '';
        $this->year = $args['year'] ?? '';
        $this->genre = $args['genre'] ?? '';
        $this->synopsis = $args['synopsis'] ?? '';
        $this->rating = $args['rating'] ?? '';
        $this->cast = $args['cast'] ?? '';
        $this->language = $args['language'] ?? '';
        $this->image_url = $args['image_url'] ?? '';
        $this->trailer = $args['trailer'] ?? '';
    }

    /**
     * Obtiene el ID de la película.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Establece el título de la película.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Obtiene el título de la película.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Obtiene el director de la película.
     *
     * @return string
     */
    public function getDirector(): string
    {
        return $this->director;
    }

    /**
     * Establece el director de la película.
     *
     * @param string $director
     */
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    /**
     * Obtiene el año de la película.
     *
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * Establece el año de la película.
     *
     * @param string $year
     */
    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    /**
     * Obtiene el género de la película.
     *
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }

    /**
     * Establece el género de la película.
     *
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * Obtiene la sinopsis de la película.
     *
     * @return string
     */
    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    /**
     * Establece la sinopsis de la película.
     *
     * @param string $synopsis
     */
    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    /**
     * Obtiene la calificación de la película.
     *
     * @return string
     */
    public function getRating(): string
    {
        return $this->rating;
    }

    /**
     * Establece la calificación de la película.
     *
     * @param string $rating
     */
    public function setRating(string $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * Obtiene el elenco de la película.
     *
     * @return string
     */
    public function getCast(): string
    {
        return $this->cast;
    }

    /**
     * Establece el elenco de la película.
     *
     * @param string $cast
     */
    public function setCast(string $cast): void
    {
        $this->cast = $cast;
    }

    /**
     * Obtiene el idioma de la película.
     *
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Establece el idioma de la película.
     *
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * Obtiene la URL de la imagen de la película.
     *
     * @return string
     */
    public function getImageURL(): string
    {
        return $this->image_url;
    }

    /**
     * Establece la URL de la imagen de la película.
     *
     * @param string $image
     */
    public function setImageURL(string $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * Obtiene la URL del trailer de la película.
     *
     * @return string
     */
    public function getTrailer(): string
    {
        return $this->trailer;
    }

    /**
     * Establece la URL del trailer de la película.
     *
     * @param string $image
     */
    public function setTrailer(string $trailer): void
    {
        $this->trailer = $trailer;
    }

    public function create(): array
    {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        debug($attributes);
        die;
        // Excluye el campo 'id' de la inserción (ya que es autoincremental)
        unset($attributes['id']);

        // Inserta en la base de datos
        $query = 'INSERT INTO ' . static::$table . ' ( ';
        $query .= join(', ', array_keys($attributes));
        $query .= ' ) VALUES (';
        $query .= join(', ', array_map(function ($value) {
            return "'$value'";
        }, array_values($attributes)));
        $query .= ')';

        // Realiza la consulta y obtiene el ID insertado
        $result = self::$db->query($query);

        return [
            'result' => $result,
            'id' => self::$db->insert_id
        ];
    }



    public function update(): bool
    {
        // Realizar lógica específica de la actualización de películas antes de llamar a la función update de ActiveRecord
        // Puedes llamar a parent::update() para ejecutar la lógica de actualización genérica

        $result = parent::update(); // Esto ejecutará la lógica de actualización genérica
        // Puedes realizar más acciones después de la actualización, si es necesario

        return $result;
    }

    public function validate(): bool
    {
        // Realizar validaciones necesarias
        // Devolver true si los datos son válidos, false de lo contrario
        return true;
    }
}
