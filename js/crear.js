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
});