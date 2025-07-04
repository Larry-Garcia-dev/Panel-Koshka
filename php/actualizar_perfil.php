<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$nuevoNombre = trim($_POST['nuevoNombre']);

// Guardar nueva imagen si se cargó
if (isset($_FILES['nuevaImagen']) && $_FILES['nuevaImagen']['error'] === 0) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES["nuevaImagen"]["name"]);
    $rutaDestino = "../images/perfil/" . $nombreArchivo;

    if (move_uploaded_file($_FILES["nuevaImagen"]["tmp_name"], $rutaDestino)) {
        // Actualizar nombre y foto
        $sql = "UPDATE user SET NombreCompleto = ?, img = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nuevoNombre, $nombreArchivo, $userId]);
    }
} else {
    // Solo actualizar nombre
    $sql = "UPDATE user SET NombreCompleto = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nuevoNombre, $userId]);
}

// Actualizar nombre en la sesión
$_SESSION['user_name'] = $nuevoNombre;

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
