<?php
require_once 'lib/JWT.php';
require_once 'lib/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarToken()
{
    $hashPropio = 'gjsadhfhsbjf&183kdsjfghmgnfdnqhwlqhwqpwqoopiwyrwqjmwqkjmmjqlwmje'; // Cambia esto por tu propia clave secreta

    $headers = getallheaders();
    $authorization = $headers['Authorization'] ?? $headers['authorization'] ?? null;

    if (!$authorization) {
        echo "Token no proporcionado";
        return false;
    }

    $token = str_replace('Bearer ', '', $authorization);
    try {
        $decoded = JWT::decode($token, new Key($hashPropio, 'HS256'));
        return $decoded->user_id;
    } catch (Exception $e) {
        echo "Token no válido " . $e->getMessage();
        return false;
    }
}
$userID = verificarToken();
if (!$userID) {
    http_response_code(401);
    echo json_encode(['error' => 'Token no válido']);
    exit;
}
