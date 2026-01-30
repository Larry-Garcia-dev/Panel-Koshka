<?php
//Usuario de produccion
// $host = 'localhost';
// $dbname = 'magnificapec_koshka';
// $username = 'magnificapec_laxky';
// $password = '(a+YMbLMKbUW';

//Usuario de desarrollo
$host = 'localhost';
$dbname = 'koshka';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>