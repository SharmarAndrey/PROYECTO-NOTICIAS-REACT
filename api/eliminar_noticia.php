<?php

require_once "functions.php";
require "conexion.php";
require_once 'authToken.php';

try {
    $id = intval($_POST['id']);
    if (!esTuya($id)) {
        http_response_code(403); // Cambiado a 403 Forbidden
        $errorGenerl = "No puedes realizar esta acción";
        header('location: noticia.php?id=' . $id . '&error=true');
        exit;
    }
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
    if (isset($_GET['foto']) && !empty($_GET['foto'])) {
        unlink($_GET['foto']);
    }
   // header('location: index.php');
} catch (Exception $e) {
    http_response_code(500);
    //header('location: noticia.php?id=' . $id . '&error=true');
}
