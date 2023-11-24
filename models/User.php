<?php

namespace Model;

class User extends ActiveRecord
{
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'surname', 'email', 'password', 'confirmed', 'token', 'isAdmin'];

    protected $id;
    protected $name;
    protected $surname;
    protected $email;
    protected $password;
    protected $password2;
    protected $confirmed;
    protected $token;
    protected $isAdmin;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->isAdmin = $args['isAdmin'] ?? 0;
    }

    /** GETTERS **/
    /**
     * Gets the id of user object.
     *
     * @return int Returns the id of user object.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the name of user object.
     *
     * @return string Returns the name of user object.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the surname of user object.
     *
     * @return string Returns the surname of user object.
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Gets the email of user object.
     *
     * @return string Returns the email of user object.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the password of user object.
     *
     * @return string Returns the password of user object.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the re typed password of user object.
     *
     * @return string Returns the re typed password of user object.
     */
    public function getPassword2()
    {
        return $this->password2;
    }

    /**
     * Gets the state of confirmed of user object.
     *
     * @return int Returns the state of confirmed of user object.
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Gets the token of user object.
     *
     * @return string Returns the token of user object.
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Gets the state is isAdmin of user object.
     *
     * @return int Returns the state is isAdmin of user object.
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /** SETTERS **/
    /**
     * Sets the confirmation status of user object.
     *
     * This method sets the confirmation status of the user object to 1, indicating confirmation.
     */
    public function setConfirmed(): void
    {
        $this->confirmed = 1;
    }

    /**
     * Sets the token of user object.
     *
     * This method generates a token of length 16 using random bytes and assigns it to the token property.
     */
    public function setToken(): void
    {
        $length = 16;
        $token = bin2hex(random_bytes($length));
        $this->token = $token;
    }

    /**
     * Clear the token of user object.
     */
    public function clearToken(): void
    {
        $this->token = null;
    }

    /**
     * Method responsible for login validation.
     *
     * @return array Returns an array of alerts if something went wrong with the validation.
     */
    public function validateLogin(): array
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'El email del usuario es obligatorio.';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'El email introducido no es válido.';
        }
        $this->validatePassword();

        return self::$alerts;
    }

    /**
     * Validates specific fields for emptiness.
     *
     * @param array $fields An associative array where keys are field names and values are error messages.
     */
    public function validateAccountFields(array $fields): void
    {
        foreach ($fields as $field => $errorMessage) {
            if (empty($this->$field)) {
                self::$alerts['error'][] = $errorMessage;
            }
        }
    }

    /**
     * Method responsible for new accounts creation validation.
     *
     * @return array Returns an array of alerts if something went wrong with the validation.
     */
    public function validateAccount(): array
    {
        $fieldsToValidate = [
            'name' => 'El campo nombre es obligatorio.',
            'surname' => 'El campo apellido es obligatorio.',
            'email' => 'El campo email es obligatorio.'
        ];

        $this->validateAccountFields($fieldsToValidate);
        $this->validatePassword();

        return self::$alerts;
    }

    /**
     * Method responsible for email validation.
     *
     * @return array Returns an array of alerts if something went wrong with the validation.
     */
    public function validateEmail(): array
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'El campo email es obligatorio.';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'El email introducido no es válido.';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for password validation.
     *
     * @return array Returns an array of alerts if something went wrong with the validation.
     */
    public function validatePassword(): array
    {
        if (!$this->password) {
            self::$alerts['error'][] = 'El campo contraseña no puede ir vacío.';
        } elseif (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña ha de contener al menos 6 caracteres.';
        } elseif ($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas introducidas son diferentes.';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for hashing password for user object.
     *
     * @return void Set a hashed password for user object.
     */
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    /**
     * Validates the authenticity of a password.
     *
     * @return bool Returns true if the password is valid; otherwise, returns false.
     */
    public function checkPassword(): bool
    {
        return password_verify($this->current_password, $this->password);
    }
}
