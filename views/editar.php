<?php
require "../php/editar.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koshka Admin Producto - Fashion Admin</title>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/editar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include "nav.php"; ?>

    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="index.php" class="btn btn-light me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-1">Editar Producto</h2>
                <p class="text-muted">Modifica la información del producto "<?php echo htmlspecialchars($producto['nombre']); ?>"</p>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-info" id="updateAlert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>¡Actualizado!</strong> Los cambios han sido guardados correctamente.
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="../php/editar.php">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($producto['id']); ?>">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label fw-semibold">Nombre del Producto *</label>
                                <input type="text" class="form-control" name="productName" id="productName" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="productDescription" class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control" name="productDescription" id="productDescription" rows="4"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label fw-semibold">Precio ($) *</label>
                                        <input type="number" class="form-control" name="productPrice" id="productPrice" step="0.01" value="<?php echo $producto['precio']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="productStock" class="form-label fw-semibold">Cantidad Disponible *</label>
                                        <input type="number" class="form-control" name="productStock" id="productStock" value="<?php echo $producto['stock']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Imagen Actual</label>
                                <div class="mb-3">
                                    <?php if (!empty($producto['img'])): ?>
                                        <img src="<?= $producto['img']; ?>" alt="Imagen actual" class="current-image">
                                    <?php endif; ?>
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
                                    <?php foreach ($tallasDisponibles as $t): ?>
                                        <div class="col-4">
                                            <div class="form-check border rounded p-3">
                                                <input class="form-check-input" type="checkbox" name="tallas[]" id="talla<?= $t['id'] ?>" value="<?= $t['id'] ?>" <?= in_array($t['id'], $tallas ?? []) ? 'checked' : '' ?>>
                                                <label class="form-check-label fw-semibold" for="talla<?= $t['id'] ?>"><?= $t['talla'] ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="col-4">
                                        <div class="form-group border rounded p-3">
                                            <label for="sizeInput" class="fw-semibold">Talla</label>
                                            <input type="text" class="form-control" name="talla_personalizada" id="sizeInput" placeholder="Ingrese la talla" value="<?= htmlspecialchars($tallaPersonalizada ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const uploadArea = document.getElementById('uploadArea');
        const inputFile = document.getElementById('productImage');
        const selectBtn = document.getElementById('selectImageBtn');
        const placeholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeBtn = document.getElementById('removeImageBtn');

        // Abrir selector al hacer clic en botón o área
        selectBtn.addEventListener('click', () => inputFile.click());
        uploadArea.addEventListener('click', (e) => {
            if (!imagePreview.classList.contains('d-none') || e.target.id === 'removeImageBtn') return;
            inputFile.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-primary');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-primary');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-primary');
            const files = e.dataTransfer.files;
            if (files.length === 1) {
                inputFile.files = files;
                showImagePreview(files[0]);
            } else {
                alert("Solo puedes subir una imagen.");
            }
        });

        // Imagen seleccionada desde input
        inputFile.addEventListener('change', () => {
            if (inputFile.files.length === 1) {
                showImagePreview(inputFile.files[0]);
            } else {
                alert("Solo puedes subir una imagen.");
                inputFile.value = '';
            }
        });

        // Mostrar vista previa en el contenedor
        function showImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                placeholder.classList.add('d-none');
                imagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }

        // Eliminar imagen seleccionada
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            inputFile.value = '';
            previewImg.src = '';
            imagePreview.classList.add('d-none');
            placeholder.classList.remove('d-none');
        });
    </script>addEventListener
</body>

</html>