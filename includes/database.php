<?php

/* $db = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_BD']
); */

$db = mysqli_connect(
    'localhost',
    'root',
    '',
    'carrot_flix'
);

/* debuguear($_ENV); */
$db->set_charset("utf8"); // Seteamos a utf8 la conexión con la db(Problema de eroku al listar servicios)

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
