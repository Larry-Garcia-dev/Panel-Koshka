<?php
// api/shopify.php

// --- 1. INCLUIR LA CONEXIÓN A LA BASE DE DATOS ---
require '../config/db.php'; // La variable de conexión es $conexion

// --- 2. OBTENER EL ID DEL PRODUCTO DESDE LA URL ---
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Error: ID de producto no válido o no proporcionado.");
}
$producto_id = (int)$_GET['id'];

// --- 3. RECOPILAR TODA LA INFORMACIÓN DEL PRODUCTO ---
try {
    // Datos principales
    $stmt = $conexion->prepare("SELECT p.*, cr.nombre as categoria_nombre FROM productos p LEFT JOIN categorias_ropa cr ON p.categoria_id = cr.id WHERE p.id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Error: Producto con ID $producto_id no encontrado.");
    }

    // Tallas
    $stmt = $conexion->prepare("SELECT tr.talla, pt.talla_personalizada FROM producto_talla pt LEFT JOIN tallas_ropa tr ON pt.talla_id = tr.id WHERE pt.producto_id = ?");
    $stmt->execute([$producto_id]);
    $tallas_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $tallas = [];
    foreach ($tallas_raw as $t) {
        $tallas[] = $t['talla'] ?? $t['talla_personalizada'];
    }

    // Nombres de los colores
    $stmt = $conexion->prepare("SELECT c.nombre FROM producto_color pc JOIN colores c ON pc.color_id = c.id WHERE pc.producto_id = ?");
    $stmt->execute([$producto_id]);
    $colores = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Construir el objeto final
    $data_para_webhook = [
        'id' => (int)$producto['id'],
        'nombre' => $producto['nombre'],
        'descripcion' => $producto['descripcion'],
        'precio' => (float)$producto['precio'],
        'stock' => (int)$producto['stock'],
        'categoria' => ['id' => (int)$producto['categoria_id'], 'nombre' => $producto['categoria_nombre']],
        'estampado' => (bool)$producto['estampado'], // --- NUEVO: Campo estampado agregado ---
        'imagen_url' => $producto['img'],
        'estado' => $producto['estado'],
        'tallas' => $tallas,
        'colores' => $colores ?: []
    ];

} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// --- 4. ENVIAR LA DATA AL WEBHOOK DE N8N ---
$webhook_url = 'https://n8n.magnificapec.com/webhook/0ebe59ca-1639-444a-b023-61448a0b308e';
$json_payload = json_encode($data_para_webhook, JSON_UNESCAPED_UNICODE);

$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($json_payload)]);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$response_body = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

// --- 5. MOSTRAR UNA RESPUESTA BASADA EN LA RESPUESTA DEL WEBHOOK ---
header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html lang='es'><head><title>Estado de Sincronización</title>";
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo "</head><body class='bg-light'><div class='container mt-5 text-center'>";

if ($curl_error) {
    echo "<div class='alert alert-danger'><h1>Error de Conexión</h1><p>No se pudo contactar al servicio webhook: " . htmlspecialchars($curl_error) . "</p></div>";
} elseif ($http_code >= 200 && $http_code < 300) {
    // Decodificamos la respuesta de n8n para obtener el mensaje
    $n8n_respuesta = json_decode($response_body, true);
    $mensaje_exito = isset($n8n_respuesta['message']) ? $n8n_respuesta['message'] : 'Producto procesado exitosamente.';
    
    // Mostramos el mensaje de éxito que viene de n8n
    echo "<div class='alert alert-success'><h1>¡Éxito! ✅</h1><p class='h4'>" . htmlspecialchars($mensaje_exito) . "</p></div>";

    // ¡CAMBIO AQUÍ! Añadimos de nuevo el bloque para ver la respuesta completa de n8n
    $pretty_json = json_encode($n8n_respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "<h5 class='mt-4'>Respuesta completa del Webhook:</h5>";
    echo "<pre class='text-start bg-dark text-white p-3 rounded'><code>" . htmlspecialchars($pretty_json) . "</code></pre>";

} else {
    // Si n8n devuelve un error (código 4xx o 5xx)
    echo "<div class='alert alert-danger'><h1>Error del Servidor</h1><p>El servicio webhook devolvió un error (Código: $http_code).</p></div>";
    echo "<h5>Respuesta del servidor:</h5><pre class='text-start bg-dark text-white p-3 rounded'><code>" . htmlspecialchars($response_body) . "</code></pre>";
}

echo "<a href='javascript:history.back()' class='btn btn-primary mt-3'>Volver a la página anterior</a>";
echo "</div></body></html>";
?>