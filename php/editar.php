<?php
// /php/editar.php

session_start();
require "../config/db.php";

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}
$userName = $_SESSION['user_name'];

// ===================================
// ========= GUARDAR CAMBIOS (POST) =========
// ===================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger todos los datos del formulario
    $id = $_POST['product_id'];
    $nombre = $_POST['productName'];
    $descripcion = $_POST['productDescription'];
    $precio = floatval($_POST['productPrice']);
    $stock = intval($_POST['productStock']);
    $categoria_id = intval($_POST['productCategory']);
    $tallas = $_POST['tallas'] ?? [];
    $tallaPersonalizada = trim($_POST['talla_personalizada'] ?? '');
    $colores_seleccionados_str = $_POST['selected_colors'] ?? '';

    // Procesar la imagen si se sube una nueva
    $imgRuta = null; 
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['productImage']['tmp_name'];
        $nombreArchivo = uniqid('prod_') . '.' . pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION);
        $destinoAbsoluto = __DIR__ . "/../images/productos/" . $nombreArchivo;
        if (move_uploaded_file($tmpName, $destinoAbsoluto)) {
            $imgRuta = "../images/productos/" . $nombreArchivo; // Ruta relativa para la BD
        }
    }

    // Actualizar los datos principales del producto
    $query = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?";
    $params = [$nombre, $descripcion, $precio, $stock, $categoria_id];
    
    // Solo añadir la imagen a la consulta si se subió una nueva
    if ($imgRuta !== null) {
        $query .= ", img=?";
        $params[] = $imgRuta;
    }
    
    $query .= " WHERE id=?";
    $params[] = $id;
    $stmt = $conexion->prepare($query);
    $stmt->execute($params);

    // Actualizar tallas (borrar las anteriores e insertar las nuevas)
    $conexion->prepare("DELETE FROM producto_talla WHERE producto_id = ?")->execute([$id]);
    if (!empty($tallas)) {
        $stmt_talla = $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_id) VALUES (?, ?)");
        foreach ($tallas as $tallaId) {
            $stmt_talla->execute([$id, $tallaId]);
        }
    }
    if (!empty($tallaPersonalizada)) {
        $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_personalizada) VALUES (?, ?)")->execute([$id, $tallaPersonalizada]);
    }
    
    // Lógica de actualización inteligente para colores
    $colores_enviados_ids = !empty($colores_seleccionados_str) ? explode(',', $colores_seleccionados_str) : [];
    $colores_enviados_ids = array_map('intval', $colores_enviados_ids);
    sort($colores_enviados_ids);

    $stmt_actuales = $conexion->prepare("SELECT color_id FROM producto_color WHERE producto_id = ?");
    $stmt_actuales->execute([$id]);
    $colores_actuales_ids = $stmt_actuales->fetchAll(PDO::FETCH_COLUMN);
    $colores_actuales_ids = array_map('intval', $colores_actuales_ids);
    sort($colores_actuales_ids);

    if ($colores_enviados_ids !== $colores_actuales_ids) {
        $conexion->prepare("DELETE FROM producto_color WHERE producto_id = ?")->execute([$id]);
        if (!empty($colores_enviados_ids)) {
            $stmt_color = $conexion->prepare("INSERT INTO producto_color (producto_id, color_id) VALUES (?, ?)");
            foreach ($colores_enviados_ids as $color_id) {
                $stmt_color->execute([$id, $color_id]);
            }
        }
    }

    // Redirigir de vuelta a la página de edición con un mensaje de éxito
    header("Location: ../views/index.php?id=" . $id . "&success=1");
    exit();
}

// ===============================================
// ========= CARGAR DATOS PARA LA VISTA (GET) =========
// ===============================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener datos del producto
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }

    // Obtener todas las categorías para el <select>
    $categorias = $conexion->query("SELECT * FROM categorias_ropa")->fetchAll(PDO::FETCH_ASSOC);

    // Obtener todas las tallas para los checkboxes
    $tallasDisponibles = $conexion->query("SELECT * FROM tallas_ropa ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

    // Obtener las tallas seleccionadas para este producto
    $stmtTallas = $conexion->prepare("SELECT talla_id FROM producto_talla WHERE producto_id = ? AND talla_id IS NOT NULL");
    $stmtTallas->execute([$id]);
    $tallas = $stmtTallas->fetchAll(PDO::FETCH_COLUMN);

    // Obtener la talla personalizada para este producto
    $stmtCustom = $conexion->prepare("SELECT talla_personalizada FROM producto_talla WHERE producto_id = ? AND talla_personalizada IS NOT NULL LIMIT 1");
    $stmtCustom->execute([$id]);
    $tallaPersonalizada = $stmtCustom->fetchColumn();

    // Obtener los colores seleccionados para este producto (con todos sus datos)
    $stmtColores = $conexion->prepare(
        "SELECT c.id, c.codigo_hex, c.nombre
         FROM producto_color pc
         JOIN colores c ON pc.color_id = c.id
         WHERE pc.producto_id = ?"
    );
    $stmtColores->execute([$id]);
    $productoColores = $stmtColores->fetchAll(PDO::FETCH_ASSOC);

    // Crear un array simple solo con los IDs de los colores para el JavaScript
    $coloresSeleccionadosIds = array_column($productoColores, 'id');
} else {
    // Si no hay ID en la URL, redirigir al índice
    header("Location: ../views/index.php");
    exit();
}
?>