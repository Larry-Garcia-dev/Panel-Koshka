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
    // });
    // =========================================================
    // ========= LÓGICA PARA COLORES COMBINADOS (CORREGIDO) =========
    // =========================================================
    const addGroupBtn = document.getElementById('add-combined-color-group');
    const combinedColorsContainer = document.getElementById('combined-colors-container');

    // ▼▼▼ CORRECCIÓN CLAVE: Hacemos el contador más inteligente ▼▼▼
    // Esta función busca el número de grupo más alto que ya existe en la página y empieza a contar desde ahí.
    // Esto evita conflictos de IDs entre los grupos viejos y los nuevos.
    let groupCounter = (() => {
        let maxId = -1;
        const existingGroups = document.querySelectorAll('.combined-group input[name^="colores_combinados"]');
        existingGroups.forEach(input => {
            const match = input.name.match(/\[(\d+)\]/);
            if (match && parseInt(match[1]) > maxId) {
                maxId = parseInt(match[1]);
            }
        });
        return maxId + 1;
    })();
    // ▲▲▲ FIN DE LA CORRECCIÓN ▲▲▲

    /**
     * Actualiza el estado de una paleta: deshabilita los colores si se alcanza el límite.
     * @param {HTMLElement} palette - El contenedor de los checkboxes de un grupo.
     */
    function updateColorGroupState(palette) {
        const checkboxes = palette.querySelectorAll('input[type="checkbox"]');
        const checkedCount = palette.querySelectorAll('input[type="checkbox"]:checked').length;
        const isLimitReached = checkedCount >= 2;

        checkboxes.forEach(cb => {
            const label = cb.nextElementSibling;
            if (!cb.checked && isLimitReached) {
                cb.disabled = true;
                label.classList.add('disabled');
            } else {
                cb.disabled = false;
                label.classList.remove('disabled');
            }
        });
    }

    /**
     * Aplica los event listeners a una paleta para manejar la selección.
     * @param {HTMLElement} palette - El contenedor de los checkboxes de un grupo.
     */
    function initializePalette(palette) {
        updateColorGroupState(palette); // Actualiza el estado inicial
        palette.addEventListener('change', () => { // Y añade el listener para el futuro
            updateColorGroupState(palette);
        });
    }

    // Aplicar la lógica a los grupos que ya existen en la página
    document.querySelectorAll('.combined-group .d-flex.flex-wrap').forEach(existingPalette => {
        initializePalette(existingPalette);
    });

    /**
     * Crea una nueva paleta de colores para un nuevo grupo de combinación.
     * @param {number} groupIndex - El índice para el nombre del input.
     * @returns {Promise<HTMLElement>} El elemento de la paleta.
     */
    async function createColorPaletteForGroup(groupIndex) {
        const palette = document.createElement('div');
        palette.className = 'd-flex flex-wrap gap-2 border rounded p-2 mb-2';

        try {
            const response = await fetch('../php/btener_colores.php');
            const colors = await response.json();

            colors.forEach(color => {
                const swatchWrapper = document.createElement('div');
                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = `colores_combinados[${groupIndex}][]`;
                input.value = color.id;
                input.id = `combined_${groupIndex}_${color.id}`;
                input.className = 'd-none';

                const label = document.createElement('label');
                label.htmlFor = `combined_${groupIndex}_${color.id}`;
                label.className = 'color-swatch-small';
                label.style.backgroundColor = color.codigo_hex;
                label.title = color.nombre;

                swatchWrapper.appendChild(input);
                swatchWrapper.appendChild(label);
                palette.appendChild(swatchWrapper);

                input.addEventListener('change', () => {
                    label.classList.toggle('selected', input.checked);
                });
            });

            initializePalette(palette);

        } catch (error) {
            console.error('Error al cargar la paleta de colores combinados:', error);
            palette.innerHTML = '<p class="text-danger">Error al cargar colores.</p>';
        }
        return palette;
    }

    // Event listener para el botón "Añadir Grupo de Combinación"
    if (addGroupBtn) {
        addGroupBtn.addEventListener('click', async () => {
            const groupIndex = groupCounter++; // Usar y luego incrementar el contador corregido
            const groupDiv = document.createElement('div');
            groupDiv.className = 'combined-group border rounded p-3 mb-3';

            groupDiv.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Nuevo Grupo de Combinación</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.combined-group').remove()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

            const colorPalette = await createColorPaletteForGroup(groupIndex);
            groupDiv.appendChild(colorPalette);
            combinedColorsContainer.appendChild(groupDiv);
        });
    }
});