<?php

$host = 'localhost';
$dbname = 'magnificapec_koshka';
$username = 'magnificapec_laxky';
$password = '(a+YMbLMKbUW';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>