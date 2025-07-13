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
//================== CÓDIGO PARA COLORES ==================
//=========================================================
document.addEventListener('DOMContentLoaded', function() {
    const addColorBtn = document.getElementById('addColorBtn');
    const colorContainer = document.getElementById('colorContainer');

    // Función para inicializar el selector de color Coloris
    function initColoris() {
        if (typeof Coloris === 'function') {
            Coloris({
                el: '.color-input',
                theme: 'large', // Tema grande y profesional
                themeMode: 'light',
                format: 'hex',
                alpha: false // Desactiva la selección de transparencia
            });
        }
    }

    // Añadir nuevo campo de color al hacer clic en el botón
    if (addColorBtn) {
        addColorBtn.addEventListener('click', () => {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative d-inline-flex align-items-center me-2 mb-2';

            const newColorInput = document.createElement('input');
            newColorInput.type = 'text';
            newColorInput.name = 'colors[]';
            newColorInput.className = 'form-control color-input';
            newColorInput.setAttribute('data-coloris', '');
            newColorInput.style.width = '120px';
            newColorInput.style.paddingLeft = '35px';

            const removeColorBtn = document.createElement('button');
            removeColorBtn.type = 'button';
            removeColorBtn.innerHTML = '&times;';
            removeColorBtn.className = 'btn btn-sm btn-danger position-absolute';
            removeColorBtn.style.right = '28px';
            removeColorBtn.style.top = '50%';
            removeColorBtn.style.transform = 'translateY(-50%)';
            removeColorBtn.style.lineHeight = '1';
            removeColorBtn.style.padding = '0.1rem 0.4rem';
            removeColorBtn.style.border = 'none';
            removeColorBtn.title = 'Eliminar color';

            removeColorBtn.onclick = () => {
                wrapper.remove();
            };
            
            wrapper.appendChild(newColorInput);
            wrapper.appendChild(removeColorBtn);
            colorContainer.appendChild(wrapper);
            
            // Re-inicializa Coloris para que el nuevo campo funcione
            initColoris();
            
            // Abre el selector de color del nuevo campo automáticamente
            newColorInput.click();
        });
    }

    // Inicializa Coloris para cualquier campo de color que ya exista al cargar la página
    initColoris();
});