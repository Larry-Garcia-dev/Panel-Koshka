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

include "../config/db.php";


//==============================================Esta consulta se encargara de cargar las tallas al front============================
// Fetch all sizes from the database using PDO
$tallas = "SELECT * FROM tallas_ropa";
$tallas_result = $conexion->query($tallas); // Use PDO's query method

// Store sizes in an array for use in the view
$sizes = [];
while ($row = $tallas_result->fetch(PDO::FETCH_ASSOC)) { // Use PDO's fetch method
    $sizes[] = $row;
}

//==============================================FIN de consulta que se encargara de cargar las tallas al front============================



//==============================================Cargar Categorias al Front ============================================================



$categorias = "SELECT * FROM categorias_ropa";
$categorias_result = $conexion->query($categorias);

$categorias_data = [];
while ($row = $categorias_result->fetch(PDO::FETCH_ASSOC)) {
    $categorias_data[] = $row;
}


//============================================== FIN de Cargar Categorias al Front ============================================================


//======================================================= Crear Producto =======================================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['productName'] ?? '';
    $descripcion = $_POST['productDescription'] ?? '';
    $precio = $_POST['productPrice'] ?? 0;
    $stock = $_POST['productStock'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;
    $tallas_seleccionadas = $_POST['sizes'] ?? [];
    $talla_personalizada = trim($_POST['custom_size'] ?? '');

    // ========== Procesar imagen ==========
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

        // 👇 INSERTAR producto incluyendo la ruta de imagen
        $stmt = $conexion->prepare("
            INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, img)
            VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :img)
        ");
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':stock' => $stock,
            ':categoria_id' => $categoria_id,
            ':img' => $ruta_relativa
        ]);

        $producto_id = $conexion->lastInsertId();

        // Tallas seleccionadas
        $stmt_talla = $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_id) VALUES (:producto_id, :talla_id)");
        foreach ($tallas_seleccionadas as $talla_id) {
            $stmt_talla->execute([
                ':producto_id' => $producto_id,
                ':talla_id' => $talla_id
            ]);
        }

        // Talla personalizada (si la hay)
        if (!empty($talla_personalizada)) {
            $stmt_custom = $conexion->prepare("INSERT INTO producto_talla (producto_id, talla_personalizada)
                                               VALUES (:producto_id, :talla_personalizada)");
            $stmt_custom->execute([
                ':producto_id' => $producto_id,
                ':talla_personalizada' => $talla_personalizada
            ]);
        }

        $conexion->commit();
        header("Location: ../views/crear.php?success=1");
        exit;
    } catch (PDOException $e) {
        $conexion->rollBack();
        die("Error al guardar el producto: " . $e->getMessage());
    }
}

//======================================================  Fin de crear producto =================================================================
