<?php 
require_once 'lib/JWT.php';
require_once 'lib/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarToken() {
    $hashPropio = 'gjsadhfhsbjf&183kdsjfghmgnfdnqhwlqhwqpwqoopiwyrwqjmwqkjmmjqlwmje'; // Cambia esto por tu propia clave secreta

    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        return false;
    }
    
    $token = explode(' ', $headers['Authorization'])[1] ?? '';
    
    try {
        $decoded = JWT::decode($token, new Key($hashPropio, 'HS256'));
        return $decoded->user_id;
    } catch (Exception $e) {
        return false;
    }
}
$userID = verificarToken();
if (!$userID){
    http_response_code(401);
    echo json_encode(['error' => 'Token no válido']);
    exit;
}