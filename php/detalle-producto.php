<?php

//======================================================  Nombre de User =================================================================

session_start();

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}

$userName = $_SESSION['user_name'];


//=======================================================  Fin de nombre de User =================================================================
require '../config/db.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = intval($_GET['id']);

// Obtener datos del producto
$sql = "SELECT p.*, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias_ropa c ON p.categoria_id = c.id
        WHERE p.id = :id AND p.estado = 'activo'";
$stmt = $conexion->prepare($sql);
$stmt->execute(['id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "Producto no encontrado o dado de baja.";
    exit();
}

// Obtener tallas asociadas
$sqlTallas = "SELECT tr.talla
              FROM producto_talla pt
              JOIN tallas_ropa tr ON pt.talla_id = tr.id
              WHERE pt.producto_id = :id";
$stmtTallas = $conexion->prepare($sqlTallas);
$stmtTallas->execute(['id' => $id]);
$tallas = $stmtTallas->fetchAll(PDO::FETCH_COLUMN);
