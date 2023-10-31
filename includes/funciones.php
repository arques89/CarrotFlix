<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}

// Función que revisa si el usuario está autenticado
function isAuth(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['name']) && !empty($_SESSION);
}

function isAdmin(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}
