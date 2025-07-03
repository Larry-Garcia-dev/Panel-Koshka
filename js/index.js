
const deleteModal = document.getElementById('deleteModal');

deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const productoId = button.getAttribute('data-id');
    const productoNombre = button.getAttribute('data-nombre');

    // Asignar los valores al formulario
    document.getElementById('productoId').value = productoId;
    document.getElementById('productoNombre').textContent = productoNombre;
});

