<?php

require_once "functions.php";
require_once "conexion.php";
$errorGeneral = "";
if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['password']) && isset($_POST['email']) && isset($_POST['repeatpassword']) && isset($_POST['nombre'])){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $repeatpass = $_POST['repeatpassword'];
        if ($pass != $repeatpass) {
            http_response_code(409); // Conflict
            $errorGeneral = "Los password no coinciden";
        }
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $nombre = $_POST['nombre'];
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $pass]);
            echo "Usuario insertado con éxito";
        }catch(Exception $e){
            http_response_code(500);
            echo "Hubo algún problema al insertar el usuario: " . $e;
        }
    }else{
        http_response_code(400);
        echo "Faltan parámetros obligatorios";
    }
} else{
        http_response_code(405); // Método no soportado
        echo "Método no soportado";
}
exit;

