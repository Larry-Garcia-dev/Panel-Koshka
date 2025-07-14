<?php
// /php/obtener_colores.php

header('Content-Type: application/json');
require "../config/db.php";

try {
    // CAMBIO: Ahora seleccionamos tanto el ID como el código hexadecimal
    $stmt = $conexion->prepare("SELECT id, codigo_hex FROM colores WHERE codigo_hex IS NOT NULL AND codigo_hex != ''");
    $stmt->execute();
    
    // CAMBIO: Obtenemos un array de objetos (cada uno con id y codigo_hex)
    $colores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($colores);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo obtener los colores: ' . $e->getMessage()]);
}