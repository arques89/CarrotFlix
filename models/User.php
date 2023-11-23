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
     * @return int Returns the id of user object.
    */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets the name of user object.
     * @return string Returns the name of user object.
    */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the surname of user object.
     * @return string Returns the surname of user object.
    */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Gets the email of user object.
     * @return string Returns the email of user object.
    */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Gets the password of user object.
     * @return string Returns the password of user object.
    */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Gets the re typed password of user object.
     * @return string Returns the re typed password of user object.
    */
    public function getPassword2() {
        return $this->password2;
    }

    /**
     * Gets the state of confirmed of user object.
     * @return int Returns the state of confirmed of user object.
    */
    public function getConfirmed() {
        return $this->confirmed;
    }

    /**
     * Gets the token of user object.
     * @return string Returns the token of user object.
    */
    public function getToken() {
        return $this->token;
    }

    /**
     * Gets the state is isAdmin of user object.
     * @return int Returns the state is isAdmin of user object.
    */
    public function getIsAdmin() {
        return $this->isAdmin;
    }

    /** SETTERS **/
    /**
     * Sets the confirmation status of user object.
     * @return void
    */
    public function setConfirmed() {
        $this->confirmed = 1;
    }

    /**
     * Sets the token of user object.
     * @return void
    */
    public function setToken(): void
    {
        $this->token = uniqid();
    }

    /**
     * Clear the token of user object.
     * @return void
    */
    public function clearToken() {
        $this->token = null;
    }

    /**
     * Method responsible for login validation.
     * @return string Returns an alert if something went wrong with the validation.
    */
    public function validateLogin()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no válido';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'El Password no puede ir vacio';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for new accounts creation validation.
     * @return string Returns an alert if something went wrong with the validation.
    */
    public function validateAccount()
    {
        if (!$this->name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->surname) {
            self::$alerts['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alerts['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'El password no puede ir vacío';
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Los password son diferentes';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for email validation.
     * @return string Returns an alert if something went wrong with the validation.
    */
    public function validateEmail()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'El Email es obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Email no válido';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for password validation.
     * @return string Returns an alert if something went wrong with the validation.
    */
    public function validatePassword()
    {
        if (!$this->password) {
            self::$alerts['error'][] = 'El Password no puede ir vacio';
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alerts;
    }

    /**
     * Method responsible for hashing password for user object.
     * @return void Set a hashed password for user object.
    */
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    

    /*  public function newPassword(): array
    {
        if (!$this->current_password) {
            self::$alerts['error'][] = 'El Password Actual no puede ir vacio';
        }
        if (!$this->password_nuevo) {
            self::$alerts['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if (strlen($this->password_nuevo) < 6) {
            self::$alerts['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alerts;
    } */

    // Comprobar el password
    /*     public function checkPassword(): bool
    {
        return password_verify($this->current_password, $this->password);
    } */

}
