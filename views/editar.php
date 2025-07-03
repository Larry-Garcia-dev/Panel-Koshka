<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka Admin Producto - Fashion Admin</title>
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
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(233, 30, 99, 0.25);
        }
        
        .upload-area {
            border: 2px dashed #e0e0e0;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            transition: border-color 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: var(--primary-color);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .current-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
                <h2 class="fw-bold text-dark mb-1">Editar Producto</h2>
                <p class="text-muted">Modifica la información del producto "Vestido Elegante Rosa"</p>
            </div>
        </div>

        <!-- Alerta de éxito (oculta por defecto, se mostraría después del envío) -->
        <div class="alert alert-info d-none" id="updateAlert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>¡Actualizado!</strong> Los cambios han sido guardados correctamente.
        </div>

        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label fw-semibold">Nombre del Producto *</label>
                                <input type="text" class="form-control" id="productName" value="Vestido Elegante Rosa" required>
                            </div>

                            <div class="mb-3">
                                <label for="productDescription" class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control" id="productDescription" rows="4">Elegante vestido perfecto para ocasiones especiales. Confeccionado en materiales de alta calidad con acabados refinados.</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label fw-semibold">Precio ($) *</label>
                                        <input type="number" class="form-control" id="productPrice" step="0.01" value="89.99" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productStock" class="form-label fw-semibold">Cantidad Disponible *</label>
                                        <input type="number" class="form-control" id="productStock" value="15" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label fw-semibold">Categoría *</label>
                                <select class="form-select" id="productCategory" required>
                                    <option value="vestidos" selected>Vestidos</option>
                                    <option value="blusas">Blusas</option>
                                    <option value="pantalones">Pantalones</option>
                                    <option value="faldas">Faldas</option>
                                    <option value="abrigos">Abrigos</option>
                                    <option value="accesorios">Accesorios</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Imagen Actual</label>
                                <div class="mb-3">
                                    <img src="https://images.unsplash.com/photo-1649972904349-6e44c42644a7?w=400" 
                                         alt="Vestido Elegante Rosa" class="current-image">
                                </div>
                                <div class="upload-area">
                                    <i class="bi bi-cloud-upload text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-2">
                                        <span class="text-primary fw-semibold">Cambiar imagen</span> o arrastra y suelta
                                    </p>
                                    <p class="text-muted small">PNG, JPG, GIF hasta 10MB</p>
                                    <input type="file" class="form-control d-none" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tallas Disponibles *</label>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeXS">
                                            <label class="form-check-label fw-semibold" for="sizeXS">XS</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeS" checked>
                                            <label class="form-check-label fw-semibold" for="sizeS">S</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeM" checked>
                                            <label class="form-check-label fw-semibold" for="sizeM">M</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeL" checked>
                                            <label class="form-check-label fw-semibold" for="sizeL">L</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeXL">
                                            <label class="form-check-label fw-semibold" for="sizeXL">XL</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeXXL">
                                            <label class="form-check-label fw-semibold" for="sizeXXL">XXL</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeXXL">
                                            <label class="form-check-label fw-semibold" for="sizeXXL">XXXL</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox" id="sizeXXL">
                                            <label class="form-check-label fw-semibold" for="sizeXXL">Unica</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.html" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

/* 32-34-36-38-40-42*/
