<?php
session_start();
require "../config/db.php";

// Validar login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}
$userName = $_SESSION['user_name'];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion'] ?? '');

    if (!empty($nombre)) {
        $stmt = $conexion->prepare("INSERT INTO categorias_ropa (nombre, descripcion) VALUES (?, ?)");
        $stmt->execute([$nombre, $descripcion]);

        header("Location: ../views/index.php?success=1");
        exit();
    } else {
        die("El nombre de la categoría es obligatorio.");
    }
}
