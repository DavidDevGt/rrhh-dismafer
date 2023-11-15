$(document).ready(function() {
    // Inicializar DataTable en tu tabla
    $('#tabla_empleados').DataTable({
        // Opciones de DataTables (puedes personalizar estas opciones según tus necesidades)
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        // Aquí puedes añadir más opciones como la carga de datos a través de AJAX, etc.
    });

    // Código para manejar eventos del modal, agregar, editar y eliminar empleados
    // ...

    // Eventos para botones de exportación
    // ...
});
