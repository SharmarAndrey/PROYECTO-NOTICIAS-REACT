<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function esTuya($noticia)
{
    global $pdo;
    global $userID;
    $stmt = $pdo->prepare("SELECT user_id FROM noticias WHERE id = ? AND user_id = ?");

    $stmt->execute([$noticia, $userID]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($noticia) {
        return true;
    }
    return false;
}
