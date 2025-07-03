<?php
require '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = intval($_POST['producto_id']);

    $stmt = $conexion->prepare("UPDATE productos SET estado = 'inactivo' WHERE id = :id");
    $stmt->execute([':id' => $producto_id]);

    header("Location: ../views/index.php?success=baja");
    exit;
}
?>
