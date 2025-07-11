<?php

require_once "authToken.php";
require_once "functions.php";
require_once "conexion.php";
define('uploads_dir', 'uploads');
$errorGenerl = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST["id"]) || empty($_POST["id"])) {

       $errorGenerl = "No hay ID";
        
    } else {
        /*  if (!preg_match("/^[a-zA-Z-' ]*$/", $titulo)) {
            $nombreErr = "Introduce solo letras mayúsculas o minúsculas";
        } */
        $id = test_input($_POST["id"]);
        if (!esTuya($id)) {
            http_response_code(405);
            echo "No puedes realizar esta acción";
            exit;
        }
    }
    if (!isset($_POST["titulo"]) || empty($_POST["titulo"])) {

        $errorGenerl = "Título ausente";
    } else {
        /*  if (!preg_match("/^[a-zA-Z-' ]*$/", $titulo)) {
            $nombreErr = "Introduce solo letras mayúsculas o minúsculas";
        }*/
        $titulo = test_input($_POST["titulo"]);
    }
    
    if (!isset($_POST["categoria"]) || empty($_POST["categoria"])) {
    
        $errorGenerl = "Categoría";
    } else {
        /*    if (!filter_var($categoria, FILTER_VALIDATE_URL)) {
            $categoriaErr = "Tienes que introducir una categoria válido";
        }*/
        $categoria = test_input($_POST["categoria"]);
    }
    if (!isset($_POST["descripcion"]) || empty($_POST["descripcion"])) {
   
        $errorGenerl = "error en la descripción";
    } else {
        /*   if (!filter_var($enlace, FILTER_VALIDATE_URL)) {
            $descripcionErr = "Tienes que introducir un descripcion válido";
        }*/
        $descripcion = test_input($_POST["descripcion"]);
    }
     if (!isset($_POST["fotoAntigua"]) || empty($_POST["fotoAntigua"])) {
   
        $errorGenerl = "error en la descripción";
    } else {
        /*   if (!filter_var($enlace, FILTER_VALIDATE_URL)) {
            $descripcionErr = "Tienes que introducir un descripcion válido";
        }*/
         $foto = $_POST["fotoAntigua"];
    }
   
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        $foto = $_FILES["foto"];
        $rutaTemporal = $foto['tmp_name'];
        $foto = uploads_dir . "/" . uniqid() . "-" . basename($foto['name']);
        if (!is_dir(uploads_dir)) mkdir(uploads_dir); // Creamos el directorio si no existe
        
        if (!move_uploaded_file($rutaTemporal, $foto)){
            
            $errorGenerl = "Hubo algún error al subir la imagen";
        }
        // Si el nombre no es una categoría, la eliminaríamos
        // hacer select de las categorías
        // unlink($_POST["fotoAntigua"]);
    }
    if (!$errorGenerl) {
        try {
            $query = "UPDATE noticias SET titulo = ?, descripcion = ?, categoria = ?, user_id = ?, foto = ?
                        WHERE 
                        id = ?
                     ";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$titulo, $descripcion, $categoria, $userID, $foto, $id]);
            // Variable declarada al principio como "
            echo json_encode([$titulo, $descripcion, $categoria, $userID, $foto, $id]);
        } catch (Exception $e) {
            // Variable declarada al principio como ""
            http_response_code(500);
            $errorGenerl = $e;
            exit;
        }
    }else{
        http_response_code(400);
        echo $errorGenerl;
        exit;
    }
} else{
    http_response_code(405);
    $errorGenerl = "No puedes realizar esta acción";
}
exit;
