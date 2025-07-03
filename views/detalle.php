<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka Admin Detalle del Producto - Fashion Admin</title>
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
        
        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .info-card {
            background: linear-gradient(135deg, var(--secondary-color), #ffffff);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
        }
        
        .price-card {
            background: linear-gradient(135deg, #ffe1e6, #ffeef1);
            border: 1px solid #ffc1cc;
        }
        
        .stock-card {
            background: linear-gradient(135deg, #e1f5fe, #f0f9ff);
            border: 1px solid #81d4fa;
        }
        
        .size-badge {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--secondary-color), #ffffff);
            border: 2px solid #e0e0e0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin: 5px;
        }
        
        .detail-item {
            background: var(--secondary-color);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="bi bi-shop"></i> Koshka Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Panel de Administración</span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="index.html" class="btn btn-light me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-1">Detalles del Producto</h2>
                <p class="text-muted">Información completa del producto</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <img src="https://images.unsplash.com/photo-1649972904349-6e44c42644a7?w=600" 
                                 alt="Vestido Elegante Rosa" class="product-image">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card price-card">
                                    <h6 class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.8rem;">Precio</h6>
                                    <h3 class="fw-bold text-primary mb-0">€89.99</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card stock-card">
                                    <h6 class="text-uppercase fw-bold text-info mb-1" style="font-size: 0.8rem;">Stock</h6>
                                    <h3 class="fw-bold text-info mb-0">15 unidades</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="h-100 d-flex flex-column">
                            <div class="mb-4">
                                <h1 class="fw-bold text-dark mb-3">Vestido Elegante Rosa</h1>
                                
                                <div class="mb-4">
                                    <span class="badge bg-info fs-6 px-3 py-2">Vestidos</span>
                                </div>

                                <div class="mb-4">
                                    <p class="text-muted lead">
                                        Elegante y sofisticado producto diseñado con los más altos estándares de calidad. 
                                        Perfecto para ocasiones especiales y uso diario, combina estilo y comodidad de manera excepcional.
                                    </p>
                                    <p class="text-muted">
                                        Confeccionado con materiales premium seleccionados cuidadosamente para garantizar 
                                        durabilidad y un ajuste perfecto. Los detalles refinados y el diseño atemporal 
                                        hacen de este producto una pieza imprescindible en cualquier guardarropa.
                                    </p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="fw-semibold text-dark mb-3">Tallas Disponibles</h4>
                                <div class="d-flex flex-wrap">
                                    <span class="size-badge">S</span>
                                    <span class="size-badge">M</span>
                                    <span class="size-badge">L</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="fw-semibold text-dark mb-3">Estado del Inventario</h4>
                                <div class="detail-item d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-dark">Disponibilidad:</span>
                                    <span class="badge bg-success">En stock</span>
                                </div>
                                <div class="detail-item d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-dark">Código de producto:</span>
                                    <span class="text-muted font-monospace">#PROD-0001</span>
                                </div>
                                <div class="detail-item d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-dark">Última actualización:</span>
                                    <span class="text-muted">Hace 2 días</span>
                                </div>
                            </div>

                            <div class="mt-auto pt-3">
                                <a href="index.html" class="btn btn-primary w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>