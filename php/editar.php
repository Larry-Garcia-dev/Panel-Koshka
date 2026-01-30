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
    $colores_combinados = $_POST['colores_combinados'] ?? [];
    
    // --- NUEVO: Capturar campo Estampado ---
    $estampado = isset($_POST['estampado']) ? 1 : 0;

    try {
        $conexion->beginTransaction();

        // ▼▼▼ LÓGICA DE IMAGEN CORREGIDA ▼▼▼
        $imgRuta = null; 
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['productImage']['tmp_name'];
            $nombreArchivo = uniqid('prod_') . '.' . pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION);
            $destinoAbsoluto = __DIR__ . "/../images/productos/" . $nombreArchivo;
            if (move_uploaded_file($tmpName, $destinoAbsoluto)) {
                // Obtenemos la ruta relativa para guardar en la BD
                $imgRuta = "../images/productos/" . $nombreArchivo; 
            }
        }

        // --- ACTUALIZADO: Se construye la consulta de forma dinámica incluyendo estampado ---
        // Agregamos 'estampado=?' a la consulta base
        $query = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, estampado=?";
        $params = [$nombre, $descripcion, $precio, $stock, $categoria_id, $estampado];
        
        // Solo se añade la imagen a la consulta si se subió una nueva
        if ($imgRuta !== null) {
            $query .= ", img=?";
            $params[] = $imgRuta;
        }
        
        $query .= " WHERE id=?";
        $params[] = $id;
        
        $stmt = $conexion->prepare($query);
        $stmt->execute($params);
        // ▲▲▲ FIN DE LA LÓGICA ACTUALIZADA ▲▲▲

        // --- El resto de la lógica para tallas y colores se mantiene intacta ---

        // Actualizar tallas
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

        // Actualización de colores de un solo tono
        $conexion->prepare("DELETE FROM producto_color WHERE producto_id = ?")->execute([$id]);
        $colores_enviados_ids = !empty($colores_seleccionados_str) ? explode(',', $colores_seleccionados_str) : [];
        if (!empty($colores_enviados_ids)) {
            $stmt_color = $conexion->prepare("INSERT INTO producto_color (producto_id, color_id) VALUES (?, ?)");
            foreach ($colores_enviados_ids as $color_id) {
                if (intval($color_id) > 0) {
                    $stmt_color->execute([$id, intval($color_id)]);
                }
            }
        }
        
        // Actualizar colores combinados
        $conexion->prepare("DELETE FROM producto_color_combinado WHERE producto_id = ?")->execute([$id]);
        if (!empty($colores_combinados)) {
            $stmt_combinado = $conexion->prepare("INSERT INTO producto_color_combinado (producto_id, color_id, grupo_combinacion) VALUES (?, ?, ?)");
            foreach ($colores_combinados as $grupo_id => $colores_del_grupo) {
                foreach ($colores_del_grupo as $color_id) {
                    $stmt_combinado->execute([$id, $color_id, $grupo_id]);
                }
            }
        }

        $conexion->commit();
        header("Location: ../views/index.php?update_success=1");
        exit();

    } catch (PDOException $e) {
        $conexion->rollBack();
        die("Error al actualizar el producto: " . $e->getMessage());
    }
}


// ===============================================
// ========= CARGAR DATOS PARA LA VISTA (GET) =========
// ===============================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $producto = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $producto->execute([$id]);
    $producto = $producto->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }

    $categorias = $conexion->query("SELECT * FROM categorias_ropa")->fetchAll(PDO::FETCH_ASSOC);
    $tallasDisponibles = $conexion->query("SELECT * FROM tallas_ropa ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    $stmtTallas = $conexion->prepare("SELECT talla_id FROM producto_talla WHERE producto_id = ? AND talla_id IS NOT NULL");
    $stmtTallas->execute([$id]);
    $tallas = $stmtTallas->fetchAll(PDO::FETCH_COLUMN);
    $stmtCustom = $conexion->prepare("SELECT talla_personalizada FROM producto_talla WHERE producto_id = ? AND talla_personalizada IS NOT NULL LIMIT 1");
    $stmtCustom->execute([$id]);
    $tallaPersonalizada = $stmtCustom->fetchColumn();
    $stmtColores = $conexion->prepare("SELECT c.id, c.codigo_hex, c.nombre FROM producto_color pc JOIN colores c ON pc.color_id = c.id WHERE pc.producto_id = ?");
    $stmtColores->execute([$id]);
    $productoColores = $stmtColores->fetchAll(PDO::FETCH_ASSOC);
    $coloresSeleccionadosIds = array_column($productoColores, 'id');
    
    $coloresCombinadosExistentes = [];
    $stmtCombinados = $conexion->prepare(
        "SELECT c.id, c.codigo_hex, c.nombre, pc.grupo_combinacion
         FROM producto_color_combinado pc
         JOIN colores c ON pc.color_id = c.id
         WHERE pc.producto_id = ?
         ORDER BY pc.grupo_combinacion, c.id"
    );
    $stmtCombinados->execute([$id]);
    $coloresCombinadosExistentes_raw = $stmtCombinados->fetchAll(PDO::FETCH_ASSOC);
    foreach ($coloresCombinadosExistentes_raw as $color) {
        $coloresCombinadosExistentes[$color['grupo_combinacion']][] = $color;
    }
    
} else {
    header("Location: ../views/index.php");
    exit();
}
?>