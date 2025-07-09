<?php

require_once 'authToken.php'; // Middleware para verificar el token de autenticación
require_once "functions.php";
require "conexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST["id"]) || empty($_POST["id"])) {
        http_response_code(400); // Faltan parámetros.
        $errorGenerl = "No hay ID";
        exit;
    }
    try {
        $id = intval($_POST['id']);
        if (!esTuya($id)) {
            http_response_code(403); // Cambiado a 403 Forbidden
            $errorGenerl = "No puedes realizar esta acción";
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
        $stmt->execute([$id]);
        
        if (isset($_GET['foto']) && !empty($_GET['foto'])) {
            if (!unlink($_GET['foto'])){
                http_response_code(500); // Error al eliminar el archivo
                $errorGenerl = "Error al eliminar la foto";
                exit;
            }
        }
        http_response_code(204);// No Content
        // header('location: index.php');
    } catch (Exception $e) {
        http_response_code(500);
        //header('location: noticia.php?id=' . $id . '&error=true');
    }
} else {
    http_response_code(405); // Método no permitido
    echo "Método no permitido";
}
exit;
