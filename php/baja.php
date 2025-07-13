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


//=======================================================  Mostrar Productos =================================================================

require "../config/db.php";

// Obtener productos con categoría
$sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, p.img, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias_ropa c ON p.categoria_id = c.id
        WHERE p.estado = 'inactivo'
        ORDER BY p.id DESC";
$stmt = $conexion->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Obtener tallas asociadas por producto
$tallasPorProducto = [];

$sqlTallas = "SELECT pt.producto_id, tr.talla
              FROM producto_talla pt
              LEFT JOIN tallas_ropa tr ON pt.talla_id = tr.id
              WHERE pt.talla_id IS NOT NULL";

$stmtTallas = $conexion->query($sqlTallas);
while ($row = $stmtTallas->fetch(PDO::FETCH_ASSOC)) {
    $tallasPorProducto[$row['producto_id']][] = $row['talla'];
}

// Agregar tallas personalizadas (si existen)
$sqlPersonalizadas = "SELECT producto_id, talla_personalizada
                      FROM producto_talla
                      WHERE talla_personalizada IS NOT NULL";

$stmtCustom = $conexion->query($sqlPersonalizadas);
while ($row = $stmtCustom->fetch(PDO::FETCH_ASSOC)) {
    $tallasPorProducto[$row['producto_id']][] = $row['talla_personalizada'];
}
//=======================================================  Obtener imagen del usuario  =================================================================


