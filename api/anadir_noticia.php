<?php
require_once "authToken.php";
require_once "functions.php";
require_once "conexion.php";

define('uploads_dir', './uploads');
$errorGenerl = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES["foto"])) {
        $foto = $_FILES["foto"];
        $rutaTemporal = $foto['tmp_name'];
        $foto = uploads_dir . "/" . uniqid() . "-" . basename($foto['name']);
        if (!is_dir(uploads_dir)) mkdir(uploads_dir); // Creamos el directorio si no existe

        if (!move_uploaded_file($rutaTemporal, $foto)) {
            echo "Hubo algún error al subir la imagen";
            $errorGenerl = true;
        }
    }
    if (!isset($_POST["titulo"]) || empty($_POST["titulo"])) {

        http_response_code(400); // Faltan parámetros.
        echo "Tienes que introducir un nombre";
        $errorGenerl = true;
    } else {
        /*  if (!preg_match("/^[a-zA-Z-' ]*$/", $titulo)) {
            $nombreErr = "Introduce solo letras mayúsculas o minúsculas";
        }*/
        $titulo = test_input($_POST["titulo"]);
    }
    

    if (!isset($_POST["categoria"]) || empty($_POST["categoria"])) {
        echo "Tienes que introducir una categoria";
        $errorGenerl = true;
    } else {
        /*    if (!filter_var($categoria, FILTER_VALIDATE_URL)) {
            $categoriaErr = "Tienes que introducir una categoria válido";
        }*/
        $categoria = test_input($_POST["categoria"]);
        if (!isset($_FILES["foto"])) {
            $foto = 'uploads/' . $categoria . '.jpg';
        }
    }
    if (!isset($_POST["descripcion"]) || empty($_POST["descripcion"])) {
        echo "Tienes que introducir algún texto";
        $errorGenerl = true;
    } else {

        $descripcion = test_input($_POST["descripcion"]);
    }

    if (!$errorGenerl) {
        try {

            $stmt = $pdo->prepare(
                "INSERT INTO noticias (titulo, descripcion, categoria, user_id, foto) 
        VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$titulo, $descripcion, $categoria, $userID, $foto]);
            // Variable declarada al principio como ""
            $idNoticia = $pdo->lastInsertId();

            $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
            $stmt->execute([$idNoticia]);
            $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($noticia);

        } catch (Exception $e) {
            // Variable declarada al principio como ""
            echo "No se ha podido ingresar la noticia en la BBDD " . $e;
        }
    } else {
        http_response_code(409); // Faltan parámetros.
        echo "Faltan parámetros obligatorios";
    }
}else{
    http_response_code(405); // Método no permitido.
    echo "Método no permitido";
    
}
exit;
