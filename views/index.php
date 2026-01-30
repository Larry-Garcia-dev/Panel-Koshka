<?php
include "../php/index.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka Admin - Panel de Administración</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- Navigation -->
    <?php include "nav.php"; ?>
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Productos</h2>
                <p class="text-muted">Gestiona tu inventario de productos de moda</p>
            </div>
            <a href="crear.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Producto</th>
                                <th class="px-4 py-3">Categoría</th>
                                <th class="px-4 py-3">Precio</th>
                                <th class="px-4 py-3">Tallas</th>
                                <th class="px-4 py-3">Stock</th>
                                <!-- <th class="px-4 py-3">colores</th> -->
                                <th class="px-4 py-3">Colores,combinados</th>
                                <th class="px-4 py-3">Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= htmlspecialchars($producto['img']) ?: '../images/placeholder.jpg' ?>"
                                                alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                                class="product-img me-3">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">
                                                    <a href="detalle.php?id=<?= $producto['id'] ?>" class="text-decoration-none text-dark">
                                                        <?= htmlspecialchars($producto['nombre']) ?>
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info"><?= htmlspecialchars($producto['categoria']) ?></span>
                                    </td>
                                    <td class="px-4 py-3 fw-semibold">$<?= number_format($producto['precio'], 2) ?></td>
                                    <td class="px-4 py-3">
                                        <?php
                                        $tallas = $tallasPorProducto[$producto['id']] ?? ['-'];
                                        foreach ($tallas as $talla) {
                                            echo '<span class="badge bg-light text-dark me-1">' . htmlspecialchars($talla) . '</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success"><?= intval($producto['stock']) ?> unidades</span>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <?php
                                        // --- Colores Individuales (esta parte no cambia) ---
                                        $colores_individuales = $coloresPorProducto[$producto['id']] ?? [];
                                        if (!empty($colores_individuales)) {
                                            foreach ($colores_individuales as $color) {
                                                echo '<span class="color-dot" style="background-color: ' . htmlspecialchars($color['hex']) . ';" title="' . htmlspecialchars($color['nombre']) . '"></span>';
                                            }
                                        }

                                        // --- Colores Combinados (AQUÍ ESTÁ EL CAMBIO) ---
                                        $combinaciones = $coloresCombinadosPorProducto[$producto['id']] ?? [];
                                        if (!empty($combinaciones)) {
                                            // Si ya hay colores individuales, añadimos un separador visual
                                            if (!empty($colores_individuales)) {
                                                echo '<hr class="my-2 border-top">';
                                            }

                                            foreach ($combinaciones as $grupo) {
                                                $num_colores = count($grupo);

                                                // CASO 1: Combinación de 2 colores (diseño especial)
                                                if ($num_colores == 2) {
                                                    $color_fondo = $grupo[0]['hex'];
                                                    $color_circulo = $grupo[1]['hex'];
                                                    $nombres = $grupo[0]['nombre'] . ' + ' . $grupo[1]['nombre'];

                                                    echo '<div class="color-combo-display" style="background-color: ' . htmlspecialchars($color_fondo) . ';" title="' . htmlspecialchars($nombres) . '">';
                                                    echo '<style>.color-combo-display[title="' . htmlspecialchars($nombres) . '"]::after { background-color: ' . htmlspecialchars($color_circulo) . '; }</style>';
                                                    echo '</div>';
                                                }
                                                // CASO 2: Más de 2 colores (se muestran como puntos solapados)
                                                else if ($num_colores > 2) {
                                                    echo '<div class="color-dot-cluster">';
                                                    foreach ($grupo as $color_combinado) {
                                                        echo '<span class="color-dot" style="background-color: ' . htmlspecialchars($color_combinado['hex']) . ';" title="' . htmlspecialchars($color_combinado['nombre']) . '"></span>';
                                                    }
                                                    echo '</div>';
                                                }
                                                // CASO 3: Solo 1 color en una 'combinación' (se muestra como un punto normal)
                                                else {
                                                    foreach ($grupo as $color_combinado) {
                                                        echo '<span class="color-dot" style="background-color: ' . htmlspecialchars($color_combinado['hex']) . ';" title="' . htmlspecialchars($color_combinado['nombre']) . ' (Comb.)"></span>';
                                                    }
                                                }
                                            }
                                        }

                                        // Si no hay ningún color en total
                                        if (empty($colores_individuales) && empty($combinaciones)) {
                                            echo '<span class="text-muted small">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="editar.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $producto['id'] ?>" data-nombre="<?= htmlspecialchars($producto['nombre']) ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <a href="../api/subir_producto.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-cloud-upload me-2"></i>
                                        </a>
                                        <a href="../api/shopify.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi me-2" viewBox="0 0 24 24">
                                                <path d="M9.7 0C8.1 0 7.1 1.4 6.7 2.7L6.6 3C6.5 2.8 6.4 2.7 6.2 2.5 5.8 2.1 5.3 2.1 5.1 2.2L0 3.9l2.7 18.5 5.8 1.6 8.5-1.9 2.9-17.2-5.5-2.6c-.1-.1-.2-.1-.3-.1H9.7zM9.7 1h5.4c.1 0 .2 0 .3.1l4.5 2.1L17.2 19l-7.4 1.7-5.3-1.5L1.2 4.5 5.5 3l.4 1.2h.1C6.4 2.2 7.7 1 9.7 1z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="../php/baja_producto.php" class="modal-content border-0 shadow">
                <div class="modal-body text-center p-4">
                    <div class="text-danger mb-3">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">¿Dar de baja el producto?</h5>
                    <p class="text-muted mb-4">
                        Estás a punto de dar de baja: <strong id="productoNombre"></strong><br>
                        Esta acción ocultará el producto del panel.
                    </p>
                    <input type="hidden" name="producto_id" id="productoId">
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Dar de baja</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/index.js"></script>
</body>

</html>