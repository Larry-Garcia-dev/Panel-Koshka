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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #e91e63;
            --secondary-color: #f8f9fa;
            --accent-color: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), #ff6b9d);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #c2185b, #e91e63);
        }

        .table th {
            background-color: var(--secondary-color);
            font-weight: 600;
            color: var(--accent-color);
            border: none;
        }

        .badge {
            border-radius: 20px;
            padding: 5px 12px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Dentro de la etiqueta <style> en views/index.php */

        .color-dot {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 4px;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            vertical-align: middle;
        }
    </style>
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
                                <th class="px-4 py-3">colores</th>
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
                                    <td class="px-4 py-3">
                                        <?php
                                        // Obtenemos los colores para el producto actual
                                        $colores = $coloresPorProducto[$producto['id']] ?? [];

                                        if (empty($colores)) {
                                            echo '<span class="text-muted small">-</span>';
                                        } else {
                                            // Mostramos un máximo de 5 colores para no saturar la tabla
                                            $colores_mostrados = array_slice($colores, 0, 5);
                                            foreach ($colores_mostrados as $color) {
                                                echo '<span class="color-dot" style="background-color: ' . htmlspecialchars($color['hex']) . ';" title="' . htmlspecialchars($color['nombre']) . '"></span>';
                                            }
                                            // Si hay más de 5 colores, mostramos un indicador
                                            if (count($colores) > 5) {
                                                echo '<span class="badge bg-light text-dark ms-1">+' . (count($colores) - 5) . '</span>';
                                            }
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