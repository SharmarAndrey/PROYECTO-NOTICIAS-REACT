<?php

require_once "functions.php";
require_once __DIR__ . '/../vendor/autoload.php';
require_once "conexion.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$errorGeneral = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['password']) && isset($_POST['email'])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            http_response_code(404);
            $errorGeneral = "No esxiste el usuario";
        } else {

            if (!password_verify($pass, $user['password'])) {
                http_response_code(401);
                $errorGeneral = "Credenciales incorrectas, inténtelo de nuevo " . password_hash($pass, PASSWORD_DEFAULT) . ' - ' . $user['password'];
            } else {
                // Echo del Token JWT
                $payload = [
                    'user_id' => $user['id'],
                    'exp' => time() + (60 * 60 * 24)  // 1 día
                ];
                $token = JWT::encode($payload, $hashPropio, 'HS256');
                echo json_encode(['token' => $token, 'user' => ['id' => $user['id'], 'nombre' => $user['nombre']]]);
            }
        }
    } else {
        http_response_code(400);
        echo "Faltan parámetros obligatorios";
    }
}else{
    http_response_code(405);
        echo "Método no permitido";
}
