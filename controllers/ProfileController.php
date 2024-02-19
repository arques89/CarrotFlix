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
                $header = null; // Agrega esta línea para almacenar el encabezado del CSV
                while (($data = fgetcsv($file, 1000, ';')) !== FALSE) {

                    if ($header === null) {
                        $header = $data; // Almacena el encabezado del CSV
                        continue; // Salta la primera línea que contiene el encabezado
                    }

                    // Excluir el campo 'id' de los datos del CSV
                    $rowData = array_combine($header, $data);
                    unset($rowData['id']);

                    // Procesar cada línea del archivo CSV
                    // Aquí puedes agregar el código para insertar los datos en la base de datos

                    // Crear una nueva instancia de la película con los datos del CSV
                    $newMovie = new Movie($rowData);


                    // Puedes validar y guardar la película en la base de datos según tu lógica
                    // Por ejemplo, podrías hacer $newMovie->save() si tu modelo Movie implementa el método save().
                    // Asegúrate de ajustar esta lógica según la implementación de tu modelo.

                    // Ejemplo de validación y guardado (ajusta según tu lógica):
                    if ($newMovie->validate()) {
                        $newMovie->save(); // Ajusta según tu lógica para guardar en la base de datos
                        echo "Película '" . $data[0] . "' insertada correctamente.<br>";
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
