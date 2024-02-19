<?php

namespace Controllers;

use Model\User;
use MVC\Router;
use Model\Movie;

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

                // Ejemplo básico:
                $file = fopen($csvFile, 'r');
                while (($data = fgetcsv($file, 1000, ';')) !== FALSE) {
                    // Procesar cada línea del archivo CSV
                    // Aquí puedes agregar el código para insertar los datos en la base de datos

                    // Crear una nueva instancia de la película con los datos del CSV
                    $newMovie = new Movie([
                        'title' => $data[1],      // Ajusta los índices según la estructura de tu CSV
                        'director' => $data[2],
                        'year' => $data[3],
                        'genre' => $data[4],
                        'synopsis' => $data[5],
                        'rating' => $data[6],
                        'cast' => $data[7],
                        'language' => $data[8],
                        'image_url' => $data[9],
                    ]);

                    $result = $newMovie->save();

                    if ($result['result']) {

                        session_start();
                        $userId = $_SESSION['id'];
                        $user = User::where('id', $userId);

                        $router->render('profile/index', [
                            'title' => 'Perfil de usuario',
                            'user' => $user,
                            'alerts' => 'Registros insertados correctamente.'
                        ]);
                    } else {
                        echo "Error al insertar la película '" . $data[0] . "'. Datos no válidos.<br>";
                    }
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
