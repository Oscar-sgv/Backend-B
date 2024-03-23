<?php
function conectarDB(): mysqli
{
    //  conectando la base de datos con mysqli__connect
    $db = mysqli_connect('localhost', 'root', 'Mentecolmena', 'bienesraices_crud');

    //  en caso de que no se conecte
    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;

    // verificando conexion de base de datos
    // if ($db) {
    //     echo "se conecto";
    // } else {
    //     echo "no se conecto";
    // }
}
