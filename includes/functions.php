<?php

/**
 * Debugs a variable by displaying its contents and halting the script.
 *
 * @param mixed $variable The variable to debug.
 *
 * @return string Returns the debug output wrapped in HTML preformatted text.
 */
function debug($variable): string
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

/**
 * Escapes/Sanitizes HTML by converting special characters to HTML entities.
 *
 * @param string $html The HTML string to be sanitized.
 *
 * @return string Returns the sanitized HTML string with special characters converted to HTML entities.
 */
function sanitize($html): string
{
    return htmlspecialchars($html);
}


/**
 * Checks if the given strings represent the last element in a sequence.
 *
 * @param string $current The current element in the sequence.
 * @param string $next    The next element in the sequence.
 *
 * @return bool Returns true if the current element is not equal to the next element, otherwise returns false.
 */
function isLast(string $current, string $next): bool
{
    if ($current !== $next) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if the user is authenticated.
 *
 * @return bool Returns true if the user is authenticated (session is set with 'name' key and not empty), otherwise returns false.
 */
function isAuth(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['name']) && !empty($_SESSION['name']);
}

/**
 * Checks if the user is an administrator.
 *
 * @return bool Returns true if the user is an administrator (session is set with 'isAdmin' key and not empty), otherwise returns false.
 */
function isAdmin(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['isAdmin']) && !empty($_SESSION['isAdmin']);
}
