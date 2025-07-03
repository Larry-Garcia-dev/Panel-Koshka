<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka Admin - Panel de Administración</title>
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
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="bi bi-shop"></i>   Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Lina Admin</span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </div>
    </nav>

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
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1649972904349-6e44c42644a7?w=400"
                                            alt="Vestido Elegante Rosa" class="product-img me-3">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">
                                                <a href="detalle-producto.html" class="text-decoration-none text-dark">
                                                    Vestido Elegante Rosa
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-info">Vestidos</span>
                                </td>
                                <td class="px-4 py-3 fw-semibold">$89.99</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark me-1">S</span>
                                    <span class="badge bg-light text-dark me-1">M</span>
                                    <span class="badge bg-light text-dark">L</span>
                                    <span class="badge bg-light text-dark">XL</span>
                                    <span class="badge bg-light text-dark">XXL</span>
                                    <span class="badge bg-light text-dark">XXXL</span>

                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-success">15 unidades</span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="editar-producto.html" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-4">
                    <div class="text-danger mb-3">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">¿Eliminar producto?</h5>
                    <p class="text-muted mb-4">¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>