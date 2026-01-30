//=========================================================
//=============== CÓDIGO PARA SUBIDA DE IMAGEN =============
//=========================================================
const uploadArea = document.getElementById('uploadArea');
const inputFile = document.getElementById('productImage');
const selectBtn = document.getElementById('selectImageBtn');
const placeholder = document.getElementById('uploadPlaceholder');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');
const removeBtn = document.getElementById('removeImageBtn');

// Abrir selector al hacer clic en botón o área
if (selectBtn) {
    selectBtn.addEventListener('click', () => inputFile.click());
}

if (uploadArea) {
    uploadArea.addEventListener('click', (e) => {
        // Evita abrir el selector si se hace clic en el botón de eliminar o si ya hay una imagen
        if (!imagePreview.classList.contains('d-none') || e.target.closest('#removeImageBtn')) {
            return;
        }
        inputFile.click();
    });

    // Funcionalidad de arrastrar y soltar (Drag and Drop)
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
        if (files.length === 1 && files[0].type.startsWith('image/')) {
            inputFile.files = files;
            showImagePreview(files[0]);
        } else {
            alert("Solo puedes subir un archivo de imagen.");
        }
    });
}

// Escuchar cambios en el input de archivo
if (inputFile) {
    inputFile.addEventListener('change', () => {
        if (inputFile.files.length === 1) {
            showImagePreview(inputFile.files[0]);
        }
    });
}

// Función para mostrar la vista previa de la imagen
function showImagePreview(file) {
    const reader = new FileReader();
    reader.onload = function (e) {
        previewImg.src = e.target.result;
        placeholder.classList.add('d-none');
        imagePreview.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}

// Eliminar la imagen seleccionada
if (removeBtn) {
    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Evita que el evento se propague al 'uploadArea'
        inputFile.value = ''; // Limpia el input de archivo
        previewImg.src = '';
        imagePreview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    });
}

//=========================================================
//================== CÓDIGO PARA COLOR ==================
//=========================================================

//============== LÓGICA PARA SUBIDA DE IMAGEN (SIN CAMBIOS) ==============
//... Tu código para la subida de imagen se mantiene igual ...


//============== LÓGICA PARA SELECCIÓN DE COLORES (ACTUALIZADO) ==============
document.addEventListener('DOMContentLoaded', (event) => {
    // Código de subida de imagen (debería estar dentro del DOMContentLoaded)
    const uploadArea = document.getElementById('uploadArea');
    // ... (el resto de tu código de imagen) ...

    // --- Lógica de la paleta de colores ---
    const colorPaletteContainer = document.getElementById('color-palette-container');
    const selectedColorsInput = document.getElementById('selectedColorsInput');
    let selectedColorIds = [];

    function createColorSwatch(color) {
        const swatch = document.createElement('div');
        swatch.className = 'color-swatch';
        swatch.style.backgroundColor = color.codigo_hex;
        swatch.title = `Seleccionar ${color.codigo_hex}`;
        swatch.dataset.colorId = color.id;

        swatch.addEventListener('click', () => {
            swatch.classList.toggle('selected');
            const colorId = parseInt(swatch.dataset.colorId);

            if (selectedColorIds.includes(colorId)) {
                selectedColorIds = selectedColorIds.filter(id => id !== colorId);
            } else {
                selectedColorIds.push(colorId);
            }
            selectedColorsInput.value = selectedColorIds.join(',');
        });
        return swatch;
    }

    async function cargarColores() {
        if (!colorPaletteContainer) return; // No ejecutar si el elemento no existe
        try {
            // Asegúrate que el nombre del archivo es correcto
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
    // ========= LÓGICA PARA COLORES COMBINADOS (Corregido para crear.js) =========
    // =========================================================
    const addGroupBtn = document.getElementById('add-combined-color-group');
    const combinedColorsContainer = document.getElementById('combined-colors-container');
    let groupCounter = 0;

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
            // Si no está seleccionado y el límite se alcanzó
            if (!cb.checked && isLimitReached) {
                cb.disabled = true;
                label.classList.add('disabled');
            } else {
                // Habilitar en cualquier otro caso
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
        // Añade el listener para futuros cambios
        palette.addEventListener('change', () => {
            updateColorGroupState(palette);
        });
    }

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

                // Actualiza el estilo visual del label cuando el input cambia
                input.addEventListener('change', () => {
                    label.classList.toggle('selected', input.checked);
                });
            });

            // Inicializa la lógica de habilitar/deshabilitar para esta nueva paleta
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
            const groupIndex = groupCounter++;
            const groupDiv = document.createElement('div');
            groupDiv.className = 'combined-group border rounded p-3 mb-3';

            groupDiv.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Combinación #${groupIndex + 1}</h6>
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