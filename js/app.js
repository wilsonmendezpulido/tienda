document.getElementById('buscador').addEventListener('keyup', function () {
    let valor = this.value.toLowerCase();
    let productos = document.querySelectorAll('.producto-item');

    productos.forEach(p => {
        let nombre = p.getAttribute('data-nombre');
        p.style.display = nombre.includes(valor) ? 'block' : 'none';
    });
});

//MODAL
function verProducto(nombre, descripcion, imagen, precio, id) {
    document.getElementById('modalNombre').innerText = nombre;
    document.getElementById('modalDescripcion').innerText = descripcion;
    document.getElementById('modalImg').src = imagen;
    document.getElementById('modalPrecio').innerText = '$' + new Intl.NumberFormat('es-CO').format(precio);

    document.getElementById('modalBtn').href = 'carrito.php?accion=agregar&id=' + id;

    $('#modalProducto').modal('show');
}