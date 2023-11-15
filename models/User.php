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
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPassword2() {
        return $this->password2;
    }

    public function getConfirmed() {
        return $this->confirmed;
    }

    public function getToken() {
        return $this->token;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

     /** SETTERS **/
    public function setConfirmed($confirmed) {
        $this->confirmed = $confirmed;
    }

    public function setToken($token) {
        $this->token = $token;
    }


    // validate el Login de Usuarios
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

    // Validación para cuentas nuevas
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

    // Valida un email
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

    // Valida el Password
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

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function createToken(): void
    {
        $this->token = uniqid();
    }
}
