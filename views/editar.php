<?php
require "../php/editar.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar: <?= htmlspecialchars($producto['nombre']); ?></title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/editar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <?php include "nav.php"; ?>

    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="index.php" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h2 class="fw-bold text-dark mb-1">Editar Producto</h2>
                <p class="text-muted">Modifica la información del producto "<?= htmlspecialchars($producto['nombre']); ?>"</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" action="../php/editar.php">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($producto['id']); ?>">
                    <div class="row gx-5">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label fw-semibold">Nombre del Producto *</label>
                                <input type="text" class="form-control" name="productName" id="productName" value="<?= htmlspecialchars($producto['nombre']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control" name="productDescription" id="productDescription" rows="4"><?= htmlspecialchars($producto['descripcion']); ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label fw-semibold">Precio ($) *</label>
                                        <input type="number" class="form-control" name="productPrice" id="productPrice" step="0.01" value="<?= $producto['precio']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productStock" class="form-label fw-semibold">Cantidad Disponible *</label>
                                        <input type="number" class="form-control" name="productStock" id="productStock" value="<?= $producto['stock']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label fw-semibold">Categoría *</label>
                                <select class="form-select" name="productCategory" id="productCategory" required>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Imagen del Producto</label>
                                <div class="mb-2 text-center">
                                    <?php if (!empty($producto['img'])): ?>
                                        <img src="<?= $producto['img']; ?>" alt="Imagen actual" class="current-image img-thumbnail mb-2">
                                    <?php endif; ?>
                                </div>
                                <div class="upload-area text-center border rounded p-4 position-relative" id="uploadArea" style="cursor: pointer; overflow: hidden; min-height: 200px;">
                                    <input type="file" class="form-control d-none" id="productImage" name="productImage" accept="image/*">
                                    <div id="uploadPlaceholder">
                                        <i class="bi bi-cloud-upload text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-2"><span class="text-primary fw-semibold">Subir nueva imagen</span> o arrastra y suelta</p>
                                        <p class="text-muted small">Reemplazará la imagen actual</p>
                                    </div>
                                    <div id="imagePreview" class="position-absolute top-0 start-0 w-100 h-100 d-none">
                                        <img id="previewImg" src="" class="w-100 h-100" style="object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removeImageBtn"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <h4 class="fw-semibold">Tallas Disponibles *</h4>
                        <div class="row g-2">
                            <?php foreach ($tallasDisponibles as $t): ?>
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="checkbox" name="tallas[]" id="talla<?= $t['id'] ?>" value="<?= $t['id'] ?>" <?= in_array($t['id'], $tallas ?? []) ? 'checked' : '' ?>>
                                        <label class="form-check-label w-100" for="talla<?= $t['id'] ?>"><?= htmlspecialchars($t['talla']) ?></label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col-12 mt-3">
                                <label for="sizeInput" class="form-label">Talla Personalizada (Opcional)</label>
                                <input type="text" class="form-control" name="talla_personalizada" id="sizeInput" placeholder="Ej: Única, 3XL, etc." value="<?= htmlspecialchars($tallaPersonalizada ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <h4 class="fw-semibold mb-3">Colores Actuales</h4>
                        <div id="current-colors-container" class="d-flex flex-wrap align-items-center gap-2">
                            <?php if (empty($productoColores)): ?>
                                <p class="text-muted m-0">Este producto no tiene colores asignados.</p>
                            <?php else: ?>
                                <?php foreach ($productoColores as $color): ?>
                                    <span class="color-swatch" style="background-color: <?= htmlspecialchars($color['codigo_hex']); ?>;" title="<?= htmlspecialchars($color['nombre']); ?>"></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h4 class="mb-3 fw-semibold">Modificar Paleta de Colores</h4>
                        <input type="hidden" name="selected_colors" id="selectedColorsInput">
                        <div id="color-palette-container"></div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.preselectedColorIds = <?php echo json_encode($coloresSeleccionadosIds); ?>;
    </script>
    <script src="../js/editar.js"></script>

</body>
</html>