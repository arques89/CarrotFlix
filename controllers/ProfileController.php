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

                $file = fopen($csvFile, 'r');
                while (($data = fgetcsv($file, 1000, ';')) !== FALSE) {

                    $movie = new Movie([
                        'title' => $data[0],
                        'director' => $data[1],
                        'year' => $data[2],
                        'genre' => $data[3],
                        'synopsis' => $data[4],
                        'rating' => $data[5],
                        'cast' => $data[6],
                        'language' => $data[7],
                        'image_url' => $data[8],
                        'trailer' => $data[9],
                    ]);

                    $result = $movie->save();
                }
                fclose($file);

                if ($result['result']) {
                    $response = [
                        'success' => true,
                        'message' => 'Registros insertados correctamente.',
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Error al insertar la película. Datos no válidos.',
                    ];
                }

                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            } else {
                echo "Error al cargar el archivo CSV.";
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}
