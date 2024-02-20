<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ('GET' === $method) {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }

    public function render($view, $datos = [])
    {

        foreach ($datos as $key => $value) {
            // Sobre $ significa variable de variable
            $$key = $value;
        }

        ob_start(); // Iniciar almacenamiento en memoria de la vista

        include __DIR__ . "/views/$view.php"; // Limpia el buffer
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
}
