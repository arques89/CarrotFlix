<?php

namespace Controllers;

use Model\User;
use MVC\Router;

class ProfileController
{
    public static function profile(Router $router)
    {
        session_start();
        if (!$_SESSION['id']) {
            header('Location: /');
        }

        $userId = $_SESSION['id'];
        $user = User::where('id', $userId);

        $router->render('profile/index', [
            'title' => 'Perfil de usuario',
            'user' => $user
        ]);
    }

    public static function procesaCSV(Router $router)
    {
        // Lógica para procesar el archivo CSV y cargar los datos en la base de datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
                $csvFile = $_FILES['csvFile']['tmp_name'];

                // Aquí puedes agregar el código para procesar el archivo CSV y cargar los datos en la base de datos
                // Por ejemplo, puedes utilizar fgetcsv() para leer el archivo CSV y trabajar con los datos

                // Ejemplo básico:
                $file = fopen($csvFile, 'r');
                while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
                    // Procesar cada línea del archivo CSV
                    // Aquí puedes agregar el código para insertar los datos en la base de datos
                    // $data contiene los valores de cada columna en la línea actual
                }
                fclose($file);

                echo "Archivo CSV cargado y procesado correctamente.";
            } else {
                echo "Error al cargar el archivo CSV.";
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
