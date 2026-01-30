<?php
// /php/create.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}
$userName = $_SESSION['user_name'];

include "../config/db.php";

// ================== CARGA DE DATOS PARA LA VISTA ==================
// Se ejecuta siempre para que la vista tenga los datos que necesita.

// Cargar Tallas
$tallas_stmt = $conexion->query("SELECT * FROM tallas_ropa");
$sizes = $tallas_stmt->fetchAll(PDO::FETCH_ASSOC);

// Cargar Categorías
$categorias_stmt = $conexion->query("SELECT * FROM categorias_ropa");
$categorias_data = $categorias_stmt->fetchAll(PDO::FETCH_ASSOC);

// ================== PROCESAMIENTO DEL FORMULARIO POST ==================
// Solo se ejecuta cuando el método es POST.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['productName'] ?? '';
    $descripcion = $_POST['productDescription'] ?? '';
    $precio = $_POST['productPrice'] ?? 0;
    $stock = $_POST['productStock'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;
    $tallas_seleccionadas = $_POST['sizes'] ?? [];
    $talla_personalizada = trim($_POST['custom_size'] ?? '');
    $colores_seleccionados_str = $_POST['selected_colors'] ?? '';

    // Procesar imagen
    $ruta_relativa = null;
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['productImage']['tmp_name'];
        $original_name = basename($_FILES['productImage']['name']);
        $ext = pathinfo($original_name, PATHINFO_EXTENSION);
        $filename = uniqid("prod_") . "." . $ext;
        $carpeta_destino = __DIR__ . "/../images/productos/";
        $ruta_relativa = "../images/productos/" . $filename;
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0755, true);
        }
        move_uploaded_file($tmp_name, $carpeta_destino . $filename);
    }
 
    try {
        $conexion->beginTransaction();

        $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, img) VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :img)");
        $stmt->execute([':nombre' => $nombre, ':descripcion' => $descripcion, ':precio' => $precio, ':stock' => $stock, ':categoria_id' => $categoria_id, ':img' => $ruta_relativa]);
        $producto_id = $conexion->lastInsertId();

        // Guardar tallas
        if (!empty($tallas_seleccionadas)) {
            $stmt_talla = $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_id) VALUES (:producto_id, :talla_id)");
            foreach ($tallas_seleccionadas as $talla_id) {
                $stmt_talla->execute([':producto_id' => $producto_id, ':talla_id' => $talla_id]);
            }
        }
        if (!empty($talla_personalizada)) {
            $stmt_custom = $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_personalizada) VALUES (:producto_id, :talla_personalizada)");
            $stmt_custom->execute([':producto_id' => $producto_id, ':talla_personalizada' => $talla_personalizada]);
        }
        
        // Guardar colores
        if (!empty($colores_seleccionados_str)) {
            $colores_ids = explode(',', $colores_seleccionados_str);
            $stmt_color = $conexion->prepare("INSERT INTO producto_color (producto_id, color_id) VALUES (:producto_id, :color_id)");
            foreach ($colores_ids as $color_id) {
                if (is_numeric($color_id)) {
                    $stmt_color->execute([':producto_id' => $producto_id, ':color_id' => trim($color_id)]);
                }
            }
        }
         // ▼▼▼ AÑADIR ESTE BLOQUE ▼▼▼
        // Guardar colores combinados
        $colores_combinados = $_POST['colores_combinados'] ?? [];
        if (!empty($colores_combinados)) {
            $stmt_combinado = $conexion->prepare(
                "INSERT INTO producto_color_combinado (producto_id, color_id, grupo_combinacion) VALUES (:producto_id, :color_id, :grupo)"
            );
            // El índice del array (0, 1, 2...) será nuestro 'grupo_combinacion'
            foreach ($colores_combinados as $grupo_id => $colores_del_grupo) {
                foreach ($colores_del_grupo as $color_id) {
                    $stmt_combinado->execute([
                        ':producto_id' => $producto_id,
                        ':color_id'    => $color_id,
                        ':grupo'       => $grupo_id
                    ]);
                }
            }
        }
        
        $conexion->commit();
        header("Location: ../views/index.php?success=1");
        exit; // Es importante salir del script después de redirigir
    } catch (PDOException $e) {
        $conexion->rollBack();
        die("Error al guardar el producto: " . $e->getMessage());
    }
}