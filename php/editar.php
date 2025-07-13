<?php
session_start();
require "../config/db.php";

// Validar login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}
$userName = $_SESSION['user_name'];

// ========= GUARDAR CAMBIOS =========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'];
    $nombre = $_POST['productName'];
    $descripcion = $_POST['productDescription'];
    $precio = floatval($_POST['productPrice']);
    $stock = intval($_POST['productStock']);
    $categoria = intval($_POST['productCategory']);
    $tallas = $_POST['tallas'] ?? [];
    $tallaPersonalizada = trim($_POST['talla_personalizada'] ?? '');

    $imgRuta = null;
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['productImage']['tmp_name'];
        $nombreArchivo = uniqid('prod_') . '.' . pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION);
        $destino = "../images/productos/" . $nombreArchivo;
        if (move_uploaded_file($tmpName, $destino)) {
            $imgRuta = $destino;
        }
    }

    $query = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?";
    $params = [$nombre, $descripcion, $precio, $stock, $categoria];
    if ($imgRuta) {
        $query .= ", img=?";
        $params[] = $imgRuta;
    }
    $query .= " WHERE id=?";
    $params[] = $id;

    $stmt = $conexion->prepare($query);
    $stmt->execute($params);

    // Tallas
    $conexion->prepare("DELETE FROM producto_talla WHERE producto_id = ?")->execute([$id]);
    foreach ($tallas as $tallaId) {
        $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_id) VALUES (?, ?)")->execute([$id, $tallaId]);
    }
    if ($tallaPersonalizada) {
        $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_personalizada) VALUES (?, ?)")->execute([$id, $tallaPersonalizada]);
    }

    header("Location: ../views/index.php");
    exit();
}

// ========= CARGAR DATOS PARA EDITAR =========
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Producto
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }

    // Categorías
    $categorias = $conexion->query("SELECT * FROM categorias_ropa")->fetchAll(PDO::FETCH_ASSOC);

    // Tallas disponibles
    $tallasDisponibles = $conexion->query("SELECT * FROM tallas_ropa ORDER BY talla ASC")->fetchAll(PDO::FETCH_ASSOC);

    // Tallas del producto
    $stmt = $conexion->prepare("SELECT talla_id FROM producto_talla WHERE producto_id = ? AND talla_id IS NOT NULL");
    $stmt->execute([$id]);
    $tallas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Talla personalizada
    $stmt = $conexion->prepare("SELECT talla_personalizada FROM producto_talla WHERE producto_id = ? AND talla_personalizada IS NOT NULL LIMIT 1");
    $stmt->execute([$id]);
    $tallaPersonalizada = $stmt->fetchColumn();
}
?>
