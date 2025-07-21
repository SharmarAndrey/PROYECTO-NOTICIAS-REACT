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
            if ($stmt->rowCount() == 0) {
                http_response_code(409);
                $errorGeneral = "El usuario ya existe";
            }else{
                http_response_code(200); // Created
                exit;
            }
        }catch(Exception $e){
            http_response_code(409);
            $errorGeneral = "El usuario ya existe";
        }
    }else{
        http_response_code(400);
        $errorGeneral = "Faltan parámetros obligatorios";
    }
} else{
        http_response_code(405); // Método no soportado
        $errorGeneral = "Método no soportado";
}
echo json_encode(["message" => $errorGeneral]);
exit;

