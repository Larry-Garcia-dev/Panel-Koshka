<?php
include("../php/create.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Fashion Admin</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/crear.css" rel="stylesheet">

</head>

<body>
    <!-- Navigation -->
    <?php include "nav.php"; ?>
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="index.php" class="btn btn-light me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-1">Crear Nuevo Producto</h2>
                <p class="text-muted">Añade un nuevo producto a tu inventario</p>
            </div>
        </div>

        <!-- Alerta de éxito (oculta por defecto, se mostraría después del envío) -->
        <div class="alert alert-success d-none" id="successAlert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>¡Éxito!</strong> El producto ha sido creado correctamente.
        </div>

        <div class="card">
            <div class="card-body">
                <form action="../php/create.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label fw-semibold">Nombre del Producto *</label>
                                <input type="text" class="form-control" id="productName" name="productName" placeholder="Ej: Vestido Elegante de Verano" required>
                            </div>

                            <div class="mb-3">
                                <label for="productDescription" class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control" id="productDescription" name="productDescription" rows="4" placeholder="Describe las características, materiales y detalles del producto..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label fw-semibold">Precio ($) *</label>
                                        <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productStock" class="form-label fw-semibold">Cantidad Disponible *</label>
                                        <input type="number" class="form-control" id="productStock" name="productStock" placeholder="0" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label fw-semibold">Categoría *</label>
                                <select class="form-select" id="productCategory" name="categoria_id" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias_data as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['id']) ?>">
                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Imagen del Producto</label>
                                <div class="upload-area text-center border rounded p-4 position-relative" id="uploadArea" style="cursor: pointer; overflow: hidden; height: 250px;">
                                    <input type="file" class="form-control d-none" id="productImage" name="productImage" accept="image/*">

                                    <!-- Contenido por defecto -->
                                    <div id="uploadPlaceholder">
                                        <i class="bi bi-cloud-upload text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-2">
                                            <span class="text-primary fw-semibold">Subir imagen</span> o arrastra y suelta
                                        </p>
                                        <p class="text-muted small">PNG, JPG, GIF hasta 10MB</p>
                                        <button type="button" class="btn btn-outline-primary mt-2" id="selectImageBtn">Seleccionar imagen</button>
                                    </div>

                                    <!-- Vista previa de la imagen -->
                                    <div id="imagePreview" class="position-absolute top-0 start-0 w-100 h-100 d-none">
                                        <img id="previewImg" src="" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removeImageBtn">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tallas Disponibles *</label>
                            <div class="row g-2">
                                <?php foreach ($sizes as $size): ?>
                                    <div class="col-4">
                                        <div class="form-check border rounded p-3">
                                            <input class="form-check-input" type="checkbox"
                                                id="size<?= htmlspecialchars($size['id']) ?>"
                                                name="sizes[]"
                                                value="<?= htmlspecialchars($size['id']) ?>">
                                            <label class="form-check-label fw-semibold"
                                                for="size<?= htmlspecialchars($size['id']) ?>">
                                                <?= htmlspecialchars($size['talla']) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="col-12 mt-2">
                                    <input type="text" class="form-control" id="customSize" name="custom_size" placeholder="¿Otra talla? Ej: Única, 3XL, etc.">
                                </div>
                            </div>
                        </div>
                       
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="mb-0 fw-semibold">Paleta de Colores *</h3>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="estampado" name="estampado" value="1">
                                    <label class="form-check-label fw-semibold" for="estampado">¿Es Estampado?</label>
                                </div>
                            </div>
                            <input type="hidden" name="selected_colors" id="selectedColorsInput">
                            <div id="color-palette-container">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <h3 class="mb-3 fw-semibold">Colores Combinados (Opcional)</h3>
                            <div id="combined-colors-container">
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="add-combined-color-group">
                                <i class="bi bi-plus-circle me-2"></i>Añadir Grupo de Combinación
                            </button>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Crear Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/crear.js"></script>



</body>

</html>