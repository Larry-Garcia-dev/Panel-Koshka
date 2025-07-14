document.addEventListener('DOMContentLoaded', () => {
    // ▼▼▼ AÑADE ESTA LÍNEA ▼▼▼
    //alert('JavaScript ha recibido estos IDs para pre-seleccionar: ' + window.preselectedColorIds);

    // =========================================================
    // =============== CÓDIGO PARA SUBIDA DE IMAGEN =============
    // =========================================================
    const uploadArea = document.getElementById('uploadArea');
    const inputFile = document.getElementById('productImage');
    const selectBtn = document.getElementById('selectImageBtn');
    const placeholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeBtn = document.getElementById('removeImageBtn');

    if (selectBtn) {
        selectBtn.addEventListener('click', () => inputFile.click());
    }

    if (uploadArea) {
        uploadArea.addEventListener('click', (e) => {
            if (imagePreview && !imagePreview.classList.contains('d-none') || e.target.closest('#removeImageBtn')) {
                return;
            }
            inputFile.click();
        });
    }

    if (inputFile) {
        inputFile.addEventListener('change', () => {
            if (inputFile.files.length === 1) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImg) previewImg.src = e.target.result;
                    if (placeholder) placeholder.classList.add('d-none');
                    if (imagePreview) imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(inputFile.files[0]);
            }
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            inputFile.value = '';
            if (previewImg) previewImg.src = '';
            if (imagePreview) imagePreview.classList.add('d-none');
            if (placeholder) placeholder.classList.remove('d-none');
        });
    }

    // /js/editar.js


    // ... (Tu código para la subida de imagen) ...

    // =========================================================
    // ================== CÓDIGO PARA COLOR ==================
    // =========================================================
    const colorPaletteContainer = document.getElementById('color-palette-container');
    const selectedColorsInput = document.getElementById('selectedColorsInput');

    const initiallySelectedIds = window.preselectedColorIds || [];

    let selectedColorIds = [...initiallySelectedIds];
    if (selectedColorsInput) {
        selectedColorsInput.value = selectedColorIds.join(',');
    }

    function createColorSwatch(color) {
        const swatch = document.createElement('div');
        swatch.className = 'color-swatch';
        swatch.style.backgroundColor = color.codigo_hex;
        swatch.title = `Seleccionar ${color.nombre}`;
        swatch.dataset.colorId = color.id;

        if (selectedColorIds.includes(parseInt(color.id))) {
            swatch.classList.add('selected');
        }

        swatch.addEventListener('click', () => {
            swatch.classList.toggle('selected');
            const colorId = parseInt(swatch.dataset.colorId);

            if (selectedColorIds.includes(colorId)) {
                selectedColorIds = selectedColorIds.filter(id => id !== colorId);
            } else {
                selectedColorIds.push(colorId);
            }

            if (selectedColorsInput) {
                selectedColorsInput.value = selectedColorIds.join(',');
            }
        });
        return swatch;
    }

    async function cargarColores() {
        if (!colorPaletteContainer) return;
        try {
            const response = await fetch('../php/btener_colores.php');
            if (!response.ok) throw new Error('Error de red al cargar colores.');

            const colors = await response.json();
            colorPaletteContainer.innerHTML = '';
            colors.forEach(color => {
                colorPaletteContainer.appendChild(createColorSwatch(color));
            });
        } catch (error) {
            console.error('Error en cargarColores:', error);
            colorPaletteContainer.innerHTML = '<p class="text-danger">No se pudo cargar la paleta de colores.</p>';
        }
    }

    cargarColores();
});