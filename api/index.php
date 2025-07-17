<?php

require_once "conexion.php";
require_once "functions.php";

$comienzo = 0;
$num = 3;
$where = "";

if (isset($_GET['comienzo'])) $comienzo = $_GET['comienzo'];
if (isset($_GET['categoria'])){
    $categoria = $_GET['categoria'];
    $where = "WHERE categoria = '$categoria'";
} 
// Añadimos la opción de filtrar una noticia concreta por su id
// Devuelve una sola noticia igualmente dentro de un array
// Si por algún motivo se envían ambos parámetros, se prioriza el id
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $where = "WHERE id = '$id'";
}
$stmt = $pdo->query("SELECT noticias.*, usuarios.email, usuarios.nombre FROM noticias JOIN usuarios ON noticias.user_id = usuarios.id $where ORDER BY fecha DESC LIMIT $comienzo, $num");
// "SELECT * FROM noticias WHERE categoria='noticias' ORDER BY fecha DESC LIMIT 0, 3"
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($noticias);
exit;