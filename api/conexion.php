<?php

// INI
$host = 'localhost'; 
$database = 'cursoNascor';
$user = 'profeNascor';
$password = 'ablaracurcix'; // 
// Conexión
try {
   $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   die(" Error de conexión: " . $e->getMessage());
}
